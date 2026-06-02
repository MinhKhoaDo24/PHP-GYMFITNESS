<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goitap_gia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_goitap');
            $table->tinyInteger('so_thang')->comment('1, 3, 6 hoặc 12 tháng');
            $table->decimal('gia_goc', 12, 0)->comment('Giá gốc (VNĐ)');
            $table->decimal('gia_khuyen_mai', 12, 0)->nullable()->comment('Giá khuyến mãi (VNĐ)');
            $table->tinyInteger('trang_thai')->default(1)->comment('1=active, 0=inactive');
            $table->timestamps();

            $table->foreign('id_goitap')
                  ->references('id_goitap')
                  ->on('goitap')
                  ->onDelete('cascade');

            // Mỗi gói chỉ có 1 giá cho mỗi mốc thời gian
            $table->unique(['id_goitap', 'so_thang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goitap_gia');
    }
};
