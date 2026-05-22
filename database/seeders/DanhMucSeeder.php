<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhmucSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danhmuc')->insert([
            [
                'ten_danhmuc'        => 'Quần tập',
                'id_danhmuc'        => 1,
                'status'             => 1,
            ],
            [
                'ten_danhmuc'        => 'Áo tập ',
                'id_danhmuc'        => 2,
                'status'             => 1,
            ],
            [
                'ten_danhmuc'        => 'Găng tay boxing',
                'id_danhmuc'         => 3,
                'status'             => 1,
            ],
            [
                'ten_danhmuc'        => 'Dây kháng lực',
                'id_danhmuc'         => 4,
                'status'             => 1,
            ],
        ]);
    }
}
