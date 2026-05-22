@extends('admin_layout')
@section('admin_content')

<style>
        .km-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            border-left: 5px solid #0ea5e9;
        }
        .km-card h2 {
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }
        .km-card span {
            font-size: 14px;
            color: #666;
        }

        .km-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            color: white;
        }
        .badge-active { background: #0d9488; }
        .badge-stop { background: #f43f5e; }
        .badge-expired { background: #fb923c; }


/* =========================================
   TABLE HEADER
========================================= */
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

/* Cột Tên căn trái */
.promo-table tbody td:first-child {
    text-align: left !important;
    white-space: normal;
}

/* =========================================
   CODE BADGE
========================================= */
.promo-code {
    background: #007bff;
    color: #fff;
    padding: 6px 16px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
    display: inline-block;
}

/* =========================================
   NGÀY THÁNG
========================================= */
.promo-date {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 13px;
}

/* =========================================
   TRẠNG THÁI
========================================= */
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

/* =========================================
   ACTION BUTTONS
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
    transform: translateY(-1px);
    text-decoration: none;
}


</style>

<h1 class="h3 mb-3"><strong>Quản Lý Khuyến Mãi</strong></h1>

{{-- SUCCESS MESSAGE --}}
@if(session()->has('success'))
<div class="alert alert-success mb-3">
    {{ session('success') }}
</div>
@endif

{{-- ===================== THỐNG KÊ ===================== --}}
<div class="row g-3 mb-4">

    <div class="col-md-2">
        <div class="km-card">
            <h2>{{ $stats['total'] }}</h2>
            <span>Tổng khuyến mãi</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="km-card" style="border-left-color:#22c55e;">
            <h2>{{ $stats['active'] }}</h2>
            <span>Đang hoạt động</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="km-card" style="border-left-color:#64748b;">
            <h2>{{ $stats['paused'] }}</h2>
            <span>Tạm dừng</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="km-card" style="border-left-color:#ef4444;">
            <h2>{{ $stats['expired'] }}</h2>
            <span>Hết hạn</span>
        </div>
    </div>

    <div class="col-md-2">
        <div class="km-card" style="border-left-color:#f59e0b;">
            <h2>{{ $stats['used'] }}</h2>
            <span>Lượt sử dụng</span>
        </div>
    </div>

    <div class="col-md-2 text-end">
        <a href="{{ route('khuyenmai.create') }}" class="btn btn-success px-4 py-2" style='background-color: #0ea5e9;'>
          Thêm khuyến mãi
        </a>
    </div>
</div>

{{-- ===================== TÌM KIẾM + FILTER ===================== --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <form method="GET" class="w-50">
        <input type="text" name="q" class="form-control"
               placeholder="🔍 Tìm kiếm theo tên hoặc mã khuyến mãi..."
               value="{{ request('q') }}">
    </form>

    <div class="d-flex">
        <form method="GET" class="me-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">📚 Tất cả trạng thái</option>
                <option value="1" {{ request('status')==1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Tạm ngưng</option>
                <option value="0" {{ request('status')==='2' ? 'selected' : '' }}>Hết hạn</option>
            </select>
        </form>

        <form method="GET">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">💰 Tất cả loại</option>
                <option value="percent" {{ request('type')=='percent' ? 'selected' : '' }}>Giảm %</option>
                <option value="money" {{ request('type')=='money' ? 'selected' : '' }}>Giảm tiền</option>
            </select>
        </form>
    </div>
</div>

{{-- ===================== BẢNG DỮ LIỆU ===================== --}}
<table class="table table-hover promo-table">
    <thead>
        <tr>
            <th>TÊN CHƯƠNG TRÌNH</th>
            <th>MÃ CODE</th>
            <th>GIẢM GIÁ</th>
            <th>ĐƠN TỐI THIỂU</th>
            <th>SỬ DỤNG</th>
            <th>THỜI GIAN</th>
            <th>TRẠNG THÁI</th>
            <th>THAO TÁC</th>
        </tr>
    </thead>

    <tbody>
        @foreach($khuyenmais as $km)
        <tr>
            {{-- TÊN --}}
            <td class="fw-bold">{{ $km->ten_khuyenmai }}</td>

            {{-- CODE --}}
            <td><span class="promo-code">{{ $km->ma_code }}</span></td>

            {{-- GIẢM GIÁ --}}
            <td>
                @if($km->kieu_giam == 'percent')
                    <strong>{{ $km->gia_tri_giam }}%</strong>
                @else
                    <strong>{{ number_format($km->gia_tri_giam) }}%</strong>
                @endif
            </td>

            {{-- ĐƠN TỐI THIỂU --}}
            <td>{{ $km->don_toi_thieu ? number_format($km->don_toi_thieu).' VNĐ' : '—' }}</td>

            {{-- SỬ DỤNG --}}
            <td>{{ $km->so_lan_su_dung ?? 0 }}</td>

            {{-- THỜI GIAN --}}
            <td>
                <div class="promo-date">
                    {{ date('d/m/Y', strtotime($km->ngay_bat_dau)) }}  
                    <span class="mx-1">→</span>  
                    {{ date('d/m/Y', strtotime($km->ngay_ket_thuc)) }}
                </div>
            </td>

            {{-- TRẠNG THÁI --}}
            <td>
                @if($km->trang_thai == 2)
                    <span class="status-badge expired">Hết hạn</span>
                @elseif($km->trang_thai == 1)
                    <span class="status-badge active">Hoạt động</span>
                @else
                    <span class="status-badge paused">Tạm dừng</span>
                @endif
            </td>

            {{-- ACTION --}}

            <td class="text-center">

                {{-- Nút Sửa luôn hiển thị --}}
                <a href="{{ route('khuyenmai.edit', $km->id_khuyenmai) }}" 
                    class="btn-action edit">Sửa</a>

                {{-- KIỂM TRA HẾT HẠN --}}
                @if($km->trang_thai == 2 || $km->trang_thai == 0)

                    {{-- Hết hạn → nút vô hiệu bị khóa --}}
                    <button class="btn-action delete" disabled style="opacity:0.6; cursor:not-allowed;">
                        Vô hiệu
                    </button>

                @elseif($km->trang_thai == 1)
                    {{-- Đang hoạt động → cho phép vô hiệu --}}
                    <form class="d-inline delete-form"
                        action="{{ route('khuyenmai.destroy', $km->id_khuyenmai) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn-action delete btn-delete">
                            Vô hiệu
                        </button>
                    </form>



                @else
                @endif

            </td>

        </tr>
        @endforeach
    </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ---------------------------
    // CONFIRM UPDATE
    // ---------------------------
    const updateBtn = document.querySelector('#btnUpdate');
    const updateForm = document.querySelector('#updateForm');

    if(updateBtn){
        updateBtn.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Cập nhật khuyến mãi?",
                text: "Bạn có chắc chắn muốn lưu thay đổi?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#10b981",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Cập nhật",
                cancelButtonText: "Hủy"
            }).then(result => {
                if (result.isConfirmed) {
                    updateForm.submit();
                }
            });
        });
    }

    // ---------------------------
    // CONFIRM DELETE / DISABLE
    // ---------------------------
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: "Vô hiệu hóa khuyến mãi?",
                text: "Khuyến mãi sẽ chuyển sang trạng thái không hoạt động.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Vô hiệu",
                cancelButtonText: "Hủy"
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>





@endsection
