<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dathang', function (Blueprint $table) {

            $table->unsignedInteger('id_khuyenmai')
                ->nullable()
                ->after('id_dathang');

            $table->foreign('id_khuyenmai')
                ->references('id_khuyenmai')
                ->on('khuyenmai')
                ->onDelete('set null');

            $table->decimal('tiengiam', 15, 2)
                ->default(0)
                ->after('id_khuyenmai');

            $table->decimal('tienphaitra', 15, 2)
                ->default(0)
                ->after('tiengiam');
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            Schema::table('dathang', function (Blueprint $table) {
                $table->enum('trangthai', [
                    'Chờ xác nhận',
                    'Chờ giao hàng',
                    'Đang giao hàng',
                    'Hoàn thành',
                    'Thất bại',
                    'Bị hủy'
                ])->default('Chờ xác nhận')->change();
            });

        } else {
            DB::statement("ALTER TABLE dathang ALTER COLUMN trangthai TYPE varchar(255);");

            DB::statement("ALTER TABLE dathang DROP CONSTRAINT IF EXISTS dathang_trangthai_check;");

            DB::statement("
                ALTER TABLE dathang 
                ADD CONSTRAINT dathang_trangthai_check 
                CHECK (trangthai IN (
                    'Chờ xác nhận',
                    'Chờ giao hàng',
                    'Đang giao hàng',
                    'Hoàn thành',
                    'Thất bại',
                    'Bị hủy'
                ));
            ");

            DB::statement("ALTER TABLE dathang ALTER COLUMN trangthai SET DEFAULT 'Chờ xác nhận';");
        }
    }


    public function down()
    {
        Schema::table('dathang', function (Blueprint $table) {
            $table->dropForeign(['id_khuyenmai']);
            $table->dropColumn(['id_khuyenmai', 'tiengiam', 'tienphaitra']);
        });

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {

            Schema::table('dathang', function (Blueprint $table) {
                $table->integer('trangthai')->default(0)->change();
            });

        } else {

            DB::statement("ALTER TABLE dathang DROP CONSTRAINT IF EXISTS dathang_trangthai_check;");
            DB::statement("ALTER TABLE dathang ALTER COLUMN trangthai TYPE integer USING trangthai::integer;");
            DB::statement("ALTER TABLE dathang ALTER COLUMN trangthai SET DEFAULT 0;");
        }
    }

};
