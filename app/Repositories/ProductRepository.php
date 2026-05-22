<?php

namespace App\Repositories;

use App\Models\Sanpham;

class ProductRepository implements IProductRepository
{
    public function allProduct()
    {
        return Sanpham::where('trang_thai', 1)->get();
    }

    public function featuredProducts()
    {
        return Sanpham::where('noi_bat', 1)
            ->where('trang_thai', 1)
            ->get();
    }

    public function getProductsByCategory($danhmucId)
    {
        return Sanpham::where('id_danhmuc', $danhmucId)
            ->where('trang_thai', 1)
            ->get();
    }

    public function randomProduct()
    {
        return Sanpham::where('trang_thai', 1)
            ->inRandomOrder()
            ->get();
    }

    public function findProduct($id)
    {
        return Sanpham::with(['images', 'danhmuc'])->findOrFail($id);
    }

    public function findByName($name)
    {
        return Sanpham::where('tensp', $name)->first();
    }

    public function storeProduct($data)
    {
        return Sanpham::create($data);
    }

    public function updateProduct($data, $id)
    {
        unset($data['anhsp'], $data['delete_images']);

        return Sanpham::where('id_sanpham', $id)->update($data);
    }

    public function softDelete($id)
    {
        return Sanpham::where('id_sanpham', $id)->update([
            'trang_thai' => 0
        ]);
    }

    public function searchProduct($request)
    {
        $keyword = $request->input('tukhoa');

        return Sanpham::with('images')
            ->where('tensp', 'LIKE', "%$keyword%")
            ->where('trang_thai', 1)
            ->paginate(12)
            ->appends($request->query());
    }

    public function getAllByDanhMuc($request)
    {
        $query = Sanpham::with(['images', 'danhmuc'])
            ->where('trang_thai', 1);

        // sửa ở đây: dùng đúng 'category'
        if ($request->filled('category')) {
            $query->where('id_danhmuc', $request->category);
        }

        return $query->paginate(12);
    }


    public function filterProducts($request)
    {
        $query = Sanpham::query();

        // tìm kiếm
        if (!empty($request->q)) {
            $query->where('tensp', 'LIKE', '%' . $request->q . '%');
        }

        // lọc danh mục
        if (!empty($request->cate)) {
            $query->where('id_danhmuc', $request->cate);
        }

        // lọc trạng thái (CHUẨN để nhận giá trị '0')
        if ($request->trang_thai !== null && $request->trang_thai !== '') {
            $query->where('trang_thai', $request->trang_thai);
        }

        return $query->get();
    }
}
