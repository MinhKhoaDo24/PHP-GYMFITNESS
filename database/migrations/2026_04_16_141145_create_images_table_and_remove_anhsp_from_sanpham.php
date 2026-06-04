<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedInteger('id_sanpham');

            $table->string('duong_dan');
            $table->timestamps();

            $table->foreign('id_sanpham')
                ->references('id_sanpham') 
                ->on('sanpham')
                ->onDelete('cascade');       
        });

        Schema::table('sanpham', function (Blueprint $table) {
            if (Schema::hasColumn('sanpham', 'anhsp')) {
                $table->dropColumn('anhsp');
            }
        });
    }

    public function down()
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->string('anhsp')->nullable();
        });

        Schema::dropIfExists('images');
    }
};
