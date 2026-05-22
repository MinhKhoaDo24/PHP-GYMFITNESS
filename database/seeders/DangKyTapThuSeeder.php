<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DangKyTapThuSeeder extends Seeder
{
    public function run()
    {
        $gioList = [
            '07:00 - 09:00',
            '09:00 - 11:00',
            '13:00 - 15:00',
            '15:00 - 17:00'
        ];

        for ($i = 1; $i <= 10; $i++) {
            DB::table('dangkidichvu')->insert([
                'ho_ten'         => fake()->name(),
                'email'          => fake()->email(),
                'so_dien_thoai'  => fake()->phoneNumber(),
                'ngay_mong_muon' => fake()->dateTimeBetween('-3 days', '+7 days')->format('Y-m-d'),
                'gio_mong_muon'  => $gioList[array_rand($gioList)],
                'ghi_chu'        => fake()->boolean(30) ? fake()->sentence(8) : null,
                'trangthai'      => rand(0, 4),  // 0 → 4
                'id_nguoidung'   => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]);
        }
    }
}
