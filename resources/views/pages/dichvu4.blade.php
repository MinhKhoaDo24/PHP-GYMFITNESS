@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/services.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/dichvu4.css') }}">
@endpush

@section('content')

{{-- BANNER Swim --}}
    <section class="service-banner-boxing d-flex align-items-center justify-content-center">
        <div class="banner-boxing-overlay"></div>

        <div class="banner-boxing-content text-center">
            <h1 class="banner-boxing-title">KICK BOXING</h1>

            <a href="{{ url('/donhang') }}" class="banner-boxing-btn">
                Miễn Phí Bơi Thử
            </a>
        </div>
    </section>

    {{-- SECTION: GIỚI THIỆU KICK BOXING --}}
    <section id="kick-intro-section" class="rf-kick-intro">
        <div class="container">
            <div class="row g-4 align-items-start">
                {{-- CỘT TRÁI: TIÊU ĐỀ --}}
                <div class="col-lg-6">
                    <h2 class="rf-kick-title">
                        NHANH HƠN, MẠNH HƠN <br>
                        VỚI KICK BOXING <br>
                        TẠI RISE FITNESS
                    </h2>
                </div>

                {{-- CỘT PHẢI: NỘI DUNG MÔ TẢ --}}
                <div class="col-lg-6">
                    <p class="rf-kick-text">
                        Kick Boxing là môn thể thao kết hợp giữa quyền anh và võ thuật.
                        Không chỉ giúp bạn đốt cháy calo và tăng cường sức mạnh, bộ môn này
                        còn giúp bạn học cách tự vệ và nâng cao tinh thần kỷ luật.
                    </p>
                    <p class="rf-kick-text">
                        Kick Boxing giúp cơ thể được giải phóng, giảm căng thẳng đồng thời
                        tăng cường sức khỏe tim mạch, làm săn chắc cơ và nâng cao bản lĩnh
                        cho người tập.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: LỢI ÍCH BOXING – SLIDER 3 ẢNH --}}
    <section class="boxing-benefit-slider-section py-5">
        <div class="container position-relative">

            {{-- Vùng slider --}}
            <div class="boxing-slider-viewport mx-auto">
                <div class="boxing-slider-track d-flex">
                    {{-- SLIDE 1 --}}
                    <div class="boxing-slide">
                        <img src="{{ asset('frontend/img/boxing-slide-1.jpg') }}" alt="Thư giãn xương khớp">
                        <div class="boxing-slide-overlay"></div>

                        <div class="boxing-slide-content boxing-slide-content-left">
                            <h3 class="boxing-slide-title">TĂNG SỨC MẠNH TOÀN THÂN</h3>
                            <p class="boxing-slide-text">
                                Kick Boxing tác động đồng thời lên tay, chân, core 
                                và vai, giúp tăng sức mạnh cơ bắp và cải thiện sự linh hoạt 
                                trong mọi chuyển động hằng ngày.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 2 --}}
                    <div class="boxing-slide">
                        <img src="{{ asset('frontend/img/boxing-slide-2.jpg') }}" alt="Cân bằng tâm trí">
                        <div class="boxing-slide-overlay"></div>

                        <div class="boxing-slide-content boxing-slide-content-right text-end">
                            <h3 class="boxing-slide-title">ĐỐT MỠ NHANH VÀ TĂNG SỨC BỀN</h3>
                            <p class="boxing-slide-text">
                                Các bài tập cường độ cao giúp đốt năng lượng mạnh mẽ, 
                                thúc đẩy trao đổi chất và nâng cao sức bền tim mạch 
                                hiệu quả hơn so với tập cardio thông thường.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 3 --}}
                    <div class="boxing-slide">
                        <img src="{{ asset('frontend/img/boxing-slide-3.jpg') }}" alt="Điều hòa hơi thở">
                        <div class="boxing-slide-overlay"></div>

                        <div class="boxing-slide-content boxing-slide-content-left">
                            <h3 class="boxing-slide-title">GIẢI TỎA CĂNG THẲNG TINH THẦN</h3>
                            <p class="boxing-slide-text">
                                Nhịp tập mạnh mẽ và các cú đấm – đá dứt khoát mang lại 
                                cảm giác giải phóng năng lượng tiêu cực, giúp tinh thần 
                                sảng khoái và tập trung tốt hơn.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút điều hướng --}}
            <button type="button"
                    class="boxing-slider-arrow boxing-slider-prev d-flex align-items-center justify-content-center">
                <span class="boxing-arrow-icon">&lt;</span>
            </button>

            <button type="button"
                    class="boxing-slider-arrow boxing-slider-next d-flex align-items-center justify-content-center">
                <span class="boxing-arrow-icon">&gt;</span>
            </button>

        </div>
    </section>

    {{-- SECTION: KHÁM PHÁ KHÔNG GIAN KICK BOXING --}}
    <section class="rf-kick-offer">
        <div class="container">
            <div class="row g-4 align-items-center">
                {{-- BÊN TRÁI: TEXT + BUTTON --}}
                <div class="col-lg-4">
                    <h2 class="rf-kick-offer-heading">
                        KHÁM PHÁ KHÔNG GIAN<br>
                        KICK BOXING TẠI RISE FITNESS
                    </h2>

                    <a href="{{ url('/donhang') }}" class="rf-kick-offer-btn mt-4 d-inline-flex">
                        Đăng ký tập thử
                    </a>
                </div>

                {{-- BÊN PHẢI: SLIDER 4 ẢNH --}}
                <div class="col-lg-8">
                    <div class="kick-offer-slider">
                        <div class="kick-offer-track" id="kickOfferTrack">
                            <div class="kick-offer-slide">
                                <img src="{{ asset('frontend/img/kick-offer-1.jpg') }}" alt="Kick boxing 1">
                            </div>
                            <div class="kick-offer-slide">
                                <img src="{{ asset('frontend/img/kick-offer-2.jpg') }}" alt="Kick boxing 2">
                            </div>
                            <div class="kick-offer-slide">
                                <img src="{{ asset('frontend/img/kick-offer-3.jpg') }}" alt="Kick boxing 3">
                            </div>
                            <div class="kick-offer-slide">
                                <img src="{{ asset('frontend/img/kick-offer-4.jpg') }}" alt="Kick boxing 4">
                            </div>
                        </div>

                        {{-- NÚT + THANH CHỈ SỐ --}}
                        <div class="kick-offer-controls">
                            <button type="button" class="kick-offer-arrow" id="kickOfferPrev">‹</button>

                            <div class="kick-offer-dots" id="kickOfferDots">
                                <button type="button" class="kick-offer-dot active" data-index="0"></button>
                                <button type="button" class="kick-offer-dot" data-index="1"></button>
                                <button type="button" class="kick-offer-dot" data-index="2"></button>
                                <button type="button" class="kick-offer-dot" data-index="3"></button>
                            </div>

                            <button type="button" class="kick-offer-arrow" id="kickOfferNext">›</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: HÃY CHỌN KICK BOXING CÙNG RISE FITNESS --}}
    <section class="rf-kick-qa">
        <div class="container">
            <div class="row g-4 align-items-start">
                {{-- CỘT TRÁI: 5 LÝ DO (ACCORDION) --}}
                <div class="col-lg-7">
                    <div id="rfKickQaList">
                        {{-- ITEM 1 --}}
                        <div class="rf-kick-qa-item">
                            <button class="rf-kick-qa-header" type="button"
                                    data-toggle="collapse"
                                    data-target="#kickReason1"
                                    aria-expanded="true">
                                <span class="rf-kick-qa-question">
                                    Xả stress và giải tỏa căng thẳng hiệu quả
                                </span>
                                <span class="rf-kick-qa-icon"></span>
                            </button>
                            <div id="kickReason1" class="collapse show"
                                data-parent="#rfKickQaList">
                                <div class="rf-kick-qa-body">
                                    Kick Boxing là bộ môn vận động cường độ cao giúp giải phóng
                                    năng lượng tiêu cực cực tốt. Khi tập luyện tại Rise Fitness, bạn
                                    sẽ được “xả” hết căng thẳng thông qua từng cú đấm, cú đá mạnh mẽ,
                                    từ đó cải thiện tinh thần, giảm stress sau những giờ học tập và
                                    làm việc áp lực.
                                </div>
                            </div>
                        </div>

                        {{-- ITEM 2 --}}
                        <div class="rf-kick-qa-item">
                            <button class="rf-kick-qa-header collapsed" type="button"
                                    data-toggle="collapse"
                                    data-target="#kickReason2"
                                    aria-expanded="false">
                                <span class="rf-kick-qa-question">
                                    Hỗ trợ đốt mỡ nhanh và cải thiện vóc dáng
                                </span>
                                <span class="rf-kick-qa-icon"></span>
                            </button>
                            <div id="kickReason2" class="collapse"
                                data-parent="#rfKickQaList">
                                <div class="rf-kick-qa-body">
                                    Kick Boxing giúp tiêu hao từ 500 – 800 calo mỗi buổi tập nhờ
                                    sự kết hợp giữa cardio và sức mạnh toàn thân. Tập luyện tại
                                    Rise Fitness giúp bạn giảm mỡ, săn chắc cơ thể nhanh chóng,
                                    đặc biệt là vùng bụng, đùi và bắp tay, mang lại vóc dáng
                                    gọn gàng, khỏe khoắn.
                                </div>
                            </div>
                        </div>

                        {{-- ITEM 3 --}}
                        <div class="rf-kick-qa-item">
                            <button class="rf-kick-qa-header collapsed" type="button"
                                    data-toggle="collapse"
                                    data-target="#kickReason3"
                                    aria-expanded="false">
                                <span class="rf-kick-qa-question">
                                    Phù hợp cho cả người mới bắt đầu
                                </span>
                                <span class="rf-kick-qa-icon"></span>
                            </button>
                            <div id="kickReason3" class="collapse"
                                data-parent="#rfKickQaList">
                                <div class="rf-kick-qa-body">
                                    Các lớp Kick Boxing tại Rise Fitness được thiết kế từ cơ bản
                                    đến nâng cao, phù hợp với cả những người chưa từng tập. Huấn
                                    luyện viên theo sát từng động tác, chỉnh form liên tục giúp bạn
                                    an tâm tập luyện, hạn chế chấn thương và tiến bộ rõ rệt chỉ sau
                                    vài tuần.
                                </div>
                            </div>
                        </div>

                        {{-- ITEM 4 --}}
                        <div class="rf-kick-qa-item">
                            <button class="rf-kick-qa-header collapsed" type="button"
                                    data-toggle="collapse"
                                    data-target="#kickReason4"
                                    aria-expanded="false">
                                <span class="rf-kick-qa-question">
                                    Nâng cao thể lực và tăng sự tự tin
                                </span>
                                <span class="rf-kick-qa-icon"></span>
                            </button>
                            <div id="kickReason4" class="collapse"
                                data-parent="#rfKickQaList">
                                <div class="rf-kick-qa-body">
                                    Kick Boxing không chỉ rèn luyện sức bền, sức mạnh mà còn
                                    cải thiện phản xạ và khả năng tự vệ. Khi cơ thể khỏe mạnh,
                                    tinh thần vững vàng, bạn sẽ cảm nhận rõ sự tự tin trong
                                    công việc, học tập và cuộc sống hằng ngày.
                                </div>
                            </div>
                        </div>

                        {{-- ITEM 5 --}}
                        <div class="rf-kick-qa-item">
                            <button class="rf-kick-qa-header collapsed" type="button"
                                    data-toggle="collapse"
                                    data-target="#kickReason5"
                                    aria-expanded="false">
                                <span class="rf-kick-qa-question">
                                    Tạo động lực tập luyện lâu dài
                                </span>
                                <span class="rf-kick-qa-icon"></span>
                            </button>
                            <div id="kickReason5" class="collapse"
                                data-parent="#rfKickQaList">
                                <div class="rf-kick-qa-body">
                                    Rise Fitness sở hữu không gian tập hiện đại, âm nhạc sôi động
                                    và môi trường tập luyện trẻ trung, năng động. Khi tập Kick Boxing
                                    tại đây, bạn không chỉ tập thể thao mà còn tận hưởng không khí
                                    tích cực, giúp duy trì thói quen luyện tập bền bỉ mỗi ngày.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: TIÊU ĐỀ LỚN --}}
                <div class="col-lg-5 d-flex align-items-start justify-content-lg-end">
                    <div class="rf-kick-qa-title text-lg-end">
                        <p class="rf-kick-qa-title-line">HÃY CHỌN</p>
                        <p class="rf-kick-qa-title-line">KICK BOXING</p>
                        <p class="rf-kick-qa-title-line">CÙNG RISE FITNESS</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.rf-packages')

    {{-- SECTION: CHIA SẺ KHÁCH HÀNG KICK BOXING --}}
    <section class="rf-kb-testimonials">
        <div class="container">
            {{-- HEADING --}}
            <div class="text-center mb-5">
                <h2 class="rf-kb-testimonials-heading">
                    CHIA SẺ CỦA KHÁCH HÀNG TẠI RISE FITNESS CENTER
                </h2>
            </div>

            <div class="row g-4 justify-content-center">
                {{-- CARD 1 --}}
                <div class="col-lg-6 col-md-10">
                    <div class="kb-testimonial-card h-100">
                        {{-- ẢNH NỬA TRÊN --}}
                        <div class="kb-testi-image">
                            <img src="{{ asset('frontend/img/kb-review-1.jpg') }}"
                                alt="Khách hàng Kick Boxing Trần Đức Hải">
                        </div>

                        {{-- NỘI DUNG NỬA DƯỚI --}}
                        <div class="kb-testi-body">
                            <h3 class="kb-testi-name">
                                TRẦN ĐỨC HẢI
                                <span class="kb-testi-separator">×</span>
                                KICK BOXING
                            </h3>

                            <div class="kb-testi-stars">
                                ★ ★ ★ ★ ★
                            </div>

                            <p class="kb-testi-text">
                                “Từ khi tập Kick Boxing, mình cảm thấy tinh thần phấn chấn hơn hẳn.
                                Những buổi tập đầy năng lượng không chỉ giúp mình xả stress mà còn
                                giúp cơ thể mình linh hoạt và săn chắc hơn. Cảm ơn sự hỗ trợ nhiệt
                                tình từ đội ngũ HLV tại Level đã giúp mình tiến bộ nhanh chóng
                                và duy trì động lực tập luyện.”
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD 2 --}}
                <div class="col-lg-6 col-md-10">
                    <div class="kb-testimonial-card h-100">
                        {{-- ẢNH NỬA TRÊN --}}
                        <div class="kb-testi-image">
                            <img src="{{ asset('frontend/img/kb-review-2.jpg') }}"
                                alt="Khách hàng Kick Boxing Nguyễn Phương Linh">
                        </div>

                        {{-- NỘI DUNG NỬA DƯỚI --}}
                        <div class="kb-testi-body">
                            <h3 class="kb-testi-name">
                                NGUYỄN PHƯƠNG LINH
                                <span class="kb-testi-separator">×</span>
                                KICK BOXING
                            </h3>

                            <div class="kb-testi-stars">
                                ★ ★ ★ ★ ★
                            </div>

                            <p class="kb-testi-text">
                                “Mình đã tập luyện Kick Boxing tại Level được hơn 1 năm.
                                Từ một cô gái rụt rè, nhút nhát mình đã trở nên mạnh mẽ,
                                tự tin và không ngại thể hiện bản thân. Cảm ơn Level đã
                                đồng hành cùng mình trên hành trình phát triển và thay đổi
                                bản thân!”
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const section = document.getElementById('kick-intro-section');
        if (!section) return;

        const title = section.querySelector('.rf-kick-title');
        if (!title) return;

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        title.classList.add('is-visible');
                        observer.unobserve(section); // chỉ chạy 1 lần
                    }
                });
            },
            { threshold: 0.3 }
        );

        observer.observe(section);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const track   = document.querySelector('.boxing-slider-track');
        const slides  = Array.from(document.querySelectorAll('.boxing-slide'));
        const prevBtn = document.querySelector('.boxing-slider-prev');
        const nextBtn = document.querySelector('.boxing-slider-next');

        if (!track || slides.length === 0) return;

        let currentIndex = 0;

        function updateSlider() {
            const slideWidth = slides[0].offsetWidth + 12; // 12px ~ margin/gap
            track.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
        }

        function goNext() {
            currentIndex = (currentIndex + 1) % slides.length; // chạy vòng tròn
            updateSlider();
        }

        function goPrev() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider();
        }

        nextBtn.addEventListener('click', goNext);
        prevBtn.addEventListener('click', goPrev);

        // Cập nhật lại khi resize để đảm bảo tính toán đúng
        window.addEventListener('resize', updateSlider);

        // set vị trí ban đầu
        updateSlider();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const track  = document.getElementById('kickOfferTrack');
        if (!track) return;

        const slides = track.querySelectorAll('.kick-offer-slide');
        const prev   = document.getElementById('kickOfferPrev');
        const next   = document.getElementById('kickOfferNext');
        const dots   = document.querySelectorAll('.kick-offer-dot');

        let current = 0;
        const total = slides.length;

        function updateSlider(index) {
            current = (index + total) % total; // vòng tròn 0 → 3 → 0 ...
            track.style.transform = `translateX(-${current * 100}%)`;

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === current);
            });
        }

        prev.addEventListener('click', () => updateSlider(current - 1));
        next.addEventListener('click', () => updateSlider(current + 1));

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const idx = parseInt(dot.dataset.index, 10);
                updateSlider(idx);
            });
        });
    });
</script>

@endpush