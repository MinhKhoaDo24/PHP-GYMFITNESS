<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
                'password' => Hash::make('123456'),
                'diachi' => 'Đống Đa, Hà nội',
                'sdt' => 379487241,
                'id_phanquyen' => 2,
            ],
            [
                'id_nd' => 2,
                'hoten' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'diachi' => 'Đống Đa, Hà nội',
                'sdt' => 379487352,
                'id_phanquyen' => 1,
            ],
            [
                'id_nd' => 4,
                'hoten' => 'dieulinh',
                'email' => 'dlinh30042004@gmail.com',
                'password' => Hash::make('123456'),
                'diachi' => '102',
                'sdt' => 359723803,
                'id_phanquyen' => 1,
            ],         
            [
                'id_nd' => 5,
                'hoten' => 'LÂM ĐỨC THỊNH',
                'email' => 'ducthinh4129@gmail.com',
                'password' => Hash::make('123456'),
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
