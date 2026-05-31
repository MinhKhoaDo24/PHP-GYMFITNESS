<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Sanpham;
use App\Models\Dathang;
use App\Models\Khuyenmai;
use App\Models\ChitietDonhang;

class CartController extends Controller
{
    public function index()
    {
        $products = Sanpham::all();
        return view('products', compact('products'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);

        $totalOriginal = 0; 
        $totalFinal    = 0; 

        foreach ($cart as $item) {
            $qty          = $item['quantity'] ?? 0;
            $giaGoc       = $item['giasp'] ?? 0;
            $giaKhuyenMai = $item['giakhuyenmai'] ?? $giaGoc;

            $totalOriginal += $giaGoc       * $qty;
            $totalFinal    += $giaKhuyenMai * $qty;
        }

        $totalDiscount = $totalOriginal - $totalFinal; 

        return view('pages.cart', compact(
            'cart',
            'totalOriginal',
            'totalDiscount',
            'totalFinal'
        ));
    }

     public function addToCart(Request $request, $id)
    {
        $product = Sanpham::with('images')->findOrFail($id);

        $firstImage = $product->images->first();
        $imagePath  = $firstImage
            ? $firstImage->duong_dan
            : 'frontend/upload/placeholder.jpg'; 

        $cart = session()->get('cart', []);

        // Lấy số lượng từ request
        $qty = (int) $request->input('quantity', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                "id_sanpham"    => $product->id_sanpham,
                "tensp"         => $product->tensp,
                "anhsp"         => $imagePath, 
                "giasp"         => $product->giasp,
                "giamgia"       => $product->giamgia,
                "giakhuyenmai"  => $product->giakhuyenmai,
                "quantity"      => $qty
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'status'      => 'success',
                'message'     => 'Đã thêm vào giỏ hàng thành công!',
                'cart_count'  => count($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    public function addGoToCart(Request $request, $id)
    {
        $product = Sanpham::with('images')->findOrFail($id);

        $firstImage = $product->images->first();
        $imagePath  = $firstImage
            ? $firstImage->duong_dan
            : 'frontend/upload/placeholder.jpg';

        $cart = session()->get('cart', []);

        // Lấy số lượng từ request
        $qty = (int) $request->input('quantity', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                "id_sanpham"    => $product->id_sanpham,
                "tensp"         => $product->tensp,
                "anhsp"         => $imagePath, // ảnh đầu tiên
                "giasp"         => $product->giasp,
                "giamgia"       => $product->giamgia,
                "giakhuyenmai"  => $product->giakhuyenmai,
                "quantity"      => $qty
            ];
        }

        session()->put('cart', $cart);
        return redirect('/cart');
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Kiểm tra số lượng hợp lệ
            if ($quantity < 1 || $quantity > 999) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng không hợp lệ.',
                    'quantity' => $cart[$id]['quantity'] // Trả về số lượng hiện tại để khôi phục
                ], 400);
            }

            // Cập nhật số lượng
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            $productTotal = $cart[$id]['giakhuyenmai'] * $quantity;
            // Tính tổng tiền giỏ hàng (giá gốc + khuyến mãi)
            $totalOriginal = 0; 
            $totalFinal    = 0; 

            foreach ($cart as $item) {
                $qty          = $item['quantity'];
                $giaGoc       = $item['giasp'];
                $giaKM        = $item['giakhuyenmai'];

                $totalOriginal += $giaGoc * $qty;
                $totalFinal    += $giaKM  * $qty;
            }

            $totalDiscount = $totalOriginal - $totalFinal; 

            return response()->json([
                'status'         => 'success',
                'product_total'  => $productTotal,
                'total_original' => $totalOriginal,
                'total_discount' => $totalDiscount,
                'total_final'    => $totalFinal,
                'message'        => 'Cập nhật giỏ hàng thành công!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'
        ], 400);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['giakhuyenmai'] * $item['quantity'];
        }

