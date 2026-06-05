@extends('pt_layout')

@section('pt_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Quản lý Khách Hàng</h3>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-4" id="ptTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-success" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-pane" type="button" role="tab" aria-controls="active-pane" aria-selected="true">
                <i class="bi bi-people-fill me-1"></i> Lớp học đang phụ trách ({{ $dangKys->where('trang_thai', 'dang_tap')->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold position-relative text-info" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-pane" type="button" role="tab" aria-controls="pending-pane" aria-selected="false">
                <i class="bi bi-bell-fill me-1"></i> Yêu cầu nhận lớp mới
                @php
                    $pendingCount = $dangKys->where('trang_thai', 'cho_pt_xac_nhan')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        {{ $pendingCount }}
                    </span>
                @endif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold position-relative text-warning" id="doipt-tab" data-bs-toggle="tab" data-bs-target="#doipt-pane" type="button" role="tab" aria-controls="doipt-pane" aria-selected="false">
                <i class="bi bi-arrow-repeat me-1"></i> Lời mời đổi PT
                @if($dangKysDoiPt->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        {{ $dangKysDoiPt->count() }}
                    </span>
                @endif
            </button>
        </li>
    </ul>

    <div class="tab-content" id="ptTabContent">
        {{-- Tab 1: Lớp học đang phụ trách --}}
        <div class="tab-pane fade show active" id="active-pane" role="tabpanel" aria-labelledby="active-tab" tabindex="0">
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
                                @forelse($dangKys->where('trang_thai', 'dang_tap') as $dangKy)
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
                                        <span class="badge bg-success">Đang tập luyện</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('pt.chiso.index', $dangKy->id) }}" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1" style="color: #10b981; border-color: #10b981;">
                                            <i class="bi bi-heart-pulse"></i> Quản lý Chỉ Số
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-people" style="font-size: 40px; color: #cbd5e1;"></i>
                                        <p class="text-muted mt-2">Chưa có học viên nào đang luyện tập với bạn.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab 2: Yêu cầu nhận lớp mới --}}
        <div class="tab-pane fade" id="pending-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Khách Hàng</th>
                                    <th>Liên Hệ</th>
                                    <th>Gói Tập</th>
                                    <th>Thời Gian Giao</th>
                                    <th>Trạng Thái</th>
                                    <th class="text-end pe-4">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dangKys->where('trang_thai', 'cho_pt_xac_nhan') as $dangKy)
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
                                        <div class="small">
                                            <div>{{ $dangKy->updated_at->format('d/m/Y H:i') }}</div>
                                            <div class="text-muted">({{ $dangKy->updated_at->diffForHumans() }})</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-white">Chờ bạn xác nhận</span>
                                    </td>
                                    <td class="text-end pe-4 d-flex justify-content-end gap-2">
                                        <form action="{{ route('pt.goitap.accept', $dangKy->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-check-circle"></i> Đồng ý nhận
                                            </button>
                                        </form>

                                        <button type="button" 
                                                class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 btn-reject"
                                                data-id="{{ $dangKy->id }}"
                                                data-name="{{ $dangKy->user->hoten }}"
                                                data-package="{{ $dangKy->packagePrice->goitap->ten_goi }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal">
                                            <i class="bi bi-x-circle"></i> Từ chối
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-bell" style="font-size: 40px; color: #cbd5e1;"></i>
                                        <p class="text-muted mt-2">Hiện tại không có yêu cầu nhận lớp mới nào.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- Tab 3: Lời mời đổi PT --}}
        <div class="tab-pane fade" id="doipt-pane" role="tabpanel" aria-labelledby="doipt-tab" tabindex="0">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Khách Hàng</th>
                                    <th>Liên Hệ</th>
                                    <th>Gói Tập</th>
                                    <th>PT Hiện Tại (Cũ)</th>
                                    <th>Thời Gian Mời</th>
                                    <th class="text-end pe-4">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dangKysDoiPt as $dangKy)
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
                                        @if($dangKy->pt)
                                            <div class="fw-bold text-dark">{{ $dangKy->pt->hoten }}</div>
                                            <div class="text-muted small">SĐT: 0{{ $dangKy->pt->sdt }}</div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div>{{ $dangKy->updated_at->format('d/m/Y H:i') }}</div>
                                            <div class="text-muted">({{ $dangKy->updated_at->diffForHumans() }})</div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4 d-flex justify-content-end gap-2">
                                        <form action="{{ route('pt.goitap.accept-doi-pt', $dangKy->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-check-circle"></i> Đồng ý tiếp nhận
                                            </button>
                                        </form>

                                        <button type="button" 
                                                class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 btn-reject-doipt"
                                                data-id="{{ $dangKy->id }}"
                                                data-name="{{ $dangKy->user->hoten }}"
                                                data-package="{{ $dangKy->packagePrice->goitap->ten_goi }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectDoiPtModal">
                                            <i class="bi bi-x-circle"></i> Từ chối
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-arrow-repeat" style="font-size: 40px; color: #cbd5e1;"></i>
                                        <p class="text-muted mt-2">Hiện không có lời mời đổi PT nào.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TỪ CHỐI NHẬN LỚP --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="rejectModalLabel">Từ Chối Nhận Lớp</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="rejectForm">
                @csrf
                <div class="modal-body p-4">
                    <p class="mb-3">Xác nhận từ chối nhận lớp cho học viên <strong class="text-danger" id="modalStudentName"></strong> - Gói tập <strong id="modalPackageName"></strong>.</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lý do từ chối nhận lớp <span class="text-danger">*</span></label>
                        <textarea name="ly_do_tu_choi" class="form-control" rows="3" placeholder="Nhập lý do từ chối cụ thể để gửi cho Admin (ví dụ: Bận lịch tập khác, quá tải học viên...)" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-danger">Xác Nhận Từ Chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnRejects = document.querySelectorAll('.btn-reject');
        const rejectForm = document.getElementById('rejectForm');
        const modalStudentName = document.getElementById('modalStudentName');
        const modalPackageName = document.getElementById('modalPackageName');

        btnRejects.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const packageName = this.dataset.package;

                rejectForm.action = `/pt/goitap/${id}/reject`;
                modalStudentName.innerText = name;
                modalPackageName.innerText = packageName;
            });
        });
    });
