# PHP base image với Apache
FROM php:8.1-apache

# Cài các thư viện cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip unzip curl git \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd pdo_pgsql pdo_mysql mbstring exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Bật module rewrite của Apache
RUN a2enmod rewrite

# Cấu hình Apache VirtualHost cho Laravel
COPY docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Copy Composer từ official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy toàn bộ mã nguồn vào container
COPY . /var/www

# Đặt thư mục làm việc
WORKDIR /var/www

# Copy .env.docker thành .env (trước khi composer install)
RUN cp .env.docker .env

# Cài đặt Composer dependencies (no-dev, optimized)
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Tạo APP_KEY
RUN php artisan key:generate --force

# Phân quyền đúng cho Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Copy startup script và cấp quyền thực thi
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Expose cổng 80
EXPOSE 80

# Chạy script khởi động (migrate + cache + apache)
CMD ["/start.sh"]
