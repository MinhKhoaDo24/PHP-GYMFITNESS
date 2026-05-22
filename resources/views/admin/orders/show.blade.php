@extends('admin_layout')
@section('admin_content')

<style>
/* ====== STYLE ĐỒNG BỘ EDIT ====== */
.detail-title {
    font-size: 22px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111827;
}

.detail-title i {
    background: #0ea5e9;
    padding: 8px;
    border-radius: 10px;
    color: #fff;
    font-size: 18px;
}

.detail-label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #374151;
}

.detail-box {
    background: #f9fafb;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media(max-width:768px){
    .grid-2 { grid-template-columns: 1fr; }
}

/* Table */
.order-items-table thead th {
    background: #000;
    color: #fff;
    padding: 12px 10px;
    text-align: center;
}

.order-items-table tbody td {
    padding: 12px 10px;
    text-align: center;
    background: #f3f4f6;
}

/* Buttons */
.btn-back {
    background: #e5e7eb;
    color: #374151;
    border-radius: 12px;
    padding: 10px 24px;
    font-weight: 600;
    text-decoration: none;
}

.btn-edit {
    background: linear-gradient(to right, #0284c7, #0ea5e9);
    color: #fff;
    padding: 10px 24px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
}
</style>

{{-- TITLE --}}
<div class="detail-title mb-3">
    <i class="bi bi-eye"></i>
    Chi tiết đơn hàng #{{ $order->id_dathang }}
</div>

{{-- THÔNG TIN KHÁCH HÀNG --}}
<h5 class="mb-2 fw-bold" style='color: #0ea5e9;'>Thông tin khách hàng</h5>
<div class="grid-2 mb-4">
    <div>
        <label class="detail-label">Họ tên</label>
        <div class="detail-box">{{ $order->hoten }}</div>
    </div>

    <div>
        <label class="detail-label">Số điện thoại</label>
        <div class="detail-box">{{ $order->sdt }}</div>
    </div>

    <div>
        <label class="detail-label">Email</label>
        <div class="detail-box">{{ $order->email ?? '—' }}</div>
    </div>

    <div>
        <label class="detail-label">Địa chỉ giao hàng</label>
        <div class="detail-box">{{ $order->diachigiaohang }}</div>
    </div>
</div>

{{-- NGÀY ĐẶT + NGÀY GIAO --}}
<h5 class="fw-bold mb-2" style='color: #0ea5e9;'>Thời gian</h5>
<div class="grid-2 mb-4">
    <div>
        <label class="detail-label">Ngày đặt hàng</label>
        <div class="detail-box">
            {{ \Carbon\Carbon::parse($order->ngaydathang)->format('d/m/Y H:i') }}
        </div>
    </div>
    <div>
        <label class="detail-label">Ngày giao dự kiến</label>
        <div class="detail-box">
            {{ $order->ngaygiaohang ? \Carbon\Carbon::parse($order->ngaygiaohang)->format('d/m/Y H:i') : '—' }}
        </div>
    </div>
</div>

{{-- THANH TOÁN + TRẠNG THÁI --}}
<h5 class="fw-bold mb-2" style='color: #0ea5e9;'>Thanh toán & Trạng thái</h5>
<div class="grid-2 mb-4">
    <div>
        <label class="detail-label">Phương thức thanh toán</label>
        <div class="detail-box">{{ $order->phuongthucthanhtoan }}</div>
    </div>

    <div>
        <label class="detail-label">Trạng thái đơn hàng</label>
        <div class="detail-box">{{ $order->trangthai }}</div>
    </div>
</div>

{{-- TIỀN TỆ --}}
<h5 class="fw-bold mb-2" style='color: #0ea5e9;'>Thanh toán</h5>
<div class="grid-2 mb-4">
    <div>
        <label class="detail-label">Tổng tiền hàng</label>
        <div class="detail-box">{{ number_format($order->tongtien) }} đ</div>
    </div>

    <div>
        <label class="detail-label">Tiền giảm (khuyến mãi)</label>
        <div class="detail-box">{{ number_format($order->tiengiam ?? 0) }} đ</div>
    </div>

    <div>
        <label class="detail-label">Tiền phải trả</label>
        <div class="detail-box">
            {{ number_format($order->tienphaitra ?? ($order->tongtien - ($order->tiengiam ?? 0))) }} đ
        </div>
    </div>
</div>

{{-- SẢN PHẨM TRONG ĐƠN --}}
<h5 class="fw-bold mb-2" style='color: #0ea5e9;'>Sản phẩm trong đơn</h5>

<div class="card shadow-sm p-0 mb-4">
    <table class="table order-items-table mb-0">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá gốc</th>
                <th>Giảm giá</th>
                <th>Giá bán</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->tensp }}</td>
                <td>{{ $item->soluong }}</td>
                <td>{{ number_format($item->giatien) }} đ</td>
                <td>{{ $item->giamgia }}%</td>
                <td>{{ number_format($item->giakhuyenmai) }} đ</td>
                <td>{{ number_format($item->soluong * $item->giakhuyenmai) }} đ</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- BUTTONS --}}
<div class="d-flex justify-content-between mt-4">
    <a href="{{ url()->previous() }}" class="btn-back" style='text-decoration: none';>Quay lại</a>

    <a href="{{ route('orders.edit', $order->id_dathang) }}?redirect={{ url()->previous() }}"
       class="btn-edit" style='text-decoration: none'>
        Chỉnh sửa
    </a>
</div>

@endsection
