#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$ROOT_DIR"

if [ -f "artisan" ]; then
  echo "Ya existe un proyecto Laravel en este directorio."
  exit 1
fi

docker compose up -d app mysql

docker compose exec -u www-data app composer create-project laravel/laravel:^13.0 /tmp/laravel --no-interaction

docker compose exec -u root app bash -c '
  shopt -s dotglob nullglob
  for item in /tmp/laravel/*; do
    name="$(basename "$item")"
    if [ "$name" = "README.md" ]; then
      continue
    fi
    cp -a "$item" /var/www/html/
  done
  chown -R www-data:www-data /var/www/html
  rm -rf /tmp/laravel
'

if [ ! -f ".env" ] && [ -f ".env.example" ]; then
  cp .env.example .env
fi

docker compose exec -u www-data app bash -c '
  if [ -f .env ]; then
    sed -i "s/^DB_CONNECTION=.*/DB_CONNECTION=mysql/" .env || true
    sed -i "s/^DB_HOST=.*/DB_HOST=mysql/" .env || true
    sed -i "s/^DB_PORT=.*/DB_PORT=3306/" .env || true
    sed -i "s/^DB_DATABASE=.*/DB_DATABASE=pizarra/" .env || true
    sed -i "s/^DB_USERNAME=.*/DB_USERNAME=pizarra/" .env || true
    sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=secret/" .env || true
  fi
  php artisan key:generate --force
'

echo "Laravel 13 creado. Abre http://localhost:8080"
