<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\SanPham;
use App\Models\Dathang;
use App\Models\Khuyenmai;
use App\Models\ChitietDonhang;
use App\Helpers\CartHelper;

class CartController extends Controller
{
    public function index()
    {
        $products = Sanpham::all();
        return view('products', compact('products'));
    }

    public function cart()
    {
        session()->forget('buy_now');
        $cart = session()->get('cart', []);

        $totalOriginal = 0;
        $totalSalePrice = 0;
        $totalSurcharge = 0;

        $stock = [];
        $sizes = [];

        foreach ($cart as $id => $item) {
            $qty          = $item['quantity'] ?? 0;
            $surcharge    = $item['gia_cong_them'] ?? 0;
            $giaGoc       = ($item['giasp'] ?? 0) + $surcharge;
            $giaKhuyenMai = ($item['giakhuyenmai'] ?? ($item['giasp'] ?? 0)) + $surcharge;

            $totalOriginal  += $giaGoc       * $qty;
            $totalSalePrice += $giaKhuyenMai * $qty;
            $totalSurcharge += $surcharge    * $qty;

            // Load product sizes and stock
            $product = Sanpham::with('sizes')->find($item['id_sanpham']);
            if ($product) {
                if ($product->co_size == 1) {
                    $sizes[$id] = $product->sizes;
                } else {
                    $sizes[$id] = [];
                }

                $szId = $item['id_size'] ?? null;
                if ($product->co_size == 1 && $szId) {
                    $sizePivot = $product->sizes()->where('sanpham_size.id_size', $szId)->first();
                    $stock[$id] = $sizePivot ? $sizePivot->pivot->soluong : 0;
                } else {
                    $stock[$id] = $product->soluong;
                }
            } else {
                $sizes[$id] = [];
                $stock[$id] = 0;
            }
        }

        $totalFinal = $totalSalePrice;
        $totalDiscount = $totalOriginal - $totalSalePrice;

        return view('pages.cart', compact(
            'cart',
            'totalOriginal',
            'totalDiscount',
            'totalFinal',
            'totalSurcharge',
            'stock',
            'sizes'
        ));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Sanpham::with(['images', 'sizes'])->findOrFail($id);
        $quantity = (int)$request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;
        $id_size = $request->input('id_size');

        $sizeObj = null;
        $ten_size = null;
        $gia_cong_them = 0;

        if ($product->co_size == 1) {
            if (!$id_size) {
                if ($request->ajax()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Vui lòng chọn size sản phẩm!'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Vui lòng chọn size sản phẩm!');
            }

            $sizePivot = $product->sizes()->where('sanpham_size.id_size', $id_size)->first();
            if (!$sizePivot) {
                if ($request->ajax()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Size được chọn không hợp lệ!'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Size được chọn không hợp lệ!');
            }

            if ($sizePivot->pivot->soluong <= 0) {
                if ($request->ajax()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Size này đã hết hàng!'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Size này đã hết hàng!');
            }

            $sizeObj = $sizePivot;
            $ten_size = $sizePivot->ten_size;
            $gia_cong_them = (int) $sizePivot->pivot->gia_cong_them;
        }

        $cartKey = $product->id_sanpham;
        if ($id_size) {
            $cartKey .= '_' . $id_size;
        }

        $firstImage = $product->images->first();
        $imagePath  = $firstImage
            ? $firstImage->duong_dan
            : 'frontend/upload/placeholder.jpg';

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $newQty = $cart[$cartKey]['quantity'] + $quantity;
            $maxQty = ($product->co_size == 1) ? $sizeObj->pivot->soluong : $product->soluong;
            if ($newQty > $maxQty) {
                if ($request->ajax()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Không đủ hàng trong kho! Chỉ còn {$maxQty} sản phẩm."
                    ], 400);
                }
                return redirect()->back()->with('error', "Không đủ hàng trong kho! Chỉ còn {$maxQty} sản phẩm.");
            }
            $cart[$cartKey]['quantity'] = $newQty;
        } else {
            $maxQty = ($product->co_size == 1) ? $sizeObj->pivot->soluong : $product->soluong;
            if ($quantity > $maxQty) {
                if ($request->ajax()) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Không đủ hàng trong kho! Chỉ còn {$maxQty} sản phẩm."
                    ], 400);
                }
                return redirect()->back()->with('error', "Không đủ hàng trong kho! Chỉ còn {$maxQty} sản phẩm.");
            }

            $cart[$cartKey] = [
                "id_sanpham"    => $product->id_sanpham,
                "tensp"         => $product->tensp,
                "anhsp"         => $imagePath,
                "giasp"         => $product->giasp,
                "giamgia"       => $product->giamgia,
                "giakhuyenmai"  => $product->giakhuyenmai,
                "quantity"      => $quantity,
                "id_size"       => $id_size,
                "ten_size"      => $ten_size,
                "gia_cong_them" => $gia_cong_them
            ];
        }

        CartHelper::saveCart($cart);

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
        $product = Sanpham::with(['images', 'sizes'])->findOrFail($id);
        $quantity = (int)$request->input('quantity', 1);
        if ($quantity < 1) $quantity = 1;
        $id_size = $request->input('id_size');

        $sizeObj = null;
        $ten_size = null;
        $gia_cong_them = 0;

        if ($product->co_size == 1) {
            if (!$id_size) {
                return redirect()->back()->with('error', 'Vui lòng chọn size sản phẩm!');
            }

            $sizePivot = $product->sizes()->where('sanpham_size.id_size', $id_size)->first();
            if (!$sizePivot) {
                return redirect()->back()->with('error', 'Size được chọn không hợp lệ!');
            }

            if ($sizePivot->pivot->soluong <= 0) {
                return redirect()->back()->with('error', 'Size này đã hết hàng!');
            }

            $sizeObj = $sizePivot;
            $ten_size = $sizePivot->ten_size;
            $gia_cong_them = (int) $sizePivot->pivot->gia_cong_them;
        }

        $cartKey = $product->id_sanpham;
        if ($id_size) {
            $cartKey .= '_' . $id_size;
        }

        $firstImage = $product->images->first();
        $imagePath  = $firstImage
            ? $firstImage->duong_dan
            : 'frontend/upload/placeholder.jpg';

        $maxQty = ($product->co_size == 1) ? $sizeObj->pivot->soluong : $product->soluong;
        if ($quantity > $maxQty) {
            return redirect()->back()->with('error', "Không đủ hàng trong kho! Chỉ còn {$maxQty} sản phẩm.");
        }

        $buyNowItem = [
            $cartKey => [
                "id_sanpham"    => $product->id_sanpham,
                "tensp"         => $product->tensp,
                "anhsp"         => $imagePath,
                "giasp"         => $product->giasp,
                "giamgia"       => $product->giamgia,
                "giakhuyenmai"  => $product->giakhuyenmai,
                "quantity"      => $quantity,
                "id_size"       => $id_size,
                "ten_size"      => $ten_size,
                "gia_cong_them" => $gia_cong_them
            ]
        ];

        session()->put('buy_now', $buyNowItem);
        return redirect('/checkout');
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
                    'quantity' => $cart[$id]['quantity']
                ], 400);
            }

            // Kiểm tra tồn kho của sản phẩm/size tương ứng
            $spId = $cart[$id]['id_sanpham'];
            $szId = $cart[$id]['id_size'] ?? null;
            $product = Sanpham::with('sizes')->find($spId);
            if ($product) {
                $maxQty = ($product->co_size == 1 && $szId)
                    ? optional($product->sizes()->where('sanpham_size.id_size', $szId)->first())->pivot->soluong
                    : $product->soluong;

                if ($maxQty !== null && $quantity > $maxQty) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Không đủ hàng! Kho chỉ còn {$maxQty} sản phẩm.",
                        'quantity' => $cart[$id]['quantity']
                    ], 400);
                }
            }

            // Cập nhật số lượng
            $cart[$id]['quantity'] = $quantity;
            CartHelper::saveCart($cart);

            $itemSurcharge = $cart[$id]['gia_cong_them'] ?? 0;
            $productTotal = ($cart[$id]['giakhuyenmai'] + $itemSurcharge) * $quantity;

            $totalOriginal = 0;
            $totalSalePrice = 0;
            $totalSurcharge = 0;

            foreach ($cart as $item) {
                $qty          = $item['quantity'];
                $surcharge    = $item['gia_cong_them'] ?? 0;
                $giaGoc       = $item['giasp'] + $surcharge;
                $giaKM        = $item['giakhuyenmai'] + $surcharge;

                $totalOriginal  += $giaGoc * $qty;
                $totalSalePrice += $giaKM  * $qty;
            }

            $totalFinal = $totalSalePrice;
            $totalDiscount = $totalOriginal - $totalSalePrice;

            return response()->json([
                'status'         => 'success',
                'product_total'  => $productTotal,
                'total_original' => $totalOriginal,
                'total_discount' => $totalDiscount,
                'total_final'    => $totalFinal,
                'total_surcharge' => $totalSurcharge,
                'message'        => 'Cập nhật giỏ hàng thành công!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'
        ], 400);
    }

    public function updateSize(Request $request)
    {
        $id = $request->id;
        $newSizeId = $request->id_size;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $item = $cart[$id];
            $productId = $item['id_sanpham'];
            $product = Sanpham::with('sizes')->find($productId);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại.'
                ], 404);
            }

            if ($product->co_size != 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm này không hỗ trợ chọn size.'
                ], 400);
            }

            $sizePivot = $product->sizes()->where('sanpham_size.id_size', $newSizeId)->first();
            if (!$sizePivot) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Size được chọn không hợp lệ.'
                ], 400);
            }

            $newMaxQty = (int)$sizePivot->pivot->soluong;
            if ($newMaxQty <= 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Size này đã hết hàng.'
                ], 400);
            }

            $qty = $item['quantity'];
            $warning = null;
            if ($qty > $newMaxQty) {
                $qty = $newMaxQty;
                $warning = "Đã điều chỉnh số lượng thành {$newMaxQty} do giới hạn tồn kho của size mới.";
            }

            $newCartKey = $productId . '_' . $newSizeId;

            unset($cart[$id]);

            if (isset($cart[$newCartKey])) {
                $mergedQty = $cart[$newCartKey]['quantity'] + $qty;
                if ($mergedQty > $newMaxQty) {
                    $mergedQty = $newMaxQty;
                    $warning = "Đã gộp giỏ hàng và điều chỉnh số lượng thành {$newMaxQty} (tối đa tồn kho của size này).";
                }
                $cart[$newCartKey]['quantity'] = $mergedQty;
            } else {
                $cart[$newCartKey] = [
                    "id_sanpham"    => $productId,
                    "tensp"         => $product->tensp,
                    "anhsp"         => $item['anhsp'],
                    "giasp"         => $product->giasp,
                    "giamgia"       => $product->giamgia,
                    "giakhuyenmai"  => $product->giakhuyenmai,
                    "quantity"      => $qty,
                    "id_size"       => (int)$newSizeId,
                    "ten_size"      => $sizePivot->ten_size,
                    "gia_cong_them" => (int)$sizePivot->pivot->gia_cong_them
                ];
            }

            CartHelper::saveCart($cart);

            $totalOriginal = 0;
            $totalSalePrice = 0;
            $totalSurcharge = 0;

            foreach ($cart as $cartItem) {
                $q            = $cartItem['quantity'];
                $surcharge    = $cartItem['gia_cong_them'] ?? 0;
                $giaGoc       = $cartItem['giasp'];
                $giaKM        = $cartItem['giakhuyenmai'];

                $totalOriginal  += $giaGoc * $q;
                $totalSalePrice += $giaKM  * $q;
                $totalSurcharge += $surcharge * $q;
            }

            $totalFinal = $totalSalePrice + $totalSurcharge;
            $totalDiscount = $totalOriginal - $totalSalePrice;

            return response()->json([
                'status'          => 'success',
                'warning'         => $warning,
                'total_original'  => $totalOriginal,
                'total_discount'  => $totalDiscount,
                'total_final'     => $totalFinal,
                'total_surcharge' => $totalSurcharge,
                'message'         => 'Thay đổi size thành công!',
                'redirect'        => route('cart')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy sản phẩm tương ứng trong giỏ hàng.'
        ], 404);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            CartHelper::saveCart($cart);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['giakhuyenmai'] + ($item['gia_cong_them'] ?? 0)) * $item['quantity'];
        }

        return response()->json([
            'success'    => true,
            'total'      => $total,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function checkout(Request $request) //Điền sẵn thông tin hội viên
    {
        $user = Auth::user(); // Lấy thông tin của Hội viên đang đăng nhập thông qua Guard Auth
        
        $buyNow = session()->get('buy_now'); // Lấy dữ liệu "Mua ngay" (nếu có) từ session
        if (!empty($buyNow)) {
            $cart = $buyNow;
        } else {
            $selected = $request->query('selected');
            if ($selected) {
                $selectedKeys = explode(',', $selected);
                $fullCart = session()->get('cart', []);
                $checkoutItems = [];
                foreach ($selectedKeys as $key) {
                    if (isset($fullCart[$key])) {
                        $checkoutItems[$key] = $fullCart[$key];
                    }
                }
                session()->put('checkout_items', $checkoutItems);
                $cart = $checkoutItems;
            } else {
                if (session()->has('checkout_items')) {
                    $cart = session()->get('checkout_items');
                } else {
                    $cart = session()->get('cart', []);
                }
            }
        }
        if (empty($cart)) { // Nếu giỏ hàng trống
            return redirect('/cart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }


        $showusers = $user // Nếu đã đăng nhập, truy vấn CSDL lấy thông tin người dùng
            ? DB::table('nguoidung')
                ->select('nguoidung.*') // Lấy tất cả các cột từ bảng người dùng
                ->where('nguoidung.id_nd', $user->id_nd) // Theo đúng ID của hội viên đang đăng nhập
                ->get()
            : collect(); // Nếu chưa đăng nhập, trả về một collection trống.

        $total = 0;// Tính toán tổng tiền đơn hàng
        $totalSurcharge = 0;
        foreach ($cart as $item) {
            $qty          = $item['quantity'] ?? 0;
            $surcharge    = $item['gia_cong_them'] ?? 0;
            $giaKM        = ($item['giakhuyenmai'] ?? ($item['giasp'] ?? 0)) + $surcharge;
            $total       += $giaKM * $qty;
            $totalSurcharge += $surcharge * $qty;
        }
// Trả về view 'pages.checkout' và truyền các biến chứa thông tin người dùng, giỏ hàng, tổng tiền sang giao diện
        return view('pages.checkout', compact('showusers', 'cart', 'total', 'totalSurcharge'));
    }

    // Đặt hàng

    public function dathang(Request $request) //Thực hiện trừ kho, tạo đơn hàng và dọn dẹp giỏ hàng
    {

        $buyNow = session('buy_now'); // Lấy dữ liệu từ session
        $cart = !empty($buyNow) ? $buyNow : (session('checkout_items') ?: session('cart', [])); // Lấy giỏ hàng từ session
        if (empty($cart)) { // Nếu giỏ hàng trống   
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
                ($km->ngay_ket_thuc && $today > $km->ngay_ket_thuc)
            ) {
                return back()->with('error', 'Mã khuyến mãi đã hết hạn!');
            }

            // Bảo vệ số lượt dùng
            if ($km->gioi_han_luot !== null && $km->so_luot_da_dung >= $km->gioi_han_luot) {
                return back()->with('error', 'Mã khuyến mãi đã hết lượt sử dụng!');
            }

            // Kiểm tra điều kiện mã Freeship
            if ($km->kieu_giam === 'freeship') {
                if ($km->don_toi_thieu != null && $tongtien < $km->don_toi_thieu) {
                    return back()->with('error', "Đơn hàng phải từ " . number_format($km->don_toi_thieu, 0, ',', '.') . "đ trở lên mới được miễn phí vận chuyển!");
                }
            }

            // Kiểm tra xem có phải mã Freeship không
            $phi_ship = $this->calculateShippingFee($request->thanh_pho);
            $isFreeship = ($km->kieu_giam === 'freeship');

if ($isFreeship) {
    $tiengiam_auto = $phi_ship;
    if ($km->giam_toi_da && $tiengiam_auto > $km->giam_toi_da) {
        $tiengiam_auto = $km->giam_toi_da;
    }
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
                if ($isFreeship) {
    $tienphaitra = $tongtien + $phi_ship - $tiengiam;
}
            } else {
                $tienphaitra = max($tongtien - $tiengiam, 0) + $phi_ship;
            }

            // Bắt đầu transaction ở trong try catch của khối ghi bên dưới
        } else {
            // Không dùng mã KM: tiền phải trả = tiền hàng + phí ship theo địa chỉ
            $tiengiam = 0;
            $tienphaitra = $tongtien + $this->calculateShippingFee($request->thanh_pho);
        }

        // -----------------------------
        // KIỂM TRA TỒN KHO CHUẨN
        // -----------------------------
        // Chạy cơ chế kiểm tra tồn kho (Stock validation) cho từng mặt hàng trong giỏ
        foreach ($cart as $item) {
            $sanpham = Sanpham::with('sizes')->find($item['id_sanpham']); // Lấy thông tin sản phẩm

            if (!$sanpham) { // Nếu không tìm thấy sản phẩm
                return back()->with('error', 'Sản phẩm không tồn tại!');
            }

            if ($sanpham->co_size == 1 && !empty($item['id_size'])) { // Nếu sản phẩm có size và có size_id
                $sizePivot = $sanpham->sizes()->where('sanpham_size.id_size', $item['id_size'])->first();
                if (!$sizePivot || $item['quantity'] > $sizePivot->pivot->soluong) {
                    $sizeName = $sizePivot ? $sizePivot->ten_size : 'Không xác định';
                    return back()->with('error', "Sản phẩm {$sanpham->tensp} (Size {$sizeName}) không đủ tồn kho! Chỉ còn " . ($sizePivot ? $sizePivot->pivot->soluong : 0) . " sản phẩm.");
                }
            } else {
                if ($item['quantity'] > $sanpham->soluong) {
                    return back()->with('error', "Sản phẩm {$sanpham->tensp} không đủ tồn kho! Chỉ còn {$sanpham->soluong} sản phẩm.");
                }
            }
        }

        // ----------------------------------------------------
        // TẠO ĐƠN HÀNG & GHI CSDL (BỌC DATABASE TRANSACTION)
        // ----------------------------------------------------
        DB::beginTransaction(); // Bắt đầu giao dịch cơ sở dữ liệu
        try { // Tạo một khối lệnh try/catch để xử lý lỗi trong quá trình ghi CSDL. Nếu có bất kỳ lỗi nào xảy ra, giao dịch sẽ bị rollback, ngăn chặn việc dữ liệu bị ghi không nhất quán.
            // Cập nhật lượt dùng mã KM nếu có
            if ($id_km) { // Nếu có mã giảm giá
                $km->increment('so_luot_da_dung'); // Tăng số lượt sử dụng mã giảm giá
            }

            $diachi = $request->display_diachigiaohang; // Lấy địa chỉ giao hàng từ request
            $thanh_pho = $request->thanh_pho ?? env('STORE_CITY', 'Hà Nội'); // Lấy thành phố từ request hoặc env
            $trimmedDiachi = mb_strtolower(trim($diachi)); // Loại bỏ khoảng trắng và chuyển sang chữ thường
            $trimmedThanhPho = mb_strtolower(trim($thanh_pho)); // Loại bỏ khoảng trắng và chuyển sang chữ thường
            $len = mb_strlen($trimmedThanhPho); // Lấy độ dài của thành phố
            
            if (mb_substr($trimmedDiachi, -$len) === $trimmedThanhPho) { // Kiểm tra xem địa chỉ có chứa thành phố không
                $diachi_cuoi = $diachi; // Nếu có thì gán địa chỉ cuối cùng bằng địa chỉ
            } else {
                $diachi_cuoi = $diachi . ', ' . $thanh_pho; // Nếu không có thì gán địa chỉ cuối cùng bằng địa chỉ + thành phố
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
                'id_nd'        => Auth::check() ? Auth::user()->id_nd : null,   // LIÊN KẾT ĐƠN HÀNG VỚI HỘI VIÊN: Lưu ID của hội viên đang đăng nhập.
            ]);

            // -----------------------------
            // TẠO CHI TIẾT ĐƠN HÀNG + TRỪ TỒN
            // -----------------------------
            foreach ($cart as $item) {
                $orderDetailName = $item['tensp'];
                if (!empty($item['ten_size'])) {
                    $orderDetailName .= ' (Size: ' . $item['ten_size'] . ')';
                }

                ChitietDonhang::create([
                    'tensp'         => $orderDetailName,
                    'soluong'       => $item['quantity'],
                    'giamgia'       => $item['giamgia'],
                    'giatien'       => $item['giasp'] + ($item['gia_cong_them'] ?? 0),
                    'giakhuyenmai'  => $item['giakhuyenmai'] + ($item['gia_cong_them'] ?? 0),
                    'id_sanpham'    => $item['id_sanpham'],
                    'id_dathang'    => $order->id_dathang,
                    'id_nd'         => Auth::check() ? Auth::user()->id_nd : null,// Trừ số lượng tồn kho của sản phẩm / size tương ứng trong DB
                ]);

                // Trừ tồn khotrong bảng trung gian sanpham_size
                $sp = Sanpham::with('sizes')->find($item['id_sanpham']);
                if ($sp) {
                    if ($sp->co_size == 1 && !empty($item['id_size'])) {
                        $sizePivot = $sp->sizes()->where('sanpham_size.id_size', $item['id_size'])->first();
                        if ($sizePivot) {
                            $newSizeQty = max(0, $sizePivot->pivot->soluong - $item['quantity']);
                            $sp->sizes()->updateExistingPivot($item['id_size'], ['soluong' => $newSizeQty]);
                        }
                        // Tính lại tổng số lượng của sản phẩm
                        $sp->soluong = $sp->sizes()->sum('sanpham_size.soluong');
                        $sp->save();
                    } else {
                        $sp->soluong -= $item['quantity'];
                        $sp->save();
                    }
                }
            }

            DB::commit();// Xác nhận mọi thay đổi CSDL thành công   
        } catch (\Exception $e) {
            DB::rollBack();// Hủy toàn bộ giao dịch nếu có lỗi
            \Illuminate\Support\Facades\Log::error('Lỗi đặt hàng (Transaction rollback): ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi đặt hàng. Vui lòng thử lại!');
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
 // 5. LÀM TRỐNG GIỎ HÀNG:
        if (session()->has('buy_now')) {
            session()->forget('buy_now');
        } else {
            if (session()->has('checkout_items')) {
                CartHelper::clearCompletedCheckout();
            } else {
                CartHelper::clearCart(); // Xóa sạch giỏ hàng trong Session
            }
        }

        return view('pages.thongbaodathang', compact('order')); // Hiển thị trang cảm ơn kèm mã đơn
    }

    public function thongbaodathang(Request $request)
    { // Kiểm tra xem VNPay có gửi đầy đủ mã kết quả và mã đơn hàng về không
        if ($request->has('vnp_ResponseCode') && $request->has('vnp_TxnRef')) {
            $vnp_SecureHash = $request->input('vnp_SecureHash');  // Chữ ký số do VNPay gửi về
            
            // 1. Trích xuất toàn bộ tham số vnp_ ngoại trừ vnp_SecureHash và vnp_SecureHashType
            $inputData = [];
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    if ($key !== 'vnp_SecureHash' && $key !== 'vnp_SecureHashType') {
                        $inputData[$key] = $value;
                    }
                }
            }

            // 2. Sắp xếp tham số theo bảng chữ cái alphabet
            ksort($inputData);
            
            // 3. Xây dựng chuỗi dữ liệu băm
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            // 4. Tính toán mã HMAC-SHA512 sử dụng Hash Secret bí mật từ cấu hình máy chủ
            $vnp_HashSecret = config('services.vnpay.hash_secret');
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // 5. So sánh đối chiếu chữ ký số để ngăn chặn giả mạo trạng thái giao dịch
            if ($secureHash !== $vnp_SecureHash) {
                \Illuminate\Support\Facades\Log::warning('Cảnh báo bảo mật: Phát hiện chữ ký VNPay không khớp cho đơn hàng #' . $request->input('vnp_TxnRef'));
                return redirect('/donhang')->with('error', 'Chữ ký thanh toán VNPay không hợp lệ (Checksum mismatch).');
            }

            $responseCode = $request->input('vnp_ResponseCode');
            $orderId      = $request->input('vnp_TxnRef');

            $order = Dathang::find($orderId);

            if ($order) {
                if ($responseCode == '00') { // Nếu mã kết quả là '00' (VNPay quy định '00' là giao dịch thành công)
                    // Cập nhật trạng thái thành Đã thanh toán khi giao dịch thành công
                    $order->trangthai = 'Đã thanh toán';
                    $order->save();

                    return view('pages.thongbaodathang', compact('order'));
                } else {
                    // Cập nhật trạng thái thành Thất bại khi giao dịch thất bại
                    $order->trangthai = 'Thất bại';
                    $order->save();

                    return redirect('/donhang')->with('error', 'Thanh toán qua cổng VNPay không thành công.');
                }
            }
        }

        return redirect('/donhang');
    }

    public function vnpay(Request $request)
    { // Lấy thông tin giỏ hàng "Mua ngay" hoặc giỏ hàng mặc định từ session
        $buyNow = session('buy_now');
        $cart = !empty($buyNow) ? $buyNow : (session('checkout_items') ?: session('cart', []));
        // Ngăn chặn nếu giỏ hàng trống
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
                ($km->ngay_ket_thuc && $today > $km->ngay_ket_thuc)
            ) {
                return back()->with('error', 'Mã khuyến mãi đã hết hạn!');
            }

            // Bảo vệ số lượt dùng
            if ($km->gioi_han_luot !== null && $km->so_luot_da_dung >= $km->gioi_han_luot) {
                return back()->with('error', 'Mã khuyến mãi đã hết lượt sử dụng!');
            }

        }

        // -----------------------------
        // KIỂM TRA TỒN KHO CHUẨN
        // -----------------------------
        foreach ($cart as $item) {
            $sanpham = Sanpham::with('sizes')->find($item['id_sanpham']);

            if (!$sanpham) {
                return back()->with('error', 'Sản phẩm không tồn tại!');
            }

            if ($sanpham->co_size == 1 && !empty($item['id_size'])) {
                $sizePivot = $sanpham->sizes()->where('sanpham_size.id_size', $item['id_size'])->first();
                if (!$sizePivot || $item['quantity'] > $sizePivot->pivot->soluong) {
                    $sizeName = $sizePivot ? $sizePivot->ten_size : 'Không xác định';
                    return back()->with('error', "Sản phẩm {$sanpham->tensp} (Size {$sizeName}) không đủ tồn kho! Chỉ còn " . ($sizePivot ? $sizePivot->pivot->soluong : 0) . " sản phẩm.");
                }
            } else {
                if ($item['quantity'] > $sanpham->soluong) {
                    return back()->with('error', "Sản phẩm {$sanpham->tensp} không đủ tồn kho! Chỉ còn {$sanpham->soluong} sản phẩm.");
                }
            }
        }

        // ----------------------------------------------------
        // TẠO ĐƠN HÀNG & GHI CSDL (BỌC DATABASE TRANSACTION)
        // ----------------------------------------------------
        DB::beginTransaction();
        try {
            // Cập nhật lượt dùng mã KM nếu có
            if ($id_km) {
                $km->increment('so_luot_da_dung');
            }
            
        // Tạo đơn hàng tạm thời trong bảng dathang (trạng thái: Chờ xác nhận)
            $order = Dathang::create([
                'tongtien'     => $tongtien,
                'tiengiam'     => $tiengiam,
                'tienphaitra'  => $tienphaitra,
                'id_khuyenmai' => $id_km,
                'phuongthucthanhtoan' => 'VNPAY',
                'diachigiaohang' => $request->display_diachigiaohang,
                'hoten'        => $request->display_hoten,
                'email'        => $request->display_email,
                'sdt'          => $request->display_sdt,
                'ngaygiaohang' => now()->addDays(4),
                'id_nd'        => Auth::check() ? Auth::user()->id_nd : null,
                'trangthai'    => 'Chờ xác nhận',
            ]);

            // -----------------------------
            // Tạo chi tiết đơn hàng và thực hiện trừ kho tạm thời để giữ hàng cho khách
            // -----------------------------
            foreach ($cart as $item) {
                $orderDetailName = $item['tensp'];
                if (!empty($item['ten_size'])) {
                    $orderDetailName .= ' (Size: ' . $item['ten_size'] . ')';
                }

                ChitietDonhang::create([
                    'tensp'         => $orderDetailName,
                    'soluong'       => $item['quantity'],
                    'giamgia'       => $item['giamgia'],
                    'giatien'       => $item['giasp'] + ($item['gia_cong_them'] ?? 0),
                    'giakhuyenmai'  => $item['giakhuyenmai'] + ($item['gia_cong_them'] ?? 0),
                    'id_sanpham'    => $item['id_sanpham'],
                    'id_dathang'    => $order->id_dathang,
                    'id_nd'         => Auth::check() ? Auth::user()->id_nd : null,
                ]);

                //  Trừ số lượng tồn kho của sản phẩm/size tương ứng
                $sp = Sanpham::with('sizes')->find($item['id_sanpham']);
                if ($sp) {
                    if ($sp->co_size == 1 && !empty($item['id_size'])) {
                        $sizePivot = $sp->sizes()->where('sanpham_size.id_size', $item['id_size'])->first();
                        if ($sizePivot) {
                            $newSizeQty = max(0, $sizePivot->pivot->soluong - $item['quantity']);
                            $sp->sizes()->updateExistingPivot($item['id_size'], ['soluong' => $newSizeQty]);
                        }
                        // Tính lại tổng số lượng của sản phẩm
                        $sp->soluong = $sp->sizes()->sum('sanpham_size.soluong');
                        $sp->save();
                    } else {
                        $sp->soluong -= $item['quantity'];
                        $sp->save();
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Lỗi thanh toán VNPay (Transaction rollback): ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi chuẩn bị thanh toán VNPay. Vui lòng thử lại!');
        }

        // Xóa giỏ hàng khỏi session
        if (session()->has('buy_now')) {
            session()->forget('buy_now');
        } else {
            if (session()->has('checkout_items')) {
                CartHelper::clearCompletedCheckout();
            } else {
                CartHelper::clearCart();
            }
        }

        // -----------------------------
        // CẤU HÌNH VNPAY
        // -----------------------------
        $vnp_TmnCode    = config('services.vnpay.tmn_code');//Lấy mã website từ file cấu hình config/services.php
        $vnp_HashSecret = config('services.vnpay.hash_secret'); // Chuỗi hash secret dùng làm chữ ký số
        $vnp_Url        = config('services.vnpay.url');// Endpoint cổng VNPay
        $vnp_Returnurl  = url('/thongbaodathang');// Link callback để VNPay trả kết quả về

        $vnp_TxnRef     = $order->id_dathang;// Mã giao dịch của shop gửi đi (sử dụng ID đơn hàng vừa tạo)
        $vnp_Amount     = $order->tienphaitra * 100; // Nhân 100 theo chuẩn VNPAY
        $vnp_OrderInfo  = "Thanh toán đơn hàng: #" . $vnp_TxnRef;
        $vnp_OrderType  = "other";
        $vnp_IpAddr     = request()->ip();// IP thiết bị của khách hàng

        // -------------------------------
        // BUILD DATA GỬI LÊN VNPAY
        // -------------------------------
        $inputData = [
            "vnp_Version"    => "2.1.0",//Tạo mảng dữ liệu gửi theo chuẩn VNPay API 2.1.0
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

        if ($request->bankCode) {
            $inputData['vnp_BankCode'] = $request->bankCode;
        }
// Sắp xếp các key trong mảng $inputData theo thứ tự bảng chữ cái (bắt buộc)
        ksort($inputData);

        $query = "";
        $hashdata = "";
        $i = 0;
// Duyệt qua mảng để tạo chuỗi dữ liệu URL Query
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
// Băm chuỗi dữ liệu trên với HashSecret theo thuật toán HMAC-SHA512 để sinh chữ ký số bảo mật
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
      // Nối chữ ký số vào link redirect
        $vnp_Url = $vnp_Url . "?" . $query . "vnp_SecureHash=" . $vnpSecureHash;
// Chuyển hướng trình duyệt khách sang cổng VNPay
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

        // Kiểm tra yêu cầu đăng nhập
        if ($promo->yeu_cau_dang_nhap == 1 && !Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để sử dụng mã ưu đãi này!',
            ]);
        }

        // Kiểm tra ngày áp dụng
        $today = now();
        if (($promo->ngay_bat_dau && $today < $promo->ngay_bat_dau) ||
            ($promo->ngay_ket_thuc && $today > $promo->ngay_ket_thuc)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi đã hết hạn!',
            ]);
        }

        // Tính tổng tiền giỏ hàng
        $buyNow = session('buy_now');
        $cart = !empty($buyNow) ? $buyNow : (session('checkout_items') ?: session('cart', []));
        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['giakhuyenmai'] + ($item['gia_cong_them'] ?? 0)) * $item['quantity'];
        }

        // Kiểm tra đơn tối thiểu
        if ($promo->don_toi_thieu != null && $total < $promo->don_toi_thieu) {
            return response()->json([
                'success' => false,
                'message' => 'Giá trị đơn hàng chưa đủ để áp dụng mã khuyến mãi (tối thiểu ' . number_format($promo->don_toi_thieu, 0, ',', '.') . 'đ)!',
            ]);
        }

        // Kiểm tra giới hạn lượt
        if ($promo->gioi_han_luot != null && $promo->so_luot_da_dung >= $promo->gioi_han_luot) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi đã hết lượt sử dụng!',
            ]);
        }

        // Kiểm tra điều kiện mã Freeship
        if ($promo->kieu_giam === 'freeship') {
            if ($promo->don_toi_thieu != null && $total < $promo->don_toi_thieu) {
                return response()->json([
                    'success' => false,
                    'message' => "Đơn hàng phải từ " . number_format($promo->don_toi_thieu, 0, ',', '.') . "đ trở lên mới được miễn phí vận chuyển!",
                ]);
            }
        }

        // Tính toán giảm giá và phí ship
        $phi_ship = $this->calculateShippingFee($request->thanh_pho);
        $isFreeship = ($promo->kieu_giam === 'freeship');

       if ($isFreeship) {
    $discount = $phi_ship;
    if ($promo->giam_toi_da && $discount > $promo->giam_toi_da) {
        $discount = $promo->giam_toi_da;
    }
    $newTotal = $total + $phi_ship - $discount;
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

