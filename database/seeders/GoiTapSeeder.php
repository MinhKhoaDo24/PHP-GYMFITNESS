<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoiTapSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // =====================================================
        // 1. SEED BẢNG GOITAP — 6 gói tập
        // =====================================================
        $goiTaps = [
            [
                'ten_goi'         => 'Basic Silver I',
                'slug'            => 'basic-silver-1',
                'mo_ta_ngan'      => 'Gym + Boxing',
                'mo_ta_chi_tiet'  => '<ul>'
                    . '<li>Phát triển cơ – cải thiện vóc dáng.</li>'
                    . '<li>Tập boxing tăng sức bền, phản xạ và đốt mỡ nhanh.</li>'
                    . '<li>Phù hợp cho người muốn tập sức mạnh + vận động năng lượng cao.</li>'
                    . '<li>Gói cơ bản hiệu quả dành cho người mới bắt đầu.</li>'
                    . '</ul>',
                'hinh_anh'        => 'frontend/img/basic-silver-1.jpg',
                'loai_goi'        => 'silver',
                'gia_pt_them'     => 1500000,
                'is_best'         => 0,
                'trang_thai'      => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'ten_goi'         => 'Basic Silver II',
                'slug'            => 'basic-silver-2',
                'mo_ta_ngan'      => 'Bơi lội',
                'mo_ta_chi_tiet'  => '<ul>'
                    . '<li>Vận động toàn thân nhẹ nhàng nhưng hiệu quả cao.</li>'
                    . '<li>Cải thiện hô hấp, tim mạch, giúp cơ thể săn chắc tự nhiên.</li>'
                    . '<li>Ít gây chấn thương, phù hợp mọi độ tuổi.</li>'
                    . '<li>Gói tập nhẹ nhàng – thư giãn – tốt cho sức khỏe lâu dài.</li>'
                    . '</ul>',
                'hinh_anh'        => 'frontend/img/basic-silver-2.jpg',
                'loai_goi'        => 'silver',
                'gia_pt_them'     => 1500000,
                'is_best'         => 0,
                'trang_thai'      => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'ten_goi'         => 'Basic Silver III',
                'slug'            => 'basic-silver-3',
                'mo_ta_ngan'      => 'Yoga + Dance',
                'mo_ta_chi_tiet'  => '<ul>'
                    . '<li>Yoga giúp tăng độ dẻo dai, giảm stress, cải thiện tư thế.</li>'
                    . '<li>Dance Fitness đốt calories nhanh, vui nhộn, tạo hứng thú tập luyện.</li>'
                    . '<li>Dành cho người muốn giữ dáng kết hợp thư giãn tinh thần.</li>'
                    . '<li>Sự kết hợp giữa rèn luyện cơ thể và nuôi dưỡng tinh thần.</li>'
                    . '</ul>',
                'hinh_anh'        => 'frontend/img/basic-silver-3.jpg',
                'loai_goi'        => 'silver',
                'gia_pt_them'     => 1500000,
                'is_best'         => 0,
                'trang_thai'      => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'ten_goi'         => 'Standard Gold I',
                'slug'            => 'standard-gold-1',
                'mo_ta_ngan'      => 'Gym + Boxing + Bơi',
                'mo_ta_chi_tiet'  => '<ul>'
                    . '<li>Tập đa môn toàn diện: tăng cơ – tăng sức bền – phục hồi tốt.</li>'
                    . '<li>Boxing đốt mỡ mạnh, Gym lên cơ rõ rệt, Bơi thư giãn cơ thể.</li>'
                    . '<li>Phù hợp cho người muốn kết quả nhanh và rõ rệt.</li>'
                    . '<li>Gói tập nâng cao – đa dạng – hiệu quả cao.</li>'
                    . '</ul>',
                'hinh_anh'        => 'frontend/img/standard-gold-1.jpg',
                'loai_goi'        => 'gold',
                'gia_pt_them'     => 2000000,
                'is_best'         => 0,
                'trang_thai'      => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'ten_goi'         => 'Standard Gold II',
                'slug'            => 'standard-gold-2',
                'mo_ta_ngan'      => 'Yoga + Dance + Bơi',
                'mo_ta_chi_tiet'  => '<ul>'
                    . '<li>Yoga cân bằng tinh thần &amp; tăng linh hoạt.</li>'
                    . '<li>Dance tạo năng lượng và đốt mỡ hiệu quả.</li>'
                    . '<li>Bơi phục hồi cơ và cải thiện hệ tim mạch.</li>'
                    . '<li>Gói đa dạng – nhẹ nhàng – phù hợp với người thích sự cân bằng.</li>'
                    . '</ul>',
                'hinh_anh'        => 'frontend/img/standard-gold-2.jpg',
                'loai_goi'        => 'gold',
                'gia_pt_them'     => 2000000,
                'is_best'         => 0,
                'trang_thai'      => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'ten_goi'         => 'Premium Diamond',
                'slug'            => 'premium-diamond',
                'mo_ta_ngan'      => 'Full Bộ Môn',
                'mo_ta_chi_tiet'  => '<ul>'
                    . '<li>Truy cập tất cả bộ môn: Gym, Boxing, Yoga, Dance, Bơi.</li>'
                    . '<li>Ưu tiên đăng ký lớp &amp; đặc quyền tham gia sự kiện.</li>'
                    . '<li>Lộ trình tập luyện toàn diện nhất của phòng gym.</li>'
                    . '<li>Gói cao cấp nhất – không giới hạn – trải nghiệm trọn vẹn.</li>'
                    . '</ul>',
                'hinh_anh'        => 'frontend/img/premium-diamond.jpg',
                'loai_goi'        => 'diamond',
                'gia_pt_them'     => 2500000,
                'is_best'         => 1,
                'trang_thai'      => 1,
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ];

        foreach ($goiTaps as $goiTap) {
            DB::table('goitap')->updateOrInsert(
                ['slug' => $goiTap['slug']],
                $goiTap
            );
        }

        // =====================================================
        // 2. SEED BẢNG GOITAP_GIA — Bảng giá theo tháng
        // =====================================================

        // Lấy id_goitap vừa insert theo slug
        $ids = DB::table('goitap')->pluck('id_goitap', 'slug');

        // Bảng giá: [slug => [1 tháng, 3 tháng, 6 tháng, 12 tháng]]
        $bangGia = [
            'basic-silver-1'  => [800000,  2100000,  3600000,   6000000],
            'basic-silver-2'  => [900000,  2400000,  4200000,   7200000],
            'basic-silver-3'  => [850000,  2250000,  3900000,   6600000],
            'standard-gold-1' => [1200000, 3300000,  5400000,   9600000],
            'standard-gold-2' => [1100000, 3000000,  5100000,   9000000],
            'premium-diamond' => [1800000, 4800000,  8400000,  14400000],
        ];

        $soThangOptions = [1, 3, 6, 12];
        $giaRows = [];

        foreach ($bangGia as $slug => $prices) {
            $idGoiTap = $ids[$slug];

            foreach ($soThangOptions as $index => $soThang) {
                $giaRows[] = [
                    'id_goitap'      => $idGoiTap,
                    'so_thang'       => $soThang,
                    'gia_goc'        => $prices[$index],
                    'gia_khuyen_mai' => null,
                    'trang_thai'     => 1,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ];
            }
        }

        foreach ($giaRows as $row) {
            DB::table('goitap_gia')->updateOrInsert(
                ['id_goitap' => $row['id_goitap'], 'so_thang' => $row['so_thang']],
                $row
            );
        }
    }
}
