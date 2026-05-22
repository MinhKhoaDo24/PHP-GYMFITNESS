<?php

namespace App\Repositories;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SanphamRepository
{
    public function allProduct()
    {
        $query = SanPham::with('danhMuc');

        if (Schema::hasColumn('sanpham', 'trang_thai')) {
            $query->where('trang_thai', 1);
        }

        return $query->orderByDesc('id_sanpham')->get();
    }

    public function featuredProducts()
    {
        $query = SanPham::with('danhMuc');

        if (Schema::hasColumn('sanpham', 'noi_bat')) {
            $query->where('noi_bat', 1);
        }

        if (Schema::hasColumn('sanpham', 'trang_thai')) {
            $query->where('trang_thai', 1);
        }

        return $query->orderByDesc('id_sanpham')->take(8)->get();
    }

    public function randomProduct()
    {
        $query = SanPham::with('danhMuc');

        if (Schema::hasColumn('sanpham', 'trang_thai')) {
            $query->where('trang_thai', 1);
        }

        return $query->inRandomOrder()->get();
    }

    public function searchProduct(Request $request)
    {
        $keyword = $request->input('tukhoa', '');

        $query = SanPham::with('danhMuc');

        if (Schema::hasColumn('sanpham', 'trang_thai')) {
            $query->where('trang_thai', 1);
        }

        $query->when($keyword, function ($q, $keyword) {
            $q->where('tensp', 'LIKE', '%' . $keyword . '%');
        });

        return $query->orderByDesc('id_sanpham')->paginate(12);
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


    public function getProductsByCategory($categoryId)
    {
        $query = SanPham::with('danhMuc')
            ->where('id_danhmuc', $categoryId);

        if (Schema::hasColumn('sanpham', 'trang_thai')) {
            $query->where('trang_thai', 1);
        }

        return $query->orderByDesc('id_sanpham')->take(8)->get();
    }
}
