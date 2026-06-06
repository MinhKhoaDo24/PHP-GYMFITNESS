<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Danhmuc;
use App\Repositories\IDanhmucRepository;

class DanhmucController extends Controller
{
    private $DanhmucRepository;

    public function __construct(IDanhmucRepository $DanhmucRepository)
    {
        $this->DanhmucRepository = $DanhmucRepository;
    }

    // ==============================
    // HIỂN THỊ DANH SÁCH DANH MỤC
    // ==============================
    public function index(Request $request)
    {
        $status = $request->get('status'); // null / 1 / 0

        $query = Danhmuc::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        $Danhmucs = $query->orderBy('id_danhmuc', 'DESC')->get();

        return view('admin.danhmucs.index', compact('Danhmucs', 'status'));
    }
    public function getDanhmucs()
    {
        $danhmucs = $this->DanhmucRepository->getAllDanhmuc();
        return response()->json($danhmucs);
    }
    // ==============================
    // TRANG THÊM DANH MỤC
    // ==============================
    public function create()
    {
        $list_danhmucs = Danhmuc::where('status', 1)->get(); // danh mục cha chỉ lấy active

        return view('admin.danhmucs.create', compact('list_danhmucs'));
    }

    // ==============================
    // LƯU DANH MỤC
    // ==============================
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten_danhmuc'      => 'required|unique:danhmuc,ten_danhmuc',
            'danh_muc_cha'     => 'nullable|integer',
            'mo_ta_danh_muc'   => 'nullable|string'
        ], [
            'ten_danhmuc.required' => 'Tên danh mục không được để trống.',
            'ten_danhmuc.unique'   => 'Tên danh mục đã tồn tại.',
        ]);

        $data = [
            'ten_danhmuc'        => $validatedData['ten_danhmuc'],
            'parent_category_id' => $request->danh_muc_cha,
            'description'        => $request->mo_ta_danh_muc,
            'status'             => 1
        ];

        $this->DanhmucRepository->storeDanhmuc($data);

        return redirect()->route('danhmuc.index')->with('success', 'Thêm danh mục thành công');
    }

    // ==============================
    // TRANG SỬA DANH MỤC
    // ==============================
    public function edit($id)
    {
        $danhmuc = $this->DanhmucRepository->findDanhmuc($id);
        $list_danhmucs = Danhmuc::where('status', 1)->where('id_danhmuc', '!=', $id)->get();

        return view('admin.danhmucs.edit', compact('danhmuc', 'list_danhmucs'));
    }

    // ==============================
    // CẬP NHẬT DANH MỤC
    // ==============================
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'ten_danhmuc' => 'required'
        ], [
            'ten_danhmuc.required' => 'Tên danh mục không được để trống.'
        ]);

        $data = [
            'ten_danhmuc'        => $validatedData['ten_danhmuc'],
            'parent_category_id' => $request->danh_muc_cha,
            'description'        => $request->mo_ta_danh_muc,
        ];

        $this->DanhmucRepository->updateDanhmuc($data, $id);

        return redirect()->route('danhmuc.index')->with('success', 'Cập nhật danh mục thành công');
    }

    // ==============================
    // XÓA (ẨN) DANH MỤC
    // ==============================
    public function destroy($id)
    {
        // Soft delete: status = 0, không xóa DB
        $danhmuc = Danhmuc::findOrFail($id);
        $danhmuc->status = 0;
        $danhmuc->save();

        return redirect()->route('danhmuc.index')->with('success', 'Danh mục đã được ẩn thành công');
    }

    public function restore($id)
    {
        // Kiểm tra danh mục có tồn tại không
        $danhmuc = $this->DanhmucRepository->findDanhmuc($id);

        if (!$danhmuc) {
            return redirect()->route('danhmuc.index')
                ->with('error', 'Danh mục không tồn tại!');
        }

        // Cập nhật trạng thái
        $this->DanhmucRepository->updateDanhmuc(['status' => 1], $id);

        return redirect()->route('danhmuc.index')
            ->with('success', 'Khôi phục danh mục thành công');
    }


}
