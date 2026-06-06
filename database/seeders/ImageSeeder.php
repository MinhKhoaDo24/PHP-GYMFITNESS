<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Mảng các sản phẩm của SanphamSeeder và URL ảnh tương ứng
        $productImages = [
            'NAM-TS-001' => [
                'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?q=80&w=600',
                'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600'
            ],
            'NAM-TT-002' => [
                'https://images.unsplash.com/photo-1567013127542-490d757e51fc?q=80&w=600',
                'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=600'
            ],
            'NAM-JG-003' => [
                'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=600'
            ],
            'NAM-SH-004' => [
                'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?q=80&w=600'
            ],
            'NU-BRA-005' => [
                'https://images.unsplash.com/photo-1518310383802-640c2de311b2?q=80&w=600'
            ],
            'NU-LG-006' => [
                'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=600'
            ],
            'NU-CT-007' => [
                'https://images.unsplash.com/photo-1518622358385-8ea7d0794bf6?q=80&w=600'
            ],
            'NU-SH-008' => [
                'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=600'
            ],
            'GYM-TD-009' => [
                'https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?q=80&w=600'
            ],
            'GYM-GT-010' => [
                'https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?q=80&w=600'
            ],
            'GYM-DL-011' => [
                'https://images.unsplash.com/photo-1620188467120-5042ed1eb5da?q=80&w=600'
            ],
            'GYM-RB-012' => [
                'https://images.unsplash.com/photo-1598971861713-54ad16a7e72e?q=80&w=600'
            ],
            'YOGA-TM-013' => [
                'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?q=80&w=600'
            ],
            'YOGA-BLOCK-014' => [
                'https://images.unsplash.com/photo-1600881333168-2ef49b341f30?q=80&w=600'
            ],
            'YOGA-SB-015' => [
                'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=600'
            ],
            'YOGA-PR-016' => [
                'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=600'
            ],
        ];

        foreach ($productImages as $sku => $urls) {
            // Tìm sản phẩm trong DB
            $product = DB::table('sanpham')->where('sku', $sku)->first();
            if (!$product) {
                continue;
            }

            $productId = $product->id_sanpham;

            // Xóa ảnh cũ trong DB
            DB::table('images')->where('id_sanpham', $productId)->delete();

            // Download ảnh mới nếu chưa có trên đĩa và lưu vào DB
            foreach ($urls as $index => $url) {
                try {
                    $dir = public_path('frontend/upload');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0755, true);
                    }

                    // Tải ảnh về với tên cố định (không dùng time() để tránh mất ảnh khi restart container)
                    $ext = 'jpg';
                    $filename = 'product_' . $productId . '_' . $index . '.' . $ext;
                    $filepath = $dir . '/' . $filename;

                    if (!file_exists($filepath)) {
                        $ctx = stream_context_create([
                            "ssl" => [
                                "verify_peer" => false,
                                "verify_peer_name" => false,
                            ],
                            "http" => [
                                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.0.0 Safari/537.36\r\n"
                            ]
                        ]);

                        $imgData = @file_get_contents($url, false, $ctx);
                        if ($imgData !== false) {
                            file_put_contents($filepath, $imgData);
                        }
                    }

                    DB::table('images')->insert([
                        'id_sanpham' => $productId,
                        'duong_dan' => 'frontend/upload/' . $filename,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Lỗi cào ảnh sản phẩm " . $sku . ": " . $e->getMessage());
                }
            }
        }
    }
}
