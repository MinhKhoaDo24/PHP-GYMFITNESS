@extends('pt_layout')

@section('pt_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Quản lý Khách Hàng</h3>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Khách Hàng</th>
                            <th>Liên Hệ</th>
                            <th>Gói Tập</th>
                            <th>Thời Hạn</th>
                            <th>Trạng Thái</th>
                            <th class="text-end pe-4">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dangKys as $dangKy)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $dangKy->user->hoten }}</div>
                                <div class="text-muted small">Mã: {{ $dangKy->ma_dang_ky }}</div>
                            </td>
                            <td>
                                <div><i class="bi bi-telephone-fill text-muted me-1"></i> 0{{ $dangKy->user->sdt }}</div>
                                <div><i class="bi bi-envelope-fill text-muted me-1"></i> {{ $dangKy->user->email }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $dangKy->packagePrice->goitap->ten_goi }}</div>
                                <span class="badge bg-light text-dark border">{{ $dangKy->packagePrice->so_thang }} Tháng</span>
                            </td>
                            <td>
                                @if($dangKy->ngay_bat_dau)
                                    {{ $dangKy->ngay_bat_dau->format('d/m/Y') }} - {{ $dangKy->ngay_ket_thuc->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">Chưa kích hoạt</span>
                                @endif
                            </td>
                            <td>
                                @if($dangKy->trang_thai == 'dang_tap')
                                    <span class="badge bg-success">Đang tập luyện</span>
                                @elseif($dangKy->trang_thai == 'cho_thanh_toan' || $dangKy->trang_thai == 'da_thanh_toan')
                                    <span class="badge bg-warning text-dark">Chờ kích hoạt</span>
                                @else
                                    <span class="badge bg-secondary">Hết hạn/Đã hủy</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($dangKy->trang_thai == 'dang_tap')
                                <a href="{{ route('pt.chiso.index', $dangKy->id) }}" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1" style="color: #10b981; border-color: #10b981;">
                                    <i class="bi bi-heart-pulse"></i> Quản lý Chỉ Số
                                </a>
                                @else
                                <span class="text-muted small">Cần kích hoạt</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-people" style="font-size: 40px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2">Chưa có khách hàng nào được phân công cho bạn.</p>
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
