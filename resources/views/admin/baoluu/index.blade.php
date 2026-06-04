@extends('admin_layout')

@section('admin_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Quản Lý Yêu Cầu Bảo Lưu</h3>
        
        {{-- Bộ lọc trạng thái --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.yeucau-baoluu.index') }}" class="btn btn-sm btn-outline-secondary {{ !request('trang_thai') ? 'active' : '' }}">Tất cả</a>
            <a href="{{ route('admin.yeucau-baoluu.index', ['trang_thai' => 'cho_duyet']) }}" class="btn btn-sm btn-outline-warning {{ request('trang_thai') == 'cho_duyet' ? 'active' : '' }}">Chờ duyệt</a>
            <a href="{{ route('admin.yeucau-baoluu.index', ['trang_thai' => 'da_duyet']) }}" class="btn btn-sm btn-outline-success {{ request('trang_thai') == 'da_duyet' ? 'active' : '' }}">Đang bảo lưu</a>
            <a href="{{ route('admin.yeucau-baoluu.index', ['trang_thai' => 'da_kich_hoat_lai']) }}" class="btn btn-sm btn-outline-info {{ request('trang_thai') == 'da_kich_hoat_lai' ? 'active' : '' }}">Đã kích hoạt lại</a>
            <a href="{{ route('admin.yeucau-baoluu.index', ['trang_thai' => 'tu_choi']) }}" class="btn btn-sm btn-outline-danger {{ request('trang_thai') == 'tu_choi' ? 'active' : '' }}">Từ chối</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Thành công!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong>Thất bại!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Mã Đăng Ký</th>
                            <th>Khách Hàng</th>
                            <th>Ngày Bắt Đầu</th>
                            <th>Số Ngày Bảo Lưu</th>
                            <th>Lý Do Bảo Lưu</th>
                            <th>Trạng Thái</th>
                            <th>Thông Tin Thêm</th>
                            <th class="text-end pe-4">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $req->dangKyGoiTap->ma_dang_ky }}</td>
                            <td>
                                <div class="fw-bold">{{ $req->khachHang->hoten }}</div>
                                <div class="text-muted small">SĐT: 0{{ $req->khachHang->sdt }}</div>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $req->ngay_bat_dau_baoluu ? $req->ngay_bat_dau_baoluu->format('d/m/Y') : 'N/A' }}</span>
                            </td>
                            <td class="fw-bold text-dark">{{ $req->so_ngay_baoluu }} ngày</td>
                            <td>
                                <span class="text-wrap d-block" style="max-width: 250px; white-space: normal;">
                                    {{ $req->ly_do }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusBadges = [
                                        'cho_duyet' => 'bg-warning text-dark',
                                        'da_duyet' => 'bg-success text-white',
                                        'da_kich_hoat_lai' => 'bg-info text-white',
                                        'tu_choi' => 'bg-danger text-white'
                                    ];
                                    $statusLabels = [
                                        'cho_duyet' => 'Chờ duyệt',
                                        'da_duyet' => 'Đang bảo lưu',
                                        'da_kich_hoat_lai' => 'Đã kích hoạt lại',
                                        'tu_choi' => 'Từ chối'
                                    ];
                                @endphp
                                <span class="badge {{ $statusBadges[$req->trang_thai] ?? 'bg-secondary' }}">
                                    {{ $statusLabels[$req->trang_thai] ?? $req->trang_thai }}
                                </span>
                            </td>
                            <td>
                                @if($req->trang_thai == 'tu_choi')
                                    <div class="small text-danger text-wrap" style="max-width: 200px; white-space: normal;">
                                        <span class="text-muted">Lý do:</span> {{ $req->ly_do_tu_choi }}
                                    </div>
                                @elseif($req->trang_thai == 'da_kich_hoat_lai')
                                    <div class="small text-success">
                                        <span class="text-muted">Đã kích hoạt lại</span>
                                    </div>
                                @elseif($req->trang_thai == 'da_duyet')
                                    <div class="small text-muted">
                                        Số ngày còn lại: <strong>{{ $req->so_ngay_con_lai_truoc_baoluu }} ngày</strong>
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($req->trang_thai == 'cho_duyet')
                                <div class="d-flex gap-1 justify-content-end">
                                    <form action="{{ route('admin.yeucau-baoluu.approve', $req->id) }}" method="POST" class="d-inline approve-baoluu-form">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-check-circle"></i> Duyệt
                                        </button>
                                    </form>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 btn-reject-bl"
                                            data-id="{{ $req->id }}"
                                            data-code="{{ $req->dangKyGoiTap->ma_dang_ky }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectBLModal">
                                        <i class="bi bi-x-circle"></i> Từ chối
                                    </button>
                                </div>
                                @elseif($req->trang_thai == 'da_duyet')
                                <form action="{{ route('admin.yeucau-baoluu.resume', $req->id) }}" method="POST" class="d-inline resume-baoluu-form">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-play-circle"></i> Kích hoạt lại tại quầy
                                    </button>
                                </form>
                                @else
                                <span class="text-muted small">Đã xử lý</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-journal-x" style="font-size: 40px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2">Không tìm thấy yêu cầu bảo lưu nào.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($requests->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $requests->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL TỪ CHỐI BẢO LƯU --}}
<div class="modal fade" id="rejectBLModal" tabindex="-1" aria-labelledby="rejectBLModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="rejectBLModalLabel">Từ Chối Yêu Cầu Bảo Lưu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="rejectBLForm">
                @csrf
                <div class="modal-body p-4">
                    <p>Mã đăng ký: <strong class="text-primary" id="modalRejectBLRegCode"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea name="ly_do_tu_choi" class="form-control" rows="3" placeholder="Nhập lý do từ chối bảo lưu..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Từ chối bảo lưu
        const btnRejects = document.querySelectorAll('.btn-reject-bl');
        const rejectBLForm = document.getElementById('rejectBLForm');
        const modalRejectBLRegCode = document.getElementById('modalRejectBLRegCode');

        btnRejects.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const code = this.dataset.code;

                rejectBLForm.action = `/admin/yeucau-baoluu/${id}/reject`;
                modalRejectBLRegCode.innerText = code;
            });
        });

        // Xác nhận duyệt bảo lưu
        const approveForms = document.querySelectorAll('.approve-baoluu-form');
        approveForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Duyệt yêu cầu bảo lưu?',
                    text: "Bạn có chắc chắn muốn phê duyệt yêu cầu bảo lưu này không? Gói tập của khách hàng sẽ được tạm dừng.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Đồng ý duyệt',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Xác nhận kích hoạt lại tại quầy
        const resumeForms = document.querySelectorAll('.resume-baoluu-form');
        resumeForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Kích hoạt lại gói tập tại quầy?',
                    text: "Xác nhận kích hoạt lại gói tập cho khách hàng ngay bây giờ? Gói tập sẽ được chuyển về Đang hoạt động.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0dcaf0',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Kích hoạt lại',
                    cancelButtonText: 'Hủy'
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
