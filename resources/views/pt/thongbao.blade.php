@extends('pt_layout')

@section('pt_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Thông Báo Của Bạn</h3>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($thongbaos as $tb)
                <a href="{{ $tb->link ?? '#' }}" class="list-group-item list-group-item-action p-4 border-bottom {{ $tb->da_doc == 0 ? 'bg-light' : '' }}">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary-subtle text-primary p-3 rounded-circle me-3" style="background: rgba(16, 185, 129, 0.15); color: #10b981 !important;">
                            @if($tb->loai == 'phan_pt')
                                <i class="bi bi-person-plus-fill fs-4"></i>
                            @else
                                <i class="bi bi-bell-fill fs-4"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 fw-bold {{ $tb->da_doc == 0 ? 'text-dark' : 'text-muted' }}">{{ $tb->tieu_de }}</h5>
                                <small class="text-muted">{{ $tb->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 {{ $tb->da_doc == 0 ? 'fw-semibold text-dark' : 'text-muted' }}">{{ $tb->noi_dung }}</p>
                            <small class="text-muted">{{ $tb->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-bell-slash" style="font-size: 50px; color: #cbd5e1;"></i>
                    <h5 class="text-muted mt-3">Không có thông báo nào</h5>
                </div>
                @endforelse
            </div>
            
            <div class="p-3 border-top d-flex justify-content-center">
                {{ $thongbaos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
