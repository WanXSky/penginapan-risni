FROM composer:2 AS vendor-build
WORKDIR /app
COPY composer.json composer.lock .
RUN composer install --prefer-dist --optimize-autoloader --no-interaction

FROM node:22-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json .
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./vite.config.js
COPY tailwind.config.js .
RUN npm run build

FROM php:8.4-fpm-alpine
WORKDIR /var/www
RUN apk add --no-cache linux-headers oniguruma-dev libpng-dev libxml2-dev 
RUN docker-php-ext-install pdo pdo_mysql mbstring pcntl bcmath gd
COPY --from=vendor-build /app/vendor /var/www/vendor
COPY --from=node-build /app/public/build /var/www/public/build
COPY . .
RUN chmod 755 /var/www/storage && chown -R www-data:www-data /var/www

USER www-data
