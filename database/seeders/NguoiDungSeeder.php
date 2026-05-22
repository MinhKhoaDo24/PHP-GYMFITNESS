<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NguoiDung;

class NguoiDungSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id_nd' => 1,
                'hoten' => 'teo',
                'email' => 'teo@gmail.com',
                'password' => '$2y$12$o42vmZrn2TzpqtP0NJ/VyOd0qgv2coPm76eyZ/ZNwUgBHNUUW6H2y',
                'diachi' => 'Đống Đa, Hà nội',
                'sdt' => 379487241,
                'id_phanquyen' => 2,
            ],
            [
                'id_nd' => 2,
                'hoten' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$/NpqKoSr.zwBa83nJfw8KuHTYjVmH51H/boJ.CxtIR8Sn/tTVg.NS',
                'diachi' => 'Đống Đa, Hà nội',
                'sdt' => 379487352,
                'id_phanquyen' => 1,
            ],
            [
                'id_nd' => 4,
                'hoten' => 'dieulinh',
                'email' => 'dlinh30042004@gmail.com',
                'password' => '$2y$12$/NpqKoSr.zwBa83nJfw8KuHTYjVmH51H/boJ.CxtIR8Sn/tTVg.NS',
                'diachi' => '102',
                'sdt' => 359723803,
                'id_phanquyen' => 1,
            ],         
            [
                'id_nd' => 5,
                'hoten' => 'LÂM ĐỨC THỊNH',
                'email' => 'ducthinh4129@gmail.com',
                'password' => '$2y$12$ABs1ORFOI1txCMSuRwlaIuVPRqgFk.eka.BBnZ2g.PnwuLMl9kRgm',
                'diachi' => '58 Nguyễn Khánh Toàn',
                'sdt' => 359723803,
                'id_phanquyen' => 1,
            ],   
        ];

        foreach ($data as $item) {
            NguoiDung::create($item);
        }
    }
}
