# syntax=docker/dockerfile:1

FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader

COPY app app
COPY bootstrap bootstrap
COPY config config
COPY database database
COPY routes routes
COPY artisan artisan
RUN composer dump-autoload --no-dev --optimize --no-scripts

FROM node:22-bookworm-slim AS assets
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY --from=vendor /app/vendor vendor
COPY resources resources
COPY vite.config.js ./
RUN npm run build

FROM php:8.3-cli-bookworm AS app
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libicu-dev \
        libpq-dev \
        libzip-dev \
    && docker-php-ext-install \
        bcmath \
        intl \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY . .
COPY --from=vendor /app/vendor vendor
COPY --from=assets /app/public/build public/build
COPY docker/render-start.sh /usr/local/bin/render-start

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache \
    && chmod +x /usr/local/bin/render-start \
    && php artisan package:discover --ansi

EXPOSE 10000

CMD ["render-start"]
