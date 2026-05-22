@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/services.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/dichvu3.css') }}">
@endpush

@section('content')

{{-- BANNER Swim --}}
    <section class="service-banner-swim d-flex align-items-center justify-content-center">
        <div class="banner-swim-overlay"></div>

        <div class="banner-swim-content text-center">
            <h1 class="banner-swim-title">BỂ BƠI BỐN MÙA</h1>

            <a href="{{ url('/donhang') }}" class="banner-swim-btn">
                Miễn Phí Bơi Thử
            </a>
        </div>
    </section>

{{-- SECTION: THIẾT KẾ THEO TIÊU CHUẨN OLYMPIC --}}
    <section class="rf-swim-standard">
        <div class="container">
            <div class="row g-4 align-items-start">
                {{-- CỘT TRÁI: TIÊU ĐỀ --}}
                <div class="col-lg-6">
                    <div class="rf-swim-standard-heading">
                        <p class="rf-swim-standard-title">THIẾT KẾ THEO TIÊU CHUẨN</p>
                        <p class="rf-swim-standard-title">OLYMPIC</p>
                    </div>
                </div>

                {{-- CỘT PHẢI: NỘI DUNG MÔ TẢ --}}
                <div class="col-lg-6">
                    <div class="rf-swim-standard-text">
                        <p>
                            Bể bơi Rise Fitness thuộc khuôn viên tổ hợp thể thao và giải trí
                            Rise Fitness Center, tự hào dẫn đầu dịch vụ bơi và học bơi tại Hà Nội.
                        </p>
                        <p>
                            Với diện tích 25×15m, độ sâu 1m2–2m, cùng 6 làn bơi riêng biệt và
                            thiết kế vòm kính sang trọng, hiện đại, bể bơi Rise Fitness đáp ứng
                            mọi mục tiêu bơi lội từ thư giãn, rèn luyện sức khỏe đến tập luyện
                            chuyên nghiệp.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    {{-- SECTION: CÁC TRẢI NGHIỆM BƠI TẠI RISE FITNESS --}}
    <section class="rf-swim-program-section">
        <div class="container">
            <div class="rf-swim-program-wrapper">

                {{-- ARROW BUTTONS --}}
                <button type="button"
                        class="rf-swim-program-arrow rf-swim-program-arrow-left"
                        id="swimProgramPrev">
                    ‹
                </button>
                <button type="button"
                        class="rf-swim-program-arrow rf-swim-program-arrow-right"
                        id="swimProgramNext">
                    ›
                </button>

                {{-- TRACK SLIDER --}}
                <div class="rf-swim-program-track" id="swimProgramTrack">
                    {{-- CARD 1 --}}
                    <article class="rf-swim-program-card">
                        <div class="rf-swim-program-image">
                            <img src="{{ asset('frontend/img/swim-program-1.jpg') }}"
                                alt="Không gian bơi lội chuyên nghiệp">
                            <div class="rf-swim-program-overlay text-center">
                                <h3 class="rf-swim-program-title">
                                    KHÔNG GIAN BƠI LỘI<br>CHUYÊN NGHIỆP
                                </h3>
                                <a href="{{ url('/donhang') }}" class="rf-swim-program-btn">
                                    Trải nghiệm miễn phí
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- CARD 2 --}}
                    <article class="rf-swim-program-card">
                        <div class="rf-swim-program-image">
                            <img src="{{ asset('frontend/img/swim-program-2.jpg') }}"
                                alt="Khóa học bơi cơ bản đến nâng cao">
                            <div class="rf-swim-program-overlay text-center">
                                <h3 class="rf-swim-program-title">
                                    KHÓA HỌC BƠI<br>CƠ BẢN ĐẾN NÂNG CAO
                                </h3>
                                <a href="{{ url('/donhang') }}" class="rf-swim-program-btn">
                                    Trải nghiệm miễn phí
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- CARD 3 --}}
                    <article class="rf-swim-program-card">
                        <div class="rf-swim-program-image">
                            <img src="{{ asset('frontend/img/swim-program-3.jpg') }}"
                                alt="Hệ thống làm nóng Heatpump">
                            <div class="rf-swim-program-overlay text-center">
                                <h3 class="rf-swim-program-title">
                                    HỆ THỐNG LÀM NÓNG<br>BẰNG CÔNG NGHỆ HEATPUMP
                                </h3>
                                <a href="{{ url('/donhang') }}" class="rf-swim-program-btn">
                                    Trải nghiệm miễn phí
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- CARD 4 --}}
                    <article class="rf-swim-program-card">
                        <div class="rf-swim-program-image">
                            <img src="{{ asset('frontend/img/swim-program-4.jpg') }}"
                                alt="An tâm bơi lội không ngại khô da hại tóc">
                            <div class="rf-swim-program-overlay text-center">
                                <h3 class="rf-swim-program-title">
                                    AN TÂM BƠI LỘI<br>KHÔNG NGẠI KHÔ DA, HẠI TÓC
                                </h3>
                                <a href="{{ url('/donhang') }}" class="rf-swim-program-btn">
                                    Trải nghiệm miễn phí
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- CARD 5 --}}
                    <article class="rf-swim-program-card">
                        <div class="rf-swim-program-image">
                            <img src="{{ asset('frontend/img/swim-program-5.jpg') }}"
                                alt="Nồng độ pH ổn định">
                            <div class="rf-swim-program-overlay text-center">
                                <h3 class="rf-swim-program-title">
                                    NỒNG ĐỘ PH<br>LUÔN GIỮ Ở MỨC ỔN ĐỊNH
                                </h3>
                                <a href="{{ url('/donhang') }}" class="rf-swim-program-btn">
                                    Trải nghiệm miễn phí
                                </a>
                            </div>
                        </div>
                    </article>

                    {{-- CARD 6 --}}
                    <article class="rf-swim-program-card">
                        <div class="rf-swim-program-image">
                            <img src="{{ asset('frontend/img/swim-program-6.jpg') }}"
                                alt="Lọc nước và khử khuẩn bằng ozone và tia UV">
                            <div class="rf-swim-program-overlay text-center">
                                <h3 class="rf-swim-program-title">
                                    LỌC NƯỚC &amp; KHỬ KHUẨN<br>BẰNG OZONE VÀ TIA UV
                                </h3>
                                <a href="{{ url('/donhang') }}" class="rf-swim-program-btn">
                                    Trải nghiệm miễn phí
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: TIỆN ÍCH ĐI KÈM – SLIDER 3 ẢNH --}}
    <section class="rf-swim-facility-section">
        <div class="container">
            {{-- TIÊU ĐỀ --}}
            <h2 class="rf-swim-facility-title">
                TẬN HƯỞNG CÁC TIỆN ÍCH ĐI KÈM
            </h2>

            {{-- SLIDER 3 ẢNH --}}
            <div class="rf-swim-facility-slider">
                <div class="rf-swim-facility-track" id="swimFacilityTrack">
                    {{-- ẢNH 1 --}}
                    <div class="rf-swim-facility-slide">
                        <img src="{{ asset('frontend/img/swim-facility-1.jpg') }}"
                            alt="Tủ locker, khăn, nước miễn phí">
                    </div>

                    {{-- ẢNH 2 --}}
                    <div class="rf-swim-facility-slide">
                        <img src="{{ asset('frontend/img/swim-facility-2.jpg') }}"
                            alt="BỂ SỤC">
                    </div>

                    {{-- ẢNH 3 --}}
                    <div class="rf-swim-facility-slide">
                        <img src="{{ asset('frontend/img/swim-facility-3.jpg') }}"
                            alt="Xông khô đá muối">
                    </div>
                </div>
            </div>

            {{-- 3 CHỮ ĐIỀU HƯỚNG --}}
            <div class="rf-swim-facility-nav" id="swimFacilityNav">
                <span class="rf-swim-facility-nav-item active" data-slide="0">
                    Tủ locker, khăn, nước miễn phí
                </span>
                <span class="rf-swim-facility-nav-item" data-slide="1">
                    BỂ SỤC
                </span>
                <span class="rf-swim-facility-nav-item" data-slide="2">
                    Xông khô đá muối
                </span>
            </div>
        </div>
    </section>

    {{-- DẢI NGANG HIỆU ỨNG --}}
        <div class="rf-divider-track">
            <div class="rf-divider-fill"></div>
        </div>

    {{-- SECTION: HỌC BƠI 1-1 & HỌC BƠI THEO NHÓM --}}
    <section class="rf-swim-lessons-section">
        <div class="container">
            <div class="row g-4">

                {{-- CỘT TRÁI: HỌC BƠI 1-1 --}}
                <div class="col-lg-6">
                    <div class="rf-swim-lesson">

                        {{-- SLIDER 1 --}}
                        <div class="rf-swim-slider" data-swim-slider="1">
                            <div class="rf-swim-slide active">
                                <img src="{{ asset('frontend/img/swim-11-1.jpg') }}" alt="Học bơi 1-1 slide 1">
                            </div>
                            <div class="rf-swim-slide">
                                <img src="{{ asset('frontend/img/swim-11-2.jpg') }}" alt="Học bơi 1-1 slide 2">
                            </div>
                            <div class="rf-swim-slide">
                                <img src="{{ asset('frontend/img/swim-11-3.jpg') }}" alt="Học bơi 1-1 slide 3">
                            </div>
                            <div class="rf-swim-slide">
                                <img src="{{ asset('frontend/img/swim-11-4.jpg') }}" alt="Học bơi 1-1 slide 4">
                            </div>

                            {{-- NÚT & THANH CHỈ BÁO --}}
                            <div class="rf-swim-controls">
                                <button type="button"
                                        class="rf-swim-arrow rf-swim-arrow-prev">
                                    ‹
                                </button>

                                <div class="rf-swim-dots">
                                    <span class="rf-swim-dot active"></span>
                                    <span class="rf-swim-dot"></span>
                                    <span class="rf-swim-dot"></span>
                                    <span class="rf-swim-dot"></span>
                                </div>

                                <button type="button"
                                        class="rf-swim-arrow rf-swim-arrow-next">
                                    ›
                                </button>
                            </div>
                        </div>

                        {{-- TEXT DƯỚI ẢNH --}}
                        <div class="rf-swim-text text-center mt-4">
                            <h3 class="rf-swim-title">
                                HỌC BƠI 1-1 CÙNG HLV CHUYÊN NGHIỆP
                            </h3>
                            <p class="rf-swim-desc">
                                Tự tin chinh phục mọi kiểu bơi dưới sự hướng dẫn của đội ngũ HLV giàu kinh
                                nghiệm và chuyên môn cao.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: HỌC BƠI THEO NHÓM --}}
                <div class="col-lg-6">
                    <div class="rf-swim-lesson">

                        {{-- SLIDER 2 --}}
                        <div class="rf-swim-slider" data-swim-slider="2">
                            <div class="rf-swim-slide active">
                                <img src="{{ asset('frontend/img/swim-group-1.jpg') }}" alt="Học bơi theo nhóm slide 1">
                            </div>
                            <div class="rf-swim-slide">
                                <img src="{{ asset('frontend/img/swim-group-2.jpg') }}" alt="Học bơi theo nhóm slide 2">
                            </div>
                            <div class="rf-swim-slide">
                                <img src="{{ asset('frontend/img/swim-group-3.jpg') }}" alt="Học bơi theo nhóm slide 3">
                            </div>
                            <div class="rf-swim-slide">
                                <img src="{{ asset('frontend/img/swim-group-4.jpg') }}" alt="Học bơi theo nhóm slide 4">
                            </div>

                            {{-- NÚT & THANH CHỈ BÁO --}}
                            <div class="rf-swim-controls">
                                <button type="button"
                                        class="rf-swim-arrow rf-swim-arrow-prev">
                                    ‹
                                </button>

                                <div class="rf-swim-dots">
                                    <span class="rf-swim-dot active"></span>
                                    <span class="rf-swim-dot"></span>
                                    <span class="rf-swim-dot"></span>
                                    <span class="rf-swim-dot"></span>
                                </div>

                                <button type="button"
                                        class="rf-swim-arrow rf-swim-arrow-next">
                                    ›
                                </button>
                            </div>
                        </div>

                        {{-- TEXT DƯỚI ẢNH --}}
                        <div class="rf-swim-text text-center mt-4">
                            <h3 class="rf-swim-title">
                                HỌC BƠI THEO NHÓM
                            </h3>
                            <p class="rf-swim-desc">
                                Tiết kiệm hơn với các khoá học bơi theo nhóm từ 2–5 thành viên, không khí vui vẻ
                                mà vẫn đảm bảo chất lượng buổi học.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- NÚT LIÊN HỆ TƯ VẤN (CĂN GIỮA) --}}
            <div class="text-center mt-5">
                <a href="{{ route('dang-ky-tap-thu') }}" class="rf-swim-cta-btn">
                    Liên hệ tư vấn
                </a>
            </div>
        </div>
    </section>

    @include('partials.rf-packages')

    {{-- SECTION: CHIA SẺ CỦA KHÁCH HÀNG TẠI RISE FITNESS CENTER --}}
    <section class="rf-swim-review-section">
        <div class="container">

            {{-- HEADING --}}
            <div class="rf-swim-review-heading text-center">
                <h2 class="rf-swim-review-title">
                    CHIA SẺ CỦA KHÁCH HÀNG TẠI RISE FITNESS CENTER
                </h2>
            </div>

            {{-- SLIDER --}}
            <div class="rf-swim-review-slider-wrapper mt-4">
                <div class="rf-swim-review-track" id="swimReviewTrack">
                    {{-- CARD 1 --}}
                    <article class="rf-swim-review-card">
                        <div class="rf-swim-review-img">
                            <img src="{{ asset('frontend/img/swim-review-1.jpg') }}" alt="Nguyễn Đức Anh bơi lội">
                        </div>
                        <div class="rf-swim-review-body">
                            <p class="rf-swim-review-name">
                                NGUYỄN ĐỨC ANH <span class="rf-swim-review-tag">× BƠI LỘI</span>
                            </p>
                            <div class="rf-swim-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </div>
                            <p class="rf-swim-review-text">
                                Mình thích bơi ở bể này vì không quá đông như các bể cư dân, lại sạch sẽ hơn nên bơi
                                hằng ngày mà không chán. Bể nước ấm nên mình bơi quanh năm cả mùa đông chứ không chỉ mùa hè.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 2 --}}
                    <article class="rf-swim-review-card">
                        <div class="rf-swim-review-img">
                            <img src="{{ asset('frontend/img/swim-review-2.jpg') }}" alt="Nguyễn Bá Sang bơi lội">
                        </div>
                        <div class="rf-swim-review-body">
                            <p class="rf-swim-review-name">
                                NGUYỄN BÁ SANG <span class="rf-swim-review-tag">× BƠI LỘI</span>
                            </p>
                            <div class="rf-swim-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </div>
                            <p class="rf-swim-review-text">
                                Cháu học bơi cùng em trai ở đây. Sau khi tham gia khóa học, hai anh em không chỉ bơi tốt
                                hơn mà còn tự tin hơn rất nhiều khi xuống nước.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 3 --}}
                    <article class="rf-swim-review-card">
                        <div class="rf-swim-review-img">
                            <img src="{{ asset('frontend/img/swim-review-3.jpg') }}" alt="Cao Ngọc Mai bơi lội">
                        </div>
                        <div class="rf-swim-review-body">
                            <p class="rf-swim-review-name">
                                CAO NGỌC MAI <span class="rf-swim-review-tag">× BƠI LỘI</span>
                            </p>
                            <div class="rf-swim-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </div>
                            <p class="rf-swim-review-text">
                                Bể bơi rộng, nước trong, khu locker sạch sẽ nên mình rất yên tâm cho con học bơi tại đây.
                                Các thầy cô nhiệt tình, luôn để ý sát sao từng bạn nhỏ.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>    
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track   = document.getElementById('swimProgramTrack');
    const prevBtn = document.getElementById('swimProgramPrev');
    const nextBtn = document.getElementById('swimProgramNext');

    if (!track || !prevBtn || !nextBtn) return;

    let currentIndex = 0;

    // chiều rộng 1 "trang" (2 card đang nhìn thấy)
    const getPageWidth = () => track.clientWidth;

    // số trang (nhóm 2 card) – tự tính theo tổng chiều rộng
    const getPageCount = () => {
        const wClient = track.clientWidth;
        const wScroll = track.scrollWidth;
        return Math.max(1, Math.round(wScroll / wClient));
    };

    const goToIndex = (i) => {
        const pages = getPageCount();
        // wrap vòng tròn: ...,-1,0,1,... → 0..pages-1
        currentIndex = ((i % pages) + pages) % pages;
        const x = currentIndex * getPageWidth();
        track.scrollTo({ left: x, behavior: 'smooth' });
    };

    nextBtn.addEventListener('click', () => {
        goToIndex(currentIndex + 1);
    });

    prevBtn.addEventListener('click', () => {
        goToIndex(currentIndex - 1);
    });

    // khi resize màn hình, giữ nguyên slide đang đứng
    window.addEventListener('resize', () => {
        goToIndex(currentIndex);
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const track = document.getElementById('swimFacilityTrack');
        const nav = document.getElementById('swimFacilityNav');
        if (!track || !nav) return;

        const slides = track.querySelectorAll('.rf-swim-facility-slide');
        const navItems = nav.querySelectorAll('.rf-swim-facility-nav-item');
        const totalSlides = slides.length;
        let currentIndex = 0;
        let autoTimer = null;

        function setActiveNav(index) {
            navItems.forEach((item, i) => {
                item.classList.toggle('active', i === index);
            });
        }

        function showSlide(index) {
            currentIndex = (index + totalSlides) % totalSlides; // vòng tròn
            const offset = -currentIndex * 100; // mỗi slide = 100%
            track.style.transform = `translateX(${offset}%)`;
            setActiveNav(currentIndex);
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoTimer = setInterval(function () {
                showSlide(currentIndex + 1);
            }, 2000); // 5 giây đổi ảnh
        }

        function stopAutoSlide() {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        }

        // Hover vào từng chữ để nhảy tới ảnh tương ứng
        navItems.forEach(item => {
            item.addEventListener('mouseenter', function () {
                const index = parseInt(this.getAttribute('data-slide'), 10) || 0;
                showSlide(index);
                startAutoSlide(); // reset timer để chạy tiếp
            });
        });

        // Khởi động
        showSlide(0);
        startAutoSlide();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.rf-swim-slider').forEach(function (slider) {
            const slides = slider.querySelectorAll('.rf-swim-slide');
            const dots   = slider.querySelectorAll('.rf-swim-dot');
            const prev   = slider.querySelector('.rf-swim-arrow-prev');
            const next   = slider.querySelector('.rf-swim-arrow-next');

            let current = 0;

            function goTo(index) {
                const total = slides.length;
                current = (index + total) % total;

                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === current);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === current);
                });
            }

            prev.addEventListener('click', () => goTo(current - 1));
            next.addEventListener('click', () => goTo(current + 1));

            dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => goTo(idx));
            });
        });
    });
</script>


@endpush