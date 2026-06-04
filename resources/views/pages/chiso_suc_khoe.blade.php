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
</style>

<div class="rf-history-wrapper">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <a href="{{ route('goitap.history') }}" class="btn btn-sm btn-outline-light mb-2"><i class="bi bi-arrow-left"></i> Lịch sử gói tập</a>
                <h2 class="font-weight-extrabold text-white mb-2" style="font-size: 32px; letter-spacing: -0.5px;">CHỈ SỐ SỨC KHỎE</h2>
                <p class="text-muted" style="font-size: 16px;">Theo dõi sự thay đổi cơ thể của bạn do PT ghi nhận</p>
            </div>
        </div>

        <div class="rf-glass-table-card">
            @if($chiSos->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-clipboard2-pulse" style="font-size: 60px; color: #64748b;"></i>
                <h4 class="text-white mt-3 font-weight-bold">Chưa có chỉ số nào được ghi nhận</h4>
                <p class="text-muted">Huấn luyện viên của bạn sẽ cập nhật chỉ số cơ thể sau mỗi buổi đo lường.</p>
            </div>
            @else
            <div class="row">
                @foreach($chiSos as $chiso)
                <div class="col-md-6 mb-4">
                    <div class="card bg-dark border-secondary" style="border-radius: 15px;">
                        <div class="card-header border-secondary d-flex justify-content-between align-items-center pb-2 pt-3">
                            <h5 class="text-info font-weight-bold mb-0">
                                <i class="bi bi-calendar-check me-2"></i> {{ $chiso->ngay_ghi_nhan->format('d/m/Y') }}
                            </h5>
                            <span class="badge bg-secondary">PT: {{ $chiso->pt->hoten }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-4 border-end border-secondary">
                                    <div class="text-muted small">Cân nặng</div>
                                    <div class="text-white font-weight-bold" style="font-size: 1.2rem;">{{ $chiso->can_nang }} <small>kg</small></div>
                                </div>
                                <div class="col-4 border-end border-secondary">
                                    <div class="text-muted small">Chiều cao</div>
                                    <div class="text-white font-weight-bold" style="font-size: 1.2rem;">{{ $chiso->chieu_cao }} <small>cm</small></div>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted small">BMI</div>
                                    @php
                                        $bmi = $chiso->chi_so_bmi;
                                        $bmiColor = '#10b981'; // Xanh
                                        if ($bmi < 18.5) $bmiColor = '#f59e0b'; // Vàng
                                        elseif ($bmi >= 25) $bmiColor = '#ef4444'; // Đỏ
                                    @endphp
                                    <div class="font-weight-bold" style="font-size: 1.2rem; color: {{ $bmiColor }};">{{ $bmi }}</div>
                                </div>
                            </div>
                            
                            <div class="row text-center mb-3 bg-dark p-2 rounded" style="background: rgba(0,0,0,0.3) !important;">
                                <div class="col-6 border-end border-secondary">
                                    <div class="text-muted small">Lượng mỡ</div>
                                    <div class="text-white">{{ $chiso->luong_mo ?? '--' }} %</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Lượng nước</div>
                                    <div class="text-white">{{ $chiso->luong_nuoc ?? '--' }} %</div>
                                </div>
                            </div>

                            @if($chiso->thoi_quen_song)
                            <div class="mb-2">
                                <strong class="text-info small">Chế độ ăn & Thói quen:</strong>
                                <p class="text-light small mb-1">{{ $chiso->thoi_quen_song }}</p>
                            </div>
                            @endif

                            @if($chiso->nhac_nho)
                            <div>
                                <strong class="text-warning small"><i class="bi bi-exclamation-triangle"></i> PT Nhắc nhở:</strong>
                                <p class="text-light small mb-0">{{ $chiso->nhac_nho }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
