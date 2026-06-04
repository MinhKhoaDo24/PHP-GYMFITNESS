<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuCauBaoLuu extends Model
{
    protected $table = 'yeucau_baoluu';

    protected $fillable = [
        'id_dangky',
        'id_khachhang',
        'ngay_bat_dau_baoluu',
        'so_ngay_baoluu',
        'so_ngay_con_lai_truoc_baoluu',
        'ly_do',
        'trang_thai', // cho_duyet, da_duyet, tu_choi, da_kich_hoat_lai
        'ly_do_tu_choi'
    ];

    protected $casts = [
        'ngay_bat_dau_baoluu' => 'date',
        'so_ngay_baoluu' => 'integer',
        'so_ngay_con_lai_truoc_baoluu' => 'integer'
    ];

    public function dangKyGoiTap()
    {
        return $this->belongsTo(DangKyGoiTap::class, 'id_dangky');
    }

    public function khachHang()
    {
        return $this->belongsTo(NguoiDung::class, 'id_khachhang', 'id_nd');
    }
}
