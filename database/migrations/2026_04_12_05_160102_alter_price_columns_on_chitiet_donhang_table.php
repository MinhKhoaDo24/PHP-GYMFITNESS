<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE chitiet_donhang ALTER COLUMN giatien TYPE NUMERIC(15,2) USING giatien::numeric');
            DB::statement('ALTER TABLE chitiet_donhang ALTER COLUMN giakhuyenmai TYPE NUMERIC(15,2) USING giakhuyenmai::numeric');
        } elseif ($driver === 'mysql') {
            Schema::table('chitiet_donhang', function (Blueprint $table) {
                $table->decimal('giatien', 15, 2)->change();
                $table->decimal('giakhuyenmai', 15, 2)->change();
            });
        }
    }

    public function down()
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE chitiet_donhang ALTER COLUMN giatien TYPE INTEGER USING round(giatien)');
            DB::statement('ALTER TABLE chitiet_donhang ALTER COLUMN giakhuyenmai TYPE INTEGER USING round(giakhuyenmai)');
        } elseif ($driver === 'mysql') {
            Schema::table('chitiet_donhang', function (Blueprint $table) {
                $table->integer('giatien')->change();
                $table->integer('giakhuyenmai')->change();
            });
        }
    }
};
