<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $sanphams = DB::table('sanpham')->get();

        foreach ($sanphams as $sp) {
            DB::table('images')->insert([
                'id_sanpham' => $sp->id_sanpham,
                'duong_dan' => 'frontend/upload/1764614789.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
