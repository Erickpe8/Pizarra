# syntax=docker/dockerfile:1

FROM dunglas/frankenphp:1-php8.3-bookworm

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && install-php-extensions \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        pcntl \
        pdo_mysql \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

WORKDIR /app

COPY . .
COPY docker/frankenphp/entrypoint.sh /usr/local/bin/app-entrypoint.sh

RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --optimize-autoloader \
        --prefer-dist \
    && npm ci \
    && npm run build \
    && mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && sed -i 's/\r$//' /usr/local/bin/app-entrypoint.sh \
    && chmod +x /usr/local/bin/app-entrypoint.sh \
    && composer dump-autoload --no-dev --classmap-authoritative \
    && APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= php artisan event:cache \
    && APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= php artisan view:cache \
    && APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= php artisan route:cache \
    && chown -R www-data:www-data /app /config/caddy /data/caddy \
    && setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp

COPY --chown=www-data:www-data Caddyfile /etc/frankenphp/Caddyfile

ENV PORT=80 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    CACHE_STORE=array \
    SESSION_DRIVER=array \
    QUEUE_CONNECTION=sync \
    RUN_MIGRATIONS=false

USER www-data

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/app-entrypoint.sh"]
