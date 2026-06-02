<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;
use App\Models\SanPham;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo danh sách các size mẫu (rất phù hợp cho đồ Gym/Fitness)
        $sizes = [
            ['ten_size' => 'S', 'mota' => 'Size Nhỏ (Small)'],
            ['ten_size' => 'M', 'mota' => 'Size Vừa (Medium)'],
            ['ten_size' => 'L', 'mota' => 'Size Lớn (Large)'],
            ['ten_size' => 'XL', 'mota' => 'Size Rất Lớn (Extra Large)'],
            ['ten_size' => 'XXL', 'mota' => 'Size Ngoại Cỡ (Double Extra Large)'],
            ['ten_size' => 'Free Size', 'mota' => 'Kích cỡ tự do, co giãn tốt'],
        ];

        // Dùng firstOrCreate để nếu chạy lại lệnh seed nhiều lần không bị trùng lặp dữ liệu
        foreach ($sizes as $size) {
            Size::firstOrCreate(
                ['ten_size' => $size['ten_size']], // Điều kiện kiểm tra trùng
                ['mota' => $size['mota']]          // Dữ liệu thêm nếu chưa có
            );
        }

        // 2. Tự động gán ngẫu nhiên size cho các sản phẩm đang có trong database để test
        $allSizes = Size::all();
        $allSanPhams = SanPham::all();

        // Nếu trong DB đã có sản phẩm thì mới chạy vòng lặp
        if ($allSanPhams->count() > 0) {
            foreach ($allSanPhams as $sanpham) {
                // Lấy ngẫu nhiên từ 1 đến 3 size từ danh sách
                $randomSizes = $allSizes->random(rand(1, 3));

                foreach ($randomSizes as $size) {
                    // Kiểm tra xem sản phẩm này đã được gán size này chưa
                    $hasSize = $sanpham->sizes()->where('sanpham_size.id_size', $size->id_size)->exists();

                    if (!$hasSize) {
                        // Gọi mối quan hệ n-n đã cấu hình ở Model để chèn vào bảng sanpham_size
                        $sanpham->sizes()->attach($size->id_size, [
                            'soluong' => rand(10, 50), // Số lượng tồn kho ngẫu nhiên từ 10 đến 50 cái
                            'gia_cong_them' => 0       // Không phụ thu thêm tiền
                        ]);
                    }
                }
            }
        }
    }
}
