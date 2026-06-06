<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IKhuyenmaiRepository;

class KhuyenmaiController extends Controller
{
    private $repo;

    public function __construct(IKhuyenmaiRepository $repo)
    {
        $this->repo = $repo;
    }


    /** ===========================
     *        INDEX
     *  =========================== */
    public function index(Request $request)
    {
        $status = $request->status;
        $query  = $request->q;
        $type   = $request->type;

        // 🟢 Thống kê dashboard
        $stats = [
            'total'   => $this->repo->countAll(),
            'active'  => $this->repo->countActive(),
            'paused'  => $this->repo->countPaused(),
            'expired' => $this->repo->countExpired(),
            'used'    => $this->repo->countUsage(),
        ];

        // 🟢 Lấy danh sách KM
        $khuyenmais = $this->repo->filter($status, $query, $type);

        return view('admin.promotions.index', compact('khuyenmais', 'stats'));
    }


    /** ===========================
     *        CREATE
     *  =========================== */
    public function create()
    {
        return view('admin.promotions.create');
    }


    /** ===========================
     *        STORE
     *  =========================== */
    public function store(Request $request)
    {
        $request->validate([
            'ten_khuyenmai'   => 'required|max:150',
            'ma_code'         => 'required|unique:khuyenmai,ma_code',
            'gia_tri_giam'    => 'required|numeric|min:0',
            'kieu_giam'       => 'required|in:percent,money,freeship',
            'yeu_cau_dang_nhap' => 'nullable|in:0,1',
            'don_toi_thieu'   => 'nullable|numeric|min:0',
            'giam_toi_da'     => 'nullable|numeric|min:0',
            'ngay_bat_dau'    => 'required|date',
            'ngay_ket_thuc'   => 'required|date|after:ngay_bat_dau',
        ], [
            'ten_khuyenmai.required'  => 'Vui lòng nhập tên chương trình khuyến mãi.',
            'ma_code.required'        => 'Vui lòng nhập mã code.',
            'ma_code.unique'          => 'Mã code này đã tồn tại, vui lòng chọn mã khác.',
            'gia_tri_giam.required'   => 'Vui lòng nhập giá trị giảm.',
            'gia_tri_giam.numeric'    => 'Giá trị giảm phải là số.',
            'gia_tri_giam.min'        => 'Giá trị giảm không được âm.',
            'ngay_bat_dau.required'   => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_bat_dau.date'       => 'Ngày bắt đầu không hợp lệ.',
            'ngay_ket_thuc.required'  => 'Vui lòng chọn ngày kết thúc.',
            'ngay_ket_thuc.date'      => 'Ngày kết thúc không hợp lệ.',
            'ngay_ket_thuc.after'     => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        $this->repo->store($request->all());

        return redirect()
            ->route('khuyenmai.index')
            ->with('success', 'Tạo khuyến mãi thành công!');
    }


    /** ===========================
     *        EDIT
     *  =========================== */
    public function edit($id)
    {
        $km = $this->repo->find($id);
        return view('admin.promotions.edit', compact('km'));
    }


    /** ===========================
     *        UPDATE
     *  =========================== */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_khuyenmai'   => 'required|max:150',
            'gia_tri_giam'    => 'required|numeric|min:0',
            'kieu_giam'       => 'required|in:percent,money,freeship',
            'yeu_cau_dang_nhap' => 'nullable|in:0,1',
            'don_toi_thieu'   => 'nullable|numeric|min:0',
            'giam_toi_da'     => 'nullable|numeric|min:0',
            'ngay_bat_dau'    => 'required|date',
            'ngay_ket_thuc'   => 'required|date|after:ngay_bat_dau',
        ], [
            'ten_khuyenmai.required'  => 'Vui lòng nhập tên chương trình khuyến mãi.',
            'gia_tri_giam.required'   => 'Vui lòng nhập giá trị giảm.',
            'gia_tri_giam.numeric'    => 'Giá trị giảm phải là số.',
            'gia_tri_giam.min'        => 'Giá trị giảm không được âm.',
            'ngay_bat_dau.required'   => 'Vui lòng chọn ngày bắt đầu.',
            'ngay_bat_dau.date'       => 'Ngày bắt đầu không hợp lệ.',
            'ngay_ket_thuc.required'  => 'Vui lòng chọn ngày kết thúc.',
            'ngay_ket_thuc.date'      => 'Ngày kết thúc không hợp lệ.',
            'ngay_ket_thuc.after'     => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);
        $data = $request->except(['_token', '_method']);

        $this->repo->update($id, $data);

        return redirect()
            ->route('khuyenmai.index')
            ->with('success', 'Cập nhật khuyến mãi thành công!');
    }


    /** ===========================
     *        DELETE
     *  =========================== */
    public function destroy($id)
    {
        $this->repo->softDelete($id);

        return redirect()
            ->route('khuyenmai.index')
            ->with('success', 'Khuyến mãi đã được vô hiệu hóa.');
    }


    /** ===========================
     *        RESTORE
     *  =========================== */
    public function restore($id)
    {
        $this->repo->restore($id);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Khuyến mãi đã được khôi phục!');
    }
}
