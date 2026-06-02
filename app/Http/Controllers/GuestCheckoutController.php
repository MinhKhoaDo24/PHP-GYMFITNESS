<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dathang;

class GuestCheckoutController extends Controller
{
    /**
     * Hiển thị trang tra cứu đơn hàng cho khách vãng lai
     */
    public function showSearchForm()
    {
        return view('pages.tra-cuu-don-hang');
    }

    /**
     * Xử lý tìm kiếm đơn hàng theo mã đơn hàng + số điện thoại
     */
    public function search(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ma_don_hang' => ['required'],
            'sdt'         => ['required', 'regex:/^(0\d{9}|\d{9})$/'],
        ], [
            'ma_don_hang.required' => 'Mã đơn hàng không được để trống.',
            'sdt.required'         => 'Số điện thoại không được để trống.',
            'sdt.regex'            => 'Số điện thoại không hợp lệ.',
        ]);

        // Lọc bỏ tiền tố RF- và các số 0 ở đầu (nếu khách nhập đúng định dạng mã mới)
        $maDonHang = preg_replace('/[^0-9]/', '', $request->input('ma_don_hang'));
        $sdt       = $request->input('sdt');

        // Tìm đơn hàng theo id_dathang + sdt
        $sdtClean = ltrim($sdt, '0');
        $order = Dathang::where('id_dathang', $maDonHang)
            ->where(function($query) use ($sdt, $sdtClean) {
                $query->where('sdt', $sdt)
                      ->orWhere('sdt', $sdtClean)
                      ->orWhere('sdt', '0' . $sdtClean);
            })
            ->first();

        // Nếu không tìm thấy
        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng. Vui lòng kiểm tra lại mã đơn hàng và số điện thoại.');
        }

        // Lưu session xác thực tạm thời để cho phép xem chi tiết
        session()->put('verified_guest_order_id', $order->id_dathang);

        // Chuyển hướng đến trang chi tiết đơn hàng
        return redirect()->route('donhang.guest-detail', $order->id_dathang);
    }

    /**
     * Hiển thị chi tiết đơn hàng của khách vãng lai
     */
    public function showDetail($id)
    {
        // Bảo mật: kiểm tra xem khách đã nhập đúng sđt để tra cứu đơn hàng này chưa
        if (session('verified_guest_order_id') != $id) {
            return redirect('/tra-cuu-don-hang')->with('error', 'Vui lòng nhập mã đơn hàng và số điện thoại để tra cứu.');
        }

        // Lấy đơn hàng
        $order = Dathang::with(['details', 'khuyenmai'])
            ->where('id_dathang', $id)
            ->first();

        if (!$order) {
            return redirect('/tra-cuu-don-hang')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Lấy chi tiết đơn hàng
        $orderdetails = $order->details;

        return view('pages.donhangdetail', compact('order', 'orderdetails'));
    }
}
