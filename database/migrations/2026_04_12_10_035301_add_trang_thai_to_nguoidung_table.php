<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            $table->tinyInteger('trang_thai')
                  ->default(1)
                  ->after('id_phanquyen');
        });
    }

    public function down()
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            $table->dropColumn('trang_thai');
        });
    }
};
