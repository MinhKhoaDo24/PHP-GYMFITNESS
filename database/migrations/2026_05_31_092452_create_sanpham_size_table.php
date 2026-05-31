<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sanpham_size', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('id_sanpham');
            $table->unsignedInteger('id_size');

            $table->integer('soluong')->default(0);
            $table->decimal('gia_cong_them', 15, 2)->default(0);

            $table->foreign('id_sanpham')
                ->references('id_sanpham')
                ->on('sanpham')
                ->onDelete('cascade');

            $table->foreign('id_size')
                ->references('id_size')
                ->on('size')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sanpham_size');
    }
};
