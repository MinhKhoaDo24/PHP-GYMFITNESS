<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('size', function (Blueprint $table) {
            $table->tinyInteger('trang_thai')->default(1)->comment('1: Active, 0: Inactive');
        });
    }

    public function down()
    {
        Schema::table('size', function (Blueprint $table) {
            $table->dropColumn('trang_thai');
        });
    }
};
