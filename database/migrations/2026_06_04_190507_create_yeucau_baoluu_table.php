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
        Schema::create('yeucau_baoluu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_dangky');
            $table->unsignedInteger('id_khachhang');
            $table->date('ngay_bat_dau_baoluu');
            $table->integer('so_ngay_baoluu');
            $table->integer('so_ngay_con_lai_truoc_baoluu');
            $table->string('ly_do');
            $table->string('trang_thai')->default('cho_duyet'); // cho_duyet, da_duyet, tu_choi, da_kich_hoat_lai
            $table->string('ly_do_tu_choi')->nullable();
            $table->timestamps();

            $table->foreign('id_dangky')->references('id')->on('dangky_goitap')->onDelete('cascade');
            $table->foreign('id_khachhang')->references('id_nd')->on('nguoidung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeucau_baoluu');
    }
};
