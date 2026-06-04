<?php

namespace App\Http\Controllers\pt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DangKyGoiTap;
use App\Models\ChiSoSucKhoe;
use App\Models\Thongbao;
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
                               ->orderBy('trang_thai')
                               ->orderBy('created_at', 'desc')
                               ->get();

        return view('pt.khachhang', compact('dangKys'));
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
            'ngay_ghi_nhan' => 'required|date',
            'chieu_cao' => 'required|numeric|min:50|max:300',
            'can_nang' => 'required|numeric|min:20|max:300',
            'luong_mo' => 'nullable|numeric|min:0|max:100',
            'luong_nuoc' => 'nullable|numeric|min:0|max:100',
            'thoi_quen_song' => 'nullable|string',
            'nhac_nho' => 'nullable|string'
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
}
