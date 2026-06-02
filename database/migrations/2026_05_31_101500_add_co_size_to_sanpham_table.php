<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->tinyInteger('co_size')->default(0)->comment('0: Không có size, 1: Có size');
        });
    }

    public function down()
    {
        Schema::table('sanpham', function (Blueprint $table) {
            $table->dropColumn('co_size');
        });
    }
};
