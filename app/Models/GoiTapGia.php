<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoiTapGia extends Model
{
    protected $table = 'goitap_gia';

    protected $fillable = [
        'id_goitap',
        'so_thang',
        'gia_goc',
        'gia_khuyen_mai',
        'trang_thai'
    ];

    public function goitap()
    {
        return $this->belongsTo(GoiTap::class, 'id_goitap', 'id_goitap');
    }
}
