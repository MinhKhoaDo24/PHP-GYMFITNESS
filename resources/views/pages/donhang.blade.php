@extends('layout')
@section('content')

<style>
.orders-hero {
    width: 100%;
    height: 300px;
    background-image: url('/frontend/img/donhang.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    align-items: flex-end;
}

.orders-hero-content {
    padding: 30px 40px;
    color: #ffffff;
}

.orders-page {
    padding: 40px 0 80px;
    background: #ffffff;
    width: 100%;
}

.orders-wrapper {
    width: 100%;
    /* max-width: 1500px; */
    margin: 0 auto;
    padding: 0 40px 0; 
}

.orders-heading {
    margin-bottom: 14px;
}

.orders-breadcrumb {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7280;
}

.orders-breadcrumb a {
    color: #34A4E0;
    text-decoration: none;
}

.orders-breadcrumb span {
    color: #9ca3af;
}

.orders-title {
    font-size: 32px;
    font-weight: 700;
    color: #0b1120;
    margin: 6px 0 4px;
}

.orders-subtitle {
    font-size: 14px;
    color: #6b7280;
}

.orders-card {
    background: transparent;
    border: none;
    box-shadow: none;
    width: 100%;
}

.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #0b1120;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 14px 32px rgba(0, 0, 0, 0.18);
    font-size: 16px;
}


.orders-table thead tr {
    background: #020617;
}

.orders-table thead th {
    padding: 16px 18px;
    text-align: left;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #f9fafb;
    white-space: nowrap;
}

.orders-table tbody tr {
    background: #dee2e6;
}

.orders-table tbody tr + tr td {
    border-top: 1px solid #1f2937;
}

.orders-table td {
    padding: 16px 18px;
    color: #000000ff;
    font-size: 16px;
}

.orders-table td:first-child {
    font-weight: 700;
    color: #0319e1ff;
}

.badge-payment {
    padding: 4px 6px;
    font-size: 14px;
    border-radius: 9px;
    background: #0319e1ff;
    color: #f4f4f4ff;
}

.badge-status {

    padding: 4px 6px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    min-width: 150px;
    transition: 0.25s ease;
}

/* Đang xử lý / Chờ xác nhận */
.badge-status--processing {
    background: #F2C34B;
    color: #fff;
}

/* Thành công */
.badge-status--success {
    background: #34D399;
    color: #fff;
}

/* Cảnh báo / Bị hủy */
.badge-status--warning {
    background: #F87171;
        color: #fff;
}
.badge-status--shipping{
    background: #1ba8efff;
    color: #fff;
}

/* Trạng thái mặc định */
.badge-status-default {
    background: #e5e7eb;
    border: 2px solid #9ca3af;
    color: #374151;
}


.checkout-section {
    padding: 35px 0;
    background: #F5F8FB;
}

.checkout-card {
    background: #fff;
    padding: 25px 28px;
    border-radius: 18px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    border: 1px solid #e5e7eb;
}

.section-title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 15px;
}

.info-label {
    color: #6B7280;
    font-weight: 600;
}

.info-value {
    color: #111827;
    font-weight: 600;
}

.table-cart thead th {
    background: #34A4E0 !important;
    color: #fff;
    padding: 12px;
    text-transform: uppercase;
    font-size: 13px;
}

.table-cart tbody td {
    vertical-align: middle;
    font-size: 16px;
    color: #111;
}

.btn-main {
    background: #34A4E0;
    color: #fff;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 10px;
    transition: .25s;
}

.btn-main:hover {
    background: #1B8AC3;
    color: #fff;
}

.btn-outline-main {
    border: 2px solid #34A4E0;
    color: #34A4E0;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 10px;
    background: transparent;
    transition: .25s;
}

.btn-outline-main:hover {
    background: #34A4E0;
    color: #fff;
}

.total-price {
    font-size: 42px;
    font-weight: 800;
    color: #34A4E0;
}

.payment-option input {
    transform: scale(1.4);
}

.modal-content {
    border-radius: 16px;
    border: none;
}


.orders-empty-row {
    text-align: center;
    padding: 24px 14px;
    font-size: 14px;
    color: #cbd5e1;
}

@media (max-width: 768px) {
    .orders-wrapper {
        padding: 0 18px;
    }

    .orders-title {
        font-size: 26px;
    }

    .orders-table thead th {
        font-size: 11px;
        padding: 10px;
    }

    .orders-table td {
        padding: 12px 10px;
    }
}
/* page-header */
.page-header {
    height: 300px;
    background-image: url('/frontend/img/kick-offer-2.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;   /* 🔥 giữ ảnh đứng yên khi scroll */
    overflow: hidden;
    position: relative;
}

.header-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
}

.header-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;

    text-shadow:
        0 2px 6px rgba(0,0,0,0.45),
        0 0 12px rgba(255,255,255,0.15);

    z-index: 3;

    /* 🔥 Animation trượt từ dưới lên */
    animation: slideUp 0.9s ease-out forwards;
}

/* 🎬 Animation chạy từ dưới → lên */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translate(-50%, -20%); /* thấp hơn */
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%); /* vị trí chuẩn */
    }
}

/* ===========================
    NÚT ACTION CHUNG
=========================== */
.orders-action-link {
    display: inline-block;
    padding: 8px 14px;
    font-size: 13px;
    border-radius: 10px;
    border: 2px solid rgba(0,200,255,0.6);
    color: #0319e1;
    text-decoration: none;
    margin-right: 6px;
    transition: 0.25s;
    background: rgba(255,255,255,0.08);
}

