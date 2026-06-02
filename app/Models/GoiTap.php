<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoiTap extends Model
{
    protected $table = 'goitap';
    protected $primaryKey = 'id_goitap';

    protected $fillable = [
        'ten_goi',
        'slug',
        'mo_ta_ngan',
        'mo_ta_chi_tiet',
        'hinh_anh',
        'loai_goi',
        'gia_pt_them',
        'is_best',
        'trang_thai'
    ];

    public function prices()
    {
        return $this->hasMany(GoiTapGia::class, 'id_goitap', 'id_goitap');
    }
}
