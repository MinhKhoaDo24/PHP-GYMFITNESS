<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dangky_goitap', function (Blueprint $table) {
            // PT mới đang chờ xác nhận (holding slot - không thay id_pt cho đến khi được đồng ý)
            $table->unsignedInteger('id_pt_moi_tam')->nullable()->after('id_pt');
            $table->foreign('id_pt_moi_tam')->references('id_nd')->on('nguoidung')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('dangky_goitap', function (Blueprint $table) {
            $table->dropForeign(['id_pt_moi_tam']);
            $table->dropColumn('id_pt_moi_tam');
        });
    }
};
