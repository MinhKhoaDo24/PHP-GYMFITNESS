@extends('admin_layout')
@section('admin_content')

<style>

/* ===================== CARD THỐNG KÊ (GIỐNG SẢN PHẨM) ===================== */
.stat-card {
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    border-left: 5px solid #2563eb;
    transition: .2s;
}
.stat-card h2 { margin:0; font-size:28px; font-weight:700; }
.stat-card span { color:#6b7280; font-size:14px; }

/* ===================== TABLE (GIỐNG SẢN PHẨM) ===================== */
.user-table thead th {
    background: black;
    color: white;
    padding: 13px 10px;
    font-size: 13px;
    letter-spacing: .5px;
    text-transform: uppercase;
    text-align: center;
}

.user-table tbody td {
    text-align: center;
    padding: 14px 10px;
    vertical-align: middle;
}
.user-table tbody td:nth-child(2),
.user-table tbody td:nth-child(1) {
    text-align: left !important;
}
/* ===================== ROLE BADGE ===================== */
.role-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 12px;
}

.role-admin  { background:#ffe4e6; color:#be123c; }
.role-staff  { background:#d1fae5; color:#0f766e; }
.role-user   { background:#e0f2fe; color:#0369a1; }

/* ===================== STATUS BADGE ===================== */
.status-badge {
    padding: 6px 14px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 12px;
}
.status-active { background:#d1fae5; color:#0f766e; }
.status-out    { background:#fecaca; color:#b91c1c; }

.btn-action {
    padding: 7px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
}
.btn-edit    { background:#facc15; color:#000; }
.btn-delete  { background:#dc2626; color:#fff; }
.btn-restore { background:#16a34a; color:#fff; }
.btn-action:hover { opacity:.9; }

</style>

<h1 class="h3 mb-3"><strong>Quản Lý Người Dùng</strong></h1>

{{-- SUCCESS --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ===================== STAT CARDS ===================== --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="stat-card" style="border-left-color:#2563eb;">
            <h2>{{ $stats['total'] }}</h2>
            <span>Tổng người dùng</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card" style="border-left-color:#22c55e;">
            <h2>{{ $stats['active'] }}</h2>
            <span>Đang hoạt động</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card" style="border-left-color:#f97316;">
            <h2>{{ $stats['inactive'] }}</h2>
            <span>Đã vô hiệu</span>
        </div>
    </div>

    <div class="col-md-3 text-end">
        <a href="{{ route('users.create') }}" class="btn btn-success px-4 py-2"style='background-color: #0ea5e9;'>
        Thêm người dùng
        </a>
    </div>

</div>

{{-- ===================== SEARCH + FILTER ===================== --}}
<div class="d-flex justify-content-between mb-3">

    {{-- SEARCH --}}
    <form class="w-50" method="GET">
        <input type="text" name="q" class="form-control"
               placeholder="Tìm theo tên, email, SĐT..."
               value="{{ request('q') }}">
    </form>

    <div class="d-flex">

        {{-- FILTER ROLE --}}
        <form method="GET" class="me-2">
            <input type="hidden" name="q" value="{{ request('q') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            
            <select name="role" class="form-select" onchange="this.form.submit()">
                <option value="">Tất cả quyền</option>
                <option value="1" {{ request('role')==1 ? 'selected':'' }}>Admin</option>
                <option value="2" {{ request('role')==2 ? 'selected':'' }}>User</option>
            </select>
        </form>

        {{-- FILTER STATUS --}}
        <form method="GET">
            <input type="hidden" name="q" value="{{ request('q') }}">
            <input type="hidden" name="role" value="{{ request('role') }}">
            
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Trạng thái</option>
                <option value="1" {{ request('status')==1 ? 'selected':'' }}>Hoạt động</option>
                <option value="0" {{ request('status')==='0' ? 'selected':'' }}>Vô hiệu</option>
            </select>
        </form>

    </div>
</div>


{{-- ===================== TABLE  ===================== --}}
<table class="table table-hover user-table">
<thead>
<tr>
    <th>Họ tên</th>
    <th>Email</th>
    <th>SĐT</th>
    <th>Địa chỉ</th>
    <th>Quyền</th>
    <th>Trạng thái</th>
    <th>Thao tác</th>
</tr>
</thead>

<tbody>
@foreach($users as $u)
<tr>

    <td class="fw-bold">{{ $u->hoten }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->sdt }}</td>
    <td>{{ $u->diachi }}</td>

    {{-- ROLE --}}
    <td>
        <span class="role-badge role-{{ $u->phanquyen->tenquyen }}">
            {{ ucfirst($u->phanquyen->tenquyen) }}
        </span>
    </td>

    {{-- STATUS --}}
    <td>
        @if($u->trang_thai == 1)
            <span class="status-badge status-active">Hoạt động</span>
        @else
            <span class="status-badge status-out">Vô hiệu</span>
        @endif
    </td>

    {{-- ACTION --}}
    <td>
        <a href="{{ route('users.edit',$u->id_nd) }}" class="btn-action btn-edit">Sửa</a>

        @if($u->trang_thai == 1)
            {{-- VÔ HIỆU --}}
            <form method="POST" class="d-inline" action="{{ route('users.destroy',$u->id_nd) }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-action btn-delete btn-delete-confirm">Vô hiệu</button>
            </form>
        @else
            {{-- KHÔI PHỤC --}}
            <form method="POST" class="d-inline" action="{{ route('users.restore',$u->id_nd) }}">
                @csrf
                <button type="button" class="btn-action btn-restore btn-restore-confirm">Khôi phục</button>
            </form>
        @endif
    </td>

</tr>
@endforeach
</tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btn-delete-confirm').forEach(btn => {
    btn.addEventListener('click', function(){
        Swal.fire({
            title: "Vô hiệu người dùng?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc2626",
            confirmButtonText: "Vô hiệu",
            cancelButtonText: "Hủy"
        }).then(r => { if(r.isConfirmed) this.closest("form").submit(); });
    });
});

document.querySelectorAll('.btn-restore-confirm').forEach(btn => {
    btn.addEventListener('click', function(){
        Swal.fire({
            title: "Khôi phục tài khoản?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#16a34a",
            confirmButtonText: "Khôi phục",
            cancelButtonText: "Hủy"
        }).then(r => { if(r.isConfirmed) this.closest("form").submit(); });
    });
});
</script>

@endsection
