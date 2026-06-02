<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Đổi kiểu cột trong conversations từ bigint → int để khớp với id_nd của nguoidung
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedInteger('customer_id')->change();
            $table->unsignedInteger('staff_id')->nullable()->change();

            // Thêm FK trỏ đúng vào id_nd
            $table->foreign('customer_id')->references('id_nd')->on('nguoidung')->onDelete('cascade');
            $table->foreign('staff_id')->references('id_nd')->on('nguoidung')->onDelete('set null');
        });

        // Đổi kiểu cột sender_id trong messages từ bigint → int
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedInteger('sender_id')->change();

            // Thêm FK sender_id trỏ đúng vào id_nd
            $table->foreign('sender_id')->references('id_nd')->on('nguoidung')->onDelete('cascade');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::table('conversations', function (Blueprint $table) {
            try { $table->dropForeign(['customer_id']); } catch (\Exception $e) {}
            try { $table->dropForeign(['staff_id']); } catch (\Exception $e) {}
            $table->unsignedBigInteger('customer_id')->change();
            $table->unsignedBigInteger('staff_id')->nullable()->change();
        });

        Schema::table('messages', function (Blueprint $table) {
            try { $table->dropForeign(['sender_id']); } catch (\Exception $e) {}
            $table->unsignedBigInteger('sender_id')->change();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
