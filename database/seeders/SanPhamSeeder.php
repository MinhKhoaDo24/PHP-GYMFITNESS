<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SanphamSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $products = [

            // ==================== DANH MỤC 1: QUẦN ÁO NAM ====================
            [
                'tensp' => 'Áo Thun Tập Gym Nam Co Giãn 4 Chiều',
                'sku' => 'NAM-TS-001',
                'giasp' => 259000,
                'gia_duoc_giam' => 199000,
                'mota' => 'Áo thun tập gym nam thoáng khí, co giãn 4 chiều, phù hợp vận động mạnh.',
                'mota_ngan' => 'Áo thun gym nam co giãn.',
                'giamgia' => 25,
                'giakhuyenmai' => 199000,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 1,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Áo Tanktop Nam QuickDry',
                'sku' => 'NAM-TT-002',
                'giasp' => 189000,
                'gia_duoc_giam' => 149000,
                'mota' => 'Tanktop nam thấm hút mồ hôi tốt, phù hợp tập gym và chạy bộ.',
                'mota_ngan' => 'Tanktop QuickDry.',
                'giamgia' => 20,
                'giakhuyenmai' => 149000,
                'soluong' => 80,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 1,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Quần Jogger Gym Nam FitBody',
                'sku' => 'NAM-JG-003',
                'giasp' => 320000,
                'gia_duoc_giam' => 270000,
                'mota' => 'Jogger thể thao nam ôm form, đàn hồi cao, phù hợp cho luyện tập.',
                'mota_ngan' => 'Quần jogger gym nam.',
                'giamgia' => 15,
                'giakhuyenmai' => 270000,
                'soluong' => 60,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 1,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Quần Short Gym Nam DryFit',
                'sku' => 'NAM-SH-004',
                'giasp' => 199000,
                'gia_duoc_giam' => 159000,
                'mota' => 'Quần short gym nam thoáng mát, công nghệ DryFit.',
                'mota_ngan' => 'Short gym DryFit.',
                'giamgia' => 20,
                'giakhuyenmai' => 159000,
                'soluong' => 70,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 1,
                'created_at' => $now, 'updated_at' => $now
            ],

            // ==================== DANH MỤC 2: QUẦN ÁO NỮ ====================
            [
                'tensp' => 'Áo Bra Tập Gym Nữ SupportMax',
                'sku' => 'NU-BRA-005',
                'giasp' => 299000,
                'gia_duoc_giam' => 239000,
                'mota' => 'Áo bra nữ nâng đỡ tốt, thoải mái khi vận động mạnh.',
                'mota_ngan' => 'Bra nữ SupportMax.',
                'giamgia' => 20,
                'giakhuyenmai' => 239000,
                'soluong' => 90,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 2,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Legging Gym Nữ Co Giãn 4 Chiều',
                'sku' => 'NU-LG-006',
                'giasp' => 350000,
                'gia_duoc_giam' => 290000,
                'mota' => 'Legging nữ tôn dáng, co giãn tốt, không bị lộ.',
                'mota_ngan' => 'Legging nữ tập gym.',
                'giamgia' => 17,
                'giakhuyenmai' => 290000,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 2,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Áo Croptop Nữ Workout',
                'sku' => 'NU-CT-007',
                'giasp' => 220000,
                'gia_duoc_giam' => 180000,
                'mota' => 'Áo croptop nữ năng động, phù hợp tập gym, yoga.',
                'mota_ngan' => 'Croptop workout.',
                'giamgia' => 18,
                'giakhuyenmai' => 180000,
                'soluong' => 75,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 2,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Quần Short Yoga Nữ UltraSoft',
                'sku' => 'NU-SH-008',
                'giasp' => 210000,
                'gia_duoc_giam' => 170000,
                'mota' => 'Short yoga nữ mềm mại, thấm hút mồ hôi.',
                'mota_ngan' => 'Short nữ UltraSoft.',
                'giamgia' => 19,
                'giakhuyenmai' => 170000,
                'soluong' => 85,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 2,
                'created_at' => $now, 'updated_at' => $now
            ],

            // ==================== DANH MỤC 3: DỤNG CỤ GYM ====================
            [
                'tensp' => 'Tạ Đơn 10kg Cao Cấp',
                'sku' => 'GYM-TD-009',
                'giasp' => 320000,
                'gia_duoc_giam' => 290000,
                'mota' => 'Tạ đơn bọc cao su, chống trượt.',
                'mota_ngan' => 'Tạ đơn 10kg.',
                'giamgia' => 10,
                'giakhuyenmai' => 290000,
                'soluong' => 40,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 3,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Găng Tay Tập Gym Chống Trượt',
                'sku' => 'GYM-GT-010',
                'giasp' => 149000,
                'gia_duoc_giam' => 119000,
                'mota' => 'Găng tay giúp tăng độ bám, hạn chế chai tay.',
                'mota_ngan' => 'Găng tay gym.',
                'giamgia' => 20,
                'giakhuyenmai' => 119000,
                'soluong' => 60,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 3,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Đai Lưng Gym PowerBack',
                'sku' => 'GYM-DL-011',
                'giasp' => 350000,
                'gia_duoc_giam' => 299000,
                'mota' => 'Đai lưng bảo vệ cột sống khi tập nặng.',
                'mota_ngan' => 'Đai lưng gym.',
                'giamgia' => 15,
                'giakhuyenmai' => 299000,
                'soluong' => 35,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 3,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Dây Kháng Lực PowerBand',
                'sku' => 'GYM-RB-012',
                'giasp' => 120000,
                'gia_duoc_giam' => 95000,
                'mota' => 'Dây kháng lực hỗ trợ tập toàn thân.',
                'mota_ngan' => 'Dây kháng lực.',
                'giamgia' => 20,
                'giakhuyenmai' => 95000,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 3,
                'created_at' => $now, 'updated_at' => $now
            ],

            // ==================== DANH MỤC 4: YOGA ====================
            [
                'tensp' => 'Thảm Yoga Cao Cấp PremiumMat',
                'sku' => 'YOGA-TM-013',
                'giasp' => 450000,
                'gia_duoc_giam' => 450000,
                'mota' => 'Thảm yoga chống trượt, độ bám cao.',
                'mota_ngan' => 'Thảm yoga premium.',
                'giamgia' => 0,
                'giakhuyenmai' => 450000,
                'soluong' => 50,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 4,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Gạch Yoga Foam Chống Trượt',
                'sku' => 'YOGA-BLOCK-014',
                'giasp' => 150000,
                'gia_duoc_giam' => 130000,
                'mota' => 'Gạch yoga hỗ trợ giữ thăng bằng.',
                'mota_ngan' => 'Block yoga foam.',
                'giamgia' => 13,
                'giakhuyenmai' => 130000,
                'soluong' => 70,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 4,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Dây Đai Yoga StretchBand',
                'sku' => 'YOGA-SB-015',
                'giasp' => 120000,
                'gia_duoc_giam' => 95000,
                'mota' => 'Dây đai yoga hỗ trợ giãn cơ.',
                'mota_ngan' => 'Dây đai yoga.',
                'giamgia' => 20,
                'giakhuyenmai' => 95000,
                'soluong' => 90,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 4,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Vòng Yoga Pilates Ring',
                'sku' => 'YOGA-PR-016',
                'giasp' => 250000,
                'gia_duoc_giam' => 220000,
                'mota' => 'Vòng yoga pilates giúp tăng cường cơ trung tâm.',
                'mota_ngan' => 'Pilates ring.',
                'giamgia' => 12,
                'giakhuyenmai' => 220000,
                'soluong' => 60,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 4,
                'created_at' => $now, 'updated_at' => $now
            ],

        ];

        // Insert 20 sản phẩm
        DB::table('sanpham')->insert($products);
    }
}
