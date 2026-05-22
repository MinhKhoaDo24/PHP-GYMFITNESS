@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== FORM STYLE (GIỐNG KHUYẾN MÃI) ===================== */

/* TITLE */
.order-title {
    font-size: 22px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111827;
}
.order-title i {
    background: #0ea5e9;
    padding: 8px;
    border-radius: 10px;
    color: #fff;
    font-size: 18px;
}

/* LABEL */
.order-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
}

/* INPUT + SELECT */
.order-input,
.order-select {
    border-radius: 12px;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    background: #fff;
    transition: .2s;
}
.order-input:focus,
.order-select:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.25);
    outline: none;
}

/* TEXTAREA */
.order-textarea {
    border-radius: 12px;
    padding: 12px;
    border: 1px solid #d1d5db;
    resize: none;
}

/* GRID */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
}

/* BUTTONS */
.btn-cancel {
    background: #e5e7eb;
    color: #374151;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    transition: .2s;
    border: none;
}
.btn-cancel:hover { background: #d1d5db; }

.btn-submit {
    background: linear-gradient(to right, #0284c7, #0ea5e9);
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    border: none;
    transition: .2s;
}
.btn-submit:hover {
    opacity: .9;
    transform: translateY(-1px);
}

/* BẢNG CHI TIẾT ĐƠN HÀNG */
.order-items-table thead th {
    background: #000;
    color: #fff;
    text-transform: uppercase;
    font-size: 13px;
    padding: 12px 10px;
    text-align: center;
}
.order-items-table tbody td {
    font-size: 14px;
    padding: 12px 10px;
    vertical-align: middle;
    text-align: center;
    background: #f8fafc;
}
.order-items-table tbody td:first-child {
    text-align: left;
}
.order-status-select {
    background: #dff5ffff !important; /* cam nhạt */
    border-color: #0ea5e9 !important; /* cam */
    color: #0ea5e9 !important; /* text cam đậm */
    font-weight: 600;
}

/* BADGE THANH TOÁN/ TRẠNG THÁI (nếu cần hiển thị read-only) */
.badge-pttt {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}
.badge-status {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}
.badge-status.pending { background:#fde68a; color:#92400e; }
.badge-status.shipping { background:#bfdbfe; color:#1d4ed8; }
.badge-status.done     { background:#bbf7d0; color:#166534; }
.badge-status.cancel   { background:#fecaca; color:#b91c1c; }
</style>

{{-- ======================= TITLE ======================= --}}
<div class="order-title mb-3">
    <i class="bi bi-receipt-cutoff"></i>
    Chỉnh sửa đơn hàng #{{ $order->id_dathang }}
</div>

{{-- ERROR --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- SUCCESS --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- ======================= FORM ======================= --}}
<form method="POST" action="{{ route('orders.update', $order->id_dathang) }}">
    @csrf
    @method('PUT')


    {{-- THÔNG TIN KHÁCH HÀNG + VẬN CHUYỂN --}}
    <div class="grid-2 mb-3">
        <div>
            <label class="order-label">Số điện thoại </label>
            <input type="text" name="sdt"
                   class="form-control order-input"
                   value="{{ old('sdt', $order->sdt) }}" readonly>
        </div>


        <div>
            <label class="order-label">Địa chỉ giao hàng </label>
            <input type="text" name="diachigiaohang"
                   class="form-control order-input"
                   value="{{ old('diachigiaohang', $order->diachigiaohang) }}" readonly>
        </div>
    </div>

    {{-- TỔNG TIỀN / GIẢM GIÁ (READONLY) --}}
    <div class="grid-2 mb-4">
        <div>
            <label class="order-label">Tổng tiền hàng</label>
            <input type="text" class="form-control order-input"
                   value="{{ number_format($order->tongtien) }} đ" readonly>
        </div>

        <div>
            <label class="order-label">Tiền giảm (khuyến mãi)</label>
            <input type="text" class="form-control order-input"
                   value="{{ number_format($order->tiengiam ?? 0) }} đ" readonly>
        </div>

        <div>
            <label class="order-label">Tiền phải trả</label>
            <input type="text" class="form-control order-input"
                   value="{{ number_format($order->tienphaitra ?? $order->tongtien - ($order->tiengiam ?? 0)) }} đ"
                   readonly>
        </div>
    </div>

    {{-- BẢNG CHI TIẾT ĐƠN HÀNG (READ ONLY) --}}
    <label class="order-label" style='color: #0ea5e9;'>Sản phẩm trong đơn </label>
    <div class="card p-0 shadow-sm mb-4">
        <table class="table order-items-table mb-0">
            <thead>
                <tr>
                    <th>SẢN PHẨM</th>
                    <th>SỐ LƯỢNG</th>
                    <th>GIÁ GỐC</th>
                    <th>GIẢM GIÁ</th>
                    <th>GIÁ BÁN</th>
                    <th>THÀNH TIỀN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->tensp }}</td>
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

    {{-- NGÀY ĐẶT + NGÀY GIAO --}}
    <div class="grid-2 mb-4">
        <div>
            <label class="order-label">Ngày đặt hàng</label>
            <input type="text" class="form-control order-input"
                   value="{{ \Carbon\Carbon::parse($order->ngaydathang)->format('d/m/Y H:i') }}"
                   readonly>
        </div>

        <div>
            <label class="order-label">Ngày giao dự kiến <span class="text-danger">*</span></label>
            <input type="datetime-local" name="ngaygiaohang"
                   class="form-control order-input order-status-select"
                   value="{{ old('ngaygiaohang', $order->ngaygiaohang ? \Carbon\Carbon::parse($order->ngaygiaohang)->format('Y-m-d\TH:i') : '') }}">
        </div>
    </div>

    {{-- THÔNG TIN ĐƠN HÀNG: PTTT + TRẠNG THÁI --}}
    <div class="grid-2 mb-3">

        {{-- PHƯƠNG THỨC THANH TOÁN --}}
        <div>
            <label class="order-label">Phương thức thanh toán </label>
            <input type="text" name="phuongthucthanhtoan"
                   class="form-control order-input"
                   value="{{ old('phuongthucthanhtoan', $order->phuongthucthanhtoan) }}" readonly>
        </div>

        {{-- TRẠNG THÁI ĐƠN HÀNG --}}
        <div>
            <label class="order-label">
                Trạng thái đơn hàng <span class="text-danger">*</span>
            </label>

            <select name="trangthai"
                    class="form-select order-select order-status-select"
                    required>

                <option value="Chờ xác nhận"
                    {{ old('trangthai', $order->trangthai) == 'Chờ xác nhận' ? 'selected' : '' }}>
                    Chờ xác nhận
                </option>

                <option value="Chờ giao hàng"
                    {{ old('trangthai', $order->trangthai) == 'Chờ giao hàng' ? 'selected' : '' }}>
                    Chờ giao hàng
                </option>

                <option value="Đang giao hàng"
                    {{ old('trangthai', $order->trangthai) == 'Đang giao hàng' ? 'selected' : '' }}>
                    Đang giao hàng
                </option>

                <option value="Hoàn thành"
                    {{ old('trangthai', $order->trangthai) == 'Hoàn thành' ? 'selected' : '' }}>
                    Hoàn thành
                </option>

                <option value="Hủy"
                    {{ old('trangthai', $order->trangthai) == 'Hủy' ? 'selected' : '' }}>
                    Hủy
                </option>

                <option value="Thất bại"
                    {{ old('trangthai', $order->trangthai) == 'Thất bại' ? 'selected' : '' }}>
                    Thất bại
                </option>
            </select>
        </div>

    </div>

    {{-- BUTTONS --}}
    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('orders.pending') }}" class="btn-cancel">Quay lại</a>
        <button type="submit" class="btn-submit">Cập nhật đơn hàng</button>
    </div>

</form>

@endsection
