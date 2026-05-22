<?php

namespace App\Repositories;

use App\Models\Dathang;

class OrderRepository implements IOrderRepository
{
    // Đơn chờ xác nhận
    public function getPending()
    {
        return Dathang::where('trangthai', 'chờ xác nhận')
            ->orderByDesc('ngaydathang')
            ->get();
    }

    // Đơn đang giao: chờ giao hàng + đang giao hàng
    public function getShipping()
    {
        return Dathang::whereIn('trangthai', ['chờ giao hàng', 'đang giao hàng'])
            ->orderByDesc('ngaydathang')
            ->get();
    }

    // Đơn đã hoàn tất: giao thành công + đã hủy
    public function getFinished()
    {
        return Dathang::whereIn('trangthai', ['giao thành công', 'đã hủy'])
            ->orderByDesc('ngaydathang')
            ->get();
    }

    public function find($id)
    {
        return Dathang::findOrFail($id);
    }

    public function updateStatus($id, string $status, array $extraData = [])
    {
        $order = $this->find($id);

        $order->trangthai = $status;

        // merge thêm các field liên quan (ngaygiaohang, tiengiam, tienphaitra,...)
        foreach ($extraData as $field => $value) {
            $order->{$field} = $value;
        }

        $order->save();

        return $order;
    }


    public function orderView($id)
    {
        return Dathang::where('id_nd', $id)
            ->orderBy('ngaydathang', 'desc')
            ->get();
    }


}
