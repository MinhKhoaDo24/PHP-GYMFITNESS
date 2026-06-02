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
        Schema::table('dathang', function (Blueprint $table) {
            $table->integer('id_nd')->nullable()->change();
        });

        Schema::table('chitiet_donhang', function (Blueprint $table) {
            $table->integer('id_nd')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dathang', function (Blueprint $table) {
            $table->integer('id_nd')->nullable(false)->change();
        });

        Schema::table('chitiet_donhang', function (Blueprint $table) {
            $table->integer('id_nd')->nullable(false)->change();
        });
    }
};
