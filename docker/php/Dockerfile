FROM php:8.2-apache

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache Rewrite
RUN a2enmod rewrite

# Laravelのドキュメントルート
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Apacheの設定変更
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Laravelプロジェクトをコピー
COPY src/ /var/www/html/

# Composer依存関係をインストール
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Laravelのstorageとcacheの権限
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/database

RUN touch /var/www/html/database/database.sqlite \
    && chown www-data:www-data /var/www/html/database/database.sqlite \
    && chmod 664 /var/www/html/database/database.sqlite

RUN php artisan migrate --force

# Apacheのポート
EXPOSE 80