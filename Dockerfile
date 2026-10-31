# ==============================
# Stage 1: Build frontend assets
# ==============================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run build

# ==============================
# Stage 2: Install PHP deps
# ==============================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock* ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# ==============================
# Stage 3: Production image (nginx + php-fpm, port 80)
# ==============================
FROM php:8.3-fpm-alpine

# Extension installer: resolves build deps, compiles in parallel, cleans up.
# mbstring already ships with the official PHP image, so it is not installed.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache nginx supervisor \
    && install-php-extensions pdo_mysql gd zip intl bcmath opcache

# PHP, nginx and supervisor config (kept before app code so this layer stays cached)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php.ini "$PHP_INI_DIR/conf.d/99-app.ini"
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/foro-ti-entrypoint
RUN chmod +x /usr/local/bin/foro-ti-entrypoint

WORKDIR /var/www/html

# App code (.dockerignore already excludes node_modules, tests, .env, CLAUDE.md, etc.)
COPY --chown=www-data:www-data . .

# Built frontend assets and PHP vendor from the previous stages
COPY --from=frontend --chown=www-data:www-data /app/public/build public/build
COPY --from=vendor --chown=www-data:www-data /app/vendor vendor

# Composer ran with --no-scripts, so rebuild the package manifest here
RUN php artisan package:discover --ansi

EXPOSE 80

# The entrypoint creates/chowns storage and bootstrap/cache on every start
ENTRYPOINT ["/usr/local/bin/foro-ti-entrypoint"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
