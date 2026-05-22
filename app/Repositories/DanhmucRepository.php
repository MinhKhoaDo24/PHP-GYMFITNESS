<?php
namespace App\Repositories;

use App\Repositories\IDanhmucRepository;
use App\Models\Danhmuc;

class DanhmucRepository implements IDanhmucRepository{

     // LẤY TẤT CẢ DANH MỤC (kể cả status = 0)
    public function allDanhmuc()
    {
        return Danhmuc::all();
    }

    // LẤY DANH MỤC HOẠT ĐỘNG (status = 1)
    public function getDanhmucActive()
    {
        return Danhmuc::where('status', 1)->get();
    }

    public function getAllDanhmuc()
    {
        return Danhmuc::where('status', 1)
                        ->orderBy('ten_danhmuc', 'ASC')
                        ->get(['id_danhmuc', 'ten_danhmuc']);
    }
    // THÊM DANH MỤC
    public function storeDanhmuc($data)
    {
        return Danhmuc::create([
            'ten_danhmuc'        => $data['ten_danhmuc'],
            'parent_category_id' => $data['parent_category_id'] ?? null,
            'description'        => $data['description'] ?? null,
            'status'             => $data['status'] ?? 1
        ]);
    }

    // CẬP NHẬT DANH MỤC
    public function updateDanhmuc($data, $id)
    {
        return Danhmuc::where('id_danhmuc', $id)->update($data);
    }


    // TÌM 1 DANH MỤC THEO ID
    public function findDanhmuc($id)
    {
        return Danhmuc::findOrFail($id);
    }

    // XÓA MỀM DANH MỤC
    public function deleteDanhmuc($id)
    {
        return Danhmuc::where('id_danhmuc', $id)->update([
            'status' => 0
        ]);
    }
}