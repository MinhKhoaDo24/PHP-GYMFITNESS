<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dangkidichvu', function (Blueprint $table) {

            // ENUM môn thể thao
            $table->enum('mon_ua_thich', [
                'gym',
                'yoga',
                'boxing',
                'dance',
                'cardio'
            ])->nullable()->after('ghi_chu');

            // ENUM cơ sở tập luyện
            $table->enum('co_so_tap', [
                '12-Chùa Bộc',
                '12-Cầu Giấy',
            ])->nullable()->after('mon_ua_thich');
        });
    }

    public function down(): void
    {
        Schema::table('dangkidichvu', function (Blueprint $table) {
            $table->dropColumn(['mon_ua_thich', 'co_so_tap']);
        });
    }
};
