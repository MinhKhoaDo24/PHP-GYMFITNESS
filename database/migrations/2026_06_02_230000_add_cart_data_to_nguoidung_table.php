<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Thêm cột cart_data vào bảng nguoidung để lưu trữ giỏ hàng
     * bền vững cho từng người dùng. Cho phép merge giỏ hàng khách
     * vãng lai với giỏ hàng đã lưu khi đăng nhập.
     */
    public function up(): void
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            $table->text('cart_data')->nullable()->after('trang_thai')
                  ->comment('Lưu trữ giỏ hàng dạng JSON cho từng tài khoản');
        });
    }

    public function down(): void
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            $table->dropColumn('cart_data');
        });
    }
};
