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
            // Làm cột id_nd thành nullable để hỗ trợ guest checkout
            $table->unsignedBigInteger('id_nd')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dathang', function (Blueprint $table) {
            // Quay lại trạng thái cũ (không nullable)
            $table->unsignedBigInteger('id_nd')->nullable(false)->change();
        });
    }
};
