<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
        $danhmuc = [
            ['id_danhmuc' => 1, 'ten_danhmuc' => 'Quần tập',       'status' => 1],
            ['id_danhmuc' => 2, 'ten_danhmuc' => 'Áo tập',         'status' => 1],
            ['id_danhmuc' => 3, 'ten_danhmuc' => 'Găng tay boxing', 'status' => 1],
            ['id_danhmuc' => 4, 'ten_danhmuc' => 'Dây kháng lực',  'status' => 1],
        ];

        foreach ($danhmuc as $item) {
            DB::table('danhmuc')->updateOrInsert(
                ['id_danhmuc' => $item['id_danhmuc']],
                $item
            );
        }

        // Reset PostgreSQL sequence
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT setval('danhmuc_id_danhmuc_seq', (SELECT MAX(id_danhmuc) FROM danhmuc))");
        }
    }
}
