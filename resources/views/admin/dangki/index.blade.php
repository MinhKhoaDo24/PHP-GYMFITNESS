@extends('admin_layout')
@section('admin_content')

<style>
/* ================= CARD THỐNG KÊ (DONG BỘ KHUYẾN MÃI) ================= */
.sp-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        text-align: center;
        border-left: 5px solid #0ea5e9;
    }
.sp-card h2 {
        font-size: 28px;
        margin: 0;
        font-weight: 700;
    }
.sp-card span {
        font-size: 14px;
        color: #666;
    }


/* ================= FILTER BAR ================= */
.filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: nowrap;
    gap: 25px;
    padding: 10px 0 20px 0;
}

.filter-left {
    display: flex;
    gap: 25px;
    align-items: center;
}

.filter-left label {
    font-weight: 600;
    margin-right: 6px;
    color: #374151;
}

.filter-right {
    display: flex;
    gap: 10px;
    align-items: center;
}

/* ================= TABS ================= */
.tab-item {
    padding: 10px 20px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 500;
    background: #f9fafb;
    color: #374151;
    border: 1px solid #e5e7eb;
    text-decoration: none !important;
    transition: 0.25s ease;
    white-space: nowrap;
}

.tab-item:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.tab-item.active {
    background: #0284c7 !important;
    color: #fff !important;
    border-color: #0284c7 !important;
    box-shadow: 0px 2px 8px rgba(2, 132, 199, 0.25);
}




