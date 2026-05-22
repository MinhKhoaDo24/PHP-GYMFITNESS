<?php

namespace App\Repositories;

interface IOrderRepository
{
    // 3 nhóm đơn hàng
    public function getPending();          // chờ xác nhận
    public function getShipping();         // chờ giao hàng + đang giao hàng
    public function getFinished();         // giao thành công + đã hủy

    // Lấy một đơn
    public function find($id);

    // Cập nhật trạng thái + các field liên quan
    public function updateStatus($id, string $status, array $extraData = []);


}
