<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chi_so_suc_khoe', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_dangky_goitap');
            $table->unsignedInteger('id_pt');
            $table->unsignedInteger('id_khach_hang');
            $table->date('ngay_ghi_nhan');
            $table->decimal('chieu_cao', 5, 1);
            $table->decimal('can_nang', 5, 1);
            $table->decimal('luong_mo', 5, 1)->nullable();
            $table->decimal('luong_nuoc', 5, 1)->nullable();
            $table->decimal('chi_so_bmi', 4, 1);
            $table->text('thoi_quen_song')->nullable();
            $table->text('nhac_nho')->nullable();
            $table->timestamps();

            $table->foreign('id_dangky_goitap')->references('id')->on('dangky_goitap')->onDelete('cascade');
            $table->foreign('id_pt')->references('id_nd')->on('nguoidung')->onDelete('cascade');
            $table->foreign('id_khach_hang')->references('id_nd')->on('nguoidung')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_so_suc_khoe');
    }
};
