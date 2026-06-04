<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuCauDoiPT extends Model
{
    protected $table = 'yeucau_doipt';

    protected $fillable = [
        'id_dangky',
        'id_khachhang',
        'id_pt_cu',
        'id_pt_moi',
        'ly_do',
        'ghi_chu',
        'trang_thai', // cho_xu_ly, da_duyet, tu_choi
        'ly_do_tu_choi'
    ];

    public function dangKyGoiTap()
    {
        return $this->belongsTo(DangKyGoiTap::class, 'id_dangky');
    }

    public function khachHang()
    {
        return $this->belongsTo(NguoiDung::class, 'id_khachhang', 'id_nd');
    }

    public function ptCu()
    {
        return $this->belongsTo(NguoiDung::class, 'id_pt_cu', 'id_nd');
    }

    public function ptMoi()
    {
        return $this->belongsTo(NguoiDung::class, 'id_pt_moi', 'id_nd');
    }
}
