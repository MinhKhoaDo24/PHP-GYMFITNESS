<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goitap', function (Blueprint $table) {
            $table->increments('id_goitap');
            $table->string('ten_goi', 100);
            $table->string('slug', 120)->unique();
            $table->string('mo_ta_ngan', 255)->nullable();
            $table->text('mo_ta_chi_tiet')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->enum('loai_goi', ['silver', 'gold', 'diamond'])->default('silver');
            $table->decimal('gia_pt_them', 12, 0)->default(0)->comment('Phụ thu PT mỗi tháng (VNĐ)');
            $table->tinyInteger('is_best')->default(0)->comment('1=Gói nổi bật');
            $table->tinyInteger('trang_thai')->default(1)->comment('1=active, 0=inactive');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goitap');
    }
};
