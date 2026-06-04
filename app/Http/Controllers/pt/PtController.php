<?php

namespace App\Http\Controllers\pt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\DangKyGoiTap;
use App\Models\ChiSoSucKhoe;
use App\Models\Thongbao;
use App\Models\NguoiDung;
use App\Models\YeuCauDoiPT;
use App\Mail\KichHoatGoiTapMail;
use Carbon\Carbon;

class PtController extends Controller
{
    public function dashboard()
    {
        $pt = Auth::user();
        
        // Số khách hàng đang quản lý (những đăng ký đang tập và thuộc về PT này)
        $soKhachHang = DangKyGoiTap::where('id_pt', $pt->id_nd)
                                   ->where('trang_thai', 'dang_tap')
                                   ->count();

        // Lấy thông báo mới (chưa đọc)
        $thongbaos = Thongbao::where('id_nguoidung', $pt->id_nd)
                             ->where('da_doc', 0)
                             ->orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();

        return view('pt.dashboard', compact('soKhachHang', 'thongbaos'));
    }

    public function khachHang()
    {
        $pt = Auth::user();
        
        $dangKys = DangKyGoiTap::with(['user', 'packagePrice.goitap'])
                               ->where('id_pt', $pt->id_nd)
                               ->whereIn('trang_thai', ['dang_tap', 'cho_pt_xac_nhan'])
                               ->orderBy('trang_thai')
                               ->orderBy('created_at', 'desc')
                               ->get();

        // Lời mời đổi PT: các gói tập mà PT này được mời tiếp nhận (id_pt_moi_tam)
        $dangKysDoiPt = DangKyGoiTap::with(['user', 'packagePrice.goitap', 'pt'])
                               ->where('id_pt_moi_tam', $pt->id_nd)
                               ->where('trang_thai', 'dang_tap')
                               ->orderBy('updated_at', 'desc')
                               ->get();

        return view('pt.khachhang', compact('dangKys', 'dangKysDoiPt'));
    }

    public function chiSoIndex($dangky_id)
    {
        $pt = Auth::user();
        $dangKy = DangKyGoiTap::with(['user', 'packagePrice.goitap'])
                              ->where('id', $dangky_id)
                              ->where('id_pt', $pt->id_nd)
                              ->firstOrFail();

        $chiSos = ChiSoSucKhoe::where('id_dangky_goitap', $dangky_id)
                              ->orderBy('ngay_ghi_nhan', 'desc')
                              ->get();

        return view('pt.chiso_index', compact('dangKy', 'chiSos'));
    }

    public function chiSoCreate($dangky_id)
    {
        $pt = Auth::user();
        $dangKy = DangKyGoiTap::with(['user'])
                              ->where('id', $dangky_id)
                              ->where('id_pt', $pt->id_nd)
                              ->firstOrFail();

        return view('pt.chiso_create', compact('dangKy'));
    }

