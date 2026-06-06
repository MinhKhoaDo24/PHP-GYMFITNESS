<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE dangky_goitap MODIFY COLUMN trang_thai ENUM('cho_thanh_toan', 'da_thanh_toan', 'cho_pt_xac_nhan', 'dang_tap', 'bao_luu', 'het_han', 'da_huy') NOT NULL DEFAULT 'cho_thanh_toan'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE dangky_goitap ALTER COLUMN trang_thai TYPE VARCHAR(30)");
            DB::statement("ALTER TABLE dangky_goitap ALTER COLUMN trang_thai SET DEFAULT 'cho_thanh_toan'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE dangky_goitap MODIFY COLUMN trang_thai ENUM('cho_thanh_toan', 'da_thanh_toan', 'dang_tap', 'bao_luu', 'het_han', 'da_huy') NOT NULL DEFAULT 'cho_thanh_toan'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE dangky_goitap ALTER COLUMN trang_thai TYPE VARCHAR(30)");
            DB::statement("ALTER TABLE dangky_goitap ALTER COLUMN trang_thai SET DEFAULT 'cho_thanh_toan'");
        }
    }
};
