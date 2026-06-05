@extends('admin_layout')

@section('admin_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Quản Lý Yêu Cầu Đổi PT</h3>
        
        {{-- Bộ lọc trạng thái --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.yeucau-doipt.index') }}" class="btn btn-sm btn-outline-secondary {{ !request('trang_thai') ? 'active' : '' }}">Tất cả</a>
            <a href="{{ route('admin.yeucau-doipt.index', ['trang_thai' => 'cho_xu_ly']) }}" class="btn btn-sm btn-outline-warning {{ request('trang_thai') == 'cho_xu_ly' ? 'active' : '' }}">Chờ xử lý</a>
            <a href="{{ route('admin.yeucau-doipt.index', ['trang_thai' => 'cho_pt_moi_xac_nhan']) }}" class="btn btn-sm btn-outline-info {{ request('trang_thai') == 'cho_pt_moi_xac_nhan' ? 'active' : '' }}">Chờ xác nhận</a>
            <a href="{{ route('admin.yeucau-doipt.index', ['trang_thai' => 'da_duyet']) }}" class="btn btn-sm btn-outline-success {{ request('trang_thai') == 'da_duyet' ? 'active' : '' }}">Đã duyệt</a>
            <a href="{{ route('admin.yeucau-doipt.index', ['trang_thai' => 'tu_choi']) }}" class="btn btn-sm btn-outline-danger {{ request('trang_thai') == 'tu_choi' ? 'active' : '' }}">Từ chối</a>
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
                            <th>PT Hiện Tại (Cũ)</th>
                            <th>Lý Do Đổi</th>
                            <th>Ghi Chú Chi Tiết</th>
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
                                <div class="fw-bold">{{ $req->ptCu->hoten }}</div>
                                <div class="text-muted small">SĐT: 0{{ $req->ptCu->sdt }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $req->ly_do }}</span>
                            </td>
                            <td>
                                <span class="text-wrap d-block" style="max-width: 250px; white-space: normal;">
                                    {{ $req->ghi_chu ?: 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusBadges = [
                                        'cho_xu_ly' => 'bg-warning text-dark',
                                        'cho_pt_moi_xac_nhan' => 'bg-info text-white',
                                        'da_duyet' => 'bg-success text-white',
                                        'tu_choi' => 'bg-danger text-white'
                                    ];
                                    $statusLabels = [
                                        'cho_xu_ly' => 'Chờ xử lý',
                                        'cho_pt_moi_xac_nhan' => 'Chờ xác nhận',
                                        'da_duyet' => 'Đã đổi PT',
                                        'tu_choi' => 'Từ chối'
                                    ];
                                @endphp
                                <span class="badge {{ $statusBadges[$req->trang_thai] ?? 'bg-secondary' }}">
                                    {{ $statusLabels[$req->trang_thai] ?? $req->trang_thai }}
                                </span>
                            </td>
                            <td>
                                @if(($req->trang_thai == 'da_duyet' || $req->trang_thai == 'cho_pt_moi_xac_nhan') && $req->ptMoi)
                                    <div class="small">
                                        <span class="text-muted">PT Mới:</span> <strong>{{ $req->ptMoi->hoten }}</strong>
                                    </div>
                                @elseif($req->trang_thai == 'tu_choi')
                                    <div class="small text-danger text-wrap" style="max-width: 200px; white-space: normal;">
                                        <span class="text-muted">Lý do:</span> {{ $req->ly_do_tu_choi }}
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($req->trang_thai == 'cho_xu_ly')
                                <div class="d-flex gap-1 justify-content-end">
                                    <button type="button" 
                                            class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 btn-accept-pt"
                                            data-id="{{ $req->id }}"
                                            data-code="{{ $req->dangKyGoiTap->ma_dang_ky }}"
                                            data-client="{{ $req->khachHang->hoten }}"
                                            data-ptcu="{{ $req->ptCu->hoten }}"
                                            data-ptcu-id="{{ $req->id_pt_cu }}"
                                            data-rejected-pts="{{ json_encode($req->dangKyGoiTap->rejected_pts ?? []) }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#acceptPTModal">
                                        <i class="bi bi-check-circle"></i> Duyệt đổi
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 btn-reject-pt"
                                            data-id="{{ $req->id }}"
                                            data-code="{{ $req->dangKyGoiTap->ma_dang_ky }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectPTModal">
                                        <i class="bi bi-x-circle"></i> Từ chối
                                    </button>
                                </div>
                                @elseif($req->trang_thai == 'cho_pt_moi_xac_nhan')
                                <span class="text-info small">Chờ xác nhận</span>
                                @else
                                <span class="text-muted small">Đã xử lý</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-journal-x" style="font-size: 40px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2">Không tìm thấy yêu cầu đổi PT nào.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($requests->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL DUYỆT ĐỔI PT --}}
<div class="modal fade" id="acceptPTModal" tabindex="-1" aria-labelledby="acceptPTModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="acceptPTModalLabel">Duyệt Đổi Huấn Luyện Viên</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="acceptPTForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 text-muted">
                        Mã đăng ký: <strong class="text-primary" id="modalPTRegCode"></strong><br>
                        Học viên: <strong class="text-dark" id="modalPTClient"></strong><br>
                        PT Hiện tại: <strong class="text-dark" id="modalPTPtCu"></strong>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn Huấn luyện viên mới <span class="text-danger">*</span></label>
                        <select name="id_pt_moi" class="form-select" id="ptMoiSelect" required>
                            <option value="">-- Chọn Huấn luyện viên mới --</option>
                            @foreach($pts as $pt)
                            <option value="{{ $pt->id_nd }}">{{ $pt->hoten }} (Đang dạy: {{ $pt->pt_registrations_count }} | SĐT: 0{{ $pt->sdt }})</option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted mt-1">Hệ thống sẽ cập nhật PT phụ trách mới cho học viên này và gửi thông báo cho các bên.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-success">Xác nhận duyệt đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TỪ CHỐI ĐỔI PT --}}
<div class="modal fade" id="rejectPTModal" tabindex="-1" aria-labelledby="rejectPTModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="rejectPTModalLabel">Từ Chối Yêu Cầu Đổi PT</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="rejectPTForm">
                @csrf
                <div class="modal-body p-4">
                    <p>Mã đăng ký: <strong class="text-primary" id="modalRejectRegCode"></strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea name="ly_do_tu_choi" class="form-control" rows="3" placeholder="Nhập lý do từ chối yêu cầu..." required></textarea>
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
        // Duyệt đổi PT
        const btnAccepts = document.querySelectorAll('.btn-accept-pt');
        const acceptPTForm = document.getElementById('acceptPTForm');
        const modalPTRegCode = document.getElementById('modalPTRegCode');
        const modalPTClient = document.getElementById('modalPTClient');
        const modalPTPtCu = document.getElementById('modalPTPtCu');
        const ptMoiSelect = document.getElementById('ptMoiSelect');

        btnAccepts.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const code = this.dataset.code;
                const client = this.dataset.client;
                const ptcu = this.dataset.ptcu;
                const ptcuId = this.dataset.ptcuId;
                const rejectedPts = JSON.parse(this.dataset.rejectedPts || '[]');

                acceptPTForm.action = `/admin/yeucau-doipt/${id}/accept`;
                modalPTRegCode.innerText = code;
                modalPTClient.innerText = client;
                modalPTPtCu.innerText = ptcu;

                // Reset all options
                Array.from(ptMoiSelect.options).forEach(opt => {
                    opt.disabled = false;
                    opt.classList.remove('d-none');
                });

                // Filter options: exclude old PT and rejected PTs
                Array.from(ptMoiSelect.options).forEach(opt => {
                    if (opt.value) {
                        const optVal = parseInt(opt.value);
                        if (optVal === parseInt(ptcuId) || rejectedPts.includes(optVal)) {
                            opt.disabled = true;
                            opt.classList.add('d-none');
                        }
                    }
                });
            });
        });

        // Từ chối đổi PT
        const btnRejects = document.querySelectorAll('.btn-reject-pt');
        const rejectPTForm = document.getElementById('rejectPTForm');
        const modalRejectRegCode = document.getElementById('modalRejectRegCode');

        btnRejects.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const code = this.dataset.code;

                rejectPTForm.action = `/admin/yeucau-doipt/${id}/reject`;
                modalRejectRegCode.innerText = code;
            });
        });
    });
</script>
@endsection
