# ==========================================
# 1. Node.jsでViteをビルド
# ==========================================
FROM node:22 AS frontend

WORKDIR /app

COPY src/package*.json ./

RUN npm ci

COPY src/ ./

RUN npm run build


# ==========================================
# 2. PHP + Apache
# ==========================================
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf


# Laravelをコピー
COPY src/ /var/www/html/


# Composer
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


# Viteのビルド結果をコピー
COPY --from=frontend /app/public/build /var/www/html/public/build

# Laravelの書き込み権限
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    && chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache


COPY src/start.sh /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

CMD ["start.sh"]

EXPOSE 80