<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>PT Dashboard - Rise Fitness</title>
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
            <a class="sidebar-brand d-flex align-items-center gap-2" href="{{ url('/pt/dashboard') }}">
                <span class="sidebar-logo-circle">
                    <img src="/frontend/img/LOGO.png" alt="Logo">
                </span>
                <span class="fw-bold sidebar-logo-text">RISE </span>
                <span class="fw-bold" style="color:#fff;">FITNESS PT</span>
            </a>

            <ul class="sidebar-nav mt-3">

                <li class="sidebar-header text-uppercase small text-muted">
                    <span style="color: #fff;">Chức năng PT</span>
                </li>

                {{-- DASHBOARD --}}
                <li class="sidebar-item {{ request()->routeIs('pt.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pt.dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>

                {{-- KHÁCH HÀNG --}}
                <li class="sidebar-item {{ request()->routeIs('pt.khachhang') || request()->routeIs('pt.chiso.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pt.khachhang') }}">
                        <i class="bi bi-people me-2"></i> Khách hàng
                    </a>
                </li>

                {{-- THÔNG BÁO --}}
                <li class="sidebar-item {{ request()->routeIs('pt.thongbao') ? 'active' : '' }}">
                    <a class="sidebar-link d-flex justify-content-between align-items-center" href="{{ route('pt.thongbao') }}">
                        <div><i class="bi bi-bell me-2"></i> Thông báo</div>
                        @php
                            $unreadCount = \App\Models\Thongbao::where('id_nguoidung', Auth::user()->id_nd)->where('da_doc', 0)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                        @endif
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
                                PT: {{ Auth::user()->hoten }}
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
            @yield('pt_content')
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
/* ================== SCROLL OVERRIDES ================== */
html, body {
    height: auto !important;
}
.wrapper {
    overflow: visible !important;
}
.main {
    overflow-y: auto !important;
    min-height: 100vh;
}

/* ================== THEME COLORS ================== */
:root {
    --gym-primary: #10b981; /* Đổi màu xanh lá cho PT để phân biệt Admin */
    --gym-primary-soft: rgba(16, 185, 129, 0.18);
    --sidebar-text: #e5e7eb;
}

/* ================== SIDEBAR ================== */

/* Logo */
.sidebar-logo-circle {
    width: 50px;
    height: 50px;
    border-radius: 999px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(16, 185, 129, 0.35);
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

/* ================= NAVBAR ================= */
.custom-navbar {
    padding: 14px 20px;
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
    background: rgba(16, 185, 129, 0.15);
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
