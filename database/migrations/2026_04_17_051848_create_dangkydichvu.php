<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dangkidichvu', function (Blueprint $table) {
                $table->id('id_dang_ky');

                $table->string('ho_ten');
                $table->string('email');
                $table->string('so_dien_thoai', 20);

                $table->date('ngay_mong_muon')->nullable();

                $table->enum('gio_mong_muon', [
                    '07:00 - 09:00',
                    '09:00 - 11:00',
                    '13:00 - 15:00',
                    '15:00 - 17:00',
                    '17:00 - 19:00',
                    '19:00 - 21:00',
                    '21:00 - 23:00'
                ])->nullable();

                $table->text('ghi_chu')->nullable();

                $table->tinyInteger('trangthai')
                    ->default(0)
                    ->comment('0: Mới đăng ký, 1: Đã xác nhận, 3: Hoàn thành');

                $table->unsignedInteger('id_nguoidung')->nullable();

                $table->timestamps();
            });

            // Foreign key phải đặt ngoài Schema::create
            Schema::table('dangkidichvu', function (Blueprint $table) {
                $table->foreign('id_nguoidung')
                    ->references('id_nd')
                    ->on('nguoidung')
                    ->onDelete('set null');
            });

    }

    public function down(): void
    {
        Schema::table('dangkidichvu', function (Blueprint $table) {
            $table->dropForeign(['id_nguoidung']);
        });

        Schema::dropIfExists('dangkidichvu');
    }
};
