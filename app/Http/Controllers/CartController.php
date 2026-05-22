<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham"    => $product->id_sanpham,
                "tensp"         => $product->tensp,
                "anhsp"         => $imagePath, 
                "giasp"         => $product->giasp,
                "giamgia"       => $product->giamgia,
                "giakhuyenmai"  => $product->giakhuyenmai,
                "quantity"      => 1
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'status'      => 'success',
                'message'     => 'Đã thêm vào giỏ hàng thành công!',
                'cart_count'  => array_sum(array_column($cart, 'quantity')),
            ]);
        }

        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    public function addGoToCart($id)
    {
        $product = Sanpham::with('images')->findOrFail($id);

        $firstImage = $product->images->first();
        $imagePath  = $firstImage
            ? $firstImage->duong_dan
            : 'frontend/upload/placeholder.jpg';

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id_sanpham"    => $product->id_sanpham,
                "tensp"         => $product->tensp,
                "anhsp"         => $imagePath, // ảnh đầu tiên
                "giasp"         => $product->giasp,
                "giamgia"       => $product->giamgia,
                "giakhuyenmai"  => $product->giakhuyenmai,
                "quantity"      => 1
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
            'success' => true,
            'total'   => $total,
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('needLogin', true);
        }

        $showusers = DB::table('nguoidung')
            ->select('nguoidung.*')
            ->where('nguoidung.id_nd', $user->id_nd)
            ->get();

        $cart = session()->get('cart', []);

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

            // Nếu AJAX tính sai → Controller tính lại
            $tiengiam_auto = ($km->kieu_giam === 'percent')
                ? ($tongtien * $km->gia_tri_giam / 100)
                : $km->gia_tri_giam;

            if ($km->giam_toi_da && $tiengiam_auto > $km->giam_toi_da) {
                $tiengiam_auto = $km->giam_toi_da;
            }

            if ($tiengiam != $tiengiam_auto) {
                // ép theo giá trị chuẩn để tránh bị chỉnh giá client
                $tiengiam = $tiengiam_auto;
                $tienphaitra = max($tongtien - $tiengiam, 0);
            }

            // Cập nhật lượt dùng mã KM
            $km->increment('so_luot_da_dung');
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
        $order = Dathang::create([
            'tongtien'     => $tongtien,
            'tiengiam'     => $tiengiam,
            'tienphaitra'  => $tienphaitra,
            'id_khuyenmai' => $id_km,
            'phuongthucthanhtoan' => $request->redirect,
            'diachigiaohang' => $request->display_diachigiaohang,
            'hoten'        => $request->display_hoten,
            'email'        => $request->display_email,
            'sdt'          => $request->display_sdt,
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
        $vnp_TmnCode    = "4M7EXIQQ"; 
        $vnp_HashSecret = "QKB1K3QJ7DL73O6GHQDRUNWTIJ3XQ77Q";

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

        // Tính giảm giá
        if ($promo->kieu_giam === 'percent') {
            $discount = ($total * $promo->gia_tri_giam) / 100;
        } else {
            $discount = $promo->gia_tri_giam;
        }

        // Giảm tối đa (nếu có)
        if ($promo->giam_toi_da && $discount > $promo->giam_toi_da) {
            $discount = $promo->giam_toi_da;
        }

        // Tính tổng mới
        $newTotal = max($total - $discount, 0);

        // Lưu session tạm (client dùng để hiển thị)
        session([
            'promo' => [
                'id' => $promo->id_khuyenmai,
                'code' => $promo->ma_code,
                'discount' => $discount,
                'new_total' => $newTotal
            ]
        ]);

        return response()->json([
            'success' => true,
            'id_khuyenmai' => $promo->id_khuyenmai,   // ⭐ trả về ID đúng
            'discount' => $discount,
            'new_total' => $newTotal,
            'message' => 'Áp dụng mã thành công!',
        ]);
    }



}
