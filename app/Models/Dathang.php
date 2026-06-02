<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dathang extends Model
{
    protected $table = 'dathang';
    protected $primaryKey = 'id_dathang';
    public $timestamps = false;

    protected $fillable = [
        'ngaydathang',
        'ngaygiaohang',
        'ngay_hoan_thanh',
        'tongtien',
        'tiengiam',           // thêm
        'tienphaitra',        // thêm
        'id_khuyenmai',       // thêm
        'phuongthucthanhtoan',
        'diachigiaohang',
        'hoten',
        'email',
        'sdt',
        'trangthai',
        'id_nd'
    ];

    protected $casts = [
        'id_dathang' => 'int',
        'ngaydathang' => 'datetime',
        'ngaygiaohang' => 'datetime',
        'ngay_hoan_thanh' => 'datetime',
        'tongtien' => 'int',
        'tiengiam' => 'int',       // thêm
        'tienphaitra' => 'int',    // thêm
        'id_khuyenmai' => 'int',   // thêm
        'phuongthucthanhtoan' => 'string',
        'diachigiaohang' => 'string',
        'hoten' => 'string',
        'email' => 'string',
        'sdt' => 'int',
        'trangthai' => 'string',
        'id_nd' => 'int',
    ];

    protected $dates = [
        'ngaydathang',
        'ngaygiaohang',
        'ngay_hoan_thanh',
    ];

    public function khuyenmai()
    {
        return $this->belongsTo(Khuyenmai::class, 'id_khuyenmai', 'id_khuyenmai');
    }

    public function details()
    {
        return $this->hasMany(ChitietDonhang::class, 'id_dathang', 'id_dathang');
    }
}

