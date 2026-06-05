<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa sạch các đánh giá cũ để tránh trùng lặp khi chạy lại seeder
        DB::table('comments')->delete();

        $now = Carbon::now();

        // Danh sách người dùng mẫu có trong DB (teo: 1, dieulinh: 4, lam ducthinh: 5)
        $userIds = [1, 4, 5];

        // Lấy danh sách sản phẩm hiện có trong CSDL
        $products = DB::table('sanpham')->get();

        if ($products->isEmpty()) {
            return;
        }

        // Các mẫu đánh giá theo danh mục sản phẩm
        $clothingReviews = [
            ['content' => 'Áo mặc rất mát, co giãn tốt và thấm hút mồ hôi siêu nhanh khi tập gym.', 'rating' => 5],
            ['content' => 'Quần co giãn thoải mái, thực hiện động tác squat rất dễ dàng không lo bị lộ.', 'rating' => 5],
            ['content' => 'Chất vải dày dặn, giặt máy nhiều lần vẫn giữ nguyên phom dáng, không bị xù lông.', 'rating' => 4],
            ['content' => 'Mặc ôm dáng đẹp, màu sắc chuẩn ảnh, nhìn cực kỳ thể thao và năng động.', 'rating' => 5],
            ['content' => 'Sport bra nâng đỡ tốt, chất vải êm ái không bị cấn hay khó chịu khi chạy bộ.', 'rating' => 5],
            ['content' => 'Chất lượng sản phẩm tuyệt vời, giao hàng nhanh, chủ shop tư vấn chọn size rất chuẩn.', 'rating' => 4],
        ];

        $equipmentReviews = [
            ['content' => 'Tạ cầm rất chắc tay, lớp cao su bên ngoài giảm chấn tốt, hạn chế ồn đáng kể.', 'rating' => 5],
            ['content' => 'Găng tay đệm dày dặn, bám xà cực tốt giúp lòng bàn tay không bị chai sạn hay phồng rộp.', 'rating' => 5],
            ['content' => 'Đai lưng da rất cứng cáp, khóa thép chắc chắn nâng đỡ cột sống cực kỳ tốt khi tập nặng.', 'rating' => 5],
            ['content' => 'Thảm yoga bám sàn tốt, độ bám cao nên tập không lo bị trơn trượt tay chân.', 'rating' => 5],
            ['content' => 'Gạch xốp EVA rất nhẹ nhưng chịu lực khỏe, đàn hồi tốt hỗ trợ thăng bằng tuyệt vời.', 'rating' => 4],
            ['content' => 'Dây kháng lực cao su tự nhiên co giãn tốt, lực đàn hồi mạnh mẽ tập rất đã.', 'rating' => 5],
            ['content' => 'Vòng pilates đàn hồi tốt, giúp các bài tập cơ trung tâm đạt hiệu quả cao hơn nhiều.', 'rating' => 4],
        ];

        $supplementReviews = [
            ['content' => 'Sữa dễ hòa tan, vị socola uống rất ngon và thơm, không bị ngọt gắt hay ngán.', 'rating' => 5],
            ['content' => 'Hỗ trợ tăng cơ rất tốt, kết hợp tập luyện đều đặn thấy cơ bắp săn chắc rõ rệt.', 'rating' => 5],
            ['content' => 'Sử dụng được một tháng thấy cân nặng tăng được 2kg, tiêu hóa tốt và không bị đầy bụng.', 'rating' => 5],
            ['content' => 'BCAA uống trong lúc tập giúp giảm mỏi cơ cực kỳ tốt, hỗ trợ phục hồi năng lượng rất nhanh.', 'rating' => 4],
            ['content' => 'Creatine tinh khiết giúp đẩy tạ khỏe hơn và sung sức hơn rõ rệt sau 2 tuần sử dụng.', 'rating' => 5],
            ['content' => 'Sản phẩm chính hãng, quét mã QR ra đúng thông tin nhà sản xuất, hạn sử dụng còn rất xa.', 'rating' => 5],
            ['content' => 'Đóng gói cẩn thận, hộp không móp méo, shop tặng kèm bình lắc xịn xò lắm nha.', 'rating' => 5],
            ['content' => 'Mùi vị dễ uống, hiệu quả cảm nhận rõ sau vài lần sử dụng, đáng đồng tiền bát gạo.', 'rating' => 4],
        ];

        $comments = [];

        foreach ($products as $product) {
            // Xác định mẫu đánh giá dựa theo danh mục sản phẩm (id_danhmuc)
            if (in_array($product->id_danhmuc, [1, 2])) {
                $pool = $clothingReviews;
            } elseif ($product->id_danhmuc == 3 || $product->id_danhmuc == 4) {
                $pool = $equipmentReviews;
            } else {
                $pool = $supplementReviews;
            }

            // Chọn ngẫu nhiên từ 2 đến 3 đánh giá cho mỗi sản phẩm
            $numReviews = rand(2, 3);
            $selectedKeys = array_rand($pool, $numReviews);

            if (!is_array($selectedKeys)) {
                $selectedKeys = [$selectedKeys];
            }

            // Xáo trộn người dùng mẫu để tránh trùng lặp tuần tự
            $users = $userIds;
            shuffle($users);

            foreach ($selectedKeys as $idx => $key) {
                $userId = $users[$idx % count($users)];
                $review = $pool[$key];

                $comments[] = [
                    'user_id' => $userId,
                    'sanpham_id' => $product->id_sanpham,
                    'id_dathang' => null,
                    'content' => $review['content'],
                    'rating' => $review['rating'],
                    'images' => null,
                    'created_at' => $now->copy()->subDays(rand(1, 30))->subHours(rand(1, 23)),
                    'updated_at' => $now,
                ];
            }
        }

        // Chèn hàng loạt đánh giá vào bảng
        DB::table('comments')->insert($comments);
    }
}
