<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KhuyenMaiSeeder extends Seeder
{
    public function run()
    {
        DB::table('khuyenmai')->insert([
            [
                'ten_khuyenmai'  => 'Giảm 10% cho đơn từ 500k',
                'ma_code'        => 'LOFI10',
                'gia_tri_giam'   => 10,
                'kieu_giam'      => 'percent',
                'mo_ta'          => 'Mã giảm 10% cho đơn hàng từ 500k trở lên.',
                'don_toi_thieu'  => 500000,
                'giam_toi_da'    => 0,
                'so_luot_da_dung'=> 0,
                'gioi_han_luot'  => 1000,
                'ngay_bat_dau'   => Carbon::now(),
                'ngay_ket_thuc'  => Carbon::now()->addMonths(1),
                'trang_thai'     => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'ten_khuyenmai'  => 'Giảm 15% cho đơn từ 1 triệu',
                'ma_code'        => 'LOFI15',
                'gia_tri_giam'   => 15,
                'kieu_giam'      => 'percent',
                'mo_ta'          => 'Mã giảm 15% cho đơn hàng từ 1.000.000đ trở lên.',
                'don_toi_thieu'  => 1000000,
                'giam_toi_da'    => 0,
                'so_luot_da_dung'=> 0,
                'gioi_han_luot'  => 1000,
                'ngay_bat_dau'   => Carbon::now(),
                'ngay_ket_thuc'  => Carbon::now()->addMonths(1),
                'trang_thai'     => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'ten_khuyenmai'  => 'Giảm 99K cho đơn từ 700k',
                'ma_code'        => 'LOFI99K',
                'gia_tri_giam'   => 99000,
                'kieu_giam'      => 'money',
                'mo_ta'          => 'Giảm trực tiếp 99.000đ cho đơn hàng từ 700.000đ.',
                'don_toi_thieu'  => 700000,
                'giam_toi_da'    => 99000,
                'so_luot_da_dung'=> 0,
                'gioi_han_luot'  => 1000,
                'ngay_bat_dau'   => Carbon::now(),
                'ngay_ket_thuc'  => Carbon::now()->addMonths(1),
                'trang_thai'     => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'ten_khuyenmai'  => 'Miễn phí vận chuyển cho đơn từ 500k',
                'ma_code'        => 'FREESHIP',
                'gia_tri_giam'   => 25000,
                'kieu_giam'      => 'money',
                'mo_ta'          => 'Miễn phí vận chuyển cho đơn hàng từ 500.000đ.',
                'don_toi_thieu'  => 500000,
                'giam_toi_da'    => 25000,
                'so_luot_da_dung'=> 0,
                'gioi_han_luot'  => 1000,
                'ngay_bat_dau'   => Carbon::now(),
                'ngay_ket_thuc'  => Carbon::now()->addMonths(1),
                'trang_thai'     => 1,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
