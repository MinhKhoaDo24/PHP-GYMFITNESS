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
                'mota' => 'Áo thun tập gym nam cao cấp được dệt từ sợi thể thao chuyên dụng siêu nhẹ, mang lại khả năng co giãn 4 chiều tuyệt vời và ôm gọn cơ bắp một cách tự nhiên. Công nghệ QuickDry giúp thấm hút mồ hôi siêu tốc và bay hơi tức thì, giữ cho cơ thể luôn mát mẻ và khô ráo ngay cả trong những buổi tập cường độ cao nhất. Thiết kế đường may phẳng (Flatlock) giảm thiểu ma sát tối đa với da, ngăn ngừa kích ứng khi vận động mạnh liên tục.',
                'mota_ngan' => 'Áo thun gym nam cao cấp, co giãn 4 chiều và thấm hút mồ hôi cực tốt.',
                'giamgia' => 25,
                'giakhuyenmai' => 199000,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 2,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Áo Tanktop Nam QuickDry',
                'sku' => 'NAM-TT-002',
                'giasp' => 189000,
                'gia_duoc_giam' => 149000,
                'mota' => 'Áo tanktop thể thao nam mang phong cách năng động, thời thượng với thiết kế khoét nách rộng rãi tối ưu hóa phạm vi chuyển động của khớp vai. Chất liệu vải mesh (lưới siêu nhỏ) siêu thoáng khí kết hợp công nghệ QuickDry giúp giải phóng nhiệt lượng cơ thể nhanh chóng. Sản phẩm cực kỳ lý tưởng cho các buổi tập tạ nặng, tập cardio cường độ cao hoặc chạy bộ ngoài trời trong những ngày hè oi bức.',
                'mota_ngan' => 'Tanktop thoáng khí QuickDry, thiết kế nách khoét rộng tối ưu vận động.',
                'giamgia' => 20,
                'giakhuyenmai' => 149000,
                'soluong' => 80,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 2,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Quần Jogger Gym Nam FitBody',
                'sku' => 'NAM-JG-003',
                'giasp' => 320000,
                'gia_duoc_giam' => 270000,
                'mota' => 'Quần Jogger thể thao nam FitBody sở hữu kiểu dáng slim-fit thời trang, tôn dáng đùi và bắp chân săn chắc. Được làm từ hỗn hợp vải Polyester và Spandex cao cấp đàn hồi cực tốt, không bị mất phom hay xù lông sau nhiều lần giặt. Thiết kế cạp chun co giãn đi kèm dây rút chắc chắn, túi khóa kéo tiện dụng bảo vệ điện thoại, ví tiền an toàn khi bạn tập squat, chạy bộ hay vận động mạnh.',
                'mota_ngan' => 'Quần jogger FitBody slim-fit ôm dáng, co giãn tốt, túi khóa kéo tiện lợi.',
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
                'mota' => 'Quần đùi/short tập gym nam DryFit siêu nhẹ, thoáng mát với thiết kế xẻ gấu nhẹ hai bên hông hỗ trợ chuyển động chân linh hoạt tối đa khi squat hoặc lunges. Công nghệ dệt DryFit độc quyền giúp điều hòa nhiệt độ cơ thể hiệu quả. Lớp lót co giãn nhẹ bên trong giúp bảo vệ tuyệt đối, kết hợp túi sâu tiện lợi hai bên rất phù hợp cho mọi hoạt động thể chất hằng ngày.',
                'mota_ngan' => 'Quần đùi DryFit siêu nhẹ, thoáng khí, hỗ trợ tối đa chuyển động chân.',
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
                'mota' => 'Áo Sport Bra SupportMax được thiết kế chuyên dụng để nâng đỡ vòng một tối ưu khi tập luyện cường độ trung bình đến cao như Cardio, chạy bộ hay tập tạ. Chất liệu thun thể thao mềm mại, đàn hồi vượt trội kết hợp đệm ngực có thể tháo rời tiện lợi. Mặt lưng phối lưới cách điệu vừa tạo điểm nhấn quyến rũ vừa tăng cường lưu thông không khí, giữ cảm giác thông thoáng dễ chịu suốt cả buổi tập.',
                'mota_ngan' => 'Sport Bra nâng đỡ ngực tối đa SupportMax, thiết kế lưng lưới thời trang.',
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
                'mota' => 'Quần Legging tập gym nữ cạp cao định hình vòng eo, nâng mông tự nhiên (Scrunch Butt) tạo đường cong cơ thể hoàn hảo. Chất liệu vải cao cấp dày dặn, co giãn 4 chiều cực tốt, cam kết tuyệt đối không lộ nội y khi thực hiện các động tác cúi gập người (Squat-proof). Đường may kim đôi chắc chắn giúp bạn tự tin thực hiện mọi động tác từ yoga dẻo dai đến nâng tạ nặng.',
                'mota_ngan' => 'Quần legging cạp cao định hình tôn dáng nâng mông, chất dày dặn squat-proof.',
                'giamgia' => 17,
                'giakhuyenmai' => 290000,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 1,
                'created_at' => $now, 'updated_at' => $now
            ],
            [
                'tensp' => 'Áo Croptop Nữ Workout',
                'sku' => 'NU-CT-007',
                'giasp' => 220000,
                'gia_duoc_giam' => 180000,
                'mota' => 'Áo thun Croptop Workout dáng ôm năng động giúp bạn khoe khéo vòng eo thon gọn và tôn lên vóc dáng khỏe khoắn. Chất vải thun gân hoặc thun mịn cao cấp co giãn đa chiều, mềm mát và thấm hút mồ hôi cực nhanh. Rất dễ phối đồ cùng quần legging cạp cao hoặc quần short, mang lại diện mạo trẻ trung đầy cuốn hút tại phòng tập gym, lớp yoga hay khi dạo phố.',
                'mota_ngan' => 'Áo croptop Workout năng động ôm phom quyến rũ, chất vải mềm mát.',
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
                'mota' => 'Quần đùi short tập Yoga nữ UltraSoft mang lại cảm giác mềm mại như làn da thứ hai nhờ công nghệ dệt sợi siêu mịn. Thiết kế ôm sát đùi nhưng không gây hằn ngứa, cạp cao ôm bụng nhẹ nhàng giúp giữ cố định phom dáng trong các tư thế yoga uốn dẻo phức tạp. Chất liệu vải kháng khuẩn, khử mùi hiệu quả giữ cho bạn luôn cảm thấy tự tin và thư thái.',
                'mota_ngan' => 'Quần short Yoga UltraSoft siêu mềm mại, ôm dáng nhẹ nhàng co giãn tốt.',
                'giamgia' => 19,
                'giakhuyenmai' => 170000,
                'soluong' => 85,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 1,
                'created_at' => $now, 'updated_at' => $now
            ],

            // ==================== DANH MỤC 3: DỤNG CỤ GYM ====================
            [
                'tensp' => 'Tạ Đơn 10kg Cao Cấp',
                'sku' => 'GYM-TD-009',
                'giasp' => 320000,
                'gia_duoc_giam' => 290000,
                'mota' => 'Tạ đơn cao cấp trọng lượng chuẩn 10kg với phần lõi bằng gang đặc đúc nguyên khối siêu bền, bên ngoài bọc một lớp cao su tự nhiên dày dặn giúp giảm chấn thương, chống ồn và bảo vệ mặt sàn khi va chạm. Tay cầm mạ Chrome sáng bóng được tạo nhám vân kim cương chống trơn trượt tối đa, giúp nắm chắc chắn ngay cả khi tay ra nhiều mồ hôi. Kiểu dáng lục giác chống lăn hiệu quả trên mọi mặt phẳng.',
                'mota_ngan' => 'Tạ đơn gang lục giác 10kg bọc cao su cao cấp, tay cầm mạ chrome chống trượt.',
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
                'mota' => 'Găng tay tập gym chuyên nghiệp nửa ngón được trang bị đệm silicone tổ ong dày dặn ở lòng bàn tay giúp tăng độ ma sát bám xà bám tạ và bảo vệ tay không bị chai sạn, phồng rộp. Chất vải lưới co giãn ở mu bàn tay cực kỳ thoáng khí, thoát mồ hôi nhanh. Thiết kế dây đai quấn cổ tay có khóa dán điều chỉnh linh hoạt giúp cố định và bảo vệ khớp cổ tay an toàn khỏi chấn thương khi đẩy tạ nặng.',
                'mota_ngan' => 'Găng tay gym chống trượt đệm silicone tổ ong thoáng khí, bảo vệ cổ tay.',
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
                'mota' => 'Đai lưng tập gym PowerBack chuyên dụng cho các bài tập gánh tạ (Squat) hoặc nhấc tạ (Deadlift). Được hoàn thiện từ chất liệu da PU cao cấp nhiều lớp chịu lực xé cực tốt, bên trong có đệm lưng êm ái nâng đỡ cột sống tối đa và ổn định áp suất khoang bụng. Hệ thống khóa khóa thép không gỉ chắc chắn đi kèm các lỗ điều chỉnh kích cỡ linh hoạt mang lại sự an tâm tuyệt đối để bứt phá giới hạn tạ mới.',
                'mota_ngan' => 'Đai lưng tập gym da PU cao cấp PowerBack bảo vệ cột sống lưng khi tập nặng.',
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
                'mota' => 'Dây kháng lực dạng dẹt PowerBand được sản xuất từ 100% cao su Latex tự nhiên có độ đàn hồi cực cao, chịu lực kéo căng mạnh mẽ mà không lo đứt gãy hay biến dạng. Dây cung cấp mức lực kháng phù hợp hỗ trợ đắc lực cho các bài tập mông đùi, tập xà đơn, squat hoặc các bài tập phục hồi chức năng cơ bắp toàn thân. Thiết kế nhỏ gọn tiện lợi mang theo tập luyện mọi lúc mọi nơi.',
                'mota_ngan' => 'Dây kháng lực cao su Latex tự nhiên siêu bền co giãn cao tập toàn thân.',
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
                'mota' => 'Thảm tập Yoga cao cấp PremiumMat làm từ chất liệu cao su tự nhiên kết hợp lớp phủ PU sinh học thân thiện với môi trường, không chứa chất độc hại. Thảm sở hữu độ dày lý tưởng 5mm giúp nâng đỡ tối đa khớp gối và cột sống. Khả năng chống trơn trượt tuyệt đối trên cả hai mặt, ngay cả khi thảm bị ướt do mồ hôi. Hệ thống vạch định tuyến khắc laser sắc nét hỗ trợ bạn căn chỉnh vị trí tay chân chuẩn xác trong từng tư thế.',
                'mota_ngan' => 'Thảm Yoga cao PU chống trượt định tuyến 5mm, độ bám cực cao thân thiện môi trường.',
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
                'mota' => 'Gạch/Block tập Yoga làm từ bọt xốp EVA mật độ cao siêu nhẹ nhưng cực kỳ chịu lực, đàn hồi tốt và không bị biến dạng dưới sức nặng cơ thể. Các góc cạnh được bo tròn 3D giúp cầm nắm êm ái, vững vàng. Gạch là dụng cụ bổ trợ đắc lực giúp kéo dài tầm tay, hỗ trợ giữ thăng bằng và giảm độ căng thẳng cho cơ bắp trong các tư thế yoga kéo giãn cơ hoặc uốn lưng nâng cao.',
                'mota_ngan' => 'Gạch tập Yoga EVA mật độ cao siêu nhẹ vững chắc bo tròn góc 3D.',
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
                'mota' => 'Dây đai hỗ trợ tập Yoga StretchBand dệt từ chất liệu cotton tự nhiên dệt dày dặn, siêu bền chắc và thân thiện với làn da, không gây đau rát khi siết chặt. Đầu dây trang bị khóa vòng chữ D bằng kim loại cứng cáp giúp cố định chiều dài dây linh hoạt theo nhu cầu tập luyện. Dụng cụ hỗ trợ tuyệt vời để kéo giãn sâu, giữ tư thế lâu hơn và cải thiện độ dẻo dai cho cơ xương khớp một cách an toàn.',
                'mota_ngan' => 'Dây đai tập Yoga Cotton dệt dày siêu bền khóa chữ D kim loại chắc chắn.',
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
                'mota' => 'Vòng tập Pilates / Yoga chuyên dụng cấu tạo từ sợi thủy tinh bọc lớp đệm cao su NBR mềm mại ở cả mặt trong và mặt ngoài, mang lại lực kháng hoàn hảo và cảm giác tiếp xúc êm ái. Thiết kế tay cầm đối xứng tiện lợi hỗ trợ đắc lực cho các bài tập săn chắc cơ đùi trong, bắp tay, cơ ngực và tăng cường sức mạnh vùng lõi cơ trung tâm (Core). Thích hợp cho cả bài tập căng cơ nhẹ nhàng đến cường độ Pilates cao.',
                'mota_ngan' => 'Vòng Pilates Ring sợi thủy tinh đệm cao su NBR êm ái luyện cơ trung tâm.',
                'giamgia' => 12,
                'giakhuyenmai' => 220000,
                'soluong' => 60,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 4,
                'created_at' => $now, 'updated_at' => $now
            ],

        ];

        // Dùng updateOrInsert để tránh trùng lặp bản ghi khi chạy lại
        foreach ($products as $prod) {
            DB::table('sanpham')->updateOrInsert(
                ['sku' => $prod['sku']],
                $prod
            );
        }
    }
}
