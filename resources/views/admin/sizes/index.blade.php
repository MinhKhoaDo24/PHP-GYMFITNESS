@extends('admin_layout')
@section('admin_content')

<style>
    .size-table thead th {
        background: black;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        padding: 14px 10px;
        font-size: 13px;
        text-align: center;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .size-table tbody td {
        vertical-align: middle !important;
        padding: 14px 10px;
        font-size: 14px;
        text-align: center;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 13px;
    }

    .status-badge.active {
        background: #d1fae5;
        color: #0f766e;
    }

    .status-badge.inactive {
        background: #fecaca;
        color: #b91c1c;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-action.edit {
        background: #facc15;
        color: #000;
    }

    .btn-action.delete {
        background: #dc2626;
        color: #fff;
    }

    .btn-action.restore {
        background: #16a34a;
        color: #fff;
    }

    .btn-action:hover {
        opacity: .9;
        color: inherit;
        text-decoration: none;
    }

    .btn-add {
        background: #0ea5e9;
        color: #fff;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-add:hover {
        opacity: .9;
        color: #fff;
    }
</style>

<h1 class="h3 mb-4"><strong>Quản lý Size sản phẩm</strong></h1>

{{-- Alert Messages --}}
@if(session()->has('success'))
<div class="alert alert-success mb-3">
    {{ session('success') }}
</div>
@endif

<div class="row g-3 mb-4 align-items-center">
    <div class="col-md-3">
        <a href="{{ route('sizes.create') }}" class="btn-add">
            Thêm Size mới
        </a>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    {{-- Search Form --}}
    <form class="w-50" method="GET" action="{{ route('sizes.index') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="text"
            name="q"
            class="form-control"
            placeholder="🔍 Tìm kiếm tên size hoặc mô tả..."
            value="{{ request('q') }}">
    </form>

    {{-- Filter Status --}}
    <form method="GET" action="{{ route('sizes.index') }}">
        <input type="hidden" name="q" value="{{ request('q') }}">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">📌 Tất cả trạng thái</option>
            <option value="1" {{ request('status') === "1" ? 'selected' : '' }}>Hoạt động</option>
            <option value="0" {{ request('status') === "0" ? 'selected' : '' }}>Vô hiệu hóa</option>
        </select>
    </form>
</div>

<div class="card p-0 shadow-sm">
    <table class="table table-hover size-table mb-0">
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="25%">TÊN SIZE</th>
                <th width="35%">MÔ TẢ</th>
                <th width="15%">TRẠNG THÁI</th>
                <th width="15%">HÀNH ĐỘNG</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sizes as $size)
            <tr>
                <td>{{ $size->id_size }}</td>
                <td class="fw-bold">{{ $size->ten_size }}</td>
                <td>{{ $size->mota ?? '—' }}</td>
                <td>
                    @if($size->trang_thai == 1)
                    <span class="status-badge active">Hoạt động</span>
                    @else
                    <span class="status-badge inactive">Vô hiệu hóa</span>
                    @endif
                </td>
                <td>
                    @if($size->trang_thai == 1)
                    <a href="{{ route('sizes.edit', $size->id_size) }}" class="btn-action edit me-1">Sửa</a>
                    <form method="POST" class="d-inline" action="{{ route('sizes.destroy', $size->id_size) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action delete">Vô hiệu</button>
                    </form>
                    @else
                    <form method="POST" class="d-inline" action="{{ route('sizes.restore', $size->id_size) }}">
                        @csrf
                        <button type="submit" class="btn-action restore">Khôi phục</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-4">Không tìm thấy size nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection