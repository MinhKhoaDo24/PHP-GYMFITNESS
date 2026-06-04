<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DangKyGoiTap extends Model
{
    protected $table = 'dangky_goitap';

    protected $fillable = [
        'ma_dang_ky',
        'id_nguoidung',
        'id_goitap_gia',
        'co_pt',
        'id_pt',
        'id_pt_moi_tam',
        'tong_tien',
        'trang_thai',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'ghi_chu',
        'rejected_pts'
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'rejected_pts' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoidung', 'id_nd');
    }

    public function pt()
    {
        return $this->belongsTo(NguoiDung::class, 'id_pt', 'id_nd');
    }

    public function ptMoiTam()
    {
        return $this->belongsTo(NguoiDung::class, 'id_pt_moi_tam', 'id_nd');
    }

    public function packagePrice()
    {
        return $this->belongsTo(GoiTapGia::class, 'id_goitap_gia', 'id');
    }

    public function yeuCauDoiPTs()
    {
        return $this->hasMany(YeuCauDoiPT::class, 'id_dangky');
    }

    public function yeuCauBaoLuus()
    {
        return $this->hasMany(YeuCauBaoLuu::class, 'id_dangky');
    }
}
