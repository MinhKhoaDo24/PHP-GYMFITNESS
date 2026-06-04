<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    $driver = Schema::getConnection()->getDriverName();

    if ($driver === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('danhmuc')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    } else {
        DB::statement('TRUNCATE TABLE danhmuc RESTART IDENTITY CASCADE;');
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
