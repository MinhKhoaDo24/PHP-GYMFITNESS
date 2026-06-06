<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            // Xóa CHECK constraint cũ còn sót lại từ lúc tạo bảng
            // (chỉ cho phép 'percent', 'money' - chưa có 'freeship')
            DB::statement("ALTER TABLE khuyenmai DROP CONSTRAINT IF EXISTS khuyenmai_kieu_giam_check");

            // Thêm CHECK constraint mới bao gồm 'freeship'
            DB::statement("ALTER TABLE khuyenmai ADD CONSTRAINT khuyenmai_kieu_giam_check
                CHECK (kieu_giam IN ('percent', 'money', 'freeship'))");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE khuyenmai DROP CONSTRAINT IF EXISTS khuyenmai_kieu_giam_check");
            DB::statement("ALTER TABLE khuyenmai ADD CONSTRAINT khuyenmai_kieu_giam_check
                CHECK (kieu_giam IN ('percent', 'money'))");
        }
    }
};