/* ================= TABLE ================= */
.promo-table thead th {
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
   BODY – CĂN GIỮA TẤT CẢ, TRỪ CỘT TÊN
========================================= */
.promo-table tbody td {
    vertical-align: middle !important;
    padding: 14px 10px;
    font-size: 14px;
    text-align: center;
    white-space: nowrap;
}
.promo-table tbody td:nth-child(2) {
    text-align: left !important;
}
/* Cột Tên căn trái */
.promo-table tbody td:first-child {
    text-align: left !important;
    white-space: normal;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 60px;
    font-weight: 600;
    font-size: 13px;
    display: inline-block;
}

.status-badge.active {
    background: #d1fae5;
    color: #0f766e;
}

.status-badge.paused {
    background: #fde68a;
    color: #b45309;
}

.status-badge.expired {
    background: #fecaca;
    color: #b91c1c;
}


/* ================= ACTION ================= */
.btn-action {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    border: none;
}

.btn-edit { background:#facc15; color:#000; }
.btn-delete { background:#dc2626; color:#fff; }

.btn-action:hover {
    opacity:.9;
}

.tab-wrapper {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-bottom: 18px;
}

.tab-item {
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 500;
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
    text-decoration: none !important; /* bỏ gạch chân */
    transition: 0.25s ease;
}

.tab-item:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.tab-item.active {
    background: #0ea5e9;
    color: #fff;
    border-color: #0ea5e9;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
}
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
.pagination {
    display: flex;
    gap: 6px;
}

.page-item .page-link {
    padding: 8px 14px;
    border-radius: 8px;
    color: #374151;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-weight: 500;
    transition: 0.2s ease;
}

.page-item .page-link:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.page-item.active .page-link {
    background: #0284c7;
    border-color: #0284c7;
    color: #fff;
    box-shadow: 0 2px 6px rgba(2,132,199,0.25);
}

.page-item.disabled .page-link {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
}
.pagination-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center; /* Căn giữa */
    justify-content: center;
    text-align: center;
}

.pagination-info {
    font-size: 14px;
    color: #6b7280;
}

.pagination {
    margin-top: 6px;
    display: flex;
    justify-content: center !important; /* Căn giữa nút */
    gap: 6px;
}
.pagination-wrapper p.small.text-muted {
    display: none !important;
}


</style>

<h1 class="h3 mb-3"><strong>Danh sách đăng ký tập thử</strong></h1>

{{-- =============== THỐNG KÊ =============== --}}
<div class="row g-3 mb-4">

    <div class="col-md-2">
        <div class="sp-card">
            <h2>{{ $stats['total'] ?? '0' }}</h2>
            <span>Tổng đăng ký</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#64748b;">
            <h2>{{ $stats['dangki'] ?? '0' }}</h2>
            <span>Mới đăng ký</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#22c55e;">
            <h2>{{ $stats['xacnhan'] ?? '0' }}</h2>
            <span>Đã xác nhận</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#ef4444;">
            <h2>{{ $stats['hoanthanh'] ?? '0' }}</h2>
            <span>Đã tập thử</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#f59e0b;">
            <h2>{{ $stats['huy'] ?? '0' }}</h2>
            <span>Đã hủy</span>
        </div>
    </div>



</div>

{{-- =============== BỘ LỌC + TABS TRÊN 1 HÀNG =============== --}}
<div class="filter-bar">

    {{-- LEFT: BỘ LỌC --}}
    <div class="filter-left">

        {{-- Lọc theo ngày --}}
        <form method="GET" class="d-flex align-items-center">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="sort_time" value="{{ request('sort_time') }}">

            <label>Ngày:</label>
            <input type="date" name="date" class="form-control"
                   style="width: 180px;"
                   value="{{ request('date') }}"
                   onchange="this.form.submit()">
        </form>

        {{-- Lọc theo giờ --}}
        <form method="GET" class="d-flex align-items-center">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="date" value="{{ request('date') }}">

            <label>Giờ:</label>
            <select name="sort_time" class="form-select"
                    style="width: 200px;" onchange="this.form.submit()">
                <option value="">-- Sắp xếp theo giờ --</option>
                <option value="asc"  {{ request('sort_time')=='asc' ? 'selected':'' }}>Tăng dần</option>
                <option value="desc" {{ request('sort_time')=='desc' ? 'selected':'' }}>Giảm dần</option>
            </select>
        </form>

    </div>

    {{-- RIGHT: TABS TRẠNG THÁI --}}
    <div class="filter-right">

        <a href="{{ url('/admin/dangki') }}"
           class="tab-item {{ request('status') == '' ? 'active' : '' }}">
            Tất cả
        </a>

        <a href="{{ url('/admin/dangki?status=0') }}"
           class="tab-item {{ request('status') == '0' ? 'active' : '' }}">
            Mới đăng ký
        </a>

        <a href="{{ url('/admin/dangki?status=1') }}"
           class="tab-item {{ request('status') == '1' ? 'active' : '' }}">
            Đã xác nhận
        </a>


        <a href="{{ url('/admin/dangki?status=3') }}"
           class="tab-item {{ request('status') == '2' ? 'active' : '' }}">
            Hoàn thành
        </a>

        <a href="{{ url('/admin/dangki?status=4') }}"
           class="tab-item {{ request('status') == '3' ? 'active' : '' }}">
            Hủy
        </a>

    </div>

</div>


{{-- =============== BẢNG DỮ LIỆU =============== --}}
<table class="table table-hover promo-table">
    <thead>
        <tr>
            <th>HỌ VÀ TÊN</th>
            <th>SDT</th>
            <th>GIỜ TẬP</th>
            <th>NGÀY TẬP</th>
            <th>GHI CHÚ</th>
            <th>TRẠNG THÁI</th>
            <th>THAO TÁC</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $item)
        <tr>
            {{-- TÊN --}}
            <td class="fw-bold">{{ $item->ho_ten }}</td>

            {{-- SDT --}}
            <td><span class="fw-bold">{{ $item->so_dien_thoai }}</span></td>


            {{-- GIỜ TẬP --}}
            <td class="fw-bold">{{ $item->gio_mong_muon }}</td>
            <td class="fw-bold">{{ $item->ngay_mong_muon }}</td>
            <td class="fw-bold">{{ $item->ghi_chu }}</td>
            
            {{-- TRẠNG THÁI --}}
            <td>
                @if($item->trangthai == 0)
                    <span class="status-badge expired">Mới</span>
                @elseif($item->trangthai == 1)
                    <span class="status-badge active">Xác nhận</span>
                @elseif($item->trangthai == 2)
                    <span class="status-badge active">Hoàn thành</span>
                @else
                    <span class="status-badge paused">Hủy</span>
                @endif
            </td>

            {{-- ACTION --}}

            <td class="text-center">

                {{-- Nút Sửa luôn hiển thị --}}
                <a href="{{ route('dangki.edit', $item->id_dang_ky) }}" 
                    class="btn-action edit" style='text-decoration: none;'>Cập nhật</a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>


<div class="pagination-wrapper mt-3">
    {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.btnDelete').forEach(btn => {
    btn.addEventListener('click', function(){
        let form = this.closest('form');
        Swal.fire({
            title: "Xóa đăng ký?",
            text: "Hành động này không thể hoàn tác!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc2626",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy"
        }).then(result => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    })
});
</script>

@endsection
