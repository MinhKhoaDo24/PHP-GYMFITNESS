<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Danh sách người dùng mẫu mặc định và fake
        $userIds = [1, 4, 5];
        $fakeEmails = [
            'namnguyen@gmail.com', 'hoatran@gmail.com', 'hoanganh@gmail.com',
            'ducpham@gmail.com', 'tranghoang@gmail.com', 'baodo@gmail.com',
            'linhvu@gmail.com', 'khanhphan@gmail.com', 'tuanbui@gmail.com',
            'chinguyen@gmail.com'
        ];

        foreach ($fakeEmails as $email) {
            $user = DB::table('nguoidung')->where('email', $email)->first();
            if ($user) {
                $userIds[] = $user->id_nd;
            }
        }

        // Xóa sạch các đánh giá cũ của các users mẫu này để tránh trùng lặp
        DB::table('comments')->whereIn('user_id', $userIds)->delete();

        // Lấy danh sách đơn hàng đã hoàn thành của các user này
        $completedOrders = DB::table('dathang')
            ->where('trangthai', 'Hoàn thành')
            ->whereIn('id_nd', $userIds)
            ->get();

        if ($completedOrders->isEmpty()) {
            $this->command->warn('Không tìm thấy đơn hàng Hoàn thành nào để seeding đánh giá.');
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
            ['content' => 'Màu sắc ngoài đời đẹp hơn trong ảnh nhiều, mặc đi tập ai cũng hỏi mua ở đâu.', 'rating' => 5],
            ['content' => 'Giao hàng siêu nhanh, vải sờ vào rất thích, độ co giãn chuẩn thể thao.', 'rating' => 5],
            ['content' => 'Dáng áo ôm rất gọn gàng, tôn cơ bắp tốt. Sẽ mua thêm vài chiếc màu khác.', 'rating' => 5],
            ['content' => 'Quần legging cạp cao mặc rất nịnh dáng, gen bụng tốt mà không bị cấn khó thở.', 'rating' => 5],
            ['content' => 'Chất thun mát lịm, giặt không hề bị nhão hay bay màu. Rất hài lòng.', 'rating' => 5],
            ['content' => 'Form cực kỳ chuẩn, ôm sát cơ thể giúp dễ quan sát động tác khi tập trước gương.', 'rating' => 5],
        ];

        $equipmentReviews = [
            ['content' => 'Tạ cầm rất chắc tay, lớp cao su bên ngoài giảm chấn tốt, hạn chế ồn đáng kể.', 'rating' => 5],
            ['content' => 'Găng tay đệm dày dặn, bám xà cực tốt giúp lòng bàn tay không bị chai sạn hay phồng rộp.', 'rating' => 5],
            ['content' => 'Đai lưng da rất cứng cáp, khóa thép chắc chắn nâng đỡ cột sống cực kỳ tốt khi tập nặng.', 'rating' => 5],
            ['content' => 'Thảm yoga bám sàn tốt, độ bám cao nên tập không lo bị trơn trượt tay chân.', 'rating' => 5],
            ['content' => 'Gạch xốp EVA rất nhẹ nhưng chịu lực khỏe, đàn hồi tốt hỗ trợ thăng bằng tuyệt vời.', 'rating' => 4],
            ['content' => 'Dây kháng lực cao su tự nhiên co giãn tốt, lực đàn hồi mạnh mẽ tập rất đã.', 'rating' => 5],
            ['content' => 'Vòng pilates đàn hồi tốt, giúp các bài tập cơ trung tâm đạt hiệu quả cao hơn nhiều.', 'rating' => 4],
            ['content' => 'Dây kháng lực độ đàn hồi tốt, tập mông đùi rất hiệu quả, mang đi du lịch tiện lợi.', 'rating' => 5],
            ['content' => 'Găng tay ôm tay, khóa dán cổ tay chắc chắn bảo vệ khớp tốt khi đẩy ngực nặng.', 'rating' => 4],
            ['content' => 'Thảm cao su tự nhiên bám sàn gỗ siêu tốt, không bị xê dịch tí nào khi tập động tác đứng.', 'rating' => 5],
            ['content' => 'Đai lưng dầy dặn và êm ái vô cùng, nâng đỡ cột sống rất tốt, rất an tâm.', 'rating' => 5],
            ['content' => 'Gạch tập rất chắc chắn, không bị lún xẹp như mấy loại rẻ tiền khác.', 'rating' => 4],
            ['content' => 'Tạ đơn đúc đẹp, cao su bọc mịn không có mùi hôi khó chịu.', 'rating' => 5],
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
            ['content' => 'Uống vị dâu rất thơm mát, cảm giác nhẹ nhàng, dễ tiêu, không bị ngấy như mấy dòng khác.', 'rating' => 5],
            ['content' => 'Creatine kết hợp Pre-workout đẩy tạ cực kỳ sung, cơ bắp căng phồng và bền sức hơn hẳn.', 'rating' => 5],
            ['content' => 'Dùng Mass Infusion này thấy hấp thu rất tốt, ăn uống ngon miệng hơn hẳn.', 'rating' => 5],
            ['content' => 'Whey Gold Standard thì thương hiệu đỉnh cao rồi, chuẩn tinh khiết, phục hồi cơ nhanh.', 'rating' => 5],
            ['content' => 'Hương vị ngon dễ uống, pha chung với đá uống giải khát sau tập cực đã.', 'rating' => 5],
            ['content' => 'Đóng gói bọc xốp chống sốc dày dặn, chủ shop tặng kèm muỗng múc rất tiện.', 'rating' => 5],
        ];

        $comments = [];

        foreach ($completedOrders as $order) {
            // Lấy các chi tiết sản phẩm của đơn hàng này
            $items = DB::table('chitiet_donhang')
                ->where('id_dathang', $order->id_dathang)
                ->get();

            foreach ($items as $item) {
                // Tìm sản phẩm tương ứng để biết danh mục
                $product = DB::table('sanpham')
                    ->where('id_sanpham', $item->id_sanpham)
                    ->first();

                if (!$product) {
                    continue;
                }

                // Chọn pool đánh giá dựa trên danh mục
                if (in_array($product->id_danhmuc, [1, 2])) {
                    $pool = $clothingReviews;
                } elseif ($product->id_danhmuc == 3 || $product->id_danhmuc == 4) {
                    $pool = $equipmentReviews;
                } else {
                    $pool = $supplementReviews;
                }

                // Chọn ngẫu nhiên 1 đánh giá từ pool
                $review = $pool[array_rand($pool)];

                $comments[] = [
                    'user_id' => $order->id_nd,
                    'sanpham_id' => $item->id_sanpham,
                    'id_dathang' => $order->id_dathang,
                    'content' => $review['content'],
                    'rating' => $review['rating'],
                    'images' => null,
                    'created_at' => Carbon::parse($order->ngay_hoan_thanh)->addHours(rand(1, 5)),
                    'updated_at' => $now,
                ];
            }
        }

        // Chèn hàng loạt đánh giá vào bảng comments
        if (!empty($comments)) {
            DB::table('comments')->insert($comments);
        }
    }
}
