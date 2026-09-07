# syntax=docker/dockerfile:1

##### Stage 1: compile PHP extensions #####
FROM php:8.5-fpm AS ext-builder

RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    --mount=type=cache,target=/var/lib/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
        g++ \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        zlib1g-dev \
    && docker-php-ext-install -j"$(nproc)" pdo pdo_pgsql intl zip \
    && pecl install apcu \
    && docker-php-ext-enable apcu

##### Stage 2: production Composer dependencies #####
FROM composer:2 AS vendor

WORKDIR /app
COPY app/composer.json app/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer-cache \
    composer install \
        --no-dev \
        --no-scripts \
        --no-interaction \
        --no-progress \
        --no-autoloader \
        --prefer-dist

COPY app/ ./
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative

##### Stage 3: runtime image #####
FROM php:8.5-fpm AS runtime

RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    --mount=type=cache,target=/var/lib/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
        cron \
        libicu76 \
        libpq5 \
        libzip5 \
        supervisor \
    && rm -rf /var/lib/apt/lists/*

COPY --from=ext-builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=ext-builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY docker/config/opcache.prod.ini /usr/local/etc/php/conf.d/zz-opcache.ini
COPY docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html
COPY app/ ./
COPY --from=vendor /app/vendor ./vendor

RUN mkdir -p var/cache var/log \
    && chown -R www-data:www-data var

CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

##### Stage 4: local dev image (used by docker/docker-compose.yml) #####
FROM runtime AS dev

RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    --mount=type=cache,target=/var/lib/apt,sharing=locked \
    apt-get update && apt-get install -y --no-install-recommends \
        git \
        iputils-ping \
        unzip \
        vim \
    && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get install -y --no-install-recommends symfony-cli \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /usr/bin/composer /usr/local/bin/composer

# ../app is bind-mounted over /var/www/html at runtime, so files must be
# re-checked on every request instead of trusting the image's build-time copy.
COPY docker/config/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d/zz-opcache.ini
