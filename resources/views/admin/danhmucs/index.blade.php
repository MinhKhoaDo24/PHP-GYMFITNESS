@extends('admin_layout')
@section('admin_content')

<style>
/* =========================================
    CARD THỐNG KÊ
========================================= */
.dm-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: center;
    border-left: 5px solid #0ea5e9;
}
.dm-card h2 {
    font-size: 28px;
    margin: 0;
    font-weight: 700;
}
.dm-card span {
    font-size: 14px;
    color: #666;
}

/* =========================================
    TABLE HEADER
========================================= */
.dm-table thead th {
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

/* =========================================
    TABLE BODY
========================================= */
.dm-table tbody td {
    vertical-align: middle !important;
        padding: 14px 10px;
        font-size: 14px;
        text-align: center;
        white-space: nowrap;
}
.dm-table tbody td:first-child {
    text-align: left !important;
        white-space: normal;
}


/* =========================================
    BADGES
========================================= */
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

/* =========================================
    BUTTONS
========================================= */
.btn-action {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
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
    text-decoration: none;
}

/* Button thêm */
.btn-add {
    background:#0ea5e9;
    color:#fff;
    padding:10px 22px;
    border-radius:8px;
    font-weight:600;
    font-size:14px;
    text-decoration:none;
}
.btn-add:hover {
    opacity:.9;
}
</style>

<h1 class="h3 mb-4"><strong>Quản lý danh mục sản phẩm</strong></h1>

{{-- SUCCESS --}}
@if(session()->has('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif


{{-- ===================== THỐNG KÊ + NÚT THÊM (GIỐNG SẢN PHẨM) ===================== --}}
<div class="row g-3 mb-4">

    <div class="col-md-3 text-start">
        <a href="{{ route('danhmuc.create') }}" class="btn-add" style='text-decoration: none;'>
        Thêm danh mục
        </a>
    </div>

</div>


{{-- ===================== TÌM KIẾM + FILTER (GIỐNG SẢN PHẨM) ===================== --}}
<div class="d-flex justify-content-between mb-3">

    {{-- SEARCH --}}
    <form class="w-50" method="GET">
        <input type="text" 
               name="q" 
               class="form-control"
               placeholder="Tìm kiếm danh mục..."
               value="{{ request('q') }}">
    </form>

    {{-- FILTER STATUS --}}
    <form method="GET">
        <input type="hidden" name="q" value="{{ request('q') }}">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="1" {{ request('status')==="1" ? 'selected' : '' }}>Hoạt động</option>
            <option value="0" {{ request('status')==="0" ? 'selected' : '' }}>Không hoạt động</option>
        </select>
    </form>
</div>


{{-- ===================== TABLE ===================== --}}
<div class="card p-0 shadow-sm">

<table class="table table-hover dm-table">
    <thead>
        <tr>
            <th width="35%">TÊN DANH MỤC</th>
            <!-- <th width="20%">DANH MỤC CHA</th> -->
            <th width="15%">TRẠNG THÁI</th>
            <th width="30%" class="text-center">HÀNH ĐỘNG</th>
        </tr>
    </thead>

    <tbody>
        @foreach($Danhmucs as $dm)
        <tr>
            <td class="fw-bold">{{ $dm->ten_danhmuc }}</td>

            <!-- <td>
                @if($dm->parent_category_id)
                    {{ optional($dm->parent)->ten_danhmuc }}
                @else
                    <span class="text-muted">—</span>
                @endif
            </td> -->

            <td>
                @if($dm->status == 1)
                    <span class="status-badge active">Hoạt động</span>
                @else
                    <span class="status-badge inactive">Không hoạt động</span>
                @endif
            </td>

            <td class="text-center">

                <a href="{{ route('danhmuc.edit', $dm->id_danhmuc) }}"
                    class="btn-action edit me-1">Sửa</a>

                @if($dm->status == 1)
                    <form method="POST" class="d-inline"
                          action="{{ route('danhmuc.destroy', $dm->id_danhmuc) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-action delete">Vô hiệu</button>
                    </form>
                @else
                    <form method="POST" class="d-inline"
                          action="{{ route('danhmuc.restore', $dm->id_danhmuc) }}">
                        @csrf
                        <button type="submit" class="btn-action restore">Khôi phục</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@endsection