.orders-action-link:hover {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    color: #fff;
}

/* ===========================
    NÚT HỦY ĐƠN
=========================== */
.orders-action-link--danger {
    border-color: rgba(255,60,60,0.7);
    color: #e63946;
    background: rgba(255,0,0,0.06);
}

.orders-action-link--danger:hover {
    background: linear-gradient(135deg, #ff4b4b, #ff1c3d);
    color: #fff !important;
    border-color: transparent;
    transform: translateY(-1px);
}

/* ===========================
    NÚT MUA LẠI
=========================== */
.orders-action-link--repurchase {
    border-color: rgba(255, 140, 0, 0.75);
    color: #ff8c00;
    background: rgba(255, 140, 0, 0.12);
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
}

.orders-action-link--repurchase:hover {
    background: linear-gradient(135deg, #ff8c00, #ff6b00);
    color: #fff !important;
    border-color: transparent;
    transform: translateY(-1px);
}

/* ===========================
    DANH SÁCH SẢN PHẨM TRONG ĐƠN
=========================== */
.order-products-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-width: 320px;
}

.order-product-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 10px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    border-left: 3px solid #ff8c00;
    transition: all 0.25s ease;
}

.order-product-item:hover {
    background: rgba(255, 140, 0, 0.08);
    transform: translateX(3px);
}

.product-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
    text-align: left;
}

.product-qty-badge {
    background: #ff8c00;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 12px;
    white-space: nowrap;
    margin-left: 8px;
}

</style>

<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>ĐƠN HÀNG</h1>
    </div>
</section>

<div class="orders-page">
    <div class="orders-wrapper">
        <div class="orders-heading">
            <h2 class="orders-title">Danh sách đơn hàng</h2>
            <p class="orders-subtitle">Theo dõi lịch sử mua hàng tại RISE FITNESS</p>
        </div>

        <div class="orders-card">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thanh toán</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao dự kiến</th>
                        <th>Trạng thái</th>
                        <th>Sản phẩm</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $i => $order)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td>
                                <span class="badge-payment">{{ $order->phuongthucthanhtoan }}</span>
                            </td>

                            <td>
                                {{ $order->ngaydathang
                                    ? \Carbon\Carbon::parse($order->ngaydathang)->format('d-m-Y')
                                    : '---' }}
                            </td>

                            <td>
                                {{ $order->ngaygiaohang
                                    ? \Carbon\Carbon::parse($order->ngaygiaohang)->format('d-m-Y')
                                    : '---' }}
                            </td>

                            <td>
                                @php
                                    $status = strtolower($order->trangthai);
                                @endphp

                                @php
                                    $statusClass = [
                                        'Chờ xác nhận' => 'badge-status--processing',
                                        'Chờ giao hàng' => 'badge-status--processing',

                                        'Đang giao hàng' => 'badge-status--shipping',


                                        'Hoàn thành' => 'badge-status--success',

                                        'Bị hủy' => 'badge-status--warning',
                                        'Thất bại' => 'badge-status--warning',
                                        'Chưa thanh toán' => 'badge-status--warning',
                                        'Đã thanh toán' => 'badge-status--success',
                                    ];

                                    $class = $statusClass[$order->trangthai] ?? '';
                                @endphp

                                <span class="badge-status {{ $class }}">
                                    {{ $order->trangthai }}
                                </span>

                            </td>

                            <td>
                                <div class="order-products-list">
                                    @if($order->details && $order->details->isNotEmpty())
                                        @foreach($order->details as $detail)
                                            <div class="order-product-item">
                                                <span class="product-name">{{ $detail->tensp }}</span>
                                                <span class="product-qty-badge">x{{ $detail->soluong }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <a href="{{ route('donhang.edit', ['id' => $order->id_dathang]) }}" 
                                class="orders-action-link">
                                    Xem chi tiết
                                </a>

                                @if($order->trangthai === 'Chờ xác nhận')
                                    <form action="{{ route('donhang.cancel', ['id' => $order->id_dathang]) }}" 
                                        method="POST" class="d-inline cancel-form">
                                        @csrf
                                        <button type="button" class="orders-action-link orders-action-link--danger btn-cancel-order">
                                            Hủy đơn
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($order->trangthai, ['Hoàn thành', 'Bị hủy', 'Thất bại']))
                                    <form action="{{ route('donhang.repurchase', ['id' => $order->id_dathang]) }}" 
                                        method="POST" class="d-inline repurchase-form">
                                        @csrf
                                        <button type="button" class="orders-action-link orders-action-link--repurchase btn-repurchase-order">
                                            Mua lại
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-white">
                                Bạn chưa có đơn hàng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-cancel-order').forEach(btn => {
        btn.addEventListener('click', function () {

            let form = this.closest('form');

            Swal.fire({
                title: "Bạn chắc chắn muốn hủy đơn?",
                text: "Đơn hàng sẽ bị hủy và không thể khôi phục!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e63946",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Hủy đơn",
                cancelButtonText: "Không"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

    document.querySelectorAll('.btn-repurchase-order').forEach(btn => {
        btn.addEventListener('click', function () {

            let form = this.closest('form');

            Swal.fire({
                title: "Mua lại đơn hàng?",
                text: "Toàn bộ sản phẩm trong đơn hàng cũ này sẽ được thêm vào giỏ hàng của bạn.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#34A4E0",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Đồng ý",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

});
</script>

@endsection
