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
        // Thêm trạng thái 'cho_pt_xac_nhan' vào enum trang_thai của bảng dangky_goitap
        DB::statement("ALTER TABLE dangky_goitap MODIFY COLUMN trang_thai ENUM('cho_thanh_toan', 'da_thanh_toan', 'cho_pt_xac_nhan', 'dang_tap', 'bao_luu', 'het_han', 'da_huy') NOT NULL DEFAULT 'cho_thanh_toan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Trở về enum cũ
        DB::statement("ALTER TABLE dangky_goitap MODIFY COLUMN trang_thai ENUM('cho_thanh_toan', 'da_thanh_toan', 'dang_tap', 'bao_luu', 'het_han', 'da_huy') NOT NULL DEFAULT 'cho_thanh_toan'");
    }
};
