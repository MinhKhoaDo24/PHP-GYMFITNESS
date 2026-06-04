<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thongbao extends Model
{
    protected $table = 'thongbao';

    protected $fillable = [
        'id_nguoidung',
        'tieu_de',
        'noi_dung',
        'loai',
        'da_doc',
        'link'
    ];

    public function user()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoidung', 'id_nd');
    }
}
