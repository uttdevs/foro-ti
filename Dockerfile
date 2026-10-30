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
# Stage 3: Production image
# ==============================
FROM php:8.3-fpm-alpine

# Install system deps + PHP extensions needed by Laravel + DomPDF
RUN apk add --no-cache \
        nginx \
        supervisor \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
        oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        intl \
        bcmath \
        opcache \
    && rm -rf /var/cache/apk/*

# PHP production config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php.ini "$PHP_INI_DIR/conf.d/99-app.ini"

# Nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor config (runs nginx + php-fpm)
COPY docker/supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

# Copy application code
COPY --chown=www-data:www-data . .

# Copy built frontend assets from stage 1
COPY --from=frontend --chown=www-data:www-data /app/public/build public/build

# Copy vendor from stage 2
COPY --from=vendor --chown=www-data:www-data /app/vendor vendor

# Create required Laravel directories
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Remove dev/unnecessary files from image
RUN rm -rf node_modules tests \
    .env .env.example \
    docker/ \
    "public/III Congreso" \
    AGENTS.md CLAUDE.md \
    storage/logs/*.log

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
