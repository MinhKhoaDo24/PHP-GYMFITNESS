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

        // Danh sách người dùng mẫu mặc định có trong DB
        $userIds = [1, 4, 5];

        // Tạo thêm 10 tài khoản khách hàng mẫu nếu chưa tồn tại để đánh giá phong phú hơn
        $fakeCustomers = [
            ['hoten' => 'Nguyễn Văn Nam', 'email' => 'namnguyen@gmail.com', 'sdt' => '0912345678', 'diachi' => 'Hà Nội'],
            ['hoten' => 'Trần Thị Hoa', 'email' => 'hoatran@gmail.com', 'sdt' => '0987654321', 'diachi' => 'Đà Nẵng'],
            ['hoten' => 'Lê Hoàng Anh', 'email' => 'hoanganh@gmail.com', 'sdt' => '0905123456', 'diachi' => 'TP. HCM'],
            ['hoten' => 'Phạm Minh Đức', 'email' => 'ducpham@gmail.com', 'sdt' => '0934567890', 'diachi' => 'Hải Phòng'],
            ['hoten' => 'Hoàng Thu Trang', 'email' => 'tranghoang@gmail.com', 'sdt' => '0978123456', 'diachi' => 'Cần Thơ'],
            ['hoten' => 'Đỗ Quốc Bảo', 'email' => 'baodo@gmail.com', 'sdt' => '0945678901', 'diachi' => 'Quảng Ninh'],
            ['hoten' => 'Vũ Thùy Linh', 'email' => 'linhvu@gmail.com', 'sdt' => '0967890123', 'diachi' => 'Nam Định'],
            ['hoten' => 'Phan Huy Khánh', 'email' => 'khanhphan@gmail.com', 'sdt' => '0919876543', 'diachi' => 'Nghệ An'],
            ['hoten' => 'Bùi Minh Tuấn', 'email' => 'tuanbui@gmail.com', 'sdt' => '0981234567', 'diachi' => 'Thanh Hóa'],
            ['hoten' => 'Nguyễn Mai Chi', 'email' => 'chinguyen@gmail.com', 'sdt' => '0936789012', 'diachi' => 'Bắc Ninh'],
        ];

        foreach ($fakeCustomers as $cust) {
            $existing = DB::table('nguoidung')->where('email', $cust['email'])->first();
            if ($existing) {
                $userIds[] = $existing->id_nd;
            } else {
                $userId = DB::table('nguoidung')->insertGetId([
                    'hoten' => $cust['hoten'],
                    'email' => $cust['email'],
                    'password' => bcrypt('123456'),
                    'diachi' => $cust['diachi'],
                    'sdt' => $cust['sdt'],
                    'id_phanquyen' => 2, // Khách hàng
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                $userIds[] = $userId;
            }
        }

        // Lấy danh sách sản phẩm hiện có trong CSDL
        $products = DB::table('sanpham')->get();

        if ($products->isEmpty()) {
            return;
        }

        // Các mẫu đánh giá theo danh mục sản phẩm (Đã mở rộng thêm nhiều bình luận chất lượng)
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

        foreach ($products as $product) {
            // Xác định mẫu đánh giá dựa theo danh mục sản phẩm (id_danhmuc)
            if (in_array($product->id_danhmuc, [1, 2])) {
                $pool = $clothingReviews;
            } elseif ($product->id_danhmuc == 3 || $product->id_danhmuc == 4) {
                $pool = $equipmentReviews;
            } else {
                $pool = $supplementReviews;
            }

            // Tăng số lượng đánh giá ngẫu nhiên lên từ 5 đến 7 đánh giá cho mỗi sản phẩm
            $numReviews = rand(5, 7);
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
