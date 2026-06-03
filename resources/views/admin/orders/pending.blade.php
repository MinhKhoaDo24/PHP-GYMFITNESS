@extends('admin_layout')
@section('admin_content')

<style>
/* ================= CARD THỐNG KÊ (CHUẨN KHUYẾN MÃI) ================= */
.stat-box {
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    border-left: 6px solid #2563eb;
    box-shadow: 0 3px 8px rgba(0,0,0,0.06);
    text-align: center;
}
.stat-number {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
}
.stat-label {
    margin-top: 4px;
    color: #6b7280;
    font-size: 14px;
}

/* ================= SEARCH BAR ================= */
.search-bar {
    background: #fff;
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    width: 32%;
}

/* ================= TABLE ================= */
.order-table thead th {
    background: #000;
    color: #fff;
    padding: 13px 10px;
    font-size: 13px;
    letter-spacing: .5px;
    text-transform: uppercase;
}
.order-table tbody td {
    padding: 14px 10px;
    background: #fff;
    vertical-align: middle;
}

/* ================= BADGE ================= */
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.status-waiting { background:#fde68a; color:#b45309; }
.status-shipping { background:#bfdbfe; color:#1d4ed8; }
.status-success { background:#bbf7d0; color:#15803d; }

/* ================= BUTTON ================= */
.btn-action {
    padding: 7px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    border: none;
}
.status-cancel {
    background:#fecaca;
    color:#b91c1c;
}
.btn-edit { background:#facc15; color:#000; }
.btn-view { background:#0ea5e9; color:#fff; }
.btn-action:hover { opacity:.9; }

</style>


{{-- ===================== PAGE TITLE ===================== --}}
<h1 class="h3 mb-4"><strong>Đơn hàng chờ xác nhận</strong></h1>


{{-- ===================== STATISTIC BOXES ===================== --}}
<div class="row g-3 mb-3">

    <div class="col-md-3">
        <div class="stat-box" style="border-left-color:#f59e0b;">
            <p class="stat-number">{{ $stats['pending'] }}</p>
            <p class="stat-label">Đơn chờ xác nhận</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-box" style="border-left-color:#dc2626;">
            <p class="stat-number">{{ $stats['canceled'] }}</p>
            <p class="stat-label">Đơn bị hủy</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-box" style="border-left-color:#0ea5e9;">
            <p class="stat-number">{{ $stats['total'] }}</p>
            <p class="stat-label">Tổng số đơn</p>
        </div>
    </div>

</div>



{{-- ===================== SEARCH + FILTER ===================== --}}
{{-- ===================== SEARCH + FILTER (GIỐNG SẢN PHẨM) ===================== --}}
<div class="d-flex justify-content-between mb-3">

    {{-- SEARCH --}}
    <form class="w-50" method="GET" action="{{ url()->current() }}">
        <input type="text" 
            name="search" 
            class="form-control"
            placeholder="Tìm theo tên, số điện thoại, mã đơn..."
            value="{{ request('search') }}"
            onkeydown="if(event.key==='Enter') this.form.submit();">
    </form>


    <div class="d-flex">

        {{-- FILTER STATUS --}}
        <form method="GET">
            {{-- Giữ lại search --}}
            <input type="hidden" name="search" value="{{ request('search') }}">

            <select name="status" 
                    class="form-select" 
                    onchange="this.form.submit()">

                <option value="">Trạng thái đơn</option>

                <option value="Chờ xác nhận"
                    {{ request('status') == 'Chờ xác nhận' ? 'selected' : '' }}>
                    Chờ xác nhận
                </option>

                <option value="Bị hủy"
                    {{ request('status') == 'Bị hủy' ? 'selected' : '' }}>
                    Đã hủy
                </option>
            </select>
        </form>

    </div>
</div>

{{-- ===================== TABLE ===================== --}}
<div class="card p-0 shadow-sm">

    <table class="table order-table mb-0">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>

        @forelse($orders as $order)
            <tr>
                <td>#RF-{{ str_pad($order->id_dathang, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ \Carbon\Carbon::parse($order->ngaydathang)->format('d/m/Y H:i') }}</td>
                <td>{{ $order->hoten }}</td>
                <td>{{ number_format($order->tienphaitra > 0 ? $order->tienphaitra : $order->tongtien, 0, ',', '.') }} đ</td>

                {{-- PAYMENT --}}
                <td>
                    @if($order->phuongthucthanhtoan == 'COD')
                        <span class="badge bg-secondary">COD</span>
                    @else
                        <span class="badge bg-primary">{{ $order->phuongthucthanhtoan }}</span>
                    @endif
                </td>

                {{-- STATUS --}}
                <td>
                    @if($order->trangthai === 'Chờ xác nhận')
                        <span class="status-badge status-waiting">Chờ xác nhận</span>
                    @elseif($order->trangthai === 'Bị hủy')
                        <span class="status-badge status-cancel" style="background:#fecaca; color:#b91c1c;">
                            Đã hủy
                        </span>
                    @endif
                </td>


                {{-- ACTION --}}
                <td>
                    <a href="{{ route('orders.edit', $order->id_dathang) }}?redirect={{ url()->current() }}"
                                class="btn-action btn-edit">Sửa</a>
                    <a href="{{ route('orders.show', $order->id_dathang) }}" class="btn-action btn-view">Xem</a>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                    Không có đơn :((
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>

{{-- PAGINATION --}}
@if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-3">
        {{ $orders->links() }}
    </div>
@endif

@endsection
