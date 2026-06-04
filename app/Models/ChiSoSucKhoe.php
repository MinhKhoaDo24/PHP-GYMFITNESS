<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiSoSucKhoe extends Model
{
    protected $table = 'chi_so_suc_khoe';

    protected $fillable = [
        'id_dangky_goitap',
        'id_pt',
        'id_khach_hang',
        'ngay_ghi_nhan',
        'chieu_cao',
        'can_nang',
        'luong_mo',
        'luong_nuoc',
        'chi_so_bmi',
        'thoi_quen_song',
        'nhac_nho'
    ];

    protected $casts = [
        'ngay_ghi_nhan' => 'date',
    ];

    public function dangKyGoiTap()
    {
        return $this->belongsTo(DangKyGoiTap::class, 'id_dangky_goitap', 'id');
    }

    public function pt()
    {
        return $this->belongsTo(NguoiDung::class, 'id_pt', 'id_nd');
    }

    public function khachHang()
    {
        return $this->belongsTo(NguoiDung::class, 'id_khach_hang', 'id_nd');
    }
}
