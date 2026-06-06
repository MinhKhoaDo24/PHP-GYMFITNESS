<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonHangSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Danh sách người dùng mẫu mặc định có trong DB
        $userIds = [1, 4, 5];

        // Tạo thêm 10 tài khoản khách hàng mẫu nếu chưa tồn tại
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
                    'hoten'        => $cust['hoten'],
                    'email'        => $cust['email'],
                    'password'     => bcrypt('123456'),
                    'diachi'       => $cust['diachi'],
                    'sdt'          => $cust['sdt'],
                    'id_phanquyen' => 2,
                    'created_at'   => $now,
                    'updated_at'   => $now
                ], 'id_nd'); // ← PK cho PostgreSQL
                $userIds[] = $userId;
            }
        }

        // Dọn sạch dữ liệu cũ thuộc các user này để đảm bảo idempotent
        DB::table('comments')->whereIn('user_id', $userIds)->delete();
        DB::table('chitiet_donhang')->whereIn('id_nd', $userIds)->delete();
        DB::table('dathang')->whereIn('id_nd', $userIds)->delete();

        // Lấy danh sách sản phẩm hiện có trong CSDL
        $products = DB::table('sanpham')->get();
        if ($products->isEmpty()) {
            $this->command->warn('Không có sản phẩm nào trong CSDL để seeding đơn hàng.');
            return;
        }

        // Cấu hình phân phối trạng thái đơn hàng (tổng cộng ~130 đơn)
        // 70% Hoàn thành, 10% Chờ xác nhận, 10% Đang giao hàng, 5% Bị hủy, 5% Thất bại
        $totalOrders = 130;
        $statuses = [];
        
        $completedCount = (int)($totalOrders * 0.70);
        $pendingCount = (int)($totalOrders * 0.10);
        $shippingCount = (int)($totalOrders * 0.10);
        $canceledCount = (int)($totalOrders * 0.05);
        $failedCount = $totalOrders - ($completedCount + $pendingCount + $shippingCount + $canceledCount);

        for ($i = 0; $i < $completedCount; $i++) $statuses[] = 'Hoàn thành';
        for ($i = 0; $i < $pendingCount; $i++) $statuses[] = 'Chờ xác nhận';
        for ($i = 0; $i < $shippingCount; $i++) $statuses[] = 'Đang giao hàng';
        for ($i = 0; $i < $canceledCount; $i++) $statuses[] = 'Bị hủy';
        for ($i = 0; $i < $failedCount; $i++) $statuses[] = 'Thất bại';

        // Trộn ngẫu nhiên trạng thái đơn hàng
        shuffle($statuses);

        foreach ($statuses as $status) {
            // Chọn người dùng ngẫu nhiên
            $userId = $userIds[array_rand($userIds)];
            $user = DB::table('nguoidung')->where('id_nd', $userId)->first();

            // Random ngày đặt hàng trong vòng 30 ngày qua
            $ngayDat = $now->copy()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            // Xác định ngày giao hàng / hoàn thành dựa trên trạng thái
            $ngayGiao = null;
            $ngayHoanThanh = null;
            if ($status === 'Hoàn thành') {
                $ngayGiao = $ngayDat->copy()->addDays(rand(1, 3))->addHours(rand(1, 12));
                $ngayHoanThanh = $ngayGiao;
            } elseif ($status === 'Đang giao hàng') {
                $ngayGiao = $ngayDat->copy()->addDays(rand(0, 1));
            }

            // Chọn ngẫu nhiên từ 1 đến 3 sản phẩm khác nhau
            $numItems = rand(1, 3);
            $selectedProducts = $products->random(min($numItems, $products->count()));

            $orderItems = [];
            $tongTien = 0;
            $tienPhaiTra = 0;

            foreach ($selectedProducts as $product) {
                $soluong = rand(1, 2);
                $giasp = (int)$product->giasp;
                $giakhuyenmai = (int)$product->giakhuyenmai;
                $giamgia = (int)$product->giamgia; // có thể là % hoặc số tiền giảm, tùy cấu trúc

                $tongTien += $giasp * $soluong;
                $tienPhaiTra += $giakhuyenmai * $soluong;

                $orderItems[] = [
                    'tensp' => $product->tensp,
                    'soluong' => $soluong,
                    'giamgia' => $giamgia,
                    'giatien' => $giasp,
                    'giakhuyenmai' => $giakhuyenmai,
                    'id_sanpham' => $product->id_sanpham,
                    'id_nd' => $userId
                ];
            }

            $tienGiam = $tongTien - $tienPhaiTra;

            // Tạo đơn hàng
            $orderId = DB::table('dathang')->insertGetId([
                'ngaydathang'          => $ngayDat,
                'ngaygiaohang'         => $ngayGiao,
                'ngay_hoan_thanh'      => $ngayHoanThanh,
                'tongtien'             => $tongTien,
                'tiengiam'             => $tienGiam,
                'tienphaitra'          => $tienPhaiTra,
                'id_khuyenmai'         => null,
                'phuongthucthanhtoan'  => rand(0, 1) ? 'COD' : 'VNPAY',
                'diachigiaohang'       => $user->diachi ?? 'Hà Nội',
                'hoten'                => $user->hoten,
                'email'                => $user->email,
                'sdt'                  => $user->sdt ?? '0912345678',
                'trangthai'            => $status,
                'id_nd'                => $userId
            ], 'id_dathang'); // ← PK cho PostgreSQL

            // Thêm chi tiết đơn hàng
            foreach ($orderItems as $item) {
                $item['id_dathang'] = $orderId;
                DB::table('chitiet_donhang')->insert($item);
            }
        }
    }
}
