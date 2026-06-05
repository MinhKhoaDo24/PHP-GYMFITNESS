#!/bin/bash
set -e

echo "==> Chạy migrations..."
php artisan migrate --force

echo "==> Chạy seeders nếu chưa có dữ liệu..."
PRODUCT_COUNT=$(php artisan tinker --execute="echo \App\Models\Sanpham::count();" 2>/dev/null | tail -1 || echo "0")
if [ "$PRODUCT_COUNT" = "0" ] || [ -z "$PRODUCT_COUNT" ]; then
    echo "    Database trống, đang seed dữ liệu..."
    php artisan db:seed --force || echo "    Seed thất bại, tiếp tục..."
else
    echo "    Đã có $PRODUCT_COUNT sản phẩm, bỏ qua seed."
fi

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
