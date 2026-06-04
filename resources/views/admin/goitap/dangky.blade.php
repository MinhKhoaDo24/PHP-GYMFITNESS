@extends('admin_layout')

@section('admin_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Duyệt Đăng Ký Gói Tập</h3>
        
        {{-- Bộ lọc nhanh --}}
        <div class="d-flex gap-2">
            <a href="{{ route('admin.goitap.dangky') }}" class="btn btn-sm btn-outline-secondary {{ !request('trang_thai') ? 'active' : '' }}">Tất cả</a>
            <a href="{{ route('admin.goitap.dangky', ['trang_thai' => 'cho_thanh_toan']) }}" class="btn btn-sm btn-outline-warning {{ request('trang_thai') == 'cho_thanh_toan' ? 'active' : '' }}">Chờ thanh toán</a>
            <a href="{{ route('admin.goitap.dangky', ['trang_thai' => 'cho_pt_xac_nhan']) }}" class="btn btn-sm btn-outline-primary {{ request('trang_thai') == 'cho_pt_xac_nhan' ? 'active' : '' }}">Chờ xác nhận</a>
            <a href="{{ route('admin.goitap.dangky', ['trang_thai' => 'dang_tap']) }}" class="btn btn-sm btn-outline-success {{ request('trang_thai') == 'dang_tap' ? 'active' : '' }}">Đang hoạt động</a>
        </div>
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
                            <th class="ps-4">Mã Đăng Ký</th>
                            <th>Khách Hàng</th>
                            <th>Gói Tập & Thời Hạn</th>
                            <th>Tổng Tiền</th>
                            <th>Kèm PT</th>
                            <th>Trạng Thái</th>
                            <th>Thời Gian Luyện Tập</th>
                            <th class="text-end pe-4">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dangKys as $dangKy)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $dangKy->ma_dang_ky }}</td>
                            <td>
                                <div class="fw-bold">{{ $dangKy->user->hoten }}</div>
                                <div class="text-muted small">SĐT: 0{{ $dangKy->user->sdt }} | Mail: {{ $dangKy->user->email }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $dangKy->packagePrice->goitap->ten_goi }}</div>
                                <span class="badge bg-light text-dark border">{{ $dangKy->packagePrice->so_thang }} Tháng</span>
                            </td>
                            <td class="fw-bold text-dark">{{ number_format($dangKy->tong_tien, 0, ',', '.') }} đ</td>
                            <td>
                                @if($dangKy->co_pt)
                                    @if($dangKy->pt)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            PT: {{ $dangKy->pt->hoten }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                            Chờ phân PT
                                        </span>
                                        @if($dangKy->rejected_pts && count($dangKy->rejected_pts) > 0)
                                            @php
                                                $rejectedNames = $pts->whereIn('id_nd', $dangKy->rejected_pts)->pluck('hoten')->toArray();
                                            @endphp
                                            @if(count($rejectedNames) > 0)
                                                <div class="text-danger small mt-1" style="font-size: 0.75rem;">
                                                    <i class="bi bi-x-circle-fill"></i> Từ chối: {{ implode(', ', $rejectedNames) }}
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    <span class="text-muted small">Không kèm PT</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusBadges = [
                                        'cho_thanh_toan' => 'bg-warning text-dark',
                                        'da_thanh_toan' => 'bg-info text-white',
                                        'cho_pt_xac_nhan' => 'bg-primary text-white',
                                        'dang_tap' => 'bg-success text-white',
                                        'het_han' => 'bg-danger text-white',
                                        'da_huy' => 'bg-secondary text-white'
                                    ];
                                    $statusLabels = [
                                        'cho_thanh_toan' => 'Chờ thanh toán',
                                        'da_thanh_toan' => 'Đã thanh toán',
                                        'cho_pt_xac_nhan' => 'Chờ xác nhận',
                                        'dang_tap' => 'Đang hoạt động',
                                        'het_han' => 'Đã hết hạn',
                                        'da_huy' => 'Đã hủy'
                                    ];
                                @endphp
                                <span class="badge {{ $statusBadges[$dangKy->trang_thai] ?? 'bg-secondary' }}">
                                    {{ $statusLabels[$dangKy->trang_thai] ?? $dangKy->trang_thai }}
                                </span>
                            </td>
                            <td>
                                @if($dangKy->ngay_bat_dau && $dangKy->ngay_ket_thuc)
                                    <div class="small">
                                        <div><span class="text-muted">Từ:</span> {{ $dangKy->ngay_bat_dau->format('d/m/Y') }}</div>
                                        <div><span class="text-muted">Đến:</span> {{ $dangKy->ngay_ket_thuc->format('d/m/Y') }}</div>
                                    </div>
                                @elseif($dangKy->trang_thai == 'cho_pt_xac_nhan')
                                    <div class="small text-primary">
                                        <div><span class="text-muted">Giao PT:</span> {{ $dangKy->updated_at->format('d/m/Y H:i') }}</div>
                                        <div class="fw-bold">({{ $dangKy->updated_at->diffForHumans() }})</div>
                                    </div>
                                @else
                                    <span class="text-muted small">Chờ kích hoạt</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($dangKy->trang_thai == 'cho_thanh_toan')
                                <button type="button" 
                                        class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 btn-approve"
                                        data-id="{{ $dangKy->id }}"
                                        data-code="{{ $dangKy->ma_dang_ky }}"
                                        data-copt="{{ $dangKy->co_pt }}"
                                        data-rejected-pts="{{ json_encode($dangKy->rejected_pts ?? []) }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#approveModal">
                                    <i class="bi bi-shield-check"></i> Duyệt & Kích Hoạt
                                </button>
                                @elseif($dangKy->trang_thai == 'da_thanh_toan')
                                <button type="button" 
                                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 btn-approve"
                                        data-id="{{ $dangKy->id }}"
                                        data-code="{{ $dangKy->ma_dang_ky }}"
                                        data-copt="{{ $dangKy->co_pt }}"
                                        data-rejected-pts="{{ json_encode($dangKy->rejected_pts ?? []) }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#approveModal">
                                    <i class="bi bi-person-fill-gear"></i> Phân công PT
                                </button>
                                @elseif($dangKy->trang_thai == 'cho_pt_xac_nhan')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle py-1 px-2 fw-semibold">
                                    <i class="bi bi-hourglass-split"></i> Chờ xác nhận
                                </span>
                                @else
                                <span class="text-muted small">Đã kích hoạt</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-journal-x" style="font-size: 40px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2">Không tìm thấy đơn đăng ký nào.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PHÊ DUYỆT & KÍCH HOẠT --}}
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="approveModalLabel">Duyệt & Kích Hoạt Gói Tập</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="approveForm">
                @csrf
                <div class="modal-body p-4">
                    <p class="mb-3">Xác nhận rằng Khách hàng đã thanh toán đầy đủ phí đăng ký gói tập <strong class="text-primary" id="modalRegCode"></strong>.</p>
                    
                    {{-- Mục phân công PT (Ẩn/Hiện bằng JS dựa trên co_pt) --}}
                    <div class="mb-3" id="ptAssignSection">
                        <label class="form-label fw-bold">Phân công PT phụ trách <span class="text-danger">*</span></label>
                        <select name="id_pt" class="form-select" id="ptSelect" required>
                            <option value="">-- Chọn Huấn luyện viên (PT) --</option>
                            @foreach($pts as $pt)
                            <option value="{{ $pt->id_nd }}">{{ $pt->hoten }} (Đang dạy: {{ $pt->pt_registrations_count }} | SĐT: 0{{ $pt->sdt }})</option>
                            @endforeach
                        </select>
                        <div class="form-text text-warning mt-1"><i class="bi bi-info-circle"></i> Khách hàng đăng ký gói tập có kèm PT. Vui lòng phân công PT trước khi kích hoạt.</div>
                    </div>
                    
                    <div id="noPtSection" class="text-muted small p-2 bg-light rounded mb-2 d-none">
                        Gói tập này không đăng ký kèm PT. Hệ thống sẽ kích hoạt ngay lập tức.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-success">Xác Nhận & Kích Hoạt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnApproves = document.querySelectorAll('.btn-approve');
        const approveForm = document.getElementById('approveForm');
        const modalRegCode = document.getElementById('modalRegCode');
        const ptAssignSection = document.getElementById('ptAssignSection');
        const noPtSection = document.getElementById('noPtSection');
        const ptSelect = document.getElementById('ptSelect');

        btnApproves.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const code = this.dataset.code;
                const coPT = parseInt(this.dataset.copt);
                const rejectedPts = JSON.parse(this.dataset.rejectedPts || '[]');

                // Reset all options in ptSelect
                Array.from(ptSelect.options).forEach(opt => {
                    opt.disabled = false;
                    opt.classList.remove('d-none');
                });

                // Cập nhật Action của Form
                approveForm.action = `/admin/goitap/dangky/kichhoat/${id}`;
                modalRegCode.innerText = code;

                if (coPT === 1) {
                    ptAssignSection.classList.remove('d-none');
                    noPtSection.classList.add('d-none');
                    ptSelect.setAttribute('required', 'required');

                    // Filter out rejected PTs
                    Array.from(ptSelect.options).forEach(opt => {
                        if (opt.value && rejectedPts.includes(parseInt(opt.value))) {
                            opt.disabled = true;
                            opt.classList.add('d-none');
                        }
                    });
                } else {
                    ptAssignSection.classList.add('d-none');
                    noPtSection.classList.remove('d-none');
                    ptSelect.removeAttribute('required');
                }
            });
        });
    });
</script>
@endsection
