#!/bin/sh
# Unified entrypoint style (SystemPOA):
# - Dev: invoked as provision script (no supervisord args) → no exec.
# - Production CapRover-style: invoked as ENTRYPOINT with supervisord → exec.

set -e

cd /var/www/html

mkdir -p \
    bootstrap/cache \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/testing \
    storage/logs

chown -R application:application storage bootstrap/cache 2>/dev/null || true
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

upsert_env() {
    key="$1"
    value="$2"

    if [ ! -f .env ]; then
        return
    fi

    if grep -qE "^[#]*[[:space:]]*${key}=" .env; then
        sed -i -E "s|^[#]*[[:space:]]*${key}=.*|${key}=${value}|" .env
    else
        printf '\n%s=%s\n' "$key" "$value" >> .env
    fi
}

if [ ! -f .env ]; then
    echo "-> Creando .env desde .env.example..."
    cp .env.example .env
fi

upsert_env "APP_NAME" "${APP_NAME:-Pizarra}"
upsert_env "APP_ENV" "${APP_ENV:-local}"
upsert_env "APP_DEBUG" "${APP_DEBUG:-true}"
upsert_env "APP_URL" "${APP_URL:-http://localhost:8001}"
upsert_env "DB_CONNECTION" "${DB_CONNECTION:-mysql}"
upsert_env "DB_HOST" "${DB_HOST:-db}"
upsert_env "DB_PORT" "${DB_PORT:-3306}"
upsert_env "DB_DATABASE" "${DB_DATABASE:-pizarra}"
upsert_env "DB_USERNAME" "${DB_USERNAME:-pizarra}"
upsert_env "DB_PASSWORD" "${DB_PASSWORD:-secret}"
upsert_env "CACHE_STORE" "${CACHE_STORE:-redis}"
upsert_env "SESSION_DRIVER" "${SESSION_DRIVER:-redis}"
upsert_env "QUEUE_CONNECTION" "${QUEUE_CONNECTION:-redis}"
upsert_env "REDIS_HOST" "${REDIS_HOST:-redis}"
upsert_env "REDIS_PORT" "${REDIS_PORT:-6379}"

export COMPOSER_MEMORY_LIMIT="${COMPOSER_MEMORY_LIMIT:-512M}"

if [ "${DOCKER_DEV}" = "1" ] && [ "${APP_ENV}" = "local" ]; then
    if [ ! -f vendor/autoload.php ] || [ ! -d vendor/laravel/framework/src ]; then
        echo "-> [dev] Instalando dependencias de Composer..."
        composer install --no-interaction --prefer-dist --no-progress
        echo "-> [dev] Composer listo."
    else
        echo "-> [dev] Dependencias de Composer ya instaladas."
    fi
fi

if ! grep -qE '^APP_KEY=base64:' .env; then
    echo "-> Generando APP_KEY..."
    php artisan key:generate --force --no-interaction
fi

php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

if [ "${FILESYSTEM_DISK:-local}" = "local" ] || [ "${FILESYSTEM_PUBLIC_DRIVER:-local}" = "local" ]; then
    php artisan storage:link --force 2>/dev/null || true
fi

# Wait for database, then migrate (local DX + production boot)
if [ "${RUN_MIGRATIONS_ON_BOOT:-1}" != "0" ]; then
    echo "-> Esperando base de datos..."
    php -r '
        $host = getenv("DB_HOST") ?: "db";
        $port = getenv("DB_PORT") ?: "3306";
        $user = getenv("DB_USERNAME") ?: "pizarra";
        $pass = getenv("DB_PASSWORD") ?: "secret";
        for ($i = 1; $i <= 60; $i++) {
            try {
                new PDO("mysql:host={$host};port={$port}", $user, $pass, [PDO::ATTR_TIMEOUT => 3]);
                echo "-> Base de datos lista." . PHP_EOL;
                exit(0);
            } catch (Throwable $e) {
                sleep(2);
            }
        }
        fwrite(STDERR, "-> La base de datos no respondió a tiempo." . PHP_EOL);
        exit(1);
    '

    echo "-> Ejecutando migraciones..."
    php artisan migrate --force --no-interaction

    if [ "${APP_ENV}" = "production" ]; then
        echo "-> Sembrando roles..."
        php artisan db:seed --class=Database\\Seeders\\RoleSeeder --force --no-interaction
    else
        echo "-> Sembrando base (roles + demo local)..."
        php artisan db:seed --force --no-interaction || true
    fi
fi

if [ "${APP_ENV}" = "production" ]; then
    php artisan config:cache 2>/dev/null || true
fi

# Production CapRover-style: hand off to webdevops entrypoint
if [ "${1:-}" = "/usr/bin/supervisord" ] || [ "${1:-}" = "supervisord" ]; then
    exec /opt/docker/bin/entrypoint.sh "$@"
fi

# Dev provision script: do not exit — webdevops continues starting nginx/php
