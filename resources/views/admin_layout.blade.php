<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>Admin Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="/frontend/img/LOGO.png" />

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- App CSS --}}
    <link href="{{ asset('backend/css/app.css')}}" rel="stylesheet"/>
    <link href="{{ asset('backend/css/style.css')}}" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet"/>
</head>

<body>
<div class="wrapper">

    {{-- =================== SIDEBAR =================== --}}
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">

            {{-- Logo --}}
            <a class="sidebar-brand d-flex align-items-center gap-2" href="{{ url('/dashboard') }}">
                <span class="sidebar-logo-circle">
                    <img src="/frontend/img/LOGO.png" alt="Logo">
                </span>
                <span class="fw-bold sidebar-logo-text">RISE </span>
                <span class="fw-bold" style="color:#fff;">FITNESS</span>
            </a>

            <ul class="sidebar-nav mt-3">

                <li class="sidebar-header text-uppercase small text-muted">
                    <span style="color: #fff;">Quản trị hệ thống</span>
                </li>

                {{-- DASHBOARD --}}
                <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ url('/dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>

                {{-- ĐƠN HÀNG --}}
                <li class="sidebar-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex align-items-center"
                    data-bs-toggle="collapse"
                    href="#orderMenu"
                    role="button">
                        <i class="bi bi-cart3 me-2"></i> Đơn hàng
                    </a>

                    <ul id="orderMenu"
                        class="collapse list-unstyled ms-4 {{ request()->routeIs('orders.*') ? 'show' : '' }}">

                        <li>
                            <a class="sidebar-link submenu-link {{ request()->routeIs('orders.pending') ? 'active-sub' : '' }}"
                            href="{{ route('orders.pending') }}">
                                Đơn chờ xử lý
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-link submenu-link {{ request()->routeIs('orders.shipping') ? 'active-sub' : '' }}"
                            href="{{ route('orders.shipping') }}">
                                Đơn đang giao
                            </a>
                        </li>

                        <li>
                            <a class="sidebar-link submenu-link {{ request()->routeIs('orders.done') ? 'active-sub' : '' }}"
                            href="{{ route('orders.done') }}">
                                Đơn đã hoàn thành
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ĐĂNG KÝ --}}
                <li class="sidebar-item {{ request()->is('admin/dangki*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ url('/admin/dangki') }}">
                        <i class="bi bi-journal-text me-2"></i> Danh sách đăng ký
                    </a>
                </li>

                {{-- KHUYẾN MÃI --}}
                <li class="sidebar-item {{ request()->is('admin/khuyenmai*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ url('/admin/khuyenmai') }}">
                        <i class="bi bi-percent me-2"></i> Khuyến mãi
                    </a>
                </li>

                {{-- SẢN PHẨM --}}
                <li class="sidebar-item {{ request()->is('admin/product*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ url('/admin/product') }}">
                        <i class="bi bi-box-seam me-2"></i> Sản phẩm
                    </a>
                </li>

                {{-- DANH MỤC --}}
                <li class="sidebar-item {{ request()->is('admin/danhmuc*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ url('/admin/danhmuc') }}">
                        <i class="bi bi-list-ul me-2"></i> Danh mục sản phẩm
                    </a>
                </li>

                {{-- NGƯỜI DÙNG --}}
                <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ url('/admin/users') }}">
                        <i class="bi bi-people me-2"></i> Người dùng
                    </a>
                </li>



            </ul>


        </div>
    </nav>

    {{-- =================== MAIN =================== --}}
    <div class="main">

        {{-- =================== NAVBAR =================== --}}
        <nav class="navbar navbar-expand navbar-light navbar-bg custom-navbar">
            <div class="container-fluid d-flex justify-content-between align-items-center">


                {{-- USER DROPDOWN --}}
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle user-toggle d-flex align-items-center gap-2"
                           href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">

                            <img src="{{ asset('backend/img/avatars/avatar.jpg') }}"
                                 class="avatar-img" alt="User">

                            <span class="username text-uppercase fw-bold">
                                {{ Auth::user()->hoten }}
                            </span>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow user-menu"
                            aria-labelledby="userDropdown">

                            <li>
                                <a class="dropdown-item" href="{{ url('/admin_logout') }}">
                                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>

                    </li>

                </ul>

            </div>
        </nav>

        {{-- =================== CONTENT =================== --}}
        <main class="content">
            @yield('admin_content')
        </main>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start"></div>
                </div>
            </div>
        </footer>

    </div>
</div>

{{-- =================== CUSTOM CSS =================== --}}
<style>
/* ================== THEME COLORS ================== */
:root {
    --gym-primary: #34A4E0;
    --gym-primary-soft: rgba(52,164,224,0.18);

    --sidebar-text: #e5e7eb;
}

/* ================== SIDEBAR ================== */

/* Logo */
.sidebar-logo-circle {
    width: 50px;
    height: 50px;
    border-radius: 999px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(52,164,224,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-logo-circle img {
    width: 80%;
}

.sidebar-logo-text {
    color: var(--gym-primary);
}

/* Menu item (cấp 1) */
.sidebar-link {
    padding: 10px 14px;
    color: var(--sidebar-text);
    border-radius: 10px;
    display: flex;
    align-items: center;
    transition: 0.2s;
}

.sidebar-link i {
    color: #cbd5e1;
}

/* =============== ACTIVE MENU CHA (cấp 1) ================= */
.sidebar-item.active > .sidebar-link {
    background: var(--gym-primary-soft) !important;
    color: var(--gym-primary) !important;
    transform: translateX(3px);
}

.sidebar-item.active > .sidebar-link i {
    color: var(--gym-primary) !important;
}

/* Hover menu cấp 1 */
.sidebar-nav > .sidebar-item > .sidebar-link:hover {
    background: var(--gym-primary-soft);
    color: var(--gym-primary);
    transform: translateX(3px);
}

/* =============== SUBMENU ================= */
.submenu-link {
    padding: 6px 12px;
    font-size: 14px;
    color: #ffffff !important; /* trắng */
    opacity: 0.75;
    transition: 0.15s;
    background: transparent !important;
    display: block;
}

/* Hover submenu */
.submenu-link:hover {
    opacity: 1;
    background: transparent !important;
}

/* Active submenu -> chỉ đổi chữ thành xanh */
.active-sub {
    color: var(--gym-primary) !important;
    font-weight: 600;
    opacity: 1;
}

/* ================= NAVBAR ================= */
.custom-navbar {
    padding: 14px 20px;
}

.navbar-toggle-icon {
    font-size: 28px;
    color: var(--gym-primary);
}

/* Avatar */
.avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid var(--gym-primary);
    object-fit: cover;
}

/* User dropdown */
.user-menu {
    border-radius: 10px;
}

.dropdown-item:hover {
    background: rgba(52,164,224,0.15);
    color: var(--gym-primary);
}
</style>




@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>


@endif

</body>
</html>