</script>

{{-- MODAL TỪ CHỐI ĐỔI PT --}}
<div class="modal fade" id="rejectDoiPtModal" tabindex="-1" aria-labelledby="rejectDoiPtModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="rejectDoiPtModalLabel">Từ Chối Tiếp Nhận Đổi PT</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="rejectDoiPtForm">
                @csrf
                <div class="modal-body p-4">
                    <p class="mb-3">Xác nhận từ chối tiếp nhận học viên <strong class="text-danger" id="modalDoiPtStudentName"></strong> - Gói tập <strong id="modalDoiPtPackageName"></strong>.</p>
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-1"></i> Học viên sẽ vẫn tiếp tục tập với PT hiện tại. Admin sẽ được thông báo để chọn PT khác.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea name="ly_do_tu_choi" class="form-control" rows="3" placeholder="Nhập lý do từ chối cụ thể..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-danger">Xác Nhận Từ Chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal từ chối đổi PT
        const btnRejectDoiPts = document.querySelectorAll('.btn-reject-doipt');
        const rejectDoiPtForm = document.getElementById('rejectDoiPtForm');
        const modalDoiPtStudentName = document.getElementById('modalDoiPtStudentName');
        const modalDoiPtPackageName = document.getElementById('modalDoiPtPackageName');

        btnRejectDoiPts.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const packageName = this.dataset.package;

                rejectDoiPtForm.action = `/pt/goitap/${id}/reject-doi-pt`;
                modalDoiPtStudentName.innerText = name;
                modalDoiPtPackageName.innerText = packageName;
            });
        });
    });
</script>
@endsection
