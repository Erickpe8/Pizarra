#!/usr/bin/env bash
set -euo pipefail

cd /app

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -f vendor/autoload.php ]; then
    composer install --no-dev --no-interaction --prefer-dist --no-scripts
    composer dump-autoload --no-dev --optimize
fi

if [ -z "${APP_KEY:-}" ] || ! grep -qE '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

exec frankenphp run --config /etc/frankenphp/Caddyfile
