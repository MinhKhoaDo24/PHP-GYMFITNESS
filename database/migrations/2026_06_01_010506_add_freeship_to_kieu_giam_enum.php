<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE khuyenmai MODIFY kieu_giam ENUM('percent', 'money', 'freeship') DEFAULT 'percent'");
        } elseif ($driver === 'pgsql') {
            // PostgreSQL: thêm giá trị mới vào type enum (nếu dùng native enum)
            // Hoặc nếu cột đang là VARCHAR thì chỉ cần thêm CHECK constraint
            // Kiểm tra xem cột có tồn tại không trước khi alter
            DB::statement("ALTER TABLE khuyenmai ALTER COLUMN kieu_giam TYPE VARCHAR(20)");
            DB::statement("ALTER TABLE khuyenmai ALTER COLUMN kieu_giam SET DEFAULT 'percent'");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE khuyenmai MODIFY kieu_giam ENUM('percent', 'money') DEFAULT 'percent'");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE khuyenmai ALTER COLUMN kieu_giam TYPE VARCHAR(20)");
            DB::statement("ALTER TABLE khuyenmai ALTER COLUMN kieu_giam SET DEFAULT 'percent'");
        }
    }
};