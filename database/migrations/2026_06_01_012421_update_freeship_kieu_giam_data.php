<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('khuyenmai')
            ->where('ma_code', 'FREESHIP')
            ->update([
                'kieu_giam' => 'freeship',
                'gia_tri_giam' => 0,
            ]);
    }

    public function down(): void
    {
        DB::table('khuyenmai')
            ->where('ma_code', 'FREESHIP')
            ->update([
                'kieu_giam' => 'money',
                'gia_tri_giam' => 25000,
            ]);
    }
};