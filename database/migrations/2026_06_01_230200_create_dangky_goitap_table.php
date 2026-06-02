<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dangky_goitap', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma_dang_ky', 20)->unique()->comment('Mã đăng ký: RF-xxxxx');
            $table->unsignedInteger('id_nguoidung')->comment('Khách hàng đăng ký');
            $table->unsignedInteger('id_goitap_gia')->comment('Gói giá được chọn');
            $table->tinyInteger('co_pt')->default(0)->comment('0=Không PT, 1=Có PT');
            $table->unsignedInteger('id_pt')->nullable()->comment('PT được phân công');
            $table->decimal('tong_tien', 12, 0)->comment('Tổng tiền (VNĐ)');
            $table->enum('trang_thai', [
                'cho_thanh_toan',
                'da_thanh_toan',
                'dang_tap',
                'het_han',
                'da_huy'
            ])->default('cho_thanh_toan');
            $table->date('ngay_bat_dau')->nullable()->comment('Ngày bắt đầu tập (khi kích hoạt)');
            $table->date('ngay_ket_thuc')->nullable()->comment('Ngày kết thúc');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            $table->foreign('id_nguoidung')
                  ->references('id_nd')
                  ->on('nguoidung')
                  ->onDelete('cascade');

            $table->foreign('id_goitap_gia')
                  ->references('id')
                  ->on('goitap_gia')
                  ->onDelete('cascade');

            $table->foreign('id_pt')
                  ->references('id_nd')
                  ->on('nguoidung')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dangky_goitap');
    }
};
