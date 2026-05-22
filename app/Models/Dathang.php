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
    ];

    public function khuyenmai()
    {
        return $this->belongsTo(Khuyenmai::class, 'id_khuyenmai', 'id_khuyenmai');
    }
}

