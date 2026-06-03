@extends('admin_layout')

@section('admin_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Quản Lý Gói Tập Gym</h3>
        <a href="{{ route('admin.goitap.create') }}" class="btn btn-primary d-flex align-items-center gap-2" style="background-color: #34A4E0; border-color: #34A4E0;">
            <i class="bi bi-plus-lg"></i> Thêm Gói Tập Mới
        </a>
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
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Hình Ảnh</th>
                            <th>Tên Gói</th>
                            <th>Môn Tập</th>
                            <th>Loại</th>
                            <th>Phụ Thu PT/Tháng</th>
                            <th>Nổi Bật</th>
                            <th class="text-end pe-4">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($goitaps as $goi)
                        <tr>
                            <td class="ps-4">
                                <img src="{{ asset($goi->hinh_anh) }}" alt="{{ $goi->ten_goi }}" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                            </td>
                            <td class="fw-bold">{{ $goi->ten_goi }}</td>
                            <td class="text-muted">{{ $goi->mo_ta_ngan }}</td>
                            <td>
                                <span class="badge text-uppercase font-weight-bold" style="background-color: {{ $goi->loai_goi == 'diamond' ? '#db2777' : ($goi->loai_goi == 'gold' ? '#d97706' : '#6b7280') }};">
                                    {{ $goi->loai_goi }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ number_format($goi->gia_pt_them, 0, ',', '.') }} đ</td>
                            <td>
                                @if($goi->is_best)
                                <span class="badge bg-success">Best</span>
                                @else
                                <span class="badge bg-secondary">Thường</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.goitap.edit', $goi->id_goitap) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.goitap.destroy', $goi->id_goitap) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa gói tập này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-journal-x" style="font-size: 40px; color: #cbd5e1;"></i>
                                <p class="text-muted mt-2">Chưa có gói tập nào.</p>
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
