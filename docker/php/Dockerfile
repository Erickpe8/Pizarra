FROM php:8.3-fpm-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/local.ini /usr/local/etc/php/conf.d/zz-local.ini
COPY docker/php/entrypoint.sh /usr/local/bin/app-entrypoint.sh

RUN sed -i 's/\r$//' /usr/local/bin/app-entrypoint.sh \
    && chmod +x /usr/local/bin/app-entrypoint.sh \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

WORKDIR /var/www/html

ENTRYPOINT ["/usr/local/bin/app-entrypoint.sh"]
CMD ["php-fpm"]