    public function chiSoStore(Request $request, $dangky_id)
    {
        $pt = Auth::user();
        $dangKy = DangKyGoiTap::where('id', $dangky_id)
                              ->where('id_pt', $pt->id_nd)
                              ->firstOrFail();

        $request->validate([
            'ngay_ghi_nhan' => 'required|date|before_or_equal:today',
            'chieu_cao' => 'required|numeric|min:50|max:300',
            'can_nang' => 'required|numeric|min:20|max:300',
            'luong_mo' => 'nullable|numeric|min:0|max:100',
            'luong_nuoc' => 'nullable|numeric|min:0|max:100',
            'thoi_quen_song' => 'nullable|string',
            'nhac_nho' => 'nullable|string'
        ], [
            'ngay_ghi_nhan.before_or_equal' => 'Ngày ghi nhận không được vượt quá ngày hiện tại.'
        ]);

        // Tính BMI = Cân nặng (kg) / (Chiều cao (m) * Chiều cao (m))
        $heightInMeters = $request->chieu_cao / 100;
        $bmi = $request->can_nang / ($heightInMeters * $heightInMeters);

        ChiSoSucKhoe::create([
            'id_dangky_goitap' => $dangKy->id,
            'id_pt' => $pt->id_nd,
            'id_khach_hang' => $dangKy->id_nguoidung,
            'ngay_ghi_nhan' => $request->ngay_ghi_nhan,
            'chieu_cao' => $request->chieu_cao,
            'can_nang' => $request->can_nang,
            'luong_mo' => $request->luong_mo,
            'luong_nuoc' => $request->luong_nuoc,
            'chi_so_bmi' => round($bmi, 1),
            'thoi_quen_song' => $request->thoi_quen_song,
            'nhac_nho' => $request->nhac_nho
        ]);

        // Tạo thông báo cho khách hàng
        Thongbao::create([
            'id_nguoidung' => $dangKy->id_nguoidung,
            'tieu_de' => 'Chỉ số sức khỏe mới',
            'noi_dung' => 'PT ' . $pt->hoten . ' vừa cập nhật chỉ số sức khỏe của bạn.',
            'loai' => 'chi_so',
            'link' => '/chi-so-suc-khoe'
        ]);

        return redirect()->route('pt.chiso.index', $dangky_id)->with('success', 'Đã lưu chỉ số sức khỏe thành công.');
    }

    public function thongBao()
    {
        $pt = Auth::user();
        $thongbaos = Thongbao::where('id_nguoidung', $pt->id_nd)
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);
                             
        // Đánh dấu tất cả là đã đọc khi vào trang này
        Thongbao::where('id_nguoidung', $pt->id_nd)->where('da_doc', 0)->update(['da_doc' => 1]);

