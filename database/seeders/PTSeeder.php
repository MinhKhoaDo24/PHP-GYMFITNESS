<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhanQuyen;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;

class PTSeeder extends Seeder
{
    public function run(): void
    {
        // Thêm quyền PT vào bảng phanquyen (nếu chưa có)
        PhanQuyen::firstOrCreate(
            ['id_phanquyen' => 4],
            ['tenquyen' => 'pt']
        );

        // Seed 3 tài khoản PT mẫu
        $pts = [
            [
                'hoten'        => 'Nguyễn Văn Hùng',
                'email'        => 'pt.hung@risefitness.vn',
                'password'     => Hash::make('123456'),
                'diachi'       => '12 Chùa Bộc, Đống Đa, Hà Nội',
                'sdt'          => 912345678,
                'id_phanquyen' => 4,
                'trang_thai'   => 1,
            ],
            [
                'hoten'        => 'Trần Minh Tuấn',
                'email'        => 'pt.tuan@risefitness.vn',
                'password'     => Hash::make('123456'),
                'diachi'       => '45 Cầu Giấy, Hà Nội',
                'sdt'          => 987654321,
                'id_phanquyen' => 4,
                'trang_thai'   => 1,
            ],
            [
                'hoten'        => 'Lê Thị Mai Anh',
                'email'        => 'pt.maianh@risefitness.vn',
                'password'     => Hash::make('123456'),
                'diachi'       => '88 Láng Hạ, Ba Đình, Hà Nội',
                'sdt'          => 933221144,
                'id_phanquyen' => 4,
                'trang_thai'   => 1,
            ],
        ];

        foreach ($pts as $pt) {
            NguoiDung::firstOrCreate(
                ['email' => $pt['email']],
                $pt
            );
        }
    }
}
