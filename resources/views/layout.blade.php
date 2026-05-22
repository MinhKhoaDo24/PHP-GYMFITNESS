<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng đến với Rise Fitness & Yoga</title>
    <link rel="shortcut icon" type="image/png" href="/frontend/img/LOGO.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link rel="stylesheet" href="/frontend/css/bsgrid.min.css" />
    <link rel="stylesheet" href="/frontend/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- header-footer -->
    <link rel="stylesheet" href="/frontend/css/main.css" />
    @stack('styles')
    @stack('scripts')
    <style>
        .footer-newsletter__form {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .footer-newsletter__form input[type="email"] {
            flex: 1;
            padding: 12px 16px;
            font-size: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #000;
            transition: 0.3s ease;
            outline: none;
        }

        .footer-newsletter__form input[type="email"]::placeholder {
            color: #999;
        }

        .footer-newsletter__form input[type="email"]:hover {
            background: #ffffff;
            border-color: #bbb;
        }

        .footer-newsletter__form input[type="email"]:focus {
            background: #000;
            border-color: #2563eb;
            box-shadow: 0px 0px 0px 3px rgba(37, 99, 235, 0.25);
        }

        .footer-newsletter__form button {
            padding: 12px 20px;
            background: #2563eb;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            white-space: nowrap;
        }

        .footer-newsletter__form button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .footer-newsletter__form button:active {
            transform: translateY(0px);
            background: #1e40af;
        }
    </style>
</head>

<body style="margin: 0; min-height: 100vh; display: flex; flex-direction: column;">

    <header>
        <div class="header">
            <div class="navbar">
                <div class="navbar__left">
                    <a href="{{ URL::to('/')}}" class="navbar__logo">
                        <img src="{{ asset('frontend/img/LOGO.png') }}" alt="">
                    </a>
                    <ul class="navbar__menu-list">
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ URL::to('/') }}" class="hover-a">Trang chủ</a>
                        </li>
                        <li class="{{ request()->is('services') ? 'active' : '' }}">
                            <a href="{{ URL::to('/services') }}" class="hover-a">Giới thiệu </a>
                        </li>
                        <li class="dropdown {{ request()->is('viewAll*') ? 'active' : '' }}" id="sanpham-dropdown">
                            <a href="javascript:void(0)" class="hover-a">Sản phẩm</a>
                            <ul class="dropdown-menu" id="dropdown-danhmuc">
                                {{-- ➤ MỤC TẤT CẢ --}}
                                <li>
                                    <a href="{{ url('/viewAll') }}" class="dropdown-item">
                                        Tất cả
                                    </a>
                                </li>

                                {{-- ➤ DANH MỤC --}}
                                @foreach($categories as $dm)
                                <li>
                                    <a href="{{ url('/viewAll?category=' . $dm->id_danhmuc) }}" class="dropdown-item">
                                        {{ $dm->ten_danhmuc }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown {{ request()->is('dich-vu/*') ? 'active' : '' }}">
                            <a href="javascript:void(0)" class="hover-a">Dịch vụ </a>
                            <ul class="dropdown-menu dropdown-services">
                                <li><a href="{{ route('services.gym') }}">Gym</a></li>
                                <li><a href="{{ route('services.yoga') }}">Yoga</a></li>
                                <li><a href="{{ route('services.swimming') }}">Swimming</a></li>
                                <li><a href="{{ route('services.kickboxing') }}">Kick Boxing</a></li>
                                <li><a href="{{ route('services.dance') }}">Dance</a></li>
                            </ul>
                        </li>
                        <li class="{{ request()->is('dang-ky-tap-thu') ? 'active' : '' }}">
                            <a href="{{ route('dang-ky-tap-thu') }}" class="hover-a">Đăng ký tập thử</a>
                        </li>

                        <li class="{{ request()->is('donhang') ? 'active' : '' }}">
                            <a href="{{ URL::to('/donhang') }}" class="hover-a">Đơn hàng</a>
                        </li>
                    </ul>
                </div>

                <div class="navbar__center">
                    <form action="{{route('search')}}" method="GET" class="navbar__search">
                        <input type="text" value="" placeholder="Nhập để tìm kiếm..." name="tukhoa" class="search" required>
                        <i class="fa fa-search" id="searchBtn"></i>
                    </form>
                </div>

                <div class="navbar__right">
                    @if (Auth::check())
                    <div class="user-info">
                        <a href="{{ route('profile.show') }}" class="hover-effect user-name-link">
                            {{ Auth::user()->hoten }} <i class="fas fa-user-circle"></i>
                        </a>
                    </div>
                    <div class="logout">
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="border: none; background: transparent; cursor: pointer;"
                                type="submit" id="logoutBtn" class="hover-effect">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="login">
                        <a href="{{ URL::to('login')}}" class="hover-effect">
                            <i class="fa fa-user"></i>
                        </a>
                    </div>
                    @endif
                    <a href="{{ route('cart') }}" class="navbar__shoppingCart hover-effect">
                        <img src="{{ asset('frontend/img/shopping-cart.svg')}}" alt="">

                        @php
                        $cart = session('cart', []);
                        $totalQty = 0;

                        if (is_array($cart)) {
                            foreach ($cart as $item) {
                                $totalQty += $item['quantity'] ?? 0;
                            }
                        }
                        @endphp

                        <span>{{ $totalQty }}</span>
                    </a>
                </div>
            </div>
        </div>
    </header>


    <div class="main-content" style="flex:1; padding-top: 60px;"> @yield('content')
    </div>

    <div class="go-to-top"><i class="fas fa-chevron-up"></i></div>

    <section class="footer-newsletter">
        <div class="footer-container">
            <div class="footer-newsletter__left" style="padding-bottom: 20px;">
                <p class="footer-newsletter__subtitle">ĐĂNG KÝ NHẬN THÔNG TIN</p>
                <h2 class="footer-newsletter__title">Kết nối với chúng tôi</h2>
            </div>

            <div class="footer-newsletter__center">
                <form action="{{ route('mail.subscribe') }}" method="POST" class="footer-newsletter__form">
                    @csrf
                    <input type="email" name="email" placeholder="Nhập email của bạn ..." required>
                    <button type="submit">Đăng ký ngay</button>
                </form>
            </div>

            <div class="footer-newsletter__right">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter / X"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="footer-container">

            <div class="site-footer__top">
                <div class="site-footer__col site-footer__brand">
                    <div class="site-footer__logo">
                        <img src="{{ asset('frontend/img/LOGO.png') }}" alt="Rise Fitness">
                        <span>RISE FITNESS</span>
                    </div>
                    <p class="site-footer__desc">
                        Dù bạn mới bắt đầu hay đã tập luyện lâu năm, Rise Fitness luôn đồng hành
                        để mỗi buổi tập của bạn trở nên đặc biệt, tràn đầy năng lượng và cảm hứng.
                    </p>
                </div>

                <div class="site-footer__col site-footer__links">
                    <h3>Khám phá</h3>
                    <div class="site-footer__links-grid">
                        <ul>
                            <li><a href="{{ URL::to('/services') }}">Giới thiệu</a></li>
                            <li><a href="{{ URL::to('/test') }}">Dịch vụ</a></li>
                            <li><a href="{{ URL::to('/donhang') }}">Đơn hàng</a></li>
                            <li><a href="{{ URL::to('/viewAll') }}">Sản phẩm</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Liên hệ</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                </div>

                <div class="site-footer__col site-footer__contact">
                    <h3>Liên hệ</h3>

                    <div class="site-footer__contact-item">
                        <div class="site-footer__contact-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="site-footer__contact-text">
                            <span class="label">Địa chỉ:</span>
                            <span>12 Chùa Bộc, Đống Đa, Hà Nội</span>
                        </div>
                    </div>

                    <div class="site-footer__contact-item">
                        <div class="site-footer__contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="site-footer__contact-text">
                            <span class="label">Điện thoại:</span>
                            <span>0-900-856-05-39</span>
                        </div>
                    </div>

                    <div class="site-footer__contact-item">
                        <div class="site-footer__contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="site-footer__contact-text">
                            <span class="label">Giờ làm việc:</span>
                            <span>Thứ 2–Thứ 6: 8:00 – 21:00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="site-footer__bottom">
                <span>Rise Fitness © All Rights Reserved – 2025</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    @if(session('thongbao'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session("thongbao") }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif



    <script>
        document.getElementById('logoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Đăng xuất?',
                text: "Bạn có chắc chắn muốn đăng xuất không?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đăng xuất',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>
    <script>
        //Slider using Slick (giữ nguyên, đảm bảo các phần tử có class này tồn tại)
        $(document).ready(function() {
            if ($('.post-wrapper').length) { // Chỉ khởi tạo nếu phần tử tồn tại
                $('.post-wrapper').slick({
                    slidesToScroll: 1,
                    autoplay: true,
                    arrow: true,
                    dots: true,
                    autoplaySpeed: 5000,
                    prevArrow: $('.prev'),
                    nextArrow: $('.next'),
                    appendDots: $(".dot"),
                });
            }
        });

        // Slick mutiple carousel (giữ nguyên, đảm bảo các phần tử có class này tồn tại)
        if ($('.post-wrapper2').length) { // Chỉ khởi tạo nếu phần tử tồn tại
            $('.post-wrapper2').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                prevArrow: $('.prev2'),
                nextArrow: $('.next2'),
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 3,
                            infinite: true,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        }
    </script>
    <script src="/frontend/script/script.js"></script>
</body>

</html>