<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\IOrderRepository;
use DB;
use App\Models\Dathang;
use App\Models\Khuyenmai;
use App\Models\ChitietDonhang;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CartHelper;

class OrderViewController extends Controller
{

    private $OrderRepository;

    public function __construct(IOrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
    }

    public function donhang()
    {
        $user = Auth::user();
        if ($user) {
            $orders = $this->OrderRepository->orderView($user->id_nd);
            $comments = \App\Models\Comment::where('user_id', $user->id_nd)
                ->get();
            return view('pages.donhang', [
                'orders' => $orders,
                'comments' => $comments
            ]);
        } else {
            return redirect('/login')->with('needLogin', true);
        }
    }


    public function edit($id)
    {
        $order = Dathang::findOrFail($id);

        $orderdetails = ChitietDonhang::where('id_dathang', $id)->get();

        return view('pages.donhangdetail', [
            'order'        => $order,
            'orderdetails' => $orderdetails,
        ]);
    }
    public function cancel($id)
    {
        $order = Dathang::findOrFail($id);

        // Chỉ cho hủy nếu ở trạng thái Chờ xác nhận
        if ($order->trangthai !== 'Chờ xác nhận') {
            return back()->with('error', 'Không thể hủy đơn hàng này!');
        }

        $order->trangthai = 'Bị hủy';
        $order->save();

        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }


    public function capnhatThongTin(Request $request)
    {
        $request->validate([
            'id_dathang' => 'required|exists:dathang,id_dathang',
            'diachi' => 'required|string|max:100',
            'hoten' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'sdt' => 'required|digits_between:9,11',
        ]);

        DB::table('dathang')
            ->where('id_dathang', $request->id_dathang)
            ->update([
                'diachigiaohang' => $request->diachi,
                'hoten'  => $request->hoten,
                'email'  => $request->email,
                'sdt'    => $request->sdt,
            ]);
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function repurchase($id)
    {
        $order = Dathang::findOrFail($id);

        // Check if the order status is Hoàn thành, Bị hủy, or Thất bại
        $allowedStatuses = ['Hoàn thành', 'Bị hủy', 'Thất bại'];
        if (!in_array($order->trangthai, $allowedStatuses)) {
            return back()->with('error', 'Trạng thái đơn hàng không hợp lệ để mua lại.');
        }

        // Get the list of products in the old order details
        $orderdetails = ChitietDonhang::where('id_dathang', $id)->get();
        if ($orderdetails->isEmpty()) {
            return back()->with('error', 'Đơn hàng này không chứa sản phẩm nào.');
        }

        $cart = session()->get('cart', []);
        $warningMessages = [];

        foreach ($orderdetails as $detail) {
            $product = SanPham::with(['images', 'sizes'])->find($detail->id_sanpham);
            if ($product) {
                $firstImage = $product->images->first();
                $imagePath = $firstImage ? $firstImage->duong_dan : 'frontend/upload/placeholder.jpg';

                // Check if product supports size
                if ($product->co_size == 1) {
                    $sizeName = null;
                    if (preg_match('/ \(Size:\s*([^)]+)\)/ui', $detail->tensp, $matches)) {
                        $sizeName = trim($matches[1]);
                    }

                    if ($sizeName) {
                        // Find matching size in this product's sizes
                        $sizeObj = $product->sizes->first(function ($size) use ($sizeName) {
                            return strcasecmp($size->ten_size, $sizeName) === 0;
                        });

                        if ($sizeObj) {
                            $sizeStock = $sizeObj->pivot->soluong;
                            if ($sizeStock <= 0) {
                                $warningMessages[] = "Sản phẩm \"" . $product->tensp . "\" (Size: " . $sizeObj->ten_size . ") đã hết hàng và không được thêm vào.";
                                continue;
                            }

                            $cartKey = $product->id_sanpham . '_' . $sizeObj->id_size;
                            $currentQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
                            $qty = $detail->soluong + $currentQty;
                            
                            if ($qty > $sizeStock) {
                                $qty = $sizeStock;
                                $warningMessages[] = "Sản phẩm \"" . $product->tensp . "\" (Size: " . $sizeObj->ten_size . ") chỉ còn " . $sizeStock . " sản phẩm trong kho (tổng yêu cầu: " . ($detail->soluong + $currentQty) . ").";
                            }

                            if (isset($cart[$cartKey])) {
                                $cart[$cartKey]['quantity'] = $qty;
                            } else {
                                $cart[$cartKey] = [
                                    "id_sanpham"    => $product->id_sanpham,
                                    "tensp"         => $product->tensp,
                                    "anhsp"         => $imagePath,
                                    "giasp"         => $product->giasp,
                                    "giamgia"       => $product->giamgia,
                                    "giakhuyenmai"  => $product->giakhuyenmai,
                                    "quantity"      => $qty,
                                    "id_size"       => $sizeObj->id_size,
                                    "ten_size"      => $sizeObj->ten_size,
                                    "gia_cong_them" => (int) $sizeObj->pivot->gia_cong_them
                                ];
                            }
                        } else {
                            $warningMessages[] = "Sản phẩm \"" . $product->tensp . "\" (Size: " . $sizeName . ") không còn hỗ trợ kích cỡ này.";
                        }
                    } else {
                        $warningMessages[] = "Sản phẩm \"" . $product->tensp . "\" hiện tại yêu cầu kích cỡ. Vui lòng chọn lại trên trang chi tiết.";
                    }
                } else {
                    // If product is out of stock, warn user
                    if ($product->soluong <= 0) {
                        $warningMessages[] = "Sản phẩm \"" . $product->tensp . "\" đã hết hàng và không được thêm vào.";
                        continue;
                    }

                    $cartKey = $product->id_sanpham;
                    $currentQty = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
                    $qty = $detail->soluong + $currentQty;
                    
                    if ($qty > $product->soluong) {
                        $qty = $product->soluong;
                        $warningMessages[] = "Sản phẩm \"" . $product->tensp . "\" chỉ còn " . $product->soluong . " sản phẩm trong kho (tổng yêu cầu: " . ($detail->soluong + $currentQty) . ").";
                    }

                    if (isset($cart[$cartKey])) {
                        $cart[$cartKey]['quantity'] = $qty;
                    } else {
                        $cart[$cartKey] = [
                            "id_sanpham"   => $product->id_sanpham,
                            "tensp"        => $product->tensp,
                            "anhsp"        => $imagePath,
                            "giasp"        => $product->giasp,
                            "giamgia"      => $product->giamgia,
                            "giakhuyenmai" => $product->giakhuyenmai,
                            "quantity"     => $qty
                        ];
                    }
                }
            } else {
                $warningMessages[] = "Sản phẩm \"" . $detail->tensp . "\" không còn tồn tại trên hệ thống.";
            }
        }

        if (empty($cart)) {
            return back()->with('error', 'Không có sản phẩm nào khả dụng để mua lại.');
        }

        // Clear existing promo session
        session()->forget('promo');

        // Set the session cart to the new cart list
        CartHelper::saveCart($cart);

        if (!empty($warningMessages)) {
            $warningText = implode(' ', $warningMessages);
            return redirect()->route('cart')->with('warning', $warningText);
        }

        return redirect()->route('cart')->with('success', 'Đã thêm các sản phẩm từ đơn hàng cũ vào giỏ hàng thành công.');
    }
}
