#!/bin/bash
set -e

echo "==> Chạy migrations..."
php artisan migrate --force

echo "==> Tạo storage link..."
php artisan storage:link || true

echo "==> Clear và cache config..."
php artisan config:clear
php artisan config:cache

echo "==> Cache routes..."
php artisan route:clear
php artisan route:cache

echo "==> Cache views..."
php artisan view:clear
php artisan view:cache

echo "==> Khởi động Apache..."
apache2-foreground
