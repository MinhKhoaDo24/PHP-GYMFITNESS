@extends('layout')

@section('content')
<style>
    /* page-header */
    .page-header {
        height: 300px;
        background-image: url('/frontend/img/kick-offer-2.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
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
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.45), 0 0 12px rgba(255, 255, 255, 0.15);
        z-index: 3;
        animation: slideUp 0.9s ease-out forwards;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translate(-50%, -20%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }

    .history-page {
        padding: 40px 0 80px;
        background: #f1f5f9;
        width: 100%;
        min-height: 100vh;
    }

    .history-wrapper {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .history-card {
        background: transparent;
        border-radius: 0;
        box-shadow: none;
        padding: 0;
        width: 100%;
    }

    .history-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
    }

    .history-table thead tr {
        background: #1e293b;
    }

    .history-table thead th {
        padding: 16px 20px;
        font-size: 13px;
        letter-spacing: .05em;
        font-weight: 700;
        text-transform: uppercase;
        color: #f8fafc;
        border-bottom: none;
        white-space: nowrap;
    }

    .history-table tbody tr {
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .history-table tbody tr:hover {
        background: #f8fafc;
    }

    .history-table tbody tr+tr td {
        border-top: 1px solid #f1f5f9;
    }

    .history-table tbody td {
        padding: 20px;
        vertical-align: middle;
        font-size: 15px;
        color: #334155;
    }

    .rf-badge-status {
        padding: 6px 14px;
        border-radius: 99px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .badge-cho_thanh_toan { background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid #f59e0b; }
    .badge-da_thanh_toan { background: rgba(59, 130, 246, 0.15); color: #2563eb; border: 1px solid #3b82f6; }
    .badge-dang_tap { background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid #10b981; }
    .badge-het_han { background: rgba(239, 68, 68, 0.15); color: #dc2626; border: 1px solid #ef4444; }
    .badge-da_huy { background: rgba(107, 114, 128, 0.15); color: #4b5563; border: 1px solid #6b7280; }

    .rf-pt-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rf-pt-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #34A4E0;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }
</style>

<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>GÓI TẬP CỦA TÔI</h1>
    </div>
</section>

<div class="history-page">
    <div class="history-wrapper">
        <div class="text-center mb-5">
            <h2 class="font-weight-extrabold mb-2" style="font-size: 32px; letter-spacing: -0.5px; color: #0f172a;">LỊCH SỬ GÓI TẬP</h2>
            <p class="text-muted" style="font-size: 16px;">Theo dõi tiến độ, thời hạn dịch vụ và huấn luyện viên đồng hành</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 p-3" style="border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #059669;">
            <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="history-card">
            @if($registrations->isEmpty())
            <div class="text-center py-5 bg-white" style="border-radius: 16px; border: 1px solid #e2e8f0;">
                <i class="bi bi-journal-x" style="font-size: 60px; color: #94a3b8;"></i>
                <h4 class="mt-3 font-weight-bold" style="color: #334155;">Bạn chưa đăng ký gói tập nào</h4>
                <p class="text-muted">Khám phá ngay các lớp học đẳng cấp của chúng tôi để bắt đầu hành trình!</p>
                <a href="{{ url('/services') }}" class="btn btn-info px-4 py-2 mt-2" style="border-radius: 10px; font-weight: 700; background-color: #34A4E0; border-color: #34A4E0;">XEM CÁC GÓI DỊCH VỤ</a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table history-table">
                    <thead>
                        <tr>
                            <th>Mã Đăng Ký</th>
                            <th>Gói Tập</th>
                            <th>Thời Hạn</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Huấn Luyện Viên (PT)</th>
                            <th>Ngày Tập</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $reg)
                        <tr>
                            <td class="font-weight-bold text-info" style="font-size: 16px; color: #34A4E0 !important;">{{ $reg->ma_dang_ky }}</td>
                            <td>
                                <div class="font-weight-bold" style="color: #0f172a;">{{ $reg->packagePrice->goitap->ten_goi }}</div>
                                <span class="text-muted small">{{ $reg->packagePrice->goitap->mo_ta_ngan }}</span>
                            </td>
                            <td class="font-weight-bold">{{ $reg->packagePrice->so_thang }} Tháng</td>
                            <td class="font-weight-bold text-info" style="font-size: 16px; color: #34A4E0 !important;">{{ number_format($reg->tong_tien, 0, ',', '.') }} đ</td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'cho_thanh_toan' => 'Chờ thanh toán',
                                        'da_thanh_toan' => 'Đã thanh toán',
                                        'dang_tap' => 'Đang tập luyện',
                                        'het_han' => 'Đã hết hạn',
                                        'da_huy' => 'Đã hủy'
                                    ];
                                @endphp
                                <span class="rf-badge-status badge-{{ $reg->trang_thai }}">
                                    {{ $statusLabels[$reg->trang_thai] ?? $reg->trang_thai }}
                                </span>
                                @if($reg->trang_thai == 'dang_tap' && $reg->co_pt)
                                    <div class="mt-2">
                                        <a href="{{ route('chiso.index') }}" class="btn btn-sm btn-outline-info" style="font-size: 11px; padding: 2px 8px; border-radius: 6px;">
                                            <i class="bi bi-heart-pulse"></i> Xem tình trạng sức khỏe tập luyện
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($reg->co_pt)
                                    @if($reg->pt)
                                        <div class="rf-pt-box">
                                            <div class="rf-pt-avatar">
                                                {{ substr($reg->pt->hoten, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold" style="color: #0f172a;">{{ $reg->pt->hoten }}</div>
                                                <span class="text-muted small">SĐT: 0{{ $reg->pt->sdt }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-warning small" style="color: #d97706 !important;"><i class="bi bi-clock-history mr-1"></i> Chờ phân PT</span>
                                    @endif
                                @else
                                    <span class="text-muted small">Không kèm PT</span>
                                @endif
                            </td>
                            <td>
                                @if($reg->ngay_bat_dau && $reg->ngay_ket_thuc)
                                    <div class="small">
                                        <span class="text-muted">Bắt đầu:</span> <strong style="color: #0f172a;">{{ $reg->ngay_bat_dau->format('d/m/Y') }}</strong><br>
                                        <span class="text-muted">Kết thúc:</span> <strong style="color: #0f172a;">{{ $reg->ngay_ket_thuc->format('d/m/Y') }}</strong>
                                    </div>
                                @else
                                    <span class="text-muted small">Chờ kích hoạt</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
