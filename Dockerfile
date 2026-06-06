FROM php:8.2-apache

# Cài extension cần thiết
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev \
    libxml2-dev libpq-dev libzip-dev \
    && docker-php-ext-install \
       pdo pdo_mysql pdo_pgsql \
       mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Bật mod_rewrite cho Laravel routes
RUN a2enmod rewrite

# Đặt thư mục gốc là /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

# Thêm AllowOverride All để .htaccess hoạt động
RUN sed -i '/<\/VirtualHost>/i \\t<Directory /var/www/html/public>\n\t\tAllowOverride All\n\t\tRequire all granted\n\t</Directory>' \
    /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Copy toàn bộ project
COPY . .

# Cài dependencies (không có dev packages)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Phân quyền cho thư mục storage và cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy và cấp quyền cho start script
COPY docker-start.sh /docker-start.sh
RUN chmod +x /docker-start.sh

EXPOSE 80

CMD ["/docker-start.sh"]
