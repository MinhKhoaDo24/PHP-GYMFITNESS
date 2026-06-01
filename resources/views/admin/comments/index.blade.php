@extends('admin_layout')
@section('admin_content')

<h3 class="fw-bold mb-3">Quản Lý Đánh Giá</h3>
<p class="text-muted">Kiểm duyệt và quản lý các bài đánh giá, bình luận từ khách hàng.</p>

<div class="card border-none shadow-sm" style="border-radius: 14px; overflow: hidden;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="fw-bold m-0"><i class="bi bi-chat-left-text text-primary me-2"></i>Danh sách bình luận & đánh giá</h5>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 60px;">STT</th>
                        <th style="width: 200px;">Khách hàng</th>
                        <th style="width: 180px;">Sản phẩm</th>
                        <th style="width: 130px;">Đánh giá</th>
                        <th>Nội dung</th>
                        <th style="width: 220px;">Ảnh/Video thực tế</th>
                        <th style="width: 130px;">Ngày gửi</th>
                        <th class="pe-4 text-end" style="width: 100px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $key => $c)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $comments->firstItem() + $key }}</td>
                            <td>
                                <div class="fw-bold">{{ $c->user->hoten ?? $c->user->name ?? 'Khách hàng ẩn danh' }}</div>
                                <div class="small text-muted">{{ $c->user->email ?? '' }}</div>
                                @if(!empty($c->user->sdt))
                                    <div class="small text-muted">SĐT: 0{{ $c->user->sdt }}</div>
                                @endif
                            </td>
                            <td>
                                @if($c->sanpham)
                                    <a href="{{ route('detail', $c->sanpham_id) }}" target="_blank" class="text-decoration-none fw-semibold text-primary">
                                        {{ $c->sanpham->tensp }}
                                    </a>
                                @else
                                    <span class="text-danger small">Sản phẩm đã bị xóa</span>
                                @endif
                            </td>
                            <td>
                                <div style="color: #ffb800; font-size: 14px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($c->rating ?? 5))
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="badge bg-light text-dark border mt-1">{{ $c->rating ?? 5 }} / 5 sao</span>
                            </td>
                            <td>
                                <div class="text-wrap" style="max-width: 350px; font-size: 14px;">
                                    {{ $c->content }}
                                </div>
                            </td>
                            <td>
                                @if(!empty($c->images))
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach($c->images as $path)
                                            @php
                                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                                $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'ogg', 'mov', 'qt']);
                                            @endphp
                                            <div class="admin-thumbnail" onclick="openAdminMedia('{{ asset($path) }}', {{ $isVideo ? 'true' : 'false' }})" style="width: 50px; height: 50px; border-radius: 6px; border: 1px solid #dee2e6; overflow: hidden; cursor: pointer; position: relative; background: #000;">
                                                @if($isVideo)
                                                    <video src="{{ asset($path) }}" style="width: 100%; height: 100%; object-fit: cover;" muted></video>
                                                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.25); color: #fff; font-size: 14px;">
                                                        <i class="bi bi-play-fill"></i>
                                                    </div>
                                                @else
                                                    <img src="{{ asset($path) }}" style="width: 100%; height: 100%; object-fit: cover;" />
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted small">---</span>
                                @endif
                            </td>
                            <td class="small text-secondary">
                                {{ $c->created_at ? $c->created_at->format('d-m-Y H:i') : '---' }}
                            </td>
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.comments.destroy', $c->id) }}" method="POST" class="d-inline delete-review-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-delete-review" style="border-radius: 8px; padding: 6px 10px;">
                                        <i class="bi bi-trash3"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-chat-left-dots text-secondary" style="font-size: 40px;"></i>
                                <p class="mt-2">Hiện chưa có đánh giá nào từ khách hàng.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Phân trang --}}
        @if($comments->hasPages())
            <div class="d-flex justify-content-center py-4 border-top">
                {!! $comments->links('pagination::bootstrap-5') !!}
            </div>
        @endif
    </div>
</div>

<!-- OVERLAY XEM ẢNH/VIDEO TRONG ADMIN -->
<div id="adminMediaOverlay" class="admin-media-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(4px); justify-content: center; align-items: center; z-index: 99999;">
    <span class="admin-close-media" style="position: absolute; top: 25px; right: 35px; font-size: 45px; color: #fff; cursor: pointer; font-weight: bold; line-height: 1;">&times;</span>
    <img id="adminOverlayImg" style="display: none; max-width: 85%; max-height: 85%; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
    <video id="adminOverlayVid" controls style="display: none; max-width: 85%; max-height: 85%; object-fit: contain; border-radius: 8px; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.3);"></video>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // Hàm mở xem ảnh/video đính kèm
    function openAdminMedia(src, isVideo) {
        const overlay = document.getElementById('adminMediaOverlay');
        const img = document.getElementById('adminOverlayImg');
        const vid = document.getElementById('adminOverlayVid');
        
        if (isVideo) {
            img.style.display = 'none';
            vid.src = src;
            vid.style.display = 'block';
        } else {
            vid.style.display = 'none';
            vid.src = '';
            img.src = src;
            img.style.display = 'block';
        }
        overlay.style.display = 'flex';
    }

    $(document).ready(function() {
        // Đóng overlay
        $('.admin-close-media, #adminMediaOverlay').on('click', function(e) {
            if (e.target === this || $(e.target).hasClass('admin-close-media')) {
                $('#adminMediaOverlay').hide();
                document.getElementById('adminOverlayVid').src = '';
            }
        });

        // Xác nhận xóa đánh giá
        $('.btn-delete-review').on('click', function() {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: 'Hành động này sẽ xóa vĩnh viễn bài đánh giá này và các ảnh/video đi kèm!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Đồng ý xóa',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
