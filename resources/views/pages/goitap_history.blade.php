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

    /* Reset CSS conflict for bootstrap modal */
    .modal {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        transform: none !important;
        width: 100% !important;
        height: 100% !important;
        z-index: 1050 !important;
        background: rgba(0, 0, 0, 0.5) !important;
    }
    .modal-dialog {
        max-width: 500px !important;
        margin: 1.75rem auto !important;
        transform: none !important;
        top: unset !important;
        left: unset !important;
    }
    .rf-modal-content {
        background: rgba(30, 41, 59, 0.98) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 20px !important;
        color: #f8fafc !important;
        padding: 0 !important;
        display: flex;
        flex-direction: column;
    }
    .rf-modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 1rem 1.5rem !important;
    }
    .rf-modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1rem 1.5rem !important;
        background: transparent !important;
    }
    .rf-input {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff !important;
        border-radius: 10px;
        padding: 10px 15px;
    }
    .rf-input:focus {
        background: rgba(15, 23, 42, 0.8);
        border-color: #34a4e0;
        box-shadow: 0 0 0 3px rgba(52, 164, 224, 0.25);
    }
    .btn-disabled-style {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .badge-bao_luu {
        background: rgba(139, 92, 246, 0.2);
        color: #8b5cf6;
        border: 1px solid #8b5cf6;
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
                            <th>Hành Động</th>
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
                                        'bao_luu' => 'Đang bảo lưu',
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
                                            <i class="bi bi-heart-pulse"></i> Xem chỉ số
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
                            <td>
                                @if($reg->trang_thai == 'dang_tap')
                                    @if($reg->co_pt == 1)
                                        @if($reg->pt)
                                            @php
                                                $pendingPT = $reg->yeuCauDoiPTs->where('trang_thai', 'cho_xu_ly')->first();
                                                $hasChangedPT = $reg->yeuCauDoiPTs->where('trang_thai', 'da_duyet')->isNotEmpty();
                                                $daysSinceStart = $reg->ngay_bat_dau ? \Carbon\Carbon::parse($reg->ngay_bat_dau)->diffInDays(now()) : 0;
                                            @endphp
                                            @if($pendingPT)
                                                <span class="badge badge-warning text-dark py-2 px-3" style="border-radius: 8px; font-weight: 600;">
                                                    <i class="bi bi-hourglass-split"></i> Chờ duyệt đổi PT
                                                </span>
                                            @elseif($hasChangedPT)
                                                <button class="btn btn-sm btn-secondary btn-disabled-style" disabled title="Mỗi gói tập chỉ được đổi Huấn luyện viên tối đa 1 lần" style="border-radius: 8px; font-weight: 600;">
                                                    Đổi PT
                                                </button>
                                                <div class="text-muted small mt-1" style="font-size: 11px;">Đã đổi PT 1 lần</div>
                                            @elseif($daysSinceStart > 7)
                                                <button class="btn btn-sm btn-secondary btn-disabled-style" disabled title="Đã quá hạn 7 ngày kể từ ngày kích hoạt gói tập" style="border-radius: 8px; font-weight: 600;">
                                                    Đổi PT
                                                </button>
                                                <div class="text-muted small mt-1" style="font-size: 11px;">Quá hạn 7 ngày</div>
                                            @else
                                                <button class="btn btn-sm btn-warning text-dark" data-toggle="modal" data-target="#doiPtModal{{ $reg->id }}" style="border-radius: 8px; font-weight: 600;">
                                                    <i class="bi bi-person-fill-exclamation"></i> Đổi PT
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted small">Chờ phân PT</span>
                                        @endif
                                    @else
                                        @php
                                            $pendingBL = $reg->yeuCauBaoLuus->where('trang_thai', 'cho_duyet')->first();
                                            $hasFrozen = $reg->yeuCauBaoLuus->whereIn('trang_thai', ['da_duyet', 'da_kich_hoat_lai'])->isNotEmpty();
                                            $isLongEnough = $reg->packagePrice->so_thang >= 3;
                                            $daysLeft = $reg->ngay_ket_thuc ? today()->diffInDays($reg->ngay_ket_thuc) : 0;
                                            $hasEnoughDays = $daysLeft >= 15;
                                        @endphp
                                        @if($pendingBL)
                                            <span class="badge badge-warning text-dark py-2 px-3" style="border-radius: 8px; font-weight: 600;">
                                                <i class="bi bi-hourglass-split"></i> Chờ duyệt bảo lưu
                                            </span>
                                        @elseif($hasFrozen)
                                            <button class="btn btn-sm btn-secondary btn-disabled-style" disabled title="Mỗi gói tập chỉ được bảo lưu tối đa 1 lần" style="border-radius: 8px; font-weight: 600;">
                                                Bảo lưu
                                            </button>
                                            <div class="text-muted small mt-1" style="font-size: 11px;">Đã bảo lưu 1 lần</div>
                                        @elseif(!$isLongEnough)
                                            <button class="btn btn-sm btn-secondary btn-disabled-style" disabled title="Chính sách bảo lưu chỉ áp dụng cho gói từ 3 tháng trở lên" style="border-radius: 8px; font-weight: 600;">
                                                Bảo lưu
                                            </button>
                                            <div class="text-muted small mt-1" style="font-size: 11px;">Chỉ áp dụng gói ≥ 3 tháng</div>
                                        @elseif(!$hasEnoughDays)
                                            <button class="btn btn-sm btn-secondary btn-disabled-style" disabled title="Số ngày còn lại của gói tập tại ngày bảo lưu phải từ 15 ngày trở lên" style="border-radius: 8px; font-weight: 600;">
                                                Bảo lưu
                                            </button>
                                            <div class="text-muted small mt-1" style="font-size: 11px;">Còn lại < 15 ngày</div>
                                        @else
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#baoluuModal{{ $reg->id }}" style="border-radius: 8px; font-weight: 600;">
                                                <i class="bi bi-pause-circle-fill"></i> Bảo lưu
                                            </button>
                                        @endif
                                    @endif
                                @elseif($reg->trang_thai == 'bao_luu')
                                    <form action="{{ route('goitap.baoluu.resume', $reg->id) }}" method="POST" class="d-inline resume-form-js">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" style="border-radius: 8px; font-weight: 600;">
                                            <i class="bi bi-play-circle-fill"></i> Kích hoạt lại
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- Modals loop at bottom of page to prevent clipping by table responsive container --}}
        @foreach($registrations as $reg)
            @if($reg->trang_thai == 'dang_tap')
                @if($reg->co_pt == 1 && $reg->pt && !$reg->yeuCauDoiPTs->where('trang_thai', 'cho_xu_ly')->first() && $reg->yeuCauDoiPTs->where('trang_thai', 'da_duyet')->isEmpty() && ($reg->ngay_bat_dau && \Carbon\Carbon::parse($reg->ngay_bat_dau)->diffInDays(now()) <= 7))
                <!-- Modal Đổi PT -->
                <div class="modal fade" id="doiPtModal{{ $reg->id }}" tabindex="-1" role="dialog" aria-labelledby="doiPtModalLabel{{ $reg->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content rf-modal-content">
                            <div class="modal-header rf-modal-header">
                                <h5 class="modal-title font-weight-bold text-white" id="doiPtModalLabel{{ $reg->id }}">
                                    <i class="bi bi-person-fill-exclamation text-warning mr-2"></i>Yêu cầu đổi PT
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('goitap.yeucau-doi-pt', $reg->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3 text-muted" style="font-size: 14px; line-height: 1.6;">
                                        Gói tập: <strong class="text-white">{{ $reg->packagePrice->goitap->ten_goi }}</strong><br>
                                        PT hiện tại: <strong class="text-white">{{ $reg->pt->hoten }}</strong>
                                    </div>
                                    <div class="form-group">
                                        <label for="ly_do_{{ $reg->id }}" class="font-weight-bold text-white-50">Lý do đổi PT <span class="text-danger">*</span></label>
                                        <select name="ly_do" id="ly_do_{{ $reg->id }}" class="form-control rf-input" required style="background: #1e293b; border-color: rgba(255,255,255,0.1); color: #fff;">
                                            <option value="">-- Chọn lý do --</option>
                                            <option value="Không phù hợp lịch tập">Không phù hợp lịch tập</option>
                                            <option value="Muốn PT nữ/PT nam">Muốn PT nữ/PT nam</option>
                                            <option value="Không phù hợp phương pháp hướng dẫn">Không phù hợp phương pháp hướng dẫn</option>
                                            <option value="Lý do khác">Lý do khác</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ghi_chu_{{ $reg->id }}" class="font-weight-bold text-white-50">Chi tiết lý do / Ghi chú</label>
                                        <textarea name="ghi_chu" id="ghi_chu_{{ $reg->id }}" rows="3" class="form-control rf-input" placeholder="Nhập thêm chi tiết lý do mong muốn đổi huấn luyện viên..." style="background: #1e293b; border-color: rgba(255,255,255,0.1); color: #fff;"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer rf-modal-footer">
                                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal" style="border-radius: 8px;">Đóng</button>
                                    <button type="submit" class="btn btn-warning text-dark px-4" style="border-radius: 8px; font-weight: 700;">Gửi yêu cầu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @php
                    $hasFrozen = $reg->yeuCauBaoLuus->whereIn('trang_thai', ['da_duyet', 'da_kich_hoat_lai'])->isNotEmpty();
                    $isLongEnough = $reg->packagePrice->so_thang >= 3;
                    $daysLeft = $reg->ngay_ket_thuc ? today()->diffInDays($reg->ngay_ket_thuc) : 0;
                    $hasEnoughDays = $daysLeft >= 15;
                @endphp

                @if($reg->co_pt == 0 && !$reg->yeuCauBaoLuus->where('trang_thai', 'cho_duyet')->first() && !$hasFrozen && $isLongEnough && $hasEnoughDays)
                <!-- Modal Bảo lưu -->
                <div class="modal fade" id="baoluuModal{{ $reg->id }}" tabindex="-1" role="dialog" aria-labelledby="baoluuModalLabel{{ $reg->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content rf-modal-content">
                            <div class="modal-header rf-modal-header">
                                <h5 class="modal-title font-weight-bold text-white" id="baoluuModalLabel{{ $reg->id }}">
                                    <i class="bi bi-pause-circle-fill text-info mr-2"></i>Yêu cầu bảo lưu gói tập
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('goitap.baoluu', $reg->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3 text-muted" style="font-size: 14px; line-height: 1.6;">
                                        Gói tập: <strong class="text-white">{{ $reg->packagePrice->goitap->ten_goi }}</strong><br>
                                        Số ngày sử dụng còn lại: <strong class="text-white">{{ $daysLeft }} ngày</strong>
                                    </div>
                                    <div class="form-group">
                                        <label for="ngay_bat_dau_baoluu_{{ $reg->id }}" class="font-weight-bold text-white-50">Ngày bắt đầu bảo lưu <span class="text-danger">*</span></label>
                                        <input type="date" name="ngay_bat_dau_baoluu" id="ngay_bat_dau_baoluu_{{ $reg->id }}" class="form-control rf-input" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ \Carbon\Carbon::parse($reg->ngay_ket_thuc)->subDays(15)->format('Y-m-d') }}" required style="background: #1e293b; border-color: rgba(255,255,255,0.1); color: #fff;">
                                    </div>
                                    <div class="form-group">
                                        <label for="so_ngay_baoluu_{{ $reg->id }}" class="font-weight-bold text-white-50">Số ngày muốn bảo lưu (7 - 30 ngày) <span class="text-danger">*</span></label>
                                        <input type="number" name="so_ngay_baoluu" id="so_ngay_baoluu_{{ $reg->id }}" class="form-control rf-input" min="7" max="30" value="7" required style="background: #1e293b; border-color: rgba(255,255,255,0.1); color: #fff;">
                                        <small class="text-muted mt-1 d-block">Thời gian bảo lưu tối thiểu 7 ngày và tối đa 30 ngày.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="ly_do_bl_{{ $reg->id }}" class="font-weight-bold text-white-50">Lý do bảo lưu <span class="text-danger">*</span></label>
                                        <input type="text" name="ly_do" id="ly_do_bl_{{ $reg->id }}" class="form-control rf-input" placeholder="Ví dụ: Bận đi công tác, Vấn đề sức khỏe..." required style="background: #1e293b; border-color: rgba(255,255,255,0.1); color: #fff;">
                                    </div>
                                </div>
                                <div class="modal-footer rf-modal-footer">
                                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal" style="border-radius: 8px;">Đóng</button>
                                    <button type="submit" class="btn btn-info px-4" style="border-radius: 8px; font-weight: 700;">Gửi yêu cầu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.resume-form-js').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: 'Kích hoạt lại gói tập?',
                text: "Bạn có chắc chắn muốn kết thúc bảo lưu và kích hoạt lại gói tập này ngay hôm nay không?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Kích hoạt lại',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection
