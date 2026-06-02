@extends('layout')
@section('content')

<style>
    .success-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        min-height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 15px;
    }

    .success-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.6);
        width: 100%;
        max-width: 650px;
        text-align: center;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon-wrapper {
        width: 80px;
        height: 80px;
        background: #dcfce7;
        color: #22c55e;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 24px auto;
        font-size: 40px;
        animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-title {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 8px;
    }

    .success-desc {
        font-size: 15px;
        color: #4b5563;
        margin-bottom: 30px;
    }

    .order-info-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        text-align: left;
        margin-bottom: 30px;
    }

    .order-info-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-label {
        color: #64748b;
        font-weight: 500;
    }

    .info-val {
        color: #0f172a;
        font-weight: 700;
    }

    .guest-warning-alert {
        background: #fff7ed;
        border: 1px solid #ffedd5;
        border-left: 5px solid #f97316;
        border-radius: 12px;
        padding: 16px;
        text-align: left;
        margin-bottom: 30px;
        display: flex;
        gap: 12px;
    }

    .guest-warning-icon {
        color: #f97316;
        font-size: 20px;
        margin-top: 2px;
    }

    .guest-warning-text {
        font-size: 13.5px;
        color: #7c2d12;
        line-height: 1.5;
    }

    .guest-warning-text strong {
        color: #ea580c;
    }

    .btn-group-success {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-success-premium {
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-success-primary {
        background: linear-gradient(135deg, #34A4E0 0%, #1d4ed8 100%);
        color: #fff;
        border: none;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-success-primary:hover {
        background: linear-gradient(135deg, #1B8AC3 0%, #1e40af 100%);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-success-secondary {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .btn-success-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
        transform: translateY(-2px);
    }
</style>

<div class="success-section">
    <div class="success-card">
        <div class="success-icon-wrapper">
            <i class="bi bi-check2-circle"></i>
        </div>

        <h1 class="success-title">Đặt hàng thành công!</h1>
        <p class="success-desc">Cảm ơn bạn đã tin tưởng lựa chọn Rise Fitness. Đơn hàng của bạn đang được xử lý.</p>

        @if(isset($order))
            <div class="order-info-box">
                <div class="order-info-title">
                    <i class="bi bi-receipt"></i> Chi tiết đơn hàng
                </div>
                <div class="info-row">
                    <span class="info-label">Mã đơn hàng:</span>
                    <span class="info-val text-primary" style="font-size: 16px;">#{{ $order->id_dathang }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Khách hàng nhận:</span>
                    <span class="info-val">{{ $order->hoten }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-val">0{{ ltrim($order->sdt, '0') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tổng thanh toán:</span>
                    <span class="info-val text-danger" style="font-size: 15px;">{{ number_format($order->tienphaitra) }}đ</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phương thức:</span>
                    <span class="info-val">{{ $order->phuongthucthanhtoan }}</span>
                </div>
            </div>

            @if(!Auth::check())
                <div class="guest-warning-alert">
                    <div class="guest-warning-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="guest-warning-text">
                        <strong>Lưu ý quan trọng cho Khách vãng lai:</strong> <br>
                        Vui lòng lưu lại <strong>Mã đơn hàng (#{{ $order->id_dathang }})</strong> và <strong>Số điện thoại (0{{ ltrim($order->sdt, '0') }})</strong> để có thể tra cứu hành trình và trạng thái đơn hàng của bạn.
                    </div>
                </div>
            @endif
        @endif

        <div class="btn-group-success">
            @if(Auth::check())
                <a href="{{ URL::to('/donhang') }}" class="btn-success-premium btn-success-primary">
                    <i class="bi bi-box-seam"></i> Quản lý đơn hàng
                </a>
            @else
                <a href="{{ URL::to('/tra-cuu-don-hang') }}" class="btn-success-premium btn-success-primary">
                    <i class="bi bi-search"></i> Tra cứu đơn hàng
                </a>
            @endif
            <a href="{{ URL::to('/') }}" class="btn-success-premium btn-success-secondary">
                <i class="bi bi-house-door"></i> Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>

@endsection
