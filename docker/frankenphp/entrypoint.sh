#!/usr/bin/env bash
set -euo pipefail

cd /app

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

if [ ! -f .env ] && [ -z "${VERCEL_ENV:-}" ]; then
    cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force
fi

should_run_migrations=false

if [ "${VERCEL_ENV:-}" = "production" ]; then
    should_run_migrations=true
fi

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    should_run_migrations=true
fi

if [ "${APP_ENV:-}" = "production" ] && [ -z "${VERCEL_ENV:-}" ]; then
    should_run_migrations=true
fi

if [ "${should_run_migrations}" = "true" ]; then
    echo "Ejecutando migraciones..."
    php artisan migrate --force

    echo "Sembrando roles de producción..."
    php artisan db:seed --class=Database\\Seeders\\RoleSeeder --force
fi

exec frankenphp run --config /etc/frankenphp/Caddyfile
