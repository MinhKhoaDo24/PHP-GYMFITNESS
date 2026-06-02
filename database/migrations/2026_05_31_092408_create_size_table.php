<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('size', function (Blueprint $table) {
            $table->increments('id_size');

            $table->string('ten_size', 50);
            $table->string('mota', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('size');
    }
};
