<?php

namespace App\Http\Controllers;

use App\Models\GoiTap;
use App\Models\GoiTapGia;
use App\Models\DangKyGoiTap;
use App\Models\Danhmuc;
use App\Mail\DangKyGoiTapMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GoiTapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function registerShow($slug)
    {
        $goitap = GoiTap::where('slug', $slug)
            ->where('trang_thai', 1)
            ->with(['prices' => function ($query) {
                $query->where('trang_thai', 1)->orderBy('so_thang', 'asc');
            }])
            ->firstOrFail();

        $danhmucs = Danhmuc::all();

        return view('pages.goitap_register', compact('goitap', 'danhmucs'));
    }

    public function registerStore(Request $request, $slug)
    {
        $request->validate([
            'id_goitap_gia' => 'required|exists:goitap_gia,id',
            'co_pt' => 'nullable|in:0,1',
            'ghi_chu' => 'nullable|string|max:500'
        ]);

        $goitap = GoiTap::where('slug', $slug)->where('trang_thai', 1)->firstOrFail();
        
        $priceOption = GoiTapGia::where('id', $request->id_goitap_gia)
            ->where('id_goitap', $goitap->id_goitap)
            ->where('trang_thai', 1)
            ->firstOrFail();

        $coPT = $request->input('co_pt', 0);
        
        // Tính tiền: giá gói + (giá PT * số tháng) nếu chọn PT
        $basePrice = $priceOption->gia_khuyen_mai ?? $priceOption->gia_goc;
        $ptPrice = $coPT ? ($goitap->gia_pt_them * $priceOption->so_thang) : 0;
        $totalPrice = $basePrice + $ptPrice;

        // Tạo mã đăng ký độc nhất dạng RF-XXXXX
        do {
            $maDangKy = 'RF-' . strtoupper(Str::random(6));
        } while (DangKyGoiTap::where('ma_dang_ky', $maDangKy)->exists());

        $dangKy = DangKyGoiTap::create([
            'ma_dang_ky' => $maDangKy,
            'id_nguoidung' => Auth::user()->id_nd,
            'id_goitap_gia' => $priceOption->id,
            'co_pt' => $coPT,
            'id_pt' => null,
            'tong_tien' => $totalPrice,
            'trang_thai' => 'cho_thanh_toan',
            'ngay_bat_dau' => null,
            'ngay_ket_thuc' => null,
            'ghi_chu' => $request->ghi_chu
        ]);

        // Gửi email cho khách hàng
        try {
            Mail::to(Auth::user()->email)->send(new DangKyGoiTapMail($dangKy));
        } catch (\Exception $e) {
            // Vẫn tiếp tục nếu lỗi cấu hình SMTP
        }

        return redirect()->route('goitap.history')->with('success', 'Đăng ký gói tập thành công! Vui lòng kiểm tra email hướng dẫn thanh toán.');
    }

    public function history()
    {
        $danhmucs = Danhmuc::all();
        $registrations = DangKyGoiTap::where('id_nguoidung', Auth::user()->id_nd)
            ->with(['packagePrice.goitap', 'pt'])
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.goitap_history', compact('registrations', 'danhmucs'));
    }

    public function chiSoSucKhoe()
    {
        $danhmucs = Danhmuc::all();
        $user = Auth::user();

        // Lấy tất cả chỉ số sức khỏe của khách hàng này
        $chiSos = \App\Models\ChiSoSucKhoe::with(['pt', 'dangKyGoiTap.packagePrice.goitap'])
            ->where('id_khach_hang', $user->id_nd)
            ->orderBy('ngay_ghi_nhan', 'desc')
            ->get();

        return view('pages.chiso_suc_khoe', compact('chiSos', 'danhmucs'));
    }
}
