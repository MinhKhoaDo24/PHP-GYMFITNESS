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

/* Badge mới */
.status-success { background:#bbf7d0; color:#15803d; } /* hoàn thành */
.status-failed  { background:#fecaca; color:#b91c1c; } /* thất bại */
</style>

<h1 class="h3 mb-4"><strong>Đơn hàng hoàn thành & thất bại</strong></h1>

{{-- ===================== STATISTIC ===================== --}}
<div class="row g-3 mb-3">

    <div class="col-md-3">
        <div class="stat-box" style="border-left-color:#10b981;">
            <p class="stat-number">{{ $stats['done'] }}</p>
            <p class="stat-label">Hoàn thành</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-box" style="border-left-color:#dc2626;">
            <p class="stat-number">{{ $stats['failed'] }}</p>
            <p class="stat-label">Thất bại</p>
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
<div class="d-flex justify-content-between mb-3">

    {{-- SEARCH --}}
    <form class="w-50" method="GET" action="{{ url()->current() }}">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="🔍 Tìm theo tên, số điện thoại, mã đơn..."
               value="{{ request('search') }}"
               onkeydown="if(event.key==='Enter') this.form.submit();">
    </form>

    <div class="d-flex">

        {{-- FILTER STATUS --}}
        <form method="GET">
            <input type="hidden" name="search" value="{{ request('search') }}">

            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">📚 Trạng thái đơn</option>

                <option value="Hoàn thành"
                    {{ request('status') == 'Hoàn thành' ? 'selected' : '' }}>
                    Hoàn thành
                </option>

                <option value="Thất bại"
                    {{ request('status') == 'Thất bại' ? 'selected' : '' }}>
                    Thất bại
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
                <td>#{{ $order->id_dathang }}</td>
                <td>{{ \Carbon\Carbon::parse($order->ngaydathang)->format('d/m/Y H:i') }}</td>
                <td>{{ $order->hoten }}</td>
                <td>{{ number_format($order->tongtien) }} đ</td>

                {{-- PAYMENT --}}
                <td>
                    @if($order->phuongthucthanhtoan === 'COD')
                        <span class="badge bg-secondary">COD</span>
                    @else
                        <span class="badge bg-primary">{{ $order->phuongthucthanhtoan }}</span>
                    @endif
                </td>

                {{-- STATUS --}}
                <td>
                    @if($order->trangthai === 'Hoàn thành')
                        <span class="status-badge status-success">Hoàn thành</span>
                    @else
                        <span class="status-badge status-failed">Thất bại</span>
                    @endif
                </td>

                {{-- ACTION --}}
                <td>
                    <a href="{{ route('orders.show', $order->id_dathang) }}" class="btn-action btn-view">Xem</a>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                    Không có đơn nào.
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
