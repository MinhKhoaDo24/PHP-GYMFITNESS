<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PhanQuyenSeeder::class,
            NguoiDungSeeder::class,
            PTSeeder::class,
            DanhMucSeeder::class,
            DangKyTapThuSeeder::class,
            KhuyenMaiSeeder::class,
            SanphamSeeder::class,
            ImageSeeder::class,
            SizeSeeder::class,
            GoiTapSeeder::class,
            SupplementSeeder::class
        ]);
    }
}
