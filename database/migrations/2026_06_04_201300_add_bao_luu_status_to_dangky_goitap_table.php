<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Thêm trạng thái 'bao_luu' vào enum trang_thai của bảng dangky_goitap
        DB::statement("ALTER TABLE dangky_goitap MODIFY COLUMN trang_thai ENUM('cho_thanh_toan', 'da_thanh_toan', 'dang_tap', 'bao_luu', 'het_han', 'da_huy') NOT NULL DEFAULT 'cho_thanh_toan'");
    }

    public function down(): void
    {
        // Trở về enum cũ
        DB::statement("ALTER TABLE dangky_goitap MODIFY COLUMN trang_thai ENUM('cho_thanh_toan', 'da_thanh_toan', 'dang_tap', 'het_han', 'da_huy') NOT NULL DEFAULT 'cho_thanh_toan'");
    }
};
