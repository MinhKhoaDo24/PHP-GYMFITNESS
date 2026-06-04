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
        Schema::create('yeucau_doipt', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_dangky');
            $table->unsignedInteger('id_khachhang');
            $table->unsignedInteger('id_pt_cu');
            $table->unsignedInteger('id_pt_moi')->nullable();
            $table->string('ly_do');
            $table->text('ghi_chu')->nullable();
            $table->string('trang_thai')->default('cho_xu_ly'); // cho_xu_ly, da_duyet, tu_choi
            $table->string('ly_do_tu_choi')->nullable();
            $table->timestamps();

            $table->foreign('id_dangky')->references('id')->on('dangky_goitap')->onDelete('cascade');
            $table->foreign('id_khachhang')->references('id_nd')->on('nguoidung')->onDelete('cascade');
            $table->foreign('id_pt_cu')->references('id_nd')->on('nguoidung')->onDelete('cascade');
            $table->foreign('id_pt_moi')->references('id_nd')->on('nguoidung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeucau_doipt');
    }
};
