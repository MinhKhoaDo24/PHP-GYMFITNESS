<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Size;

class SupplementSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Insert/Update Categories
        $categories = [
            ['id_danhmuc' => 5, 'ten_danhmuc' => 'Giảm cân - Đốt mỡ', 'status' => 1],
            ['id_danhmuc' => 6, 'ten_danhmuc' => 'Tăng cân', 'status' => 1],
            ['id_danhmuc' => 7, 'ten_danhmuc' => 'Tăng cơ', 'status' => 1],
        ];

        foreach ($categories as $cat) {
            DB::table('danhmuc')->updateOrInsert(
                ['id_danhmuc' => $cat['id_danhmuc']],
                $cat
            );
        }

        // 2. Insert Products, Images, and Sizes (Flavors)
        $products = [
            [
                'tensp' => 'Viên Uống Đốt Mỡ Không Chất Kích Thích Nutrex Lipo-6 Black Stim-free 60 Viên',
                'sku' => 'SMNU7818',
                'giasp' => 850000.0,
                'gia_duoc_giam' => 800000.0,
                'mota' => 'Hỗ trợ giảm cân không chứa chất kích thích cực đậm đặcHiệu lực cao chỉ cần một viên duy nhấtGiúp tăng cường hoạt động trao đổi chất và sử dụng chất béo trong cơ thểCó thể uống vào ban ngày hoặc ban đêm100% không chứa chất kích thích và không chứa caffeineCung cấp đầy đủ 30 ngày dùng########Lipo-6 Black Stim-free 100% không chứa chất kích thích và CaffeinĐây là thực phẩm bổ sung giảm cân hiệu quả cao của Nutrex. Chỉ cần một viên duy nhất, nó giúp tăng cường quá trình trao đổi chất và giúp cơ t...',
                'mota_ngan' => 'Hỗ trợ giảm cân không chứa chất kích thích cực đậm đặcHiệu lực cao chỉ cần một viên duy nhấtGiúp tăng cường hoạt động trao đổi chất và sử dụng chất...',
                'giamgia' => 6,
                'giakhuyenmai' => 800000.0,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 5,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/lipo6-stimfree-ifitness_832236e6fe134b3d943cd01969ca0e44.png', 'https://product.hstatic.net/1000185761/product/lipo6-stimfree-sfp_508e38b810b54892b586c72906c7adec.png', 'https://product.hstatic.net/1000185761/product/lipo6-stimfree-inp_72a49ddcd4f94cfb848bf6f2a5e435e5.png'],
                'flavors' => ['60 Viên'],
            ],
            [
                'tensp' => 'Sữa Tăng Sức Mạnh Sức Bền Ostrovit Creatine Monohydrate',
                'sku' => 'SMSTV002',
                'giasp' => 450000.0,
                'gia_duoc_giam' => 450000.0,
                'mota' => 'Độ tinh khiết creatine monohydrate gần như tuyệt đốiDạng micronized 200 mesh hòa tan nhanh, mịn, dễ uốngHiệu quả tăng sức mạnh rõ rệt sau 2–4 tuầnHỗ trợ tăng khối cơ nạc bền vững, không gây tăng mỡCải thiện sức bền, sức mạnh bứt tốc cho cả runner và gymerRút ngắn thời gian phục hồi, giảm nhức mỏi sau tập nặngAn toàn cho cả nam và nữ, không gây tác dụng phụ nguy hiểmKhông gây hại thận ở người khỏe mạnh, đã được nghiên cứu rộng rãiGiá thành rất tốt so với hiệu quả mang lại########OstroVit Creat...',
                'mota_ngan' => 'Độ tinh khiết creatine monohydrate gần như tuyệt đốiDạng micronized 200 mesh hòa tan nhanh, mịn, dễ uốngHiệu quả tăng sức mạnh rõ rệt sau 2–4 tuầnHỗ...',
                'giamgia' => 0,
                'giakhuyenmai' => 450000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 5,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/a12_09258a580cf84106b2cb63f0c6dd28fc.png', 'https://cdn.hstatic.net/products/1000185761/a3-f50f68ca-299e-4b3b-95fc-37e2a64a7d0c_7179dd69096a4d80b1dcd93419163546.png', 'https://cdn.hstatic.net/products/1000185761/ostrovit_creatine_monohydrate__2__8ba604d28dd943edb2645e0b03a2086d.jpg'],
                // 300g = giá gốc, 500g = +120,000đ
                'flavors' => ['300 G' => 0, '500 G' => 120000],
            ],
            [
                'tensp' => 'Sữa Phục Hồi Phát Triển Cơ Bắp Eaa+Glutamine Scitec Nutrition 33 Servings',
                'sku' => 'SMST0012',
                'giasp' => 800000.0,
                'gia_duoc_giam' => 790000.0,
                'mota' => '4250 mg axit amin thiết yếu (EAA) mỗi khẩu phầnBao gồm BCAA: Leucine, Isoleucine, Valine2000 mg L-Glutamine – axit amin phổ biến nhất trong cơ thểKhông đường, không carb – phù hợp cả chế độ giảm cân, ketoThuần chay (vegan) – amino acid chiết xuất từ thực vật lên menHương vị trái cây dễ uống – dùng trong hoặc sau tập########Scitec EAA + Glutamine – Bổ sung axit amin thiết yếu và glutamine từ thực vậtCông thức \'EAA + Glutamine\' của Scitec Nutrition cung cấp các axit amin thiết yếu quý giá nhất,...',
                'mota_ngan' => '4250 mg axit amin thiết yếu (EAA) mỗi khẩu phầnBao gồm BCAA: Leucine, Isoleucine, Valine2000 mg L-Glutamine – axit amin phổ biến nhất trong cơ...',
                'giamgia' => 1,
                'giakhuyenmai' => 790000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 5,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/eaa-5-768x768_1666a8ad48f047d9be31bf70176276c6.png'],
                'flavors' => ['Không mùi'],
            ],
            [
                'tensp' => 'Sữa Tăng Sức Mạnh Sức Bền 100% Creatine Monohydrate Scitec Nutrition 300G (88 Serving)',
                'sku' => 'SMST5721',
                'giasp' => 890000.0,
                'gia_duoc_giam' => 750000.0,
                'mota' => 'Creatine tinh khiết 100%Hàm lượng 3g/khẩu phần đã được khoa học chứng minh hiệu quảTăng sức mạnh, xây dựng cơ bắp vượt trộDễ sử dụng, dễ hấp thuPhù hợp cho nhiều đối tượng luyện tậpPhù hợp cho người ăn chayThương hiệu uy tín, sản phẩm chính hãng########Giới thiệu chi tiết sản phẩm Scitec Nutrition 100% Creatine MonohydrateScitec Nutrition 100% Creatine Monohydrate dạng bột (hộp 300g) cung cấp 88 lần dùng. Mỗi khẩu phần ~3,4g bột chứa 3g creatine tinh khiết, đáp ứng liều lượng hiệu quả đã được...',
                'mota_ngan' => 'Creatine tinh khiết 100%Hàm lượng 3g/khẩu phần đã được khoa học chứng minh hiệu quảTăng sức mạnh, xây dựng cơ bắp vượt trộDễ sử dụng, dễ hấp thuPhù...',
                'giamgia' => 16,
                'giakhuyenmai' => 750000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 5,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/scitec-nutrition-creatine-monohydrate-300g-88serings_7f256f1efbc345aba5b912446f66d474.png', 'https://cdn.hstatic.net/products/1000185761/creatine_monohydrate_scitec_nutrition__3__a3554f6582fa4b488500af4ff4c9489b.png', 'https://cdn.hstatic.net/products/1000185761/creatine_monohydrate_scitec_nutrition__5__72007ea7a16e46fa93d04af364143a07.png'],
                'flavors' => ['Không mùi'],
            ],
            [
                'tensp' => 'Viên Uống Tăng Sức Mạnh và Sức Bền Hammer Nutrition Endurance BCAA+',
                'sku' => 'SMHM620',
                'giasp' => 950000.0,
                'gia_duoc_giam' => 950000.0,
                'mota' => 'Tăng sức bền, sức mạnh khi tập luyệnGiảm đau mỏi cơ sau khi tập luyện, ngăn ngừa quá trình cơ bắp bị dị hóaGiúp hỗ trợ giảm mỡ hiệu quả đồng thời bảo vệ cơ bắp Giúp xây dựng và kích thích cơ nạc phát triển; giảm tình trạng mỡ thừa tích tụDạng viên uống tiện lợi dễ dàng sử dụng mọi lúc mọi nơi Chứa 120/240 viên - 40/80 lần dùngNên dùng: 1 lần/ngày - Mỗi lần: 3 viên########Bạn cảm thấy không đủ sức để tăng thời gian tập luyện và đạt được mục tiêu của mình?Bạn đang tập luyện để giảm cân, giảm mỡ...',
                'mota_ngan' => 'Tăng sức bền, sức mạnh khi tập luyệnGiảm đau mỏi cơ sau khi tập luyện, ngăn ngừa quá trình cơ bắp bị dị hóaGiúp hỗ trợ giảm mỡ hiệu quả đồng thời bảo...',
                'giamgia' => 0,
                'giakhuyenmai' => 950000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 5,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/endurance-bcaa-120cap.jpg', 'https://product.hstatic.net/1000185761/product/endurance-bcaa-240caps.jpg'],
                // 120 viên = giá gốc 950k, 240 viên = +850,000đ (gần gấp đôi)
                'flavors' => ['120 Viên' => 0, '240 Viên' => 850000],
            ],
            [
                'tensp' => 'Sữa tăng sức bền phục hồi chống đau mỏi cơ Mutant BCAA 9.7 - 348gr',
                'sku' => 'SMMUT2264',
                'giasp' => 750000.0,
                'gia_duoc_giam' => 750000.0,
                'mota' => 'Cung cấp 9,7 gram hỗn hợp BCAA chất lượng cao tỉ lệ 2:1:1Bổ sung thêm 8 chất điện giải để giữ nước cho cơ bắp chống mỏi cơ.Không đường, không calo1 muỗng ~ 12g - 1 hộp ~ 30 muỗngSản phẩm phù hợp cho người ăn chayGiá chưa bao gồm 10% VAT########Bạn cảm thấy không đủ sức để tăng thời gian tập luyện và đạt được mục tiêu của mình?Bạn đang tập luyện để giảm cân, giảm mỡ ?Bạn thường cảm thấy đau mỏi cơ sau khi tập luyện?Bạn cần nâng cao sự tập trung và sự tỉnh táo khi tập luyện?Bạn đang chuẩn bị ch...',
                'mota_ngan' => 'Cung cấp 9,7 gram hỗn hợp BCAA chất lượng cao tỉ lệ 2:1:1Bổ sung thêm 8 chất điện giải để giữ nước cho cơ bắp chống mỏi cơ.Không đường, không calo1...',
                'giamgia' => 0,
                'giakhuyenmai' => 750000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 5,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/mutant-bcaa-roadsidelemonade_51372da4af4348bdb8e85ce503e30b9c.jpg', 'https://product.hstatic.net/1000185761/product/bcaa-fuzz-peach_3dc547155d9d4273a4ca64e435db8673.jpg', 'https://product.hstatic.net/1000185761/product/bcaa-tropical-mango_24e46202bc684c8cb0464a2e1f247300.jpg'],
                'flavors' => ['Sweet Iced Tea', 'Đào', 'Dưa hấu', 'Trái cây', 'Xoài'],
            ],
            [
                'tensp' => 'Serious Mass 12lbs (5.44kg) - Sữa Tăng Cân Optimum Nutrition',
                'sku' => 'SMON1914',
                'giasp' => 2650000.0,
                'gia_duoc_giam' => 2650000.0,
                'mota' => 'Sữa tăng cân Serious Mass bán chạy nhiều năm liềnCung cấp 1250 calo/liều dùng50g protein chất lượng cao254g carbohydrate hấp thụ nhanhCó chứa Creatine, Glutamine và axit Glutamic25 loại vitamin và khoáng chất32 muỗng - 167g/muỗng - 16 lần dùng/hũNên dùng 1 lần/ngày. 2 muỗng/lầnGiá chưa bao gồm 8% VAT########Sữa bột Serious Mass Gainer 12lbs cung cấp hàm lượng calo, protein lớn giúp người gầy nhanh chóng cải thiện được cân nặng nhờ tăng chỉ số calo. Đây là dòng sản phẩm tăng cân tốt nhất cho n...',
                'mota_ngan' => 'Sữa tăng cân Serious Mass bán chạy nhiều năm liềnCung cấp 1250 calo/liều dùng50g protein chất lượng cao254g carbohydrate hấp thụ nhanhCó chứa...',
                'giamgia' => 0,
                'giakhuyenmai' => 2650000.0,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 6,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/serious-mass-chocolate-12lbs_bbfb423d9aac430bbe36f201f9ffc4e7.jpg', 'https://product.hstatic.net/1000185761/product/serious-mass-chocolate-12lbs-2_48f079f687064c81948f6741ac178fbb.jpg', 'https://product.hstatic.net/1000185761/product/serious-mass-chocolate-12lbs-3_6bfe70db330c4d05b8f8e9f3fa76422a.jpg'],
                'flavors' => ['Socola', 'Vani', 'Chuối', 'Bơ socola'],
            ],
            [
                'tensp' => 'Sữa Tăng Cân Tăng Cơ Scitec Nutrition Jumbo 1320g',
                'sku' => 'SMST3979',
                'giasp' => 990000.0,
                'gia_duoc_giam' => 1000000.0,
                'mota' => '849 kcal/serving – giải pháp tăng cân nhanh cho người gầy khó hấp thu.53g protein chất lượng cao – hỗ trợ xây dựng cơ bắp nạc, phục hồi nhanh.140g carb đa nguồn – cung cấp năng lượng nhanh và bền bỉ.3g creatine – tăng sức mạnh, hiệu suất tập luyện.BCAA, glutamine, vitamin & khoáng – chống dị hóa cơ, hỗ trợ sức khỏe.Superfood (Quinoa, Goji, Açaí) – tăng cường miễn dịch, chống oxy hóa.Hương vị ngon, dễ tan – tiện lợi pha uống mỗi ngày.########Scitec Nutrition Jumbo 1320g – “Bom Calo” Giúp Tăng ...',
                'mota_ngan' => '849 kcal/serving – giải pháp tăng cân nhanh cho người gầy khó hấp thu.53g protein chất lượng cao – hỗ trợ xây dựng cơ bắp nạc, phục hồi nhanh.140g...',
                'giamgia' => 0,
                'giakhuyenmai' => 1000000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 6,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/5941_a56bbc9c84cb_834013a723da4529a8a4f12273cd481a.png', 'https://cdn.hstatic.net/products/1000185761/scitec-nutrition-jumbo-1320g-6servings_07d3ec670f9642d98a022e574342b2c7.png'],
                'flavors' => ['Không mùi'],
            ],
            [
                'tensp' => 'Sữa Tăng Cân Tăng Cơ Nutrex Mass Infusion 12lbs (5.54kg)',
                'sku' => 'SMBBTNU009',
                'giasp' => 2250000.0,
                'gia_duoc_giam' => 1930000.0,
                'mota' => 'Nutrex Mass Infusion cung cấp 1120 calo và 200g carb giúp tăng cân hiệu quả8.1g Glutamine giúp đẩy nhanh tốc độ phục hồi và phát triển cơ nạc sau tập10g BCAA chất lượng cao, giúp phục hồi cơ bắp cực nhanh50g Protein (Whey Protein Concentrate, Hydrolyzed Whey Protein, Micellar Casein) hỗ trợ xây cơ nạc theo cách hoàn hảo nhấtChứa Enzyme tiêu hoá lactase, hỗ trợ tiêu hóa và hấp thu chất tốt hơnMùi vị cực kỳ thơm ngonChứa 76 muỗng (19 lần dùng) - 1 muỗng ~ 70,75gNên dùng 1-2 lần/ngày - Mỗi lần 4...',
                'mota_ngan' => 'Nutrex Mass Infusion cung cấp 1120 calo và 200g carb giúp tăng cân hiệu quả8.1g Glutamine giúp đẩy nhanh tốc độ phục hồi và phát triển cơ nạc sau...',
                'giamgia' => 14,
                'giakhuyenmai' => 1930000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 6,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/massinfusion-choc-f_d20b8d5fd84d424eaa31dfedcafe3246.png', 'https://cdn.hstatic.net/products/1000185761/massinfusion-van-sfp_5829cbb575b447cab216135c25f1ea40.png', 'https://cdn.hstatic.net/products/1000185761/massinfusion-van_5572b70c5d2c4313a77d9da3e73a117b.png'],
                'flavors' => ['Vani', 'Socola'],
            ],
            [
                'tensp' => 'Muscle Mass Gainer 12lbs (5.45kg) - Sữa Tăng Cân Labrada',
                'sku' => 'SMBBTLBD004',
                'giasp' => 2550000.0,
                'gia_duoc_giam' => 2400000.0,
                'mota' => 'Labrada Muscle Mass Gainer cung cấp 1265kcal/liều dùng, cam kết là nguồn sữa tăng cân tăng cơ hàng đầu thế giới hiện nay52g protein chất lượng cao từ Whey Concentrate, Isolate254g carbs hấp thụ nhanh, đảm bảo cung cấp nguồn năng lượng cực lớnHàm lượng đường tương đối cho 1 liều dùng tương đối lớn - 20g19 loại vitamin và khoáng chất, đảm bảo giúp cơ thể hấp thụ chất dinh dưỡng tốt hơn và khỏe mạnhSử dụng để bổ sung dinh dưỡng hàng ngày tuyệt vời hoặc giúp phục hồi hiệu quả sau khi tậpBổ sung C...',
                'mota_ngan' => 'Labrada Muscle Mass Gainer cung cấp 1265kcal/liều dùng, cam kết là nguồn sữa tăng cân tăng cơ hàng đầu thế giới hiện nay52g protein chất lượng cao từ...',
                'giamgia' => 6,
                'giakhuyenmai' => 2400000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 6,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/labrada-muscle-mass-gainer-12-lbs_2f4ccfaa7247477bbe00949c23bd3a89.jpg', 'https://product.hstatic.net/1000185761/product/labrada-muscle-mass-gainer-chocolate-12lbs.jpg', 'https://product.hstatic.net/1000185761/product/labrada-muscle-mass-gainer-strawberry-12-lbs_455ad9ec50da40948caebba63eeef374.jpg'],
                'flavors' => ['Socola', 'Dâu', 'Vanilla'],
            ],
            [
                'tensp' => 'Sữa Tăng Cân Tăng Cơ Nạc MUTANT MASS 15LBS – Túi 6.8kg',
                'sku' => 'SMMUT2695',
                'giasp' => 2690000.0,
                'gia_duoc_giam' => 2590000.0,
                'mota' => '1.100 calo mỗi khẩu phầnĐược làm từ thực phẩm hoàn toàn tự nhiên (lúa mạch, khoai lang, yến mạch cuộn, bơ, dầu dừa, hạt lanh, hạt bí ngô và dầu hướng dương)56 g protein nguyên chất, 192 g carbs sạch, 12 g chất béo26,1 g EAA và 12,2 g BCAAs (có trong tự nhiên)Axit béo thiết yếu (EFAs) và dầu tự nhiên từ dừa, bơ, hạt lanh, hạt bí ngô và hướng dươngĐược thiết kế trong cơ sở sản xuất hiện đại để duy trì chất lượng tiêu chuẩn vàngHương vị thơm ngon không ngán dành cho người sành ăn!Giá chưa bao gồ...',
                'mota_ngan' => '1.100 calo mỗi khẩu phầnĐược làm từ thực phẩm hoàn toàn tự nhiên (lúa mạch, khoai lang, yến mạch cuộn, bơ, dầu dừa, hạt lanh, hạt bí ngô và dầu hướng...',
                'giamgia' => 4,
                'giakhuyenmai' => 2590000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 6,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/ifitness-mass-mutant-vanilla_a0e07847b0f543a78f6f339dc45a6ad4.png', 'https://product.hstatic.net/1000185761/product/ifitness-mass-mutant-dau_741f41096fc74285a1fea15ea90464b3.png', 'https://product.hstatic.net/1000185761/product/ifitness-mass-mutant-vani_01293bd63feb42a6a91e33af67628c7c.png'],
                'flavors' => ['Cookies', 'Vani', 'Dâu Chuối'],
            ],
            [
                'tensp' => 'Sữa Tăng Cân Optimum Nutrition Serious Mass 6lbs (2.72kg) - 4 mùi',
                'sku' => 'SMON1916',
                'giasp' => 1150000.0,
                'gia_duoc_giam' => 1490000.0,
                'mota' => 'Serious Mass 6lbs cung cấp 1.250 calories cho mỗi muỗng dùng50g protein chất lượng cao250g carbs hấp thụ nhanhCreatine, Glutamine và axit Glutamic25 vitamin và khoáng chấtChứa 16 muỗng - Mỗi muỗng ~ 167gNên dùng 1-3 lần/ngày. 2 muỗng/liều dùngGiá chưa bao gồm VAT########Tăng cân mà vẫn giữ được body săn chắc khỏe mạnh không phải là vấn đề đơn giản. Trong đó, yếu tố dinh dưỡng đóng vai trò quan trọng. Sữa Tăng Cân Serious Mass 2.27kg sẽ cung cấp cho bạn lượng calo, protein, tinh bột, chất béo,...',
                'mota_ngan' => 'Serious Mass 6lbs cung cấp 1.250 calories cho mỗi muỗng dùng50g protein chất lượng cao250g carbs hấp thụ nhanhCreatine, Glutamine và axit Glutamic25...',
                'giamgia' => 0,
                'giakhuyenmai' => 1490000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 6,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/serious-mass-6lbs_1703059336.jpg_85a352ba2af54bfdaab31fffb80f5158.png', 'https://cdn.hstatic.net/products/1000185761/image_1e049f1c1ab340b2beca01d2e342f38d.png', 'https://product.hstatic.net/1000185761/product/serious-mass-banana-6lbs.jpg'],
                'flavors' => ['Socola', 'Vani', 'Chuối', 'Bơ socola'],
            ],
            [
                'tensp' => 'Thanh Protein Bar Từ Đậu Và Hạt Agri Boost 40G',
                'sku' => 'SMAB54840',
                'giasp' => 50000.0,
                'gia_duoc_giam' => 50000.0,
                'mota' => 'Bảo toàn tối đa dinh dưỡng: Ứng dụng công nghệ chế biến tiên tiến giúp giữ lại trọn vẹn các vitamin, khoáng chất và kết cấu tự nhiên của nguyên liệu.Xây dựng và phục hồi cơ bắp tối ưu: Cung cấp chuỗi axit amin toàn diện (đặc biệt là protein từ đậu Hà Lan), đã được chứng minh lâm sàng có khả năng kích thích tổng hợp protein cơ bắp (Muscle Protein Synthesis) và tăng độ dày cơ bắp hiệu quả tương đương Whey protein.Kiểm soát đường huyết hiệu quả: Công thức cân bằng giúp duy trì mức đường huyết ổn...',
                'mota_ngan' => 'Bảo toàn tối đa dinh dưỡng: Ứng dụng công nghệ chế biến tiên tiến giúp giữ lại trọn vẹn các vitamin, khoáng chất và kết cấu tự nhiên của nguyên...',
                'giamgia' => 0,
                'giakhuyenmai' => 50000.0,
                'soluong' => 100,
                'noi_bat' => 1,
                'trang_thai' => 1,
                'id_danhmuc' => 7,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/protein-cam_feb8541b7c8a4e649d62830b5a6d81e9.png', 'https://cdn.hstatic.net/products/1000185761/protein-scl-1536x1536_1ca2db9fb14841948c9ffa1089e08545.png', 'https://cdn.hstatic.net/products/1000185761/thong_tin_dinh_duong__2__e5ebba8ec8484a8f83db9ad7d041e33b.png'],
                'flavors' => ['Socola Bạc Hà', 'Cam Sữa Chua', 'Phô Mai Cay', 'Tom Yum Lá Chanh'],
            ],
            [
                'tensp' => 'Sữa Tăng Cơ ON Gold Standard 100% Whey 5.6lbs (2.48kg)',
                'sku' => 'SMON3404',
                'giasp' => 5000000.0,
                'gia_duoc_giam' => 3090000.0,
                'mota' => 'Whey Gold 100% Standard bán chạy nhất thế giới24g Protein cao cấp, siêu tinh khiết Whey Isolate, Concentrate & Whey Peptides4g Glutamine & Glutamic Acid xây dựng cơ bắp 5.5g BCAAs chống đau mỏi và phục hồi cơ Chứa 74 - 80 muỗng - Mỗi muỗng ~ 30.4g ( Mẫu bao bì thay đổi theo từng lô hàng nhập )Nên dùng 2-3 lần/ngày. Lần dùng 1 muỗngGiá chưa bao gồm 8% VAT########Whey Gold Standard là dòng sản phẩm sữa thể hình tăng cơ giảm mỡ hoàn hảo do hãng Optimum Nutrition (ON) sản xuất. Đây là 1 trong nhữ...',
                'mota_ngan' => 'Whey Gold 100% Standard bán chạy nhất thế giới24g Protein cao cấp, siêu tinh khiết Whey Isolate, Concentrate & Whey Peptides4g Glutamine & Glutamic...',
                'giamgia' => 38,
                'giakhuyenmai' => 3090000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 7,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/s-l1600_7740c9a677064c4bb3882109238725a4.png', 'https://product.hstatic.net/1000185761/product/double_rich_chocolate_df38303465fd474e92a328aa7604d6ea.png', 'https://product.hstatic.net/1000185761/product/mocha_cappuchino_fd69300191874449a32bdbcda2c9a9bc.png'],
                'flavors' => ['Vanilla Ice Cream', 'Extreme Milk Chocolate', 'Delicious Strawberry', 'Mocha Cappuccino', 'Cookies and Cream'],
            ],
            [
                'tensp' => 'Sữa Tăng Cơ Thực Vật + 50 Loại Siêu Thực Dưỡng Orgain Organic Protein & 50 Superfoods 1.2kg',
                'sku' => 'SMORG7566',
                'giasp' => 1450000.0,
                'gia_duoc_giam' => 1390000.0,
                'mota' => 'Kết hợp của Protein và Siêu thực phẩm: 21 gam protein từ thực vật hữu cơ (hạt đậu, gạo lứt và hạt chia), 3 gam chất xơ (vị socola) hữu cơ và chỉ 1 gam đường trong mỗi khẩu phần. 50 siêu thực phẩm hữu cơ mỗi muỗngThuần chay, hữu cơ USDA, không sữa, không đường sữa, không gluten, không đậu nành, không biến đổi gen, bác sĩ phát triển. Hỗn hợp siêu thực phẩm hữu cơ bao gồm rau hữu cơ, thảo mộc, rau xanh, cỏ, quả mọng, trái cây, rau mầm và ngũ cốc lâu đời. Nguồn thực phẩm dồi dào vitamin B6 và C, ...',
                'mota_ngan' => 'Kết hợp của Protein và Siêu thực phẩm: 21 gam protein từ thực vật hữu cơ (hạt đậu, gạo lứt và hạt chia), 3 gam chất xơ (vị socola) hữu cơ và chỉ 1...',
                'giamgia' => 4,
                'giakhuyenmai' => 1390000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 7,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/organic-protein-superfoods-chocolate-1-2kg_13ad8216ed754aaeaa3f6a19a933daa0.jpg', 'https://product.hstatic.net/1000185761/product/organic-protein-superfoods-kem-dau_90d6cafb24a242b2b4edbd999b357f2c.jpg', 'https://product.hstatic.net/1000185761/product/organic-protein-superfoods-vanilla_85bdb2d381fc455d93bbb98f916d90a5.jpg'],
                'flavors' => ['Vani', 'Socola', 'Dâu'],
            ],
            [
                'tensp' => 'Sữa Tăng Cơ Scitec Nutrition 100% Whey Protein Professional 2.35kg (78 Servings)',
                'sku' => 'SMST1648',
                'giasp' => 2950000.0,
                'gia_duoc_giam' => 2750000.0,
                'mota' => '22g Protein giúp phát triển, phục hồi cơ bắp hiệu quả.10g EAA, 4.8g BCAA tăng khả năng tổng hợp Protein sau tập, đồng thời giúp phục hồi và chống dị hóa cơ bắp sau tập.900mg Glutamine giảm các cơn đau nhức của cơ bắp, tăng khả năng hồi phục cơ sau tập.Bổ sung 2 Enzyme hỗ trợ tiêu hóa, tăng khả năng hấp thụ Protein trong cơ thể.Không GlutenKhông có hormone nhân tạoĐược phê duyệt bởi Cơ quan An toàn Thực phẩm Châu Âu (EFSA).########Bạn bận rộn và không có thời gian chuẩn bị đầy đủ món ăn giàu p...',
                'mota_ngan' => '22g Protein giúp phát triển, phục hồi cơ bắp hiệu quả.10g EAA, 4.8g BCAA tăng khả năng tổng hợp Protein sau tập, đồng thời giúp phục hồi và chống dị...',
                'giamgia' => 7,
                'giakhuyenmai' => 2750000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 7,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/scitec-100-whey-protein-professional_1d02d26985004dba84278c9e6a29a08d.jpg'],
                'flavors' => ['Vanilla', 'Chocolate Hazelnut'],
            ],
            [
                'tensp' => 'Sữa Tăng Cơ Prostar 100% Whey Protein 907g 5 mùi',
                'sku' => 'SMUN146',
                'giasp' => 1400000.0,
                'gia_duoc_giam' => 1400000.0,
                'mota' => 'Hàm lượng Protein CAO - 25g Protein kết hợp từ 3 nguồn protein hấp thụ nhanh nhất gồm: Whey Protein Isolate, Whey Protein Concentrate và Whey Peptides.Cung cấp 6g BCAAs - Giúp nâng cao hiệu suất tập luyện giảm mệt mỏi sau khi tậpÍt chất béo, ít đường, ít tinh bột, chứa nhiều amino axit quan trọngBạn sẽ sở hữu loại PROTEIN CAO CẤP NHẤT với GIÁ TỐT NHẤTNhiều mùi vị cực ngon, dễ tanChứa 30 muỗng - 1 muỗng ~ 30gNên dùng: 1 - 3 lần/ ngày - Mỗi lần: 1 - 2 muỗngSản phẩm có muỗng đi kèm########Bạn bậ...',
                'mota_ngan' => 'Hàm lượng Protein CAO - 25g Protein kết hợp từ 3 nguồn protein hấp thụ nhanh nhất gồm: Whey Protein Isolate, Whey Protein Concentrate và Whey...',
                'giamgia' => 0,
                'giakhuyenmai' => 1400000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 7,
                'co_size' => 1,
                'images' => ['https://product.hstatic.net/1000185761/product/prostar-100-whey-protein-dau-907g.jpg', 'https://product.hstatic.net/1000185761/product/prostar-100-whey-protein-socola-907g.jpg', 'https://product.hstatic.net/1000185761/product/prostar-whey-vani-907g.jpg'],
                'flavors' => ['Socola', 'Vani', 'Dâu rừng', 'Dâu', 'Bánh'],
            ],
            [
                'tensp' => 'Sữa Tăng Cơ Hammer Whey Protein Isolate 570g - 3 Mùi',
                'sku' => 'SMHM0150',
                'giasp' => 1350000.0,
                'gia_duoc_giam' => 1350000.0,
                'mota' => '15g 100% Whey Isolate Duy trì và sửa chữa khối lượng cơ nạcTăng cường hệ miễn dịchTăng tốc phục hồi########Chắc chắn bạn đã biết rõ vai trò của Whey Protein là gì trong việc tập luyện. Protein (chất đạm) đóng vai trò quan trọng trong quá trình xây dựng cơ bắp, kích thích các mô cơ phát triển hiệu quả sau khi tập. Từ đó, bạn sẽ nhanh chóng có body săn chắc, đốt mỡ tốt hơn. Hammer Whey Protein Isolate Grass Feb - môt trong những sản phẩm bổ sung phát triên cơ bắp chất lượng - cung cấp hàm lượng...',
                'mota_ngan' => '15g 100% Whey Isolate Duy trì và sửa chữa khối lượng cơ nạcTăng cường hệ miễn dịchTăng tốc phục hồi########Chắc chắn bạn đã biết rõ vai trò của Whey...',
                'giamgia' => 0,
                'giakhuyenmai' => 1350000.0,
                'soluong' => 100,
                'noi_bat' => 0,
                'trang_thai' => 1,
                'id_danhmuc' => 7,
                'co_size' => 1,
                'images' => ['https://cdn.hstatic.net/products/1000185761/wv24_25_1200x.progressive_e65847c8f86e49e9bc7bd2605d759181.jpg', 'https://cdn.hstatic.net/products/1000185761/wc24_25_1200x.progressive_e7882f280f9d4fb0a35c42c6a21c0cc5.jpg', 'https://cdn.hstatic.net/products/1000185761/ws24_25_1200x.progressive_ffe22781c6d54f3cb49058b2101a9026.jpg'],
                'flavors' => ['Socola', 'Vani', 'Dâu'],
            ],
        ];

        foreach ($products as $prod) {
            // Check if product with same SKU already exists
            $existingProduct = DB::table('sanpham')->where('sku', $prod['sku'])->first();
            if ($existingProduct) {
                $productId = $existingProduct->id_sanpham;
                // Update basic fields
                DB::table('sanpham')->where('id_sanpham', $productId)->update([
                    'tensp' => $prod['tensp'],
                    'giasp' => $prod['giasp'],
                    'gia_duoc_giam' => $prod['gia_duoc_giam'],
                    'mota' => $prod['mota'],
                    'mota_ngan' => $prod['mota_ngan'],
                    'giamgia' => $prod['giamgia'],
                    'giakhuyenmai' => $prod['giakhuyenmai'],
                    'id_danhmuc' => $prod['id_danhmuc'],
                    'co_size' => 1,
                    'updated_at' => $now
                ]);
            } else {
                $productId = DB::table('sanpham')->insertGetId([
                    'tensp'        => $prod['tensp'],
                    'sku'          => $prod['sku'],
                    'giasp'        => $prod['giasp'],
                    'gia_duoc_giam'=> $prod['gia_duoc_giam'],
                    'mota'         => $prod['mota'],
                    'mota_ngan'    => $prod['mota_ngan'],
                    'giamgia'      => $prod['giamgia'],
                    'giakhuyenmai' => $prod['giakhuyenmai'],
                    'soluong'      => $prod['soluong'],
                    'noi_bat'      => $prod['noi_bat'],
                    'trang_thai'   => $prod['trang_thai'],
                    'id_danhmuc'   => $prod['id_danhmuc'],
                    'co_size'      => 1,
                    'created_at'   => $now,
                    'updated_at'   => $now
                ], 'id_sanpham'); // ← chỉ định PK cho PostgreSQL
            }

            // Sync images: Download images from internet to local public/frontend/upload and save path to DB
            DB::table('images')->where('id_sanpham', $productId)->delete();
            if (isset($prod['images']) && is_array($prod['images'])) {
                foreach ($prod['images'] as $index => $url) {
                    try {
                        $dir = public_path('frontend/upload');
                        if (!file_exists($dir)) {
                            mkdir($dir, 0755, true);
                        }

                        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                        if (empty($ext)) $ext = 'png';

                        // Tải ảnh về với tên cố định (không dùng time() để tránh mất ảnh khi restart container)
                        $filename = 'supplement_' . $productId . '_' . $index . '.' . $ext;
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
                        \Illuminate\Support\Facades\Log::error("Lỗi cào ảnh sản phẩm " . $prod['sku'] . ": " . $e->getMessage());
                    }
                }
            }

            // Sync flavors/sizes
            // Support both indexed array ['Socola', 'Vani'] and associative ['120 Viên' => 0, '240 Viên' => 850000]
            foreach ($prod['flavors'] as $flavorKey => $flavorValue) {
                // Detect format: if key is int -> simple list (no extra price), if key is string -> assoc (with price)
                if (is_int($flavorKey)) {
                    $flavorName = $flavorValue;
                    $giaCongThem = 0;
                } else {
                    $flavorName = $flavorKey;
                    $giaCongThem = (float) $flavorValue;
                }

                $size = Size::firstOrCreate(
                    ['ten_size' => $flavorName],
                    ['mota' => 'Hương vị/Biến thể của thực phẩm bổ sung', 'trang_thai' => 1]
                );

                // Update or insert relation with correct price
                $hasRelation = DB::table('sanpham_size')
                    ->where('id_sanpham', $productId)
                    ->where('id_size', $size->id_size)
                    ->exists();

                if (!$hasRelation) {
                    DB::table('sanpham_size')->insert([
                        'id_sanpham' => $productId,
                        'id_size' => $size->id_size,
                        'soluong' => 100,
                        'gia_cong_them' => $giaCongThem
                    ]);
                } else {
                    // Update existing relation's price
                    DB::table('sanpham_size')
                        ->where('id_sanpham', $productId)
                        ->where('id_size', $size->id_size)
                        ->update(['gia_cong_them' => $giaCongThem]);
                }
            }
        }
    }
}
