<?php

namespace App\Http\Controllers\admin;

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
            'gia_tri_giam'    => 'required|numeric|min:1',
            'kieu_giam'       => 'required|in:percent,money',
            'don_toi_thieu'   => 'nullable|numeric|min:0',
            'giam_toi_da'     => 'nullable|numeric|min:0',
            'ngay_bat_dau'    => 'required|date',
            'ngay_ket_thuc'   => 'required|date|after_or_equal:ngay_bat_dau',
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
            'gia_tri_giam'    => 'required|numeric|min:1',
            'kieu_giam'       => 'required|in:percent,money',
            'don_toi_thieu'   => 'nullable|numeric|min:0',
            'giam_toi_da'     => 'nullable|numeric|min:0',
            'ngay_bat_dau'    => 'required|date',
            'ngay_ket_thuc'   => 'required|date|after_or_equal:ngay_bat_dau',
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