        return response()->json([
            'success'    => true,
            'total'      => $total,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('needLogin', true);
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $showusers = DB::table('nguoidung')
            ->select('nguoidung.*')
            ->where('nguoidung.id_nd', $user->id_nd)
            ->get();

        $total = 0;
        foreach ($cart as $item) {
            $qty          = $item['quantity'] ?? 0;
            $giaKM        = $item['giakhuyenmai'] ?? ($item['giasp'] ?? 0);
            $total       += $giaKM * $qty;
        }

        return view('pages.checkout', compact('showusers', 'cart', 'total'));
    }

// Đặt hàng

    public function dathang(Request $request)
    {

        // -----------------------------
        // KIỂM TRA GIỎ HÀNG
        // -----------------------------
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Không có sản phẩm nào trong giỏ hàng!');
        }

        // -----------------------------
        // XÁC THỰC THÔNG TIN NHẬN HÀNG
        // -----------------------------
        $request->validate([
            'display_hoten' => ['required', 'string', 'max:100'],
            'display_email' => ['required', 'email', 'max:100'],
            'display_sdt' => ['required', 'regex:/^(0\d{9}|\d{9})$/'],
            'display_diachigiaohang' => ['required', 'string', 'max:255'],
        ], [
            'display_hoten.required' => 'Họ tên không được để trống.',
            'display_email.required' => 'Email không được để trống.',
            'display_email.email' => 'Email không đúng định dạng.',
            'display_sdt.required' => 'Số điện thoại không được để trống.',
            'display_sdt.regex' => 'Số điện thoại không hợp lệ.',
            'display_diachigiaohang.required' => 'Địa chỉ giao hàng không được để trống.',
        ]);

        // -----------------------------
        // LẤY THÔNG TIN TỪ FORM
        // -----------------------------
        $tongtien = (int) $request->tongtien;
        $tiengiam = (int) $request->tiengiam;
        $tienphaitra = (int) $request->tienphaitra;
        $id_km = $request->id_khuyenmai;

        // -----------------------------
        // BẢO VỆ: CHECK KHUYẾN MÃI LẠI
        // -----------------------------
        if ($id_km) {
            $km = Khuyenmai::find($id_km);

            if (!$km || $km->trang_thai != 1) {
                return back()->with('error', 'Mã khuyến mãi không hợp lệ!');
            }

            $today = now();
            if (($km->ngay_bat_dau && $today < $km->ngay_bat_dau) ||
                ($km->ngay_ket_thuc && $today > $km->ngay_ket_thuc)) {
                return back()->with('error', 'Mã khuyến mãi đã hết hạn!');
            }

            // Bảo vệ số lượt dùng
            if ($km->gioi_han_luot !== null && $km->so_luot_da_dung >= $km->gioi_han_luot) {
                return back()->with('error', 'Mã khuyến mãi đã hết lượt sử dụng!');
            }

            // Kiểm tra xem có phải mã Freeship không
            $phi_ship = $this->calculateShippingFee($request->thanh_pho);
            $isFreeship = (
                $km->kieu_giam === 'freeship'
                && $request->thanh_pho === env('STORE_CITY', 'Hà Nội')
                && ($km->don_toi_thieu === null || $tongtien >= $km->don_toi_thieu)
            );

            if ($isFreeship) {
                $tiengiam_auto = $phi_ship; // Giảm đúng bằng phí ship thực tế
            } else {
                // Nếu AJAX tính sai → Controller tính lại
                $tiengiam_auto = ($km->kieu_giam === 'percent')
                    ? ($tongtien * $km->gia_tri_giam / 100)
                    : $km->gia_tri_giam;

                if ($km->giam_toi_da && $tiengiam_auto > $km->giam_toi_da) {
                    $tiengiam_auto = $km->giam_toi_da;
                }
            }

            if ($tiengiam != $tiengiam_auto) {
                // ép theo giá trị chuẩn để tránh bị chỉnh giá client
                $tiengiam = $tiengiam_auto;
            }

            // Tổng thanh toán thực tế = Tiền hàng - Giảm giá + phí ship (nếu freeship thì triệt tiêu)
            if ($isFreeship) {
                $tienphaitra = $tongtien;
            } else {
                $tienphaitra = max($tongtien - $tiengiam, 0) + $phi_ship;
            }

            // Cập nhật lượt dùng mã KM
            $km->increment('so_luot_da_dung');
        } else {
            // Không dùng mã KM: tiền phải trả = tiền hàng + phí ship theo địa chỉ
            $tiengiam = 0;
            $tienphaitra = $tongtien + $this->calculateShippingFee($request->thanh_pho);
        }

        // -----------------------------
        // KIỂM TRA TỒN KHO CHUẨN
        // -----------------------------
        foreach ($cart as $item) {
            $sanpham = Sanpham::find($item['id_sanpham']);

            if (!$sanpham) {
                return back()->with('error', 'Sản phẩm không tồn tại!');
            }

            // tồn kho trực tiếp từ bảng sanpham
            if ($item['quantity'] > $sanpham->soluong) {
                return back()->with('error', "Sản phẩm {$sanpham->tensp} không đủ tồn kho!");
            }
        }

        // -----------------------------
        // TẠO ĐƠN HÀNG
        // -----------------------------
        $diachi = $request->display_diachigiaohang;
        $thanh_pho = $request->thanh_pho ?? env('STORE_CITY', 'Hà Nội');
        $trimmedDiachi = mb_strtolower(trim($diachi));
        $trimmedThanhPho = mb_strtolower(trim($thanh_pho));
        $len = mb_strlen($trimmedThanhPho);
        
        if (mb_substr($trimmedDiachi, -$len) === $trimmedThanhPho) {
            $diachi_cuoi = $diachi;
        } else {
            $diachi_cuoi = $diachi . ', ' . $thanh_pho;
        }

        $order = Dathang::create([
            'tongtien'     => $tongtien,
            'tiengiam'     => $tiengiam,
            'tienphaitra'  => $tienphaitra,
            'id_khuyenmai' => $id_km,
            'phuongthucthanhtoan' => $request->redirect,
            'diachigiaohang' => $diachi_cuoi,
            'hoten'        => $request->display_hoten,
            'email'        => $request->display_email,
            'sdt'          => $request->display_sdt,
            'ngaydathang'  => now(),
            'ngaygiaohang' => now()->addDays(4),
            'id_nd'        => Auth::user()->id_nd,
        ]);

        // -----------------------------
        // TẠO CHI TIẾT ĐƠN HÀNG + TRỪ TỒN
        // -----------------------------
        foreach ($cart as $item) {
            
            ChitietDonhang::create([
                'tensp'         => $item['tensp'],
                'soluong'       => $item['quantity'],
                'giamgia'       => $item['giamgia'],
                'giatien'       => $item['giasp'],
                'giakhuyenmai'  => $item['giakhuyenmai'],
                'id_sanpham'    => $item['id_sanpham'],
                'id_dathang'    => $order->id_dathang,
                'id_nd'         => Auth::user()->id_nd,
            ]);

            // Trừ tồn kho
            $sp = Sanpham::find($item['id_sanpham']);
            $sp->soluong -= $item['quantity'];
            $sp->save();
        }

        // -----------------------------
        // GỬI EMAIL HÓA ĐƠN
        // -----------------------------
        try {
            $email = $order->email;
            $hoten = $order->hoten;
            Mail::send('pages.invoice_mail', compact('order', 'cart'), function ($message) use ($email, $hoten) {
                $message->to($email, $hoten)
                        ->subject('Rise Fitness - Hóa đơn mua hàng #' . time());
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi gửi email hóa đơn: ' . $e->getMessage());
        }

        // -----------------------------
        // XÓA GIỎ HÀNG
        // -----------------------------
        session()->forget('cart');

        return view('pages.thongbaodathang');
    }




    public function thongbaodathang(Request $request)
    {
        if ($request->has('vnp_ResponseCode') && $request->has('vnp_TransactionNo')) {
            $responseCode = $request->input('vnp_ResponseCode');

            if ($responseCode == '00') {

                $orderData = session()->get('order_data');
                if ($orderData) {
                    $fakeRequest = Request::create('/', 'POST', $orderData);
                    $fakeRequest->setLaravelSession(app('session')->driver());

                    $this->dathang($fakeRequest);
                    session()->forget('order_data');
                }
                return view('pages.thongbaodathang');
            } else {
                return redirect('/cart')->with('error', 'Thanh toán thất bại.');
            }
        } else {
            return redirect('/cart');
        }
    }

    public function vnpay(Request $request)
    {
        // -----------------------------
        // XÁC THỰC THÔNG TIN NHẬN HÀNG
        // -----------------------------
        $request->validate([
            'display_hoten' => ['required', 'string', 'max:100'],
            'display_email' => ['required', 'email', 'max:100'],
            'display_sdt' => ['required', 'regex:/^(0\d{9}|\d{9})$/'],
            'display_diachigiaohang' => ['required', 'string', 'max:255'],
        ], [
            'display_hoten.required' => 'Họ tên không được để trống.',
            'display_email.required' => 'Email không được để trống.',
            'display_email.email' => 'Email không đúng định dạng.',
            'display_sdt.required' => 'Số điện thoại không được để trống.',
            'display_sdt.regex' => 'Số điện thoại không hợp lệ.',
            'display_diachigiaohang.required' => 'Địa chỉ giao hàng không được để trống.',
        ]);

        $vnp_TmnCode    = env('VNP_TMN_CODE', '4M7EXIQQ'); 
        $vnp_HashSecret = env('VNP_HASH_SECRET', 'QKB1K3QJ7DL73O6GHQDRUNWTIJ3XQ77Q');

        $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl  = url('/thongbaodathang');

        $vnp_TxnRef     = date("YmdHis");   // mã giao dịch
        $vnp_Amount     = $request->tienphaitra * 100; // nhân 100 theo chuẩn VNPAY
        $vnp_OrderInfo  = "Thanh toán hóa đơn: " . $vnp_TxnRef;
        $vnp_OrderType  = "other";
        $vnp_IpAddr     = request()->ip();

        // -------------------------------
        // BUILD DATA GỬI LÊN VNPAY
        // -------------------------------
        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => "vn",
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => $vnp_OrderType,
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef
        ];

        // Nếu có bankCode
        if ($request->bankCode) {
            $inputData['vnp_BankCode'] = $request->bankCode;
        }

        // -------------------------------
        // SORT KEY + TẠO QUERY & HASH
        // -------------------------------
        ksort($inputData);

        $query = "";
        $hashdata = "";
        $i = 0;

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }

            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // -------------------------------
        // TẠO SECURE HASH ĐÚNG CHUẨN
        // -------------------------------
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // Append vào URL
        $vnp_Url = $vnp_Url . "?" . $query . "vnp_SecureHash=" . $vnpSecureHash;

        // -------------------------------
        // LƯU ORDER TẠM (NẾU CẦN)
        // -------------------------------
        session()->put('order_data', $request->all());
        session()->put('vnp_TxnRef', $vnp_TxnRef);

        return redirect($vnp_Url);
    }
    
