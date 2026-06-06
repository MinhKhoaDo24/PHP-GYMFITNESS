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
            '15:00 - 17:00',
        ];

        $data = [
            ['ho_ten' => 'Nguyễn Thị Lan', 'email' => 'lan.nguyen@gmail.com', 'sdt' => '0901234567', 'ghi_chu' => 'Muốn giảm cân nhanh'],
            ['ho_ten' => 'Trần Văn Minh', 'email' => 'minh.tran@gmail.com', 'sdt' => '0912345678', 'ghi_chu' => null],
            ['ho_ten' => 'Lê Thị Hoa', 'email' => 'hoa.le@gmail.com', 'sdt' => '0923456789', 'ghi_chu' => 'Tập tăng cơ'],
            ['ho_ten' => 'Phạm Đức Nam', 'email' => 'nam.pham@gmail.com', 'sdt' => '0934567890', 'ghi_chu' => null],
            ['ho_ten' => 'Hoàng Thị Mai', 'email' => 'mai.hoang@gmail.com', 'sdt' => '0945678901', 'ghi_chu' => 'Cải thiện sức khỏe'],
            ['ho_ten' => 'Đỗ Văn Long', 'email' => 'long.do@gmail.com', 'sdt' => '0956789012', 'ghi_chu' => null],
            ['ho_ten' => 'Vũ Thị Thu', 'email' => 'thu.vu@gmail.com', 'sdt' => '0967890123', 'ghi_chu' => 'Tập yoga và cardio'],
            ['ho_ten' => 'Bùi Quang Huy', 'email' => 'huy.bui@gmail.com', 'sdt' => '0978901234', 'ghi_chu' => null],
            ['ho_ten' => 'Ngô Thị Bích', 'email' => 'bich.ngo@gmail.com', 'sdt' => '0989012345', 'ghi_chu' => 'Phục hồi sau chấn thương'],
            ['ho_ten' => 'Đinh Văn Tùng', 'email' => 'tung.dinh@gmail.com', 'sdt' => '0990123456', 'ghi_chu' => null],
        ];

        $ngayList = [
            Carbon::now()->subDays(2)->format('Y-m-d'),
            Carbon::now()->subDay()->format('Y-m-d'),
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDay()->format('Y-m-d'),
            Carbon::now()->addDays(3)->format('Y-m-d'),
            Carbon::now()->addDays(5)->format('Y-m-d'),
            Carbon::now()->addDays(7)->format('Y-m-d'),
        ];

        foreach ($data as $i => $item) {
            // Chỉ insert nếu email chưa tồn tại
            $exists = DB::table('dangkidichvu')->where('email', $item['email'])->exists();
            if (!$exists) {
                DB::table('dangkidichvu')->insert([
                    'ho_ten'         => $item['ho_ten'],
                    'email'          => $item['email'],
                    'so_dien_thoai'  => $item['sdt'],
                    'ngay_mong_muon' => $ngayList[$i % count($ngayList)],
                    'gio_mong_muon'  => $gioList[$i % count($gioList)],
                    'ghi_chu'        => $item['ghi_chu'],
                    'trangthai'      => rand(0, 3),
                    'id_nguoidung'   => null,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]);
            }
        }
    }
}
