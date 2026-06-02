<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\GoiTap;
use App\Models\GoiTapGia;
use App\Models\DangKyGoiTap;
use App\Models\NguoiDung;
use App\Mail\KichHoatGoiTapMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminGoiTapController extends Controller
{
    public function index()
    {
        $goitaps = GoiTap::with('prices')->get();
        return view('admin.goitap.index', compact('goitaps'));
    }

    public function create()
    {
        return view('admin.goitap.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_goi' => 'required|string|max:100',
            'mo_ta_ngan' => 'required|string|max:255',
            'mo_ta_chi_tiet' => 'required|string',
            'loai_goi' => 'required|in:silver,gold,diamond',
            'gia_pt_them' => 'required|numeric|min:0',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price_1' => 'required|numeric|min:0',
            'price_3' => 'required|numeric|min:0',
            'price_6' => 'required|numeric|min:0',
            'price_12' => 'required|numeric|min:0',
        ]);

        $hinhAnhPath = 'frontend/img/basic-silver-1.jpg'; // default
        if ($request->hasFile('hinh_anh')) {
            $image = $request->file('hinh_anh');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('frontend/img'), $name);
            $hinhAnhPath = 'frontend/img/' . $name;
        }

        $goitap = GoiTap::create([
            'ten_goi' => $request->ten_goi,
            'slug' => Str::slug($request->ten_goi),
            'mo_ta_ngan' => $request->mo_ta_ngan,
            'mo_ta_chi_tiet' => $request->mo_ta_chi_tiet,
            'hinh_anh' => $hinhAnhPath,
            'loai_goi' => $request->loai_goi,
            'gia_pt_them' => $request->gia_pt_them,
            'is_best' => $request->has('is_best') ? 1 : 0,
            'trang_thai' => 1
        ]);

        // Tạo giá cho 1, 3, 6, 12 tháng
        $months = [1, 3, 6, 12];
        foreach ($months as $m) {
            GoiTapGia::create([
                'id_goitap' => $goitap->id_goitap,
                'so_thang' => $m,
                'gia_goc' => $request->input('price_' . $m),
                'gia_khuyen_mai' => null,
                'trang_thai' => 1
            ]);
        }

        return redirect()->route('admin.goitap.index')->with('success', 'Thêm gói tập mới thành công!');
    }

    public function edit($id)
    {
        $goitap = GoiTap::with('prices')->findOrFail($id);
        
        // Nhóm giá theo số tháng để hiển thị trên form dễ dàng
        $prices = [];
        foreach ($goitap->prices as $p) {
            $prices[$p->so_thang] = $p->gia_goc;
        }

        return view('admin.goitap.edit', compact('goitap', 'prices'));
    }

    public function update(Request $request, $id)
    {
        $goitap = GoiTap::findOrFail($id);

        $request->validate([
            'ten_goi' => 'required|string|max:100',
            'mo_ta_ngan' => 'required|string|max:255',
            'mo_ta_chi_tiet' => 'required|string',
            'loai_goi' => 'required|in:silver,gold,diamond',
            'gia_pt_them' => 'required|numeric|min:0',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price_1' => 'required|numeric|min:0',
            'price_3' => 'required|numeric|min:0',
            'price_6' => 'required|numeric|min:0',
            'price_12' => 'required|numeric|min:0',
        ]);

        $hinhAnhPath = $goitap->hinh_anh;
        if ($request->hasFile('hinh_anh')) {
            $image = $request->file('hinh_anh');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('frontend/img'), $name);
            $hinhAnhPath = 'frontend/img/' . $name;
        }

        $goitap->update([
            'ten_goi' => $request->ten_goi,
            'slug' => Str::slug($request->ten_goi),
            'mo_ta_ngan' => $request->mo_ta_ngan,
            'mo_ta_chi_tiet' => $request->mo_ta_chi_tiet,
            'hinh_anh' => $hinhAnhPath,
            'loai_goi' => $request->loai_goi,
            'gia_pt_them' => $request->gia_pt_them,
            'is_best' => $request->has('is_best') ? 1 : 0,
        ]);

        // Cập nhật giá cho 1, 3, 6, 12 tháng
        $months = [1, 3, 6, 12];
        foreach ($months as $m) {
            GoiTapGia::updateOrCreate(
                ['id_goitap' => $goitap->id_goitap, 'so_thang' => $m],
                ['gia_goc' => $request->input('price_' . $m), 'trang_thai' => 1]
            );
        }

        return redirect()->route('admin.goitap.index')->with('success', 'Cập nhật gói tập thành công!');
    }

    public function destroy($id)
    {
        $goitap = GoiTap::findOrFail($id);
        
        // Xóa các bảng giá trước
        GoiTapGia::where('id_goitap', $goitap->id_goitap)->delete();
        
        // Xóa gói tập
        $goitap->delete();

        return redirect()->route('admin.goitap.index')->with('success', 'Xóa gói tập thành công!');
    }

    // ==========================================
    // PHẦN QUẢN LÝ ĐĂNG KÝ GÓI TẬP CỦA KHÁCH HÀNG
    // ==========================================

    public function dangKyList(Request $request)
    {
        $query = DangKyGoiTap::with(['user', 'pt', 'packagePrice.goitap']);

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $dangKys = $query->orderBy('id', 'desc')->get();

        // Lấy danh sách PT (nguoidung thuộc phanquyen = 4)
        $pts = NguoiDung::where('id_phanquyen', 4)->get();

        return view('admin.goitap.dangky', compact('dangKys', 'pts'));
    }

    public function dangKyKichHoat(Request $request, $id)
    {
        $dangKy = DangKyGoiTap::with('packagePrice')->findOrFail($id);

        $request->validate([
            'id_pt' => 'nullable|exists:nguoidung,id_nd'
        ]);

        $now = now();
        $soThang = $dangKy->packagePrice->so_thang;

        $dangKy->update([
            'trang_thai' => 'dang_tap',
            'id_pt' => $dangKy->co_pt ? $request->id_pt : null,
            'ngay_bat_dau' => $now,
            'ngay_ket_thuc' => $now->copy()->addMonths($soThang)
        ]);

        // Gửi mail kích hoạt thành công
        try {
            Mail::to($dangKy->user->email)->send(new KichHoatGoiTapMail($dangKy));
        } catch (\Exception $e) {
            // Vẫn tiếp tục nếu SMTP lỗi
        }

        return redirect()->back()->with('success', 'Kích hoạt gói tập cho khách hàng thành công!');
    }
}
