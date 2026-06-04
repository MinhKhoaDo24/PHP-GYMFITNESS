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
        Schema::create('thongbao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_nguoidung');
            $table->string('tieu_de', 100);
            $table->text('noi_dung');
            $table->enum('loai', ['phan_pt', 'kich_hoat', 'chi_so', 'chung'])->default('chung');
            $table->tinyInteger('da_doc')->default(0);
            $table->string('link')->nullable();
            $table->timestamps();

            $table->foreign('id_nguoidung')->references('id_nd')->on('nguoidung')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thongbao');
    }
};
