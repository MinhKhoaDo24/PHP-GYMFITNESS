<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            // Nếu bảng chưa có timestamps thì thêm vào
            if (!Schema::hasColumn('nguoidung', 'created_at')) {
                $table->timestamp('created_at')->useCurrent(); 
            }

            if (!Schema::hasColumn('nguoidung', 'updated_at')) {
                $table->timestamp('updated_at')
                      ->useCurrent()
                      ->useCurrentOnUpdate(); 
            }
        });
    }

    public function down()
    {
        Schema::table('nguoidung', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};
