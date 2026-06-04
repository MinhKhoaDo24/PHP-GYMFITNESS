@extends('pt_layout')

@section('pt_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('pt.khachhang') }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i> Quay lại</a>
            <h3 class="fw-bold mb-0">Chỉ Số Sức Khỏe: {{ $dangKy->user->hoten }}</h3>
            <p class="text-muted mb-0">Gói tập: {{ $dangKy->packagePrice->goitap->ten_goi }} ({{ $dangKy->packagePrice->so_thang }} tháng)</p>
        </div>
        <a href="{{ route('pt.chiso.create', $dangKy->id) }}" class="btn btn-success d-inline-flex align-items-center gap-1" style="background: #10b981; border-color: #10b981;">
            <i class="bi bi-plus-lg"></i> Thêm chỉ số mới
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Thành công!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Ngày Ghi Nhận</th>
                            <th>Chiều Cao / Cân Nặng</th>
                            <th>Lượng Mỡ / Nước</th>
                            <th>BMI</th>
                            <th>Thói Quen Sống</th>
                            <th>Nhắc Nhở</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chiSos as $chiso)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $chiso->ngay_ghi_nhan->format('d/m/Y') }}</td>
                            <td>
                                <div><span class="text-muted">Cao:</span> {{ $chiso->chieu_cao }} cm</div>
                                <div><span class="text-muted">Nặng:</span> <strong class="text-primary">{{ $chiso->can_nang }} kg</strong></div>
                            </td>
                            <td>
                                <div><span class="text-muted">Mỡ:</span> {{ $chiso->luong_mo ?? '--' }} %</div>
                                <div><span class="text-muted">Nước:</span> {{ $chiso->luong_nuoc ?? '--' }} %</div>
                            </td>
                            <td>
                                @php
                                    $bmi = $chiso->chi_so_bmi;
                                    $bmiClass = 'bg-success';
                                    if ($bmi < 18.5) $bmiClass = 'bg-warning text-dark';
                                    elseif ($bmi >= 25) $bmiClass = 'bg-danger';
                                @endphp
                                <span class="badge {{ $bmiClass }} fs-6">{{ $bmi }}</span>
                            </td>
                            <td style="white-space: normal; min-width: 200px;">
                                <small class="text-muted">{{ $chiso->thoi_quen_song ?? 'Không có ghi chú' }}</small>
                            </td>
                            <td style="white-space: normal; min-width: 200px;">
                                <small class="text-danger">{{ $chiso->nhac_nho ?? 'Không có nhắc nhở' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-clipboard2-pulse" style="font-size: 40px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2">Chưa có dữ liệu chỉ số sức khỏe nào được ghi nhận.</p>
                                <a href="{{ route('pt.chiso.create', $dangKy->id) }}" class="btn btn-sm btn-outline-success mt-2">
                                    Thêm chỉ số đầu tiên
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