    public function applyPromo(Request $request)
    {
        $code = $request->promo_code;

        // Tìm mã khuyến mãi
        $promo = Khuyenmai::where('ma_code', $code)
                    ->where('trang_thai', 1)
                    ->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không hợp lệ!',
            ]);
        }

        // Kiểm tra ngày áp dụng
        $today = now();
        if (($promo->ngay_bat_dau && $today < $promo->ngay_bat_dau) ||
            ($promo->ngay_ket_thuc && $today > $promo->ngay_ket_thuc)) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi đã hết hạn!',
            ]);
        }

        // Tính tổng tiền giỏ hàng
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['giakhuyenmai'] * $item['quantity'];
        }

        // Kiểm tra đơn tối thiểu
        if ($promo->don_toi_thieu != null && $total < $promo->don_toi_thieu) {
            return response()->json([
                'success' => false,
                'message' => 'Giá trị đơn hàng chưa đủ để áp dụng mã khuyến mãi!',
            ]);
        }

        // Kiểm tra giới hạn lượt
        if ($promo->gioi_han_luot != null && $promo->so_luot_da_dung >= $promo->gioi_han_luot) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi đã hết lượt sử dụng!',
            ]);
        }

        // Tính toán giảm giá và phí ship
        $phi_ship = $this->calculateShippingFee($request->thanh_pho);
        $isFreeship = (
            $promo->kieu_giam === 'freeship'
            && $request->thanh_pho === env('STORE_CITY', 'Hà Nội')
            && ($promo->don_toi_thieu === null || $total >= $promo->don_toi_thieu)
        );

        if ($isFreeship) {
            $discount = $phi_ship; // Giảm đúng bằng phí ship thực tế
            $newTotal = $total;    // Đơn Freeship: tổng = đúng tiền hàng
        } else {
            // Tính giảm giá sản phẩm thông thường
            if ($promo->kieu_giam === 'percent') {
                $discount = ($total * $promo->gia_tri_giam) / 100;
            } else {
                $discount = $promo->gia_tri_giam;
            }

            // Giảm tối đa (nếu có)
            if ($promo->giam_toi_da && $discount > $promo->giam_toi_da) {
                $discount = $promo->giam_toi_da;
            }

            // Tổng thanh toán = Tiền hàng - Giảm giá + phí ship theo địa chỉ
            $newTotal = max($total - $discount, 0) + $phi_ship;
        }

        // Lưu session tạm (client dùng để hiển thị)
        session([
            'promo' => [
                'id' => $promo->id_khuyenmai,
                'code' => $promo->ma_code,
                'discount' => $discount,
                'new_total' => $newTotal,
                'is_freeship' => $isFreeship
            ]
        ]);

        return response()->json([
            'success' => true,
            'id_khuyenmai' => $promo->id_khuyenmai,   // ⭐ trả về ID đúng
            'discount' => $discount,
            'new_total' => $newTotal,
            'is_freeship' => $isFreeship,
            'message' => 'Áp dụng mã thành công!',
        ]);
    }


    /**
     * Tính phí ship dựa vào tỉnh/thành phố khách chọn.
     * Cấu hình trong .env:
     *   STORE_CITY        = tên tỉnh/thành của kho hàng (vd: "Hà Nội")
     *   SHIPPING_FEE_INSIDE  = phí ship nội thành (vd: 20000)
     *   SHIPPING_FEE_OUTSIDE = phí ship ngoại tỉnh (vd: 35000)
     */
    private function calculateShippingFee(?string $thanh_pho): int
    {
        $storeCity   = env('STORE_CITY', 'Hà Nội');
        $feeInside   = (int) env('SHIPPING_FEE_INSIDE', 20000);
        $feeOutside  = (int) env('SHIPPING_FEE_OUTSIDE', 35000);

        if ($thanh_pho && mb_strtolower(trim($thanh_pho)) === mb_strtolower(trim($storeCity))) {
            return $feeInside;
        }

        return $feeOutside;
    }


}
