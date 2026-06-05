@extends('admin_layout')

@section('admin_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Tất Cả Thông Báo</h3>
        
        @if($thongbaos->count() > 0)
        <button type="button" id="markAllReadBtnPage" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
            <i class="bi bi-check-all"></i> Đánh dấu đã đọc tất cả
        </button>
        @endif
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($thongbaos as $tb)
                <div class="list-group-item p-4 {{ $tb->da_doc ? 'opacity-75' : 'bg-light fw-bold' }} d-flex justify-content-between align-items-start gap-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                {{ $tb->tieu_de }}
                            </span>
                            <span class="text-muted small" style="font-size: 0.75rem;">
                                <i class="bi bi-clock"></i> {{ $tb->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-dark mb-0 mt-1" style="font-size: 0.95rem; line-height: 1.5;">
                            {{ $tb->noi_dung }}
                        </p>
                        @if($tb->link)
                        <div>
                            <a href="{{ $tb->link }}" class="btn btn-sm btn-outline-secondary mt-1 py-1 px-3 rounded-pill text-decoration-none d-inline-inline-flex align-items-center gap-1 admin-noti-page-link" data-id="{{ $tb->id }}">
                                <i class="bi bi-arrow-right-short"></i> Đi đến liên kết
                            </a>
                        </div>
                        @endif
                    </div>
                    <div>
                        @if(!$tb->da_doc)
                        <span class="badge bg-danger rounded-circle p-1" style="width: 10px; height: 10px; display: inline-block;" title="Thông báo mới"></span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bell-slash" style="font-size: 40px; color: #cbd5e1;"></i>
                    <p class="mt-2">Không tìm thấy thông báo nào dành cho bạn.</p>
                </div>
                @endforelse
            </div>
            
            @if($thongbaos->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $thongbaos->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Đánh dấu đọc từng liên kết khi nhấn nút đi đến
        const pageLinks = document.querySelectorAll('.admin-noti-page-link');
        pageLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const id = this.dataset.id;
                const url = this.getAttribute('href');
                if (id) {
                    e.preventDefault();
                    fetch(`/admin/thong-bao/${id}/doc`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        window.location.href = url;
                    }).catch(() => {
                        window.location.href = url;
                    });
                }
            });
        });

        // Đánh dấu đọc tất cả bằng nút trên trang
        const markAllReadBtnPage = document.getElementById('markAllReadBtnPage');
        if (markAllReadBtnPage) {
            markAllReadBtnPage.addEventListener('click', function (e) {
                e.preventDefault();
                fetch('/admin/thong-bao/doc-het', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    location.reload();
                });
            });
        }
    });
</script>
@endsection
