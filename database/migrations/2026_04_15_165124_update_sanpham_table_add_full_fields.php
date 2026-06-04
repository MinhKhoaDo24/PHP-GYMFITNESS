<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sanpham', function (Blueprint $table) {

            // Các trường bổ sung
            $table->string('sku')->nullable()->after('tensp');
            $table->text('mota_ngan')->nullable()->after('mota');  // short_description
            $table->integer('gia_goc')->nullable()->after('giasp'); // original_price
            $table->integer('gia_ban')->nullable()->after('gia_goc'); // sale_price
            $table->integer('phan_tram_giam')->nullable()->after('gia_ban'); // discount_percentage
            $table->integer('trang_thai_kho')->default(1)->after('soluong'); // stock_status (1 = còn hàng)
            $table->tinyInteger('noi_bat')->default(0)->after('trang_thai_kho'); // featured
            $table->tinyInteger('trang_thai')->default(1)->after('noi_bat'); // status

            // Liên kết với khuyến mãi
            $table->unsignedInteger('id_khuyenmai')->nullable()->after('id_danhmuc');
            $table->foreign('id_khuyenmai')
                ->references('id_khuyenmai')->on('khuyenmai')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->dropColumn([
                'sku', 'mota_ngan', 'gia_goc', 'gia_ban',
                'phan_tram_giam', 'trang_thai_kho', 'noi_bat',
                'trang_thai'
            ]);

            $table->dropForeign(['id_khuyenmai']);
            $table->dropColumn('id_khuyenmai');
        });
    }
};