        return view('pt.thongbao', compact('thongbaos'));
    }

    public function docThongBao($id)
    {
        $thongbao = Thongbao::where('id_nguoidung', Auth::user()->id_nd)->findOrFail($id);
        $thongbao->update(['da_doc' => 1]);
        
        return response()->json(['success' => true]);
    }

    public function acceptAssignment($id)
    {
        $pt = Auth::user();
        $dangKy = DangKyGoiTap::with(['packagePrice', 'user'])
            ->where('id', $id)
            ->where('id_pt', $pt->id_nd)
            ->where('trang_thai', 'cho_pt_xac_nhan')
            ->firstOrFail();

        $now = now();
        $soThang = $dangKy->packagePrice->so_thang;

        $updateData = [
            'trang_thai' => 'dang_tap',
            'rejected_pts' => null
        ];

        if (!$dangKy->ngay_bat_dau) {
            $updateData['ngay_bat_dau'] = $now;
            $updateData['ngay_ket_thuc'] = $now->copy()->addDays($soThang * 30);
        }

        $dangKy->update($updateData);

        // Thông báo cho khách hàng
        Thongbao::create([
            'id_nguoidung' => $dangKy->id_nguoidung,
            'tieu_de' => 'Gói tập đã được kích hoạt',
            'noi_dung' => 'Huấn luyện viên ' . $pt->hoten . ' đã đồng ý nhận lớp và kích hoạt gói tập ' . $dangKy->packagePrice->goitap->ten_goi . ' của bạn.',
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        // Gửi mail kích hoạt thành công cho khách hàng
        try {
            Mail::to($dangKy->user->email)->send(new KichHoatGoiTapMail($dangKy));
        } catch (\Exception $e) {
            // Vẫn tiếp tục nếu SMTP lỗi
        }

        return redirect()->back()->with('success', 'Nhận lớp và kích hoạt gói tập thành công!');
    }

    public function rejectAssignment(Request $request, $id)
    {
        $request->validate([
            'ly_do_tu_choi' => 'required|string|max:500'
        ], [
            'ly_do_tu_choi.required' => 'Vui lòng cung cấp lý do từ chối nhận lớp.'
        ]);

        $pt = Auth::user();
        $dangKy = DangKyGoiTap::with(['packagePrice', 'user'])
            ->where('id', $id)
            ->where('id_pt', $pt->id_nd)
            ->where('trang_thai', 'cho_pt_xac_nhan')
            ->firstOrFail();

        // Lưu danh sách PT đã từ chối để Admin không phân lại PT này
        $rejectedPts = $dangKy->rejected_pts ?? [];
        if (!in_array($pt->id_nd, $rejectedPts)) {
            $rejectedPts[] = $pt->id_nd;
        }

        // Trả gói tập về trạng thái da_thanh_toan, reset id_pt và lưu danh sách PT đã từ chối
        $dangKy->update([
            'trang_thai' => 'da_thanh_toan',
            'id_pt' => null,
            'rejected_pts' => $rejectedPts
        ]);

        // Gửi thông báo cho toàn bộ Admin (id_phanquyen = 1)
        $admins = NguoiDung::where('id_phanquyen', 1)->get();
        foreach ($admins as $admin) {
            Thongbao::create([
                'id_nguoidung' => $admin->id_nd,
                'tieu_de' => 'PT từ chối nhận lớp',
                'noi_dung' => 'PT ' . $pt->hoten . ' đã từ chối phụ trách học viên ' . $dangKy->user->hoten . ' - Gói tập: ' . $dangKy->packagePrice->goitap->ten_goi . '. Lý do: ' . $request->ly_do_tu_choi,
                'loai' => 'phan_pt',
                'link' => '/admin/goitap/dangky?trang_thai=da_thanh_toan'
            ]);
        }

        return redirect()->back()->with('success', 'Đã từ chối nhận lớp và gửi thông báo tới Admin.');
    }

    // ==========================================
    // LUỒNG ĐỔI PT (KỊCH BẢN A)
    // ==========================================

    public function acceptDoiPtAssignment($id)
    {
        $pt = Auth::user();
        $dangKy = DangKyGoiTap::with(['packagePrice.goitap', 'user', 'pt'])
            ->where('id', $id)
            ->where('id_pt_moi_tam', $pt->id_nd)
            ->where('trang_thai', 'dang_tap')
            ->firstOrFail();

        $ptCu = $dangKy->pt; // PT cũ hiện tại

        // Chuyển PT: id_pt = PT mới, xóa holding slot
        $dangKy->update([
            'id_pt' => $pt->id_nd,
            'id_pt_moi_tam' => null,
            'rejected_pts' => null
        ]);

        // Cập nhật yêu cầu đổi PT thành đã duyệt hoàn tất
        $yeuCau = YeuCauDoiPT::where('id_dangky', $dangKy->id)
            ->where('trang_thai', 'cho_pt_moi_xac_nhan')
            ->latest()
            ->first();
        if ($yeuCau) {
            $yeuCau->update(['trang_thai' => 'da_duyet']);
        }

        // 1. Thông báo cho Khách hàng
        Thongbao::create([
            'id_nguoidung' => $dangKy->id_nguoidung,
            'tieu_de' => 'Đổi PT thành công',
            'noi_dung' => 'Yêu cầu đổi PT của bạn đã hoàn tất. PT mới của bạn là ' . $pt->hoten . ' (SĐT: 0' . $pt->sdt . '). Chúc bạn tập luyện hiệu quả!',
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        // 2. Thông báo cho PT cũ
        if ($ptCu) {
            Thongbao::create([
                'id_nguoidung' => $ptCu->id_nd,
                'tieu_de' => 'Học viên đã chuyển sang PT khác',
                'noi_dung' => 'Học viên ' . $dangKy->user->hoten . ' đã được chuyển sang PT ' . $pt->hoten . ' phụ trách.',
                'loai' => 'phan_pt',
                'link' => '/pt/khach-hang'
            ]);
        }

        // 3. Thông báo cho Admin
        $admins = NguoiDung::where('id_phanquyen', 1)->get();
        foreach ($admins as $admin) {
            Thongbao::create([
                'id_nguoidung' => $admin->id_nd,
                'tieu_de' => 'PT đồng ý tiếp nhận đổi PT',
                'noi_dung' => 'PT ' . $pt->hoten . ' đã đồng ý tiếp nhận học viên ' . $dangKy->user->hoten . ' (chuyển từ PT ' . ($ptCu ? $ptCu->hoten : 'N/A') . ').',
                'loai' => 'phan_pt',
                'link' => '/admin/yeucau-doipt'
            ]);
        }

        return redirect()->back()->with('success', 'Đã đồng ý tiếp nhận học viên ' . $dangKy->user->hoten . '!');
    }

    public function rejectDoiPtAssignment(Request $request, $id)
    {
        $request->validate([
            'ly_do_tu_choi' => 'required|string|max:500'
        ], [
            'ly_do_tu_choi.required' => 'Vui lòng cung cấp lý do từ chối.'
        ]);

        $pt = Auth::user();
        $dangKy = DangKyGoiTap::with(['packagePrice.goitap', 'user', 'pt'])
            ->where('id', $id)
            ->where('id_pt_moi_tam', $pt->id_nd)
            ->where('trang_thai', 'dang_tap')
            ->firstOrFail();

        // Lưu PT vào danh sách từ chối
        $rejectedPts = $dangKy->rejected_pts ?? [];
        if (!in_array($pt->id_nd, $rejectedPts)) {
            $rejectedPts[] = $pt->id_nd;
        }

        // Xóa holding slot, giữ id_pt = PT cũ, học viên vẫn tập bình thường
        $dangKy->update([
            'id_pt_moi_tam' => null,
            'rejected_pts' => $rejectedPts
        ]);

        // Reset yêu cầu đổi PT về cho_xu_ly để Admin có thể chọn PT khác
        $yeuCau = YeuCauDoiPT::where('id_dangky', $dangKy->id)
            ->where('trang_thai', 'cho_pt_moi_xac_nhan')
            ->latest()
            ->first();
        if ($yeuCau) {
            $yeuCau->update(['trang_thai' => 'cho_xu_ly']);
        }

        // Kiểm tra còn PT khả dụng không
        $tongPT = NguoiDung::where('id_phanquyen', 4)->where('trang_thai', 1)->count();
        $soPtBiLoai = count($rejectedPts) + 1; // +1 cho PT cũ
        $hetPt = $soPtBiLoai >= $tongPT;

        // Thông báo cho Admin: PT từ chối đổi
        $admins = NguoiDung::where('id_phanquyen', 1)->get();
        foreach ($admins as $admin) {
            Thongbao::create([
                'id_nguoidung' => $admin->id_nd,
                'tieu_de' => 'PT từ chối tiếp nhận đổi PT',
                'noi_dung' => 'PT ' . $pt->hoten . ' đã từ chối tiếp nhận học viên ' . $dangKy->user->hoten . ' (yêu cầu đổi PT). Lý do: ' . $request->ly_do_tu_choi,
                'loai' => 'phan_pt',
                'link' => '/admin/yeucau-doipt?trang_thai=cho_xu_ly'
            ]);

            // Alert đặc biệt nếu hết PT khả dụng
            if ($hetPt) {
                Thongbao::create([
                    'id_nguoidung' => $admin->id_nd,
                    'tieu_de' => '⚠️ Không còn PT khả dụng',
                    'noi_dung' => 'Không còn PT nào có thể tiếp nhận học viên ' . $dangKy->user->hoten . '. Tất cả PT đã từ chối hoặc đang là PT cũ. Vui lòng xử lý thủ công (từ chối yêu cầu hoặc giữ PT cũ).',
                    'loai' => 'phan_pt',
                    'link' => '/admin/yeucau-doipt?trang_thai=cho_xu_ly'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Đã từ chối tiếp nhận và thông báo tới Admin.');
    }
}
