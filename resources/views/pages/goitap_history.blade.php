@extends('layout')

@section('content')
<style>
    .rf-history-wrapper {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        min-height: 100vh;
        color: #f8fafc;
        padding: 80px 0;
    }

    .rf-glass-table-card {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        padding: 30px;
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

    .badge-cho_thanh_toan {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid #f59e0b;
    }

    .badge-da_thanh_toan {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid #3b82f6;
    }

    .badge-dang_tap {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid #10b981;
    }

    .badge-het_han {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid #ef4444;
    }

    .badge-da_huy {
        background: rgba(107, 114, 128, 0.2);
        color: #6b7280;
        border: 1px solid #6b7280;
    }

    .rf-table {
        color: #f8fafc;
        margin-bottom: 0;
    }

    .rf-table th {
        border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        color: #94a3b8;
    }

    .rf-table td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        vertical-align: middle;
        padding: 18px 12px;
        font-size: 15px;
    }

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

<div class="rf-history-wrapper">
    <div class="container">
        
        <div class="text-center mb-5">
            <h2 class="font-weight-extrabold text-white mb-2" style="font-size: 32px; letter-spacing: -0.5px;">GÓI TẬP CỦA TÔI</h2>
            <p class="text-muted" style="font-size: 16px;">Theo dõi tiến độ, thời hạn dịch vụ và huấn luyện viên đồng hành</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 p-3" style="border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #10b981;">
            <i class="bi bi-check-circle-fill mr-2"></i> {{ session('success') }}
        </div>
        @endif

        <div class="rf-glass-table-card">
            @if($registrations->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-journal-x" style="font-size: 60px; color: #64748b;"></i>
                <h4 class="text-white mt-3 font-weight-bold">Bạn chưa đăng ký gói tập nào</h4>
                <p class="text-muted">Khám phá ngay các lớp học đẳng cấp của chúng tôi để bắt đầu hành trình!</p>
                <a href="{{ url('/services') }}" class="btn btn-info px-4 py-2 mt-2" style="border-radius: 10px; font-weight: 700;">XEM CÁC GÓI DỊCH VỤ</a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table rf-table">
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
                            <td class="font-weight-bold text-info" style="font-size: 16px;">{{ $reg->ma_dang_ky }}</td>
                            <td>
                                <div class="font-weight-bold text-white">{{ $reg->packagePrice->goitap->ten_goi }}</div>
                                <span class="text-muted small">{{ $reg->packagePrice->goitap->mo_ta_ngan }}</span>
                            </td>
                            <td class="font-weight-bold">{{ $reg->packagePrice->so_thang }} Tháng</td>
                            <td class="font-weight-bold text-info" style="font-size: 16px;">{{ number_format($reg->tong_tien, 0, ',', '.') }} đ</td>
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
                            </td>
                            <td>
                                @if($reg->co_pt)
                                    @if($reg->pt)
                                        <div class="rf-pt-box">
                                            <div class="rf-pt-avatar">
                                                {{ substr($reg->pt->hoten, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-white">{{ $reg->pt->hoten }}</div>
                                                <span class="text-muted small">SĐT: 0{{ $reg->pt->sdt }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-warning small"><i class="bi bi-clock-history mr-1"></i> Chờ phân PT</span>
                                    @endif
                                @else
                                    <span class="text-muted small">Không kèm PT</span>
                                @endif
                            </td>
                            <td>
                                @if($reg->ngay_bat_dau && $reg->ngay_ket_thuc)
                                    <div class="small">
                                        <span class="text-muted">Bắt đầu:</span> <strong class="text-white">{{ $reg->ngay_bat_dau->format('d/m/Y') }}</strong><br>
                                        <span class="text-muted">Kết thúc:</span> <strong class="text-white">{{ $reg->ngay_ket_thuc->format('d/m/Y') }}</strong>
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
