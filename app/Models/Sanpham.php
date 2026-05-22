<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';

    protected $primaryKey = 'id_sanpham';

    protected $fillable = [
        'tensp',
        'sku',
        'anhsp',
        'giasp',
        'gia_duoc_giam',
        'mota',
        'mota_ngan',
        'giamgia',
        'giakhuyenmai',
        'soluong',
        'noi_bat',
        'trang_thai',
        'id_danhmuc'
    ];

    public function danhMuc()
    {
        return $this->belongsTo(Danhmuc::class, 'id_danhmuc', 'id_danhmuc');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'id_sanpham', 'id_sanpham');
    }
    public function chitiets()
    {
        return $this->hasMany(ChitietDonhang::class, 'id_sanpham');
    }


    public function getSoldAttribute()
    {
        return $this->chitiets()
            ->whereHas('dathang', function ($q) {
                $q->where('trangthai', 'Hoàn thành');
            })
            ->sum('soluong');
    }


}
