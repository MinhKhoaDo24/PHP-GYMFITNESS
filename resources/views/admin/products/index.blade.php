@extends('admin_layout')
@section('admin_content')

<style>
    /* ======================= CARD ======================= */
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

    /* ======================= TABLE HEADER ======================= */
    .product-table thead th {
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

    /* ======================= BODY ======================= */
    .product-table tbody td {
        vertical-align: middle !important;
        padding: 14px 10px;
        font-size: 14px;
        text-align: center;
        white-space: nowrap;
    }
    .product-table tbody td:first-child {
        text-align: left !important;
        white-space: normal;
    }

    /* ======================= BADGE ======================= */
    .status-badge {
        padding: 6px 12px;
        border-radius: 60px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }
    .status-instock { background: #d1fae5; color: #0f766e; }
    .status-low { background: #fde68a; color: #b45309; }
    .status-out { background: #fecaca; color: #b91c1c; }

    /* ======================= ACTION BUTTON ======================= */
    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }
    .btn-action.edit { background: #facc15; color:#000; }
    .btn-action.delete { background: #dc2626; color:#fff; }
    
    .btn-action:hover {
        opacity: .9;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .product-img {
        width: 55px; height: 55px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
</style>

<h1 class="h3 mb-3"><strong>Quản Lý Sản Phẩm</strong></h1>

@if(session('success'))
<div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

{{-- ======================= THỐNG KÊ ======================= --}}
<div class="row g-3 mb-4">

    <div class="col-md-2">
        <div class="sp-card">
            <h2>{{ $stats['total'] }}</h2>
            <span>Tổng sản phẩm</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#22c55e;">
            <h2>{{ $stats['instock'] }}</h2>
            <span>Còn hàng</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#f59e0b;">
            <h2>{{ $stats['low'] }}</h2>
            <span>Sắp hết</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="sp-card" style="border-left-color:#ef4444;">
            <h2>{{ $stats['out'] }}</h2>
            <span>Hết hàng</span>
        </div>
    </div>

    <div class="col-md-4 text-end">
        <a href="{{ route('product.create') }}"
           class="btn btn-success px-4 py-2"style='background-color: #0ea5e9;'>
           Thêm sản phẩm
        </a>
    </div>

</div>

{{-- ======================= TÌM KIẾM & FILTER ======================= --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <form method="GET" class="w-50">
        <input type="text" name="q" class="form-control"
               placeholder="Tìm kiếm sản phẩm..."
               value="{{ request('q') }}">
    </form>

    <div class="d-flex">

    {{-- FILTER DANH MỤC --}}
    <form method="GET" class="me-2">
        <input type="hidden" name="trang_thai" value="{{ request('trang_thai') }}">
        <input type="hidden" name="q" value="{{ request('q') }}">

        <select name="cate" class="form-select" onchange="this.form.submit()">
            <option value="">Tất cả danh mục</option>
            @foreach($danhmucs as $dm)
                <option value="{{ $dm->id_danhmuc }}"
                    {{ request('cate') == $dm->id_danhmuc ? 'selected' : '' }}>
                    {{ $dm->ten_danhmuc }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- FILTER TRẠNG THÁI --}}
    <form method="GET">
        <input type="hidden" name="cate" value="{{ request('cate') }}">
        <input type="hidden" name="q" value="{{ request('q') }}">

        <select name="trang_thai" class="form-select" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="1" {{ request('trang_thai') === '1' ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ request('trang_thai') === '0' ? 'selected' : '' }}>Ẩn</option>
        </select>
    </form>

</div>

</div>

{{-- ======================= BẢNG SẢN PHẨM ======================= --}}
<div class="card p-0 shadow-sm table-responsive">
    <table class="table table-hover product-table mb-0">
    <thead>
        <tr>
            <!-- <th>ẢNH</th> -->
            <th>TÊN SẢN PHẨM</th>
            <th>GIÁ BÁN</th>
            <th>GIẢM GIÁ</th>
            <th>SỐ LƯỢNG</th>
            <th>DANH MỤC</th>
            <th>TỒN KHO</th>
            <th>TRẠNG THÁI</th>
            <th>THAO TÁC</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sanphams as $sp)
        <tr>

            <!-- <td><img src="/{{ $sp->anhsp }}" class="product-img"></td> -->

            <td class="fw-bold">{{ $sp->tensp }}</td>

            <td>{{ number_format($sp->giakhuyenmai, 0, ',', '.') }}đ</td>

            <td>{{ $sp->giamgia }}%</td>

            <td>{{ $sp->soluong }}</td>

            <td>{{ $sp->danhMuc->ten_danhmuc ?? '—' }}</td>

            <td>
                @if($sp->soluong == 0)
                    <span class="status-badge status-out">Hết hàng</span>
                @elseif($sp->soluong < 10)
                    <span class="status-badge status-low">Sắp hết</span>
                @else
                    <span class="status-badge status-instock">Còn hàng</span>
                @endif
            </td>

             <td>
                @if($sp->trang_thai == 0)
                    <span class="status-badge status-out">Ẩn</span>
                @elseif($sp->trang_thai == 1)
                    <span class="status-badge status-instock">Hoạt động</span>
                @endif
            </td>

            <td class="text-center">

                {{-- NÚT SỬA LUÔN HIỆN --}}
                <a href="{{ route('product.edit', $sp->id_sanpham) }}"
                    class="btn-action edit">Sửa</a>


                {{-- TRẠNG THÁI 1 (đang hoạt động) → Cho phép vô hiệu --}}
                @if($sp->trang_thai == 1)

                    <form method="POST" action="{{ route('product.destroy', $sp->id_sanpham) }}"
                        class="d-inline delete-form">
                        @csrf @method('DELETE')
                        <button type="button" class="btn-action delete btn-delete">
                            Vô hiệu
                        </button>
                    </form>

                {{-- TRẠNG THÁI 0 (đã vô hiệu) → Không cho bấm --}}
                @else
                    <button class="btn-action delete" disabled
                            style="opacity:0.6; cursor:not-allowed;">
                        Vô hiệu
                    </button>
                @endif

            </td>

        </tr>
        @endforeach
    </tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: "Xóa sản phẩm?",
                text: "Sản phẩm sẽ bị chuyển vào trạng thái ẩn.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>

@endsection
