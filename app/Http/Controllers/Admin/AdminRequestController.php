<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiTap;
use App\Models\NguoiDung;
use App\Models\Thongbao;
use App\Models\YeuCauBaoLuu;
use App\Models\YeuCauDoiPT;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.login');
    }

    // ==========================================
    // QUẢN LÝ YÊU CẦU ĐỔI PT
    // ==========================================

    public function listPTRequests(Request $request)
    {
        $query = YeuCauDoiPT::with(['dangKyGoiTap.packagePrice.goitap', 'khachHang', 'ptCu', 'ptMoi']);

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $requests = $query->orderBy('id', 'desc')->paginate(10);
        $pts = NguoiDung::where('id_phanquyen', 4)
            ->where('trang_thai', 1)
            ->withCount(['ptRegistrations' => function ($query) {
                $query->where('trang_thai', 'dang_tap');
            }])
            ->get(); // Danh sách PT đang hoạt động và số lượng học viên đang dạy

        return view('admin.pt_change.index', compact('requests', 'pts'));
    }

    public function acceptPTRequest(Request $request, $id)
    {
        $request->validate([
            'id_pt_moi' => 'required|exists:nguoidung,id_nd'
        ], [
            'id_pt_moi.required' => 'Vui lòng chọn Huấn luyện viên mới.',
            'id_pt_moi.exists' => 'Huấn luyện viên được chọn không hợp lệ.'
        ]);

        $yeuCau = YeuCauDoiPT::findOrFail($id);

        if (!in_array($yeuCau->trang_thai, ['cho_xu_ly'])) {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $dangKy = DangKyGoiTap::findOrFail($yeuCau->id_dangky);
        $ptMoi = NguoiDung::findOrFail($request->id_pt_moi);
        $ptCu = NguoiDung::find($yeuCau->id_pt_cu);

        // ✅ Kịch bản A: Học viên vẫn tập với PT cũ (id_pt không đổi, trang_thai không đổi)
        // Chỉ lưu PT mới vào id_pt_moi_tam để chờ PT mới xác nhận
        $dangKy->update([
            'id_pt_moi_tam' => $ptMoi->id_nd,
            // id_pt và trang_thai giữ nguyên → học viên không gián đoạn
        ]);

        // Cập nhật yêu cầu đổi PT sang trạng thái chờ PT mới xác nhận
        $yeuCau->update([
            'id_pt_moi' => $ptMoi->id_nd,
            'trang_thai' => 'cho_pt_moi_xac_nhan'
        ]);

        // 1. Thông báo cho Khách hàng: yêu cầu đang được xử lý
        Thongbao::create([
            'id_nguoidung' => $yeuCau->id_khachhang,
            'tieu_de' => 'Yêu cầu đổi PT đang được xử lý',
            'noi_dung' => 'Yêu cầu đổi PT của bạn đang được Admin xử lý. Bạn vẫn tiếp tục tập luyện với ' . ($ptCu ? $ptCu->hoten : 'PT hiện tại') . ' trong thời gian này.',
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        // 2. Thông báo cho PT mới: lời mời tiếp nhận đổi PT
        Thongbao::create([
            'id_nguoidung' => $ptMoi->id_nd,
            'tieu_de' => 'Lời mời tiếp nhận học viên đổi PT',
            'noi_dung' => 'Bạn được mời tiếp nhận học viên ' . $yeuCau->khachHang->hoten . ' hiện đang học với PT ' . ($ptCu ? $ptCu->hoten : 'chưa có') . '. Học viên sẽ chuyển sang bạn sau khi bạn xác nhận. Vui lòng vào trang Quản lý Khách Hàng để đồng ý hoặc từ chối.',
            'loai' => 'phan_pt',
            'link' => '/pt/khach-hang'
        ]);

        return redirect()->back()->with('success', 'Đã gửi lời mời đến PT ' . $ptMoi->hoten . '. Học viên vẫn tiếp tục tập với PT cũ trong lúc chờ xác nhận.');
    }

    public function rejectPTRequest(Request $request, $id)
    {
        $request->validate([
            'ly_do_tu_choi' => 'required|string|max:500'
        ], [
            'ly_do_tu_choi.required' => 'Vui lòng nhập lý do từ chối yêu cầu.'
        ]);

        $yeuCau = YeuCauDoiPT::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_xu_ly') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        // Cập nhật yêu cầu
        $yeuCau->update([
            'trang_thai' => 'tu_choi',
            'ly_do_tu_choi' => $request->ly_do_tu_choi
        ]);

        // Thông báo cho khách hàng
        Thongbao::create([
            'id_nguoidung' => $yeuCau->id_khachhang,
            'tieu_de' => 'Yêu cầu đổi PT bị từ chối',
            'noi_dung' => 'Yêu cầu đổi PT của bạn đã bị từ chối. Lý do: ' . $request->ly_do_tu_choi,
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        return redirect()->back()->with('success', 'Từ chối yêu cầu đổi Huấn luyện viên thành công!');
    }

    // ==========================================
    // QUẢN LÝ YÊU CẦU BẢO LƯU GÓI TẬP
    // ==========================================

    public function listBaoLuuRequests(Request $request)
    {
        $today = Carbon::today();

        // 1. Tự động chuyển các gói tập sang 'bao_luu' nếu đã đến ngày bắt đầu bảo lưu
        $pendingStarts = YeuCauBaoLuu::where('trang_thai', 'da_duyet')
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

        // 2. Tự động kích hoạt lại các gói tập đã hết hạn bảo lưu
        $expiredBaoLuus = YeuCauBaoLuu::where('trang_thai', 'da_duyet')
            ->get();
        
        foreach ($expiredBaoLuus as $bl) {
            $ngayKetThucBaoLuu = Carbon::parse($bl->ngay_bat_dau_baoluu)->addDays($bl->so_ngay_baoluu);
            if ($today->greaterThanOrEqualTo($ngayKetThucBaoLuu)) {
                $dangKy = DangKyGoiTap::find($bl->id_dangky);
                if ($dangKy && $dangKy->trang_thai === 'bao_luu') {
                    $daysLeft = $bl->so_ngay_con_lai_truoc_baoluu;
                    $reactivationDate = Carbon::parse($bl->ngay_bat_dau_baoluu)->addDays($bl->so_ngay_baoluu);
                    
                    $dangKy->update([
                        'trang_thai' => 'dang_tap',
                        'ngay_bat_dau' => $reactivationDate,
                        'ngay_ket_thuc' => $reactivationDate->copy()->addDays($daysLeft)
                    ]);
                    
                    $bl->update([
                        'trang_thai' => 'da_kich_hoat_lai'
                    ]);

                    // Gửi thông báo cho khách hàng
                    Thongbao::create([
                        'id_nguoidung' => $bl->id_khachhang,
                        'tieu_de' => 'Gói tập tự động kích hoạt lại',
                        'noi_dung' => 'Thời gian bảo lưu gói tập ' . $dangKy->packagePrice->goitap->ten_goi . ' của bạn đã kết thúc. Gói tập đã được tự động kích hoạt lại.',
                        'loai' => 'kich_hoat',
                        'link' => '/goi-tap/lich-su'
                    ]);
                }
            }
        }

        $query = YeuCauBaoLuu::with(['dangKyGoiTap.packagePrice.goitap', 'khachHang']);

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $requests = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.baoluu.index', compact('requests'));
    }

    public function approveBaoLuu(Request $request, $id)
    {
        $yeuCau = YeuCauBaoLuu::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_duyet') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $dangKy = DangKyGoiTap::findOrFail($yeuCau->id_dangky);

        if ($dangKy->trang_thai !== 'dang_tap') {
            return back()->with('error', 'Gói tập này hiện không ở trạng thái Đang tập nên không thể bảo lưu.');
        }

        $today = Carbon::today();
        $ngayBatDauBL = Carbon::parse($yeuCau->ngay_bat_dau_baoluu);

        if ($ngayBatDauBL->lessThanOrEqualTo($today)) {
            // Nếu ngày bắt đầu bảo lưu là hôm nay hoặc trong quá khứ -> Kích hoạt bảo lưu ngay lập tức
            $ngayKetThuc = Carbon::parse($dangKy->ngay_ket_thuc);
            $soNgayConLai = $today->diffInDays($ngayKetThuc, false);

            $dangKy->update([
                'trang_thai' => 'bao_luu'
            ]);

            $yeuCau->update([
                'trang_thai' => 'da_duyet',
                'ngay_bat_dau_baoluu' => $today,
                'so_ngay_con_lai_truoc_baoluu' => $soNgayConLai
            ]);
        } else {
            // Nếu ngày bắt đầu bảo lưu ở tương lai -> Chỉ duyệt yêu cầu, giữ trạng thái gói là 'dang_tap'
            // Gói tập sẽ tự động chuyển sang 'bao_luu' khi đến ngày ngay_bat_dau_baoluu
            $yeuCau->update([
                'trang_thai' => 'da_duyet'
            ]);
        }

        // Thông báo cho khách hàng
        Thongbao::create([
            'id_nguoidung' => $yeuCau->id_khachhang,
            'tieu_de' => 'Yêu cầu bảo lưu được phê duyệt',
            'noi_dung' => 'Yêu cầu bảo lưu gói tập ' . $dangKy->packagePrice->goitap->ten_goi . ' của bạn đã được phê duyệt. Số ngày được bảo lưu: ' . $yeuCau->so_ngay_baoluu . ' ngày.',
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        return redirect()->back()->with('success', 'Phê duyệt yêu cầu bảo lưu thành công!');
    }

    public function rejectBaoLuu(Request $request, $id)
    {
        $request->validate([
            'ly_do_tu_choi' => 'required|string|max:500'
        ], [
            'ly_do_tu_choi.required' => 'Vui lòng nhập lý do từ chối bảo lưu.'
        ]);

        $yeuCau = YeuCauBaoLuu::findOrFail($id);

        if ($yeuCau->trang_thai !== 'cho_duyet') {
            return back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        // Cập nhật trạng thái yêu cầu
        $yeuCau->update([
            'trang_thai' => 'tu_choi',
            'ly_do_tu_choi' => $request->ly_do_tu_choi
        ]);

        // Thông báo cho khách hàng
        Thongbao::create([
            'id_nguoidung' => $yeuCau->id_khachhang,
            'tieu_de' => 'Yêu cầu bảo lưu bị từ chối',
            'noi_dung' => 'Yêu cầu bảo lưu gói tập của bạn đã bị từ chối. Lý do: ' . $request->ly_do_tu_choi,
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        return redirect()->back()->with('success', 'Từ chối yêu cầu bảo lưu thành công!');
    }

    public function resumeBaoLuu(Request $request, $id)
    {
        $yeuCau = YeuCauBaoLuu::findOrFail($id);

        if ($yeuCau->trang_thai !== 'da_duyet') {
            return back()->with('error', 'Yêu cầu bảo lưu này chưa được duyệt hoặc đã kích hoạt lại.');
        }

        $dangKy = DangKyGoiTap::findOrFail($yeuCau->id_dangky);

        if ($dangKy->trang_thai !== 'bao_luu') {
            return back()->with('error', 'Gói tập này không ở trạng thái bảo lưu.');
        }

        $now = now()->startOfDay();
        $daysLeft = $yeuCau->so_ngay_con_lai_truoc_baoluu;

        // Kích hoạt lại gói tập
        $dangKy->update([
            'trang_thai' => 'dang_tap',
            'ngay_bat_dau' => $now,
            'ngay_ket_thuc' => $now->copy()->addDays($daysLeft)
        ]);

        // Cập nhật trạng thái yêu cầu
        $yeuCau->update([
            'trang_thai' => 'da_kich_hoat_lai'
        ]);

        // Thông báo cho khách hàng
        Thongbao::create([
            'id_nguoidung' => $yeuCau->id_khachhang,
            'tieu_de' => 'Gói tập được kích hoạt lại tại quầy',
            'noi_dung' => 'Gói tập ' . $dangKy->packagePrice->goitap->ten_goi . ' đã được kích hoạt lại tại quầy. Hạn sử dụng mới đến ngày: ' . $now->copy()->addDays($daysLeft)->format('d/m/Y') . '.',
            'loai' => 'kich_hoat',
            'link' => '/goi-tap/lich-su'
        ]);

        return redirect()->back()->with('success', 'Đã kích hoạt lại gói tập cho khách hàng thành công!');
    }
}
