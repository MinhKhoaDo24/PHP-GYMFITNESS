<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'size';
    protected $primaryKey = 'id_size';
    public $timestamps = false;
    protected $fillable = [
        'ten_size',
        'mota',
        'trang_thai'
    ];
    public function sanphams()
    {
        return $this->belongsToMany(SanPham::class, 'sanpham_size', 'id_size', 'id_sanpham')
            ->withPivot('soluong', 'gia_cong_them');
    }
}
