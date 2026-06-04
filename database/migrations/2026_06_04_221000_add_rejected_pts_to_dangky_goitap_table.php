<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dangky_goitap', function (Blueprint $table) {
            $table->text('rejected_pts')->nullable()->after('ghi_chu');
        });
    }

    public function down(): void
    {
        Schema::table('dangky_goitap', function (Blueprint $table) {
            $table->dropColumn('rejected_pts');
        });
    }
};
