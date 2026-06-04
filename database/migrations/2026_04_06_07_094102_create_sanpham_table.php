<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanpham', function (Blueprint $table) {
            $table->increments('id_sanpham');
            $table->string('tensp', 100)->nullable();
            $table->decimal('giasp', 15, 2)->nullable();          
            $table->decimal('gia_duoc_giam', 15, 2)->nullable();  
            $table->text('mota')->nullable();
            $table->integer('giamgia')->nullable();               
            $table->decimal('giakhuyenmai', 15, 2)->nullable();   
            $table->integer('soluong')->nullable();
            $table->integer('id_danhmuc')->index('fk_customer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanpham');
    }
};
