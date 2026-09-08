#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

upsert_env() {
    local key="$1"
    local value="$2"

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
    echo "Creando .env desde .env.example..."
    cp .env.example .env
fi

upsert_env "APP_NAME" "${APP_NAME:-Pizarra}"
upsert_env "APP_ENV" "${APP_ENV:-local}"
upsert_env "APP_DEBUG" "${APP_DEBUG:-true}"
upsert_env "APP_URL" "${APP_URL:-http://localhost:8080}"
upsert_env "DB_CONNECTION" "mysql"
upsert_env "DB_HOST" "${DB_HOST:-mysql}"
upsert_env "DB_PORT" "3306"
upsert_env "DB_DATABASE" "${DB_DATABASE:-pizarra}"
upsert_env "DB_USERNAME" "${DB_USERNAME:-pizarra}"
upsert_env "DB_PASSWORD" "${DB_PASSWORD:-secret}"

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

export COMPOSER_MEMORY_LIMIT=-1

if [ ! -f vendor/autoload.php ]; then
    echo "Instalando dependencias de Composer..."
    composer install --no-interaction --prefer-dist --no-progress --no-scripts
elif [ ! -d vendor/laravel/framework/src ]; then
    echo "Reinstalando dependencias de Composer..."
    composer install --no-interaction --prefer-dist --no-progress --no-scripts
else
    echo "Dependencias de Composer ya instaladas."
fi

if ! grep -qE '^APP_KEY=base64:' .env; then
    echo "Generando APP_KEY..."
    php artisan key:generate --force
fi

php artisan package:discover --ansi >/dev/null
php artisan config:clear --ansi >/dev/null
php artisan view:clear --ansi >/dev/null

echo "Esperando a MySQL..."
php -r '
    $host = getenv("DB_HOST") ?: "mysql";
    $port = getenv("DB_PORT") ?: "3306";
    $user = getenv("DB_USERNAME") ?: "pizarra";
    $pass = getenv("DB_PASSWORD") ?: "secret";
    $maxAttempts = 60;

    for ($i = 1; $i <= $maxAttempts; $i++) {
        try {
            new PDO(
                "mysql:host={$host};port={$port}",
                $user,
                $pass,
                [PDO::ATTR_TIMEOUT => 3]
            );
            echo "MySQL listo." . PHP_EOL;
            exit(0);
        } catch (Throwable $e) {
            sleep(2);
        }
    }

    fwrite(STDERR, "MySQL no respondió a tiempo." . PHP_EOL);
    exit(1);
'

php artisan migrate --force
php artisan storage:link --force >/dev/null 2>&1 || true

if [ -f package.json ]; then
    echo "Instalando node_modules..."
    npm ci --no-audit --no-fund
    echo "Compilando assets..."
    npm run build
    rm -f public/hot
fi

chown -R www-data:www-data storage bootstrap/cache || true
chmod -R ug+rwx storage bootstrap/cache || true

echo "Laravel listo. Iniciando PHP-FPM..."
exec docker-php-entrypoint "$@"
