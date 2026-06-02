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

                        @if(Auth::check())
                        <li class="{{ request()->is('donhang') ? 'active' : '' }}">
                            <a href="{{ URL::to('/donhang') }}" class="hover-a">Đơn hàng</a>
                        </li>
                        <li class="{{ request()->is('goi-tap/lich-su') ? 'active' : '' }}">
                            <a href="{{ route('goitap.history') }}" class="hover-a">Gói tập của tôi</a>
                        </li>
                        @else
                        <li class="{{ request()->is('tra-cuu-don-hang') ? 'active' : '' }}">
                            <a href="{{ URL::to('/tra-cuu-don-hang') }}" class="hover-a">Tra cứu đơn hàng</a>
                        </li>
                        @endif
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
                        $totalQty = is_array($cart) ? count($cart) : 0;
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
                            @if(Auth::check())
                            <li><a href="{{ URL::to('/donhang') }}">Đơn hàng</a></li>
                            @else
                            <li><a href="{{ URL::to('/tra-cuu-don-hang') }}">Tra cứu đơn hàng</a></li>
                            @endif
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
                <span>Rise Fitness © All Rights Reserved – 2026</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.js-add-to-cart');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const coSize = btn.getAttribute('data-co-size');
            const isSupplement = btn.getAttribute('data-is-supplement') === '1';
            const productId = btn.getAttribute('data-id') || btn.getAttribute('data-url').split('/').pop();
            const productName = btn.getAttribute('data-name') || 'Sản phẩm';

            if (coSize === '1') {
                let sizes = [];
                try {
                    sizes = JSON.parse(btn.getAttribute('data-sizes') || '[]');
                } catch(err) {
                    console.error(err);
                }

                if (sizes.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Sản phẩm này tạm thời hết hàng hoặc chưa cấu hình!'
                    });
                    return;
                }

                const labelText = isSupplement ? 'Vui lòng chọn hương vị / quy cách của sản phẩm:' : 'Vui lòng chọn kích thước (Size) của sản phẩm:';
                const validationText = isSupplement ? 'Vui lòng chọn hương vị / quy cách trước khi thêm vào giỏ hàng!' : 'Vui lòng chọn một size trước khi thêm vào giỏ hàng!';

                let sizesHtml = `
                    <p style="font-size: 15px; color: #555; margin-bottom: 20px;">${labelText}</p>
                    <div class="swal-size-options" style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; margin-top: 15px; margin-bottom: 15px;">
                `;

                sizes.forEach(sz => {
                    const isOos = sz.qty <= 0;
                    sizesHtml += `
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                            <button type="button" class="swal-size-btn ${isOos ? 'swal-size-disabled' : ''}" 
                                    data-id="${sz.id}" ${isOos ? 'disabled' : ''} 
                                    style="border: 2px dashed ${isOos ? '#e5e7eb' : '#34A4E0'}; background: ${isOos ? '#f3f4f6' : '#fff'}; color: ${isOos ? '#9ca3af' : '#111827'}; padding: 12px 20px; font-weight: 700; font-size: 16px; border-radius: 12px; cursor: ${isOos ? 'not-allowed' : 'pointer'}; min-width: 70px; transition: all 0.25s ease;">
                                ${sz.name}
                            </button>
                            <span style="font-size: 12px; font-weight: 600; color: ${isOos ? '#ef4444' : '#10b981'}">
                                ${isOos ? 'Hết hàng' : 'Còn hàng'}
                            </span>
                        </div>
                    `;
                });

                sizesHtml += `</div>`;

                Swal.fire({
                    title: productName,
                    html: sizesHtml,
                    showCancelButton: true,
                    confirmButtonText: 'Thêm vào giỏ hàng',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#34A4E0',
                    cancelButtonColor: '#6B7280',
                    didOpen: () => {
                        const btns = Swal.getHtmlContainer().querySelectorAll('.swal-size-btn');
                        btns.forEach(b => {
                            b.addEventListener('click', function() {
                                btns.forEach(x => {
                                    x.classList.remove('active');
                                    x.style.borderStyle = 'dashed';
                                    x.style.borderColor = '#34A4E0';
                                    x.style.backgroundColor = '#fff';
                                    x.style.color = '#111827';
                                });
                                this.classList.add('active');
                                this.style.borderStyle = 'solid';
                                this.style.borderColor = '#34A4E0';
                                this.style.backgroundColor = '#34A4E0';
                                this.style.color = '#fff';
                            });
                        });
                    },
                    preConfirm: () => {
                        const active = Swal.getHtmlContainer().querySelector('.swal-size-btn.active');
                        if (!active) {
                            Swal.showValidationMessage(validationText);
                            return false;
                        }
                        return active.getAttribute('data-id');
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        const selectedSizeId = result.value;
                        const url = `/add-to-cart/${productId}?id_size=${selectedSizeId}&quantity=1`;
                        submitAddToCartAjax(url);
                    }
                });

            } else {
                const url = btn.getAttribute('data-url') || btn.getAttribute('href');
                if (!url || url === '#' || url === 'javascript:void(0)') return;
                submitAddToCartAjax(url);
            }
        }, true);

        function submitAddToCartAjax(url) {
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(async res => {
                let data = {};
                try {
                    data = await res.json();
                } catch(err) {
                    data = { message: "Đã thêm sản phẩm vào giỏ hàng!" };
                }

                if (res.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: data.message || 'Đã thêm sản phẩm vào giỏ hàng!',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    const cartBadge = document.querySelector('.navbar__shoppingCart span');
                    if (cartBadge && typeof data.cart_count !== 'undefined') {
                        cartBadge.textContent = data.cart_count;
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: data.message || 'Không thể thêm vào giỏ hàng!',
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                });
            });
        }
    </script>
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

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session("success") }}',
            timer: 3000,
            showConfirmButton: true
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '{{ session("error") }}',
            showConfirmButton: true
        });
    </script>
    @endif

    @if(session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Cảnh báo',
            text: '{{ session("warning") }}',
            showConfirmButton: true
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