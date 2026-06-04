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
        $user = Auth::user();
        $today = today();

        // 1. Tự động chuyển các gói tập sang 'bao_luu' nếu đã đến ngày bắt đầu bảo lưu
        $pendingStarts = \App\Models\YeuCauBaoLuu::where('id_khachhang', $user->id_nd)
            ->where('trang_thai', 'da_duyet')
            ->where('ngay_bat_dau_baoluu', '<=', $today)
            ->get();
        
        foreach ($pendingStarts as $bl) {
            $dangKy = DangKyGoiTap::find($bl->id_dangky);
            if ($dangKy && $dangKy->trang_thai === 'dang_tap') {
                $dangKy->update([
                    'trang_thai' => 'bao_luu'
                ]);
            }
        }

        // 2. Tự động kích hoạt lại các gói tập của user này đã hết hạn bảo lưu
        $expiredBaoLuus = \App\Models\YeuCauBaoLuu::where('id_khachhang', $user->id_nd)
            ->where('trang_thai', 'da_duyet')
            ->get();
        
        foreach ($expiredBaoLuus as $bl) {
            $ngayKetThucBaoLuu = \Carbon\Carbon::parse($bl->ngay_bat_dau_baoluu)->addDays($bl->so_ngay_baoluu);
            if ($today->greaterThanOrEqualTo($ngayKetThucBaoLuu)) {
                $dangKy = DangKyGoiTap::find($bl->id_dangky);
                if ($dangKy && $dangKy->trang_thai === 'bao_luu') {
                    $daysLeft = $bl->so_ngay_con_lai_truoc_baoluu;
                    $reactivationDate = \Carbon\Carbon::parse($bl->ngay_bat_dau_baoluu)->addDays($bl->so_ngay_baoluu);
                    
                    $dangKy->update([
                        'trang_thai' => 'dang_tap',
                        'ngay_bat_dau' => $reactivationDate,
                        'ngay_ket_thuc' => $reactivationDate->copy()->addDays($daysLeft)
                    ]);
                    
                    $bl->update([
                        'trang_thai' => 'da_kich_hoat_lai'
                    ]);

                    // Gửi thông báo cho khách hàng
                    \App\Models\Thongbao::create([
                        'id_nguoidung' => $bl->id_khachhang,
                        'tieu_de' => 'Gói tập tự động kích hoạt lại',
                        'noi_dung' => 'Thời gian bảo lưu gói tập ' . $dangKy->packagePrice->goitap->ten_goi . ' của bạn đã kết thúc. Gói tập đã được tự động kích hoạt lại.',
                        'loai' => 'kich_hoat',
                        'link' => '/goi-tap/lich-su'
                    ]);
                }
            }
        }

        // Đánh dấu tất cả thông báo chưa đọc của người dùng hiện tại là đã đọc
        \App\Models\Thongbao::where('id_nguoidung', $user->id_nd)
            ->where('da_doc', 0)
            ->update(['da_doc' => 1]);

        $danhmucs = Danhmuc::all();
        $registrations = DangKyGoiTap::where('id_nguoidung', $user->id_nd)
            ->with(['packagePrice.goitap', 'pt', 'yeuCauDoiPTs', 'yeuCauBaoLuus'])
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.goitap_history', compact('registrations', 'danhmucs'));
    }

    public function chiSoSucKhoe()
    {
        $danhmucs = Danhmuc::all();
        $user = Auth::user();

        // Đánh dấu tất cả thông báo chưa đọc của người dùng hiện tại là đã đọc
        \App\Models\Thongbao::where('id_nguoidung', $user->id_nd)
            ->where('da_doc', 0)
            ->update(['da_doc' => 1]);

        // Lấy tất cả chỉ số sức khỏe của khách hàng này
        $chiSos = \App\Models\ChiSoSucKhoe::with(['pt', 'dangKyGoiTap.packagePrice.goitap'])
            ->where('id_khach_hang', $user->id_nd)
            ->orderBy('ngay_ghi_nhan', 'desc')
            ->get();

        return view('pages.chiso_suc_khoe', compact('chiSos', 'danhmucs'));
    }

    public function storeRequestPTChange(Request $request, $id)
    {
        $request->validate([
            'ly_do' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string|max:1000'
        ], [
            'ly_do.required' => 'Vui lòng chọn hoặc nhập lý do đổi PT.'
        ]);

        $user = Auth::user();
        $dangKy = DangKyGoiTap::where('id', $id)
            ->where('id_nguoidung', $user->id_nd)
            ->firstOrFail();

        if ($dangKy->trang_thai !== 'dang_tap') {
            return back()->with('error', 'Gói tập này chưa được kích hoạt hoặc đã hết hạn.');
        }

        if ($dangKy->co_pt != 1 || empty($dangKy->id_pt)) {
            return back()->with('error', 'Gói tập này không có Huấn luyện viên phụ trách.');
        }

        // Kiểm tra ràng buộc thời gian: chỉ được đổi trong vòng 7 ngày đầu
        $ngayBatDau = \Carbon\Carbon::parse($dangKy->ngay_bat_dau);
        if ($ngayBatDau->diffInDays(now()) > 7) {
            return back()->with('error', 'Đã quá thời hạn 7 ngày để gửi yêu cầu đổi Huấn luyện viên.');
        }

        // Kiểm tra ràng buộc: mỗi gói chỉ được đổi PT tối đa 1 lần
        $hasApproved = \App\Models\YeuCauDoiPT::where('id_dangky', $id)
            ->where('trang_thai', 'da_duyet')
            ->exists();
        if ($hasApproved) {
            return back()->with('error', 'Mỗi gói tập chỉ được phép đổi Huấn luyện viên tối đa 1 lần.');
        }

        // Kiểm tra xem đã có yêu cầu đổi PT nào đang xử lý chưa
        $existing = \App\Models\YeuCauDoiPT::where('id_dangky', $id)
            ->where('trang_thai', 'cho_xu_ly')
            ->exists();
        if ($existing) {
            return back()->with('error', 'Bạn đã có một yêu cầu đổi Huấn luyện viên đang chờ Admin xử lý.');
        }

        \App\Models\YeuCauDoiPT::create([
            'id_dangky' => $id,
            'id_khachhang' => $user->id_nd,
            'id_pt_cu' => $dangKy->id_pt,
            'ly_do' => $request->ly_do,
            'ghi_chu' => $request->ghi_chu,
            'trang_thai' => 'cho_xu_ly'
        ]);

        return back()->with('success', 'Gửi yêu cầu đổi Huấn luyện viên thành công! Vui lòng chờ Admin phê duyệt.');
    }

    public function storeRequestBaoLuu(Request $request, $id)
    {
        $request->validate([
            'ngay_bat_dau_baoluu' => 'required|date|after_or_equal:today',
            'so_ngay_baoluu' => 'required|integer|between:7,30',
            'ly_do' => 'required|string|max:255'
        ], [
            'ngay_bat_dau_baoluu.required' => 'Vui lòng chọn ngày bắt đầu bảo lưu.',
            'ngay_bat_dau_baoluu.after_or_equal' => 'Ngày bắt đầu bảo lưu phải từ ngày hôm nay trở đi.',
            'so_ngay_baoluu.required' => 'Vui lòng nhập số ngày bảo lưu.',
            'so_ngay_baoluu.between' => 'Thời hạn bảo lưu tối thiểu phải là 7 ngày và tối đa là 30 ngày.',
            'ly_do.required' => 'Vui lòng nhập lý do xin bảo lưu.'
        ]);

        $user = Auth::user();
        $dangKy = DangKyGoiTap::with('packagePrice.goitap')->where('id', $id)
            ->where('id_nguoidung', $user->id_nd)
            ->firstOrFail();

        if ($dangKy->trang_thai !== 'dang_tap') {
            return back()->with('error', 'Gói tập này không ở trạng thái đang hoạt động để bảo lưu.');
        }

        if ($dangKy->co_pt == 1) {
            return back()->with('error', 'Gói tập có Huấn luyện viên kèm theo không hỗ trợ bảo lưu.');
        }

        // RÀNG BUỘC 1: Mỗi gói chỉ được bảo lưu 1 lần
        $hasBaoLuu = \App\Models\YeuCauBaoLuu::where('id_dangky', $id)
            ->whereIn('trang_thai', ['da_duyet', 'da_kich_hoat_lai'])
            ->exists();
        if ($hasBaoLuu) {
            return back()->with('error', 'Gói tập này đã được bảo lưu một lần trước đó. Mỗi gói chỉ được bảo lưu tối đa 1 lần.');
        }

        // RÀNG BUỘC 2: Chỉ áp dụng cho gói 3 tháng (tương ứng so_thang >= 3)
        $soThang = $dangKy->packagePrice->so_thang;
        if ($soThang < 3) {
            return back()->with('error', 'Chính sách bảo lưu chỉ áp dụng cho gói tập có thời hạn từ 3 tháng trở lên.');
        }

        // RÀNG BUỘC 3: Số ngày còn lại phải từ 15 ngày trở lên
        $ngayKetThuc = \Carbon\Carbon::parse($dangKy->ngay_ket_thuc);
        $ngayBatDauBaoLuu = \Carbon\Carbon::parse($request->ngay_bat_dau_baoluu);
        $soNgayConLai = $ngayBatDauBaoLuu->diffInDays($ngayKetThuc, false);
        if ($soNgayConLai < 15) {
            return back()->with('error', 'Số ngày sử dụng còn lại của gói tập tại ngày bảo lưu phải từ 15 ngày trở lên.');
        }

        // Kiểm tra xem đã có yêu cầu bảo lưu nào đang chờ duyệt chưa
        $existing = \App\Models\YeuCauBaoLuu::where('id_dangky', $id)
            ->where('trang_thai', 'cho_duyet')
            ->exists();
        if ($existing) {
            return back()->with('error', 'Bạn đã có một yêu cầu bảo lưu đang chờ Admin phê duyệt.');
        }

        \App\Models\YeuCauBaoLuu::create([
            'id_dangky' => $id,
            'id_khachhang' => $user->id_nd,
            'ngay_bat_dau_baoluu' => $request->ngay_bat_dau_baoluu,
            'so_ngay_baoluu' => $request->so_ngay_baoluu,
            'so_ngay_con_lai_truoc_baoluu' => $soNgayConLai,
            'ly_do' => $request->ly_do,
            'trang_thai' => 'cho_duyet'
        ]);

        return back()->with('success', 'Gửi yêu cầu bảo lưu thành công! Vui lòng chờ Admin phê duyệt.');
    }

    public function resumeGoiTap(Request $request, $id)
    {
        $user = Auth::user();
        $dangKy = DangKyGoiTap::where('id', $id)
            ->where('id_nguoidung', $user->id_nd)
            ->firstOrFail();

        if ($dangKy->trang_thai !== 'bao_luu') {
            return back()->with('error', 'Gói tập này không ở trạng thái bảo lưu để kích hoạt lại.');
        }

        // Lấy yêu cầu bảo lưu được duyệt gần nhất
        $baoluu = \App\Models\YeuCauBaoLuu::where('id_dangky', $id)
            ->where('trang_thai', 'da_duyet')
            ->orderBy('id', 'desc')
            ->first();

        if (!$baoluu) {
            return back()->with('error', 'Không tìm thấy dữ liệu bảo lưu hợp lệ.');
        }

        $now = now()->startOfDay();
        $daysLeft = $baoluu->so_ngay_con_lai_truoc_baoluu;

        // Cập nhật lại ngày bắt đầu, ngày kết thúc và trạng thái gói tập
        $dangKy->update([
            'trang_thai' => 'dang_tap',
            'ngay_bat_dau' => $now,
            'ngay_ket_thuc' => $now->copy()->addDays($daysLeft)
        ]);

        // Cập nhật trạng thái yêu cầu bảo lưu
        $baoluu->update([
            'trang_thai' => 'da_kich_hoat_lai'
        ]);

        return back()->with('success', 'Đã kích hoạt lại gói tập thành công! Chúc bạn tập luyện vui vẻ.');
    }
}
