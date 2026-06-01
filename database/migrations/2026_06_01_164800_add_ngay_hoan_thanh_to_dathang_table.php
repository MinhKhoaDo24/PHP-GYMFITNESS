<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dathang', function (Blueprint $table) {
            $table->timestamp('ngay_hoan_thanh')->nullable()->after('ngaygiaohang');
        });

        // Đồng bộ dữ liệu cũ: Đơn nào đã 'Hoàn thành' thì cập nhật ngay_hoan_thanh = ngaygiaohang (hoặc ngaydathang nếu ngaygiaohang null)
        DB::table('dathang')
            ->where('trangthai', 'Hoàn thành')
            ->update([
                'ngay_hoan_thanh' => DB::raw('COALESCE(ngaygiaohang, ngaydathang)')
            ]);
    }

    public function down(): void
    {
        Schema::table('dathang', function (Blueprint $table) {
            $table->dropColumn('ngay_hoan_thanh');
        });
    }
};
