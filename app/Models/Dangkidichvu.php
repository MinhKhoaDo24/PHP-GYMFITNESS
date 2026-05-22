<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dangkidichvu extends Model
{
    protected $table = 'dangkidichvu';
    protected $primaryKey = 'id_dang_ky';

    protected $fillable = [
        'ho_ten',
        'email',
        'so_dien_thoai',
        'ngay_mong_muon',
        'gio_mong_muon',
        'ghi_chu',
        'mon_ua_thich',
        'co_so_tap',
        'trangthai',
        'id_nguoidung'

    ];
}
