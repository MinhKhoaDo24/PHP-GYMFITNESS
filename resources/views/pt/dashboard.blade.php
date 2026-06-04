@extends('pt_layout')

@section('pt_content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3 fw-bold">Trang Tổng Quan PT</h1>

    <div class="row">
        <div class="col-xl-6 col-xxl-5 d-flex">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card shadow-sm border-0" style="border-radius: 12px; border-bottom: 4px solid #10b981 !important;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title text-muted fw-bold mb-1">Khách hàng</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary" style="background: rgba(16, 185, 129, 0.15); color: #10b981 !important;">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-2 mb-3 fw-bold">{{ $soKhachHang }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted small">đang huấn luyện</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 col-xxl-4 d-flex order-2 order-xxl-3">
            <div class="card flex-fill w-100 shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header border-0 bg-white pt-4 pb-2">
                    <h5 class="card-title mb-0 fw-bold">Thông báo mới nhất</h5>
                </div>
                <div class="card-body px-4">
                    @forelse($thongbaos as $tb)
                    <div class="d-flex align-items-start mb-3 border-bottom pb-3">
                        <div class="bg-primary-subtle text-primary p-2 rounded-circle me-3" style="background: rgba(16, 185, 129, 0.15); color: #10b981 !important;">
                            @if($tb->loai == 'phan_pt')
                                <i class="bi bi-person-plus-fill"></i>
                            @else
                                <i class="bi bi-bell-fill"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ $tb->tieu_de }}</h6>
                            <p class="text-muted small mb-1">{{ $tb->noi_dung }}</p>
                            <small class="text-muted">{{ $tb->created_at->diffForHumans() }}</small>
                            @if($tb->link)
                            <div><a href="{{ $tb->link }}" class="small" style="color: #10b981;">Xem chi tiết</a></div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
                        Không có thông báo mới
                    </div>
                    @endforelse
                    
                    @if($thongbaos->count() > 0)
                    <div class="text-center mt-3">
                        <a href="{{ route('pt.thongbao') }}" class="btn btn-sm btn-outline-primary" style="color: #10b981; border-color: #10b981;">Xem tất cả</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
