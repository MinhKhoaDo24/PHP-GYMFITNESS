@extends('layout')
@section('content')

<style>
    .order-bg {
    background-image: url('/frontend/img/boxing-slide-1.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;  /* đứng yên */
    }

    .order-container {
        padding: 10px 0;
    }

    .page-title {
        font-size: 30px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 25px;
    }

    /* ===== CARD ===== */
    .card-clean {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 30px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 16px;
    }

    .info-label {
        color: #6B7280;
        font-weight: 600;
    }

    .info-value {
        color: #111827;
        font-weight: 600;
    }

    /* ===== TABLE ===== */
    .table-order th {
        background: #34A4E0;
        color: #fff;
        text-transform: uppercase;
        font-size: 13px;
    }

    .table-order td {
        background: #fff;
        color: #111;
        vertical-align: middle;
    }

    .badge-status {
        padding: 4px 6px;
        font-size: 14px;
        border-radius: 9px;
        background: #0319e1ff;
        color: #f4f4f4ff;
    }


    /* ===== BUTTON ===== */
    .btn-main {
        background: #34A4E0;
        color: #fff;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
    }

    .btn-main:hover {
        background: #1B8AC3;
        color: #fff;
    }

    .btn-outline-main {
        border: 2px solid #34A4E0;
        color: #34A4E0;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-outline-main:hover {
        background: #34A4E0;
        color: #fff;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 14px;
        border: none;
        padding: 10px 15px;
    }
    .totals-wrapper {
    display: flex;
    justify-content: space-between;
    gap: 18px;
    margin-top: 25px;
    flex-wrap: wrap;
}

.total-card {
    flex: 1;
    min-width: 250px;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 22px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    border-left: 6px solid #34A4E0;
}

.total-card.discount-card {
    border-left-color: #ef4444;
}

.total-card.final-card {
    border-left-color: #16a34a;
}

.total-title {
    font-size: 16px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}

.total-value {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
}

.big-price {
    font-size: 24px;
    color: #16a34a;
    font-weight: 700;
}

.badge-status {
    display: inline-block;
    padding: 4px 6px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
}

/* Chờ xác nhận - vàng */
.badge-status--processing {
    background: #F2C34B;
    color: #fff;
}

/* Chờ giao hàng - xanh dương nhạt */
.badge-status--shipping {
    background: #1ba8efff;
    color: #fff;
}

/* Hoàn thành - xanh lá */
.badge-status--success {
    background: #34D399;
    color: #fff;
}

/* Bị hủy - đỏ */
.badge-status--danger {
    background: #F87171;
    color: #fff;
}

</style>

<div class="order-bg">
    <div class="container order-container">

        {{-- PAGE TITLE --}}
        <h1 class="page-title">Chi tiết đơn hàng</h1>


        {{-- ===== KHÁCH HÀNG ===== --}}
        <div class="card-clean">
            <div class="section-title">Thông tin khách hàng</div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <div><span class="info-label">Khách hàng:</span> 
                        <span class="info-value">{{ $order->hoten }}</span></div>
                    <div><span class="info-label">Email:</span> 
                        <span class="info-value">{{ $order->email }}</span></div>
                </div>

                <div class="col-md-6 mb-2">
                    <div><span class="info-label">Số điện thoại:</span> 
                        <span class="info-value">0{{ $order->sdt }}</span></div>
                    <div><span class="info-label">Địa chỉ:</span> 
                        <span class="info-value">{{ $order->diachigiaohang }}</span></div>
                </div>
            </div>

        </div>


        {{-- ===== ĐƠN HÀNG ===== --}}
        <div class="card-clean">
            <div class="section-title">Thông tin đơn hàng</div>

            <table class="table table-borderless">
                <tr>
                    <td class="info-label">Ngày đặt</td>
                    <td class="info-value">{{ date('d/m/Y H:i', strtotime($order->ngaydathang)) }}</td>
                </tr>

                <tr>
                    <td class="info-label">Ngày giao</td>
                    <td class="info-value">{{ date('d/m/Y', strtotime($order->ngaygiaohang)) }}</td>
                </tr>

                <tr>
                    <td class="info-label">Mã khuyến mãi</td>
                    <td class="info-value" style='color:red;'>
                        {{ $order->khuyenmai->ma_code ?? 'Không áp dụng' }}
                    </td>
                </tr>

                <tr>
                    <td class="info-label">Phương thức thanh toán</td>
                    <td><span class="badge-status bg-primary">{{ $order->phuongthucthanhtoan }}</span></td>
                </tr>
                

                @php

                    $status = strtolower($order->trangthai);

                    $badgeClass = match ($status) {
                        'chờ xác nhận', 'chờ giao hàng'      => 'badge-status--processing',
                        'Đang giao hàng'                     => 'badge-status--shipping',
                        'hoàn thành'                         => 'badge-status--success',
                        'Bị hủy', 'Thất bại'                 => 'badge-status--danger',
                        default                              => '',
                    };
                @endphp

                <tr>
                    <td class="info-label">Trạng thái</td>
                    <td>
                        <span class="badge-status {{ $badgeClass }}">
                            {{ ucfirst($order->trangthai) }}
                        </span>
                    </td>
                </tr>

            </table>
        </div>


        {{-- ===== SẢN PHẨM ===== --}}
        <div class="card-clean">
            <div class="section-title">Sản phẩm đã mua</div>

            <table class="table table-order table-hover">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá gốc</th>
                        <th>Giảm</th>
                        <th>Giá khuyến mại</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>

                <tbody>
                    @php $total = 0; @endphp
                    @foreach($orderdetails as $od)
                        @php 
                            $line = $od->giakhuyenmai * $od->soluong;
                        @endphp

                        <tr>
                            <td>{{ $od->tensp }}</td>
                            <td>{{ $od->soluong }}</td>
                            <td>{{ number_format($od->giatien) }}đ</td>
                            <td>{{ $od->giamgia }}%</td>
                            <td>{{ number_format($od->giakhuyenmai) }}đ</td>
                            <td>{{ number_format($line) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="totals-wrapper">

            {{-- Tổng tiền hàng --}}
            <div class="total-card">
                <div class="total-title">Tổng tiền hàng</div>
                <div class="total-value">{{ number_format($order->tongtien) }} VND</div>
            </div>

            {{-- Giảm giá --}}
            <div class="total-card discount-card">
                <div class="total-title">Giảm giá</div>
                <div class="total-value text-danger">- {{ number_format($order->tiengiam) }} VND</div>
            </div>

            {{-- Tổng phải trả --}}
            <div class="total-card final-card">
                <div class="total-title">Tổng thanh toán</div>
                <div class="total-value big-price">{{ number_format($order->tienphaitra) }} VND</div>
            </div>

        </div>


        <a href="{{ URL::to('/donhang') }}" class="btn btn-outline-main mt-4">← Quay lại</a>

    </div>
</div>

@endsection
