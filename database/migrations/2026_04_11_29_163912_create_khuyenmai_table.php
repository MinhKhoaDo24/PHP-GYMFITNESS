<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('khuyenmai', function (Blueprint $table) {
            $table->increments('id_khuyenmai'); // AUTO_INCREMENT, khóa chính

            $table->string('ten_khuyenmai', 255);
            $table->string('ma_code', 255)->unique()->nullable();
            
            $table->integer('gia_tri_giam')->nullable(); // int, null
            $table->enum('kieu_giam', ['percent', 'money'])->default('percent'); // enum

            $table->text('mo_ta')->nullable(); // mô tả

            $table->integer('don_toi_thieu')->default(0); // int default 0
            $table->integer('giam_toi_da')->nullable(); // int, null

            $table->integer('so_luot_da_dung')->default(0); // int default 0
            $table->integer('gioi_han_luot')->nullable(); // int, null

            $table->dateTime('ngay_bat_dau')->nullable();
            $table->dateTime('ngay_ket_thuc')->nullable();

            $table->tinyInteger('trang_thai')->default(1);

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('khuyenmai');
    }
};
