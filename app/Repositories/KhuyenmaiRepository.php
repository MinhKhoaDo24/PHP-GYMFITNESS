<?php

namespace App\Repositories;

use App\Models\Khuyenmai;
use Carbon\Carbon;

class KhuyenmaiRepository implements IKhuyenmaiRepository
{
    /** =====================================================
     *    LẤY DANH SÁCH CÓ FILTER: trạng thái – tìm kiếm – loại
     *  ===================================================== */
    public function filter($status = null, $search = null, $type = null)
    {
        return Khuyenmai::when($status !== null, function ($q) use ($status) {
                return $q->where('trang_thai', $status);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where(function ($x) use ($search) {
                    $x->where('ten_khuyenmai', 'like', "%$search%")
                      ->orWhere('ma_code', 'like', "%$search%");
                });
            })
            ->when($type, function ($q) use ($type) {
                return $q->where('kieu_giam', $type);
            })
            ->orderBy('id_khuyenmai', 'DESC')
            ->get();
    }


    /** =====================================================
     *    CRUD
     *  ===================================================== */
    public function all($status = null)
    {
        return Khuyenmai::when($status !== null, function ($query) use ($status) {
                return $query->where('trang_thai', $status);
            })
            ->orderBy('id_khuyenmai', 'DESC')
            ->get();
    }

    public function find($id)
    {
        return Khuyenmai::findOrFail($id);
    }

    public function store($data)
    {
        return Khuyenmai::create($data);
    }

    public function update($id, $data)
    {
        
        return Khuyenmai::where('id_khuyenmai', $id)->update($data);
    }

    public function softDelete($id)
    {
        return Khuyenmai::where('id_khuyenmai', $id)->update([
            'trang_thai' => 0
        ]);
    }

    public function restore($id)
    {
        return Khuyenmai::where('id_khuyenmai', $id)->update([
            'trang_thai' => 1
        ]);
    }


    /** =====================================================
     *    THỐNG KÊ DASHBOARD
     *  ===================================================== */

    // Tổng số KM
    public function countAll()
    {
        return Khuyenmai::count();
    }

    // Đang hoạt động
    public function countActive()
    {
        return Khuyenmai::where('trang_thai', 1)
            ->where('ngay_bat_dau', '<=', Carbon::now())
            ->where('ngay_ket_thuc', '>=', Carbon::now())
            ->count();
    }

    // Tạm dừng
    public function countPaused()
    {
        return Khuyenmai::where('trang_thai', 0)->count();
    }

    // Hết hạn
    public function countExpired()
    {
        return Khuyenmai::where('ngay_ket_thuc', '<', Carbon::now())->count();
    }

    // Tổng lượt sử dụng
    public function countUsage()
    {
        return Khuyenmai::sum('so_luot_da_dung');
    }
}
