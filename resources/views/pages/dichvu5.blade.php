@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/services.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/dichvu5.css') }}">
@endpush

@section('content')
    {{-- BANNER DANCE --}}
    <section class="service-banner-dance d-flex align-items-center justify-content-center">
        <div class="banner-dance-overlay"></div>

        <div class="banner-dance-content text-center">
            <h1 class="banner-dance-title">DANCE</h1>

            <a href="{{ route('dang-ky-tap-thu') }}" class="banner-dance-btn">
                Miễn Phí Tập Thử
            </a>
        </div>
    </section>

    {{-- SECTION: DANCE BÙNG NỔ NĂNG LƯỢNG --}}
    <section class="rf-dance-benefits">
        <div class="container">

            {{-- HEADING --}}
            <div class="rf-dance-heading text-center">
                <p class="rf-dance-heading-line">
                    NĂNG LƯỢNG BÙNG NỔ VÀ PHONG CÁCH
                </p>
                <p class="rf-dance-heading-line">
                    VỚI NHỮNG LỚP DANCE SÔI ĐỘNG
                </p>
            </div>

            {{-- 3 CARD BENEFITS --}}
            <div class="row g-4 align-items-stretch">

                {{-- CARD 1 --}}
                <div class="col-lg-4 d-flex">
                    <article class="rf-dance-item w-100">
                        <div class="rf-dance-img-wrapper">
                            <img src="{{ asset('frontend/img/dance-benefit-1.jpg') }}" alt="Cải thiện sức khỏe tim mạch">
                        </div>
                        <div class="rf-dance-copy">
                            <h3 class="rf-dance-title">
                                CẢI THIỆN SỨC KHỎE TIM MẠCH
                            </h3>
                            <p class="rf-dance-desc">
                                Tập luyện các bài tập với cường độ cao như Body Combat, Dance,
                                Zumba khiến nhịp tim của bạn tăng lên, thúc đẩy sự tuần hoàn máu
                                và hỗ trợ quá trình lưu thông máu của cơ thể, hạn chế rủi ro đột quỵ
                                và các bệnh tim mạch.
                            </p>
                        </div>
                    </article>
                </div>

                {{-- CARD 2 --}}
                <div class="col-lg-4 d-flex">
                    <article class="rf-dance-item w-100">
                        <div class="rf-dance-img-wrapper">
                            <img src="{{ asset('frontend/img/dance-benefit-2.jpg') }}" alt="Hỗ trợ giảm cân hiệu quả">
                        </div>
                        <div class="rf-dance-copy">
                            <h3 class="rf-dance-title">
                                HỖ TRỢ GIẢM CÂN HIỆU QUẢ
                            </h3>
                            <p class="rf-dance-desc">
                                Một buổi tập GroupX với cường độ cao sẽ giúp bạn đốt cháy
                                600–800 calo. Không chỉ hỗ trợ giảm cân, duy trì vóc dáng
                                săn chắc mà còn tăng cường sự trao đổi chất, giúp cơ thể
                                sử dụng năng lượng hiệu quả hơn trong cả ngày.
                            </p>
                        </div>
                    </article>
                </div>

                {{-- CARD 3 --}}
                <div class="col-lg-4 d-flex">
                    <article class="rf-dance-item w-100">
                        <div class="rf-dance-img-wrapper">
                            <img src="{{ asset('frontend/img/dance-benefit-3.jpg') }}" alt="Thư giãn tinh thần">
                        </div>
                        <div class="rf-dance-copy">
                            <h3 class="rf-dance-title">
                                THƯ GIÃN TINH THẦN
                            </h3>
                            <p class="rf-dance-desc">
                                Hòa mình vào âm nhạc sôi động và không khí hứng khởi trong lớp học
                                sẽ mang đến cho bạn cảm giác vui vẻ, thoải mái, tạo nên sự hứng thú
                                và giúp cơ thể, tâm trí được thư giãn sau những giờ làm việc căng thẳng.
                            </p>
                        </div>
                    </article>
                </div>

            </div>
        </div>
    </section>

    {{-- SECTION: HÃY THAM GIA LỚP HỌC MÀ BẠN YÊU THÍCH --}}
    <section class="dv5-classes-section">
        <div class="container">

            {{-- HEADER --}}
            <h2 class="dv5-classes-heading text-center">
                <span>HÃY THAM GIA LỚP HỌC</span><br>
                <span>MÀ BẠN YÊU THÍCH</span>
            </h2>

            {{-- DIVIDER XANH BIỂN --}}
            <div class="dv5-classes-divider"></div>

            {{-- 3 LABEL: BODY COMBAT / ZUMBA / BACHATA --}}
            <div class="dv5-classes-tabs">
                <span class="dv5-class-tab active" data-index="0">BODY COMBAT</span>
                <span class="dv5-class-tab" data-index="1">ZUMBA</span>
                <span class="dv5-class-tab" data-index="2">BACHATA</span>
            </div>

            {{-- SLIDER 3 ẢNH --}}
            <div class="dv5-classes-slider">
                <div class="dv5-classes-track" id="dv5ClassesTrack">
                    {{-- Slide 1: BODY COMBAT --}}
                    <div class="dv5-class-slide">
                        <img src="{{ asset('frontend/img/body-combat.jpg') }}" alt="Body Combat">
                    </div>

                    {{-- Slide 2: ZUMBA --}}
                    <div class="dv5-class-slide">
                        <img src="{{ asset('frontend/img/zumba.jpg') }}" alt="Zumba">
                    </div>

                    {{-- Slide 3: BACHATA --}}
                    <div class="dv5-class-slide">
                        <img src="{{ asset('frontend/img/bachata.jpg') }}" alt="Bachata">
                    </div>
                </div>
            </div>

        </div>
    </section>

{{-- SECTION: VĂN HÓA TẬP LUYỆN DANCE TẠI RISE FITNESS --}}
    <section class="dv5-culture">
        <div class="container">

            <!-- HEADER -->
            <h2 class="dv5-culture-title text-center">
                VĂN HÓA TẬP LUYỆN DANCE TẠI RISE FITNESS
            </h2>

            <div class="row g-4 align-items-stretch">
                {{-- CỘT TRÁI: ACCORDION + ARROWS --}}
                <div class="col-lg-5">
                    <div class="dv5-acc-wrapper">

                        <!-- ITEM 1 -->
                        <div class="dv5-acc-item dv5-acc-item-active" data-index="0">
                            <button type="button" class="dv5-acc-toggle">
                                <span class="dv5-acc-title">Vào lớp là phải vui</span>
                                <span class="dv5-acc-icon"></span>
                            </button>
                            <div class="dv5-acc-body">
                                <p>
                                    Mỗi buổi tập Dance tại Rise Fitness không chỉ là tập luyện mà còn là buổi
                                    “nạp năng lượng” đúng nghĩa. Âm nhạc sôi động, huấn luyện viên khuấy động
                                    không khí và những tràng cười liên tục khiến bạn quên hết mệt mỏi, chỉ còn
                                    lại cảm giác hứng khởi và muốn quay lại lớp tiếp theo.
                                </p>
                            </div>
                        </div>

                        <!-- ITEM 2 -->
                        <div class="dv5-acc-item" data-index="1">
                            <button type="button" class="dv5-acc-toggle">
                                <span class="dv5-acc-title">Ai cũng có thể nhảy</span>
                                <span class="dv5-acc-icon"></span>
                            </button>
                            <div class="dv5-acc-body">
                                <p>
                                    Tại Rise Fitness, bạn không cần phải nhảy giỏi mới được tham gia.
                                    Từ người mới hoàn toàn đến người đã tập lâu, tất cả đều được tôn trọng
                                    và khích lệ. Không so sánh, không áp lực, chỉ có sự động viên để mỗi
                                    buổi tập là một lần bạn tự tin hơn với chính mình.
                                </p>
                            </div>
                        </div>

                        <!-- ITEM 3 -->
                        <div class="dv5-acc-item" data-index="2">
                            <button type="button" class="dv5-acc-toggle">
                                <span class="dv5-acc-title">Vào là thành một đội</span>
                                <span class="dv5-acc-icon"></span>
                            </button>
                            <div class="dv5-acc-body">
                                <p>
                                    Dance tại Rise Fitness không chỉ là tập một mình mà là tập cùng nhau.
                                    Chỉ sau vài buổi, bạn sẽ quen mặt, quen nhạc, quen từng nhịp đếm và dần
                                    dần được kéo vào một cộng đồng năng động, thân thiện, nơi mọi người cùng
                                    nhảy, cùng đổ mồ hôi và cùng lan tỏa năng lượng tích cực.
                                </p>
                            </div>
                        </div>

                        <!-- ARROWS -->
                        <div class="dv5-culture-arrows">
                            <button type="button" class="dv5-culture-arrow" id="dv5CulturePrev">
                                ‹
                            </button>
                            <button type="button" class="dv5-culture-arrow" id="dv5CultureNext">
                                ›
                            </button>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: SLIDER ẢNH --}}
                <div class="col-lg-7">
                    <div class="dv5-slider">
                        <div class="dv5-slider-track">
                            <!-- SLIDE 1 -->
                            <div class="dv5-slide dv5-slide-active" data-index="0">
                                <div class="dv5-slide-inner">
                                    <img src="{{ asset('frontend/img/dance-culture-1.jpg') }}"
                                        alt="Vào lớp là phải vui">
                                </div>
                            </div>

                            <!-- SLIDE 2 -->
                            <div class="dv5-slide" data-index="1">
                                <div class="dv5-slide-inner">
                                    <img src="{{ asset('frontend/img/dance-culture-2.jpg') }}"
                                        alt="Ai cũng có thể nhảy">
                                </div>
                            </div>

                            <!-- SLIDE 3 -->
                            <div class="dv5-slide" data-index="2">
                                <div class="dv5-slide-inner">
                                    <img src="{{ asset('frontend/img/dance-culture-3.jpg') }}"
                                        alt="Vào là thành một đội">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.rf-packages')

    {{-- SECTION: CHIA SẺ CỦA KHÁCH HÀNG TẠI RISE FITNESS CENTER --}}
    <section class="rf-dance-review-section">
        <div class="container">

            {{-- HEADING 1 DÒNG --}}
            <div class="text-center rf-dance-review-heading">
                <h2 class="rf-dance-review-title">
                    Chia sẻ của khách hàng tại RISE FITNESS CENTER
                </h2>
            </div>

            {{-- SLIDER --}}
            <div class="rf-dance-review-slider-wrapper">
                <div class="rf-dance-review-track" id="danceReviewTrack">

                    {{-- CARD 1 --}}
                    <article class="rf-dance-review-card">
                        <div class="rf-dance-review-image">
                            <img src="{{ asset('frontend/img/tc-dance-3.jpg') }}" alt="Nguyễn Lan Anh Dance">
                        </div>
                        <div class="rf-dance-review-body">
                            <p class="rf-dance-review-name">
                                NGUYỄN THU TRANG <span class="rf-dance-review-x">×</span> DANCE
                            </p>
                            <p class="rf-dance-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-dance-review-text">
                                Trước đây mình tập gym mãi mà chán, từ ngày chuyển sang Zumba tại Rise là mình nghiện luôn. Nhạc sôi động, mọi người trong lớp cực kỳ năng lượng, tập mà không thấy áp lực. Mỗi buổi tập trôi qua rất nhanh, mồ hôi ra nhiều nhưng tinh thần thì cực kỳ thoải mái, vóc dáng cũng gọn gàng rõ rệt.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 2 --}}
                    <article class="rf-dance-review-card">
                        <div class="rf-dance-review-image">
                            <img src="{{ asset('frontend/img/tc-dance-4.jpg') }}" alt="Cao Ngọc Mai Dance">
                        </div>
                        <div class="rf-dance-review-body">
                            <p class="rf-dance-review-name">
                                TRẦN KHÁNH LINH <span class="rf-dance-review-x">×</span> DANCE
                            </p>
                            <p class="rf-dance-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-dance-review-text">
                                Mình chọn Body Combat vì muốn xả stress sau giờ làm và thật sự không ngờ lại hợp đến vậy. Đấm – đá theo nhạc cực đã, mỗi buổi tập như trút hết năng lượng tiêu cực. Sau một thời gian tập đều tại Rise, mình thấy cơ thể săn chắc hơn, ngủ ngon hơn và tinh thần cũng mạnh mẽ hơn rất nhiều.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 3 --}}
                    <article class="rf-dance-review-card">
                        <div class="rf-dance-review-image">
                            <img src="{{ asset('frontend/img/tc-dance-5.jpg') }}" alt="Trần Thu Hà Dance">
                        </div>
                        <div class="rf-dance-review-body">
                            <p class="rf-dance-review-name">
                                LÊ PHƯƠNG AN <span class="rf-dance-review-x">×</span> DANCE
                            </p>
                            <p class="rf-dance-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-dance-review-text">
                                Mình đến với Bachata chỉ vì tò mò, nhưng rồi lại bị cuốn vào lúc nào không hay. Không khí lớp học rất nhẹ nhàng, lãng mạn, thầy dạy cực kỳ tận tâm. Mỗi buổi tập giống như một buổi chữa lành, giúp mình tự tin hơn với cơ thể và cảm xúc của chính mình.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 4 --}}
                    <article class="rf-dance-review-card">
                        <div class="rf-dance-review-image">
                            <img src="{{ asset('frontend/img/tc-dance-6.jpg') }}" alt="Lê Hoàng Nam Dance">
                        </div>
                        <div class="rf-dance-review-body">
                            <p class="rf-dance-review-name">
                                HOÀNG DIỆU LINH <span class="rf-dance-review-x">×</span> DANCE
                            </p>
                            <p class="rf-dance-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-dance-review-text">
                                Điều mình thích nhất khi tập Dance tại Rise là cảm giác được hòa vào một cộng đồng rất tích cực. Mọi người không so sánh, không phán xét, ai cũng động viên nhau. Đi tập không chỉ để giảm cân mà còn để vui, để cười, để kết nối và để yêu bản thân hơn mỗi ngày.
                            </p>
                        </div>
                    </article>

                </div>
            </div>

            {{-- ARROW BUTTONS --}}
            <div class="rf-dance-review-arrows">
                <button type="button" class="rf-dance-review-arrow" id="danceReviewPrev">‹</button>
                <button type="button" class="rf-dance-review-arrow" id="danceReviewNext">›</button>
            </div>

        </div>
    </section>



@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const danceHeading = document.querySelector('.rf-dance-heading');
    if (!danceHeading) return;

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                danceHeading.classList.add('is-visible');
                obs.unobserve(entry.target); // chỉ animate 1 lần
            }
        });
    }, {
        threshold: 0.3  // heading vào ~30% màn hình là bắt đầu hiện
    });

    observer.observe(danceHeading);
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const track = document.getElementById('dv5ClassesTrack');
        if (!track) return;

        const tabs = document.querySelectorAll('.dv5-class-tab');
        const slideCount = track.children.length;
        let currentIndex = 0;
        let autoTimer = null;

        function goToSlide(index) {
            currentIndex = (index + slideCount) % slideCount;
            const offset = -currentIndex * 100; // mỗi slide chiếm 100%
            track.style.transform = `translateX(${offset}%)`;

            tabs.forEach((tab, i) => {
                tab.classList.toggle('active', i === currentIndex);
            });
        }

        function startAuto() {
            stopAuto();
            autoTimer = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 2000); // 2s / ảnh
        }

        function stopAuto() {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        }

        // Hover vào label thì nhảy tới ảnh tương ứng
        tabs.forEach(tab => {
            tab.addEventListener('mouseenter', () => {
                const idx = Number(tab.dataset.index || 0);
                goToSlide(idx);
                startAuto(); // reset vòng auto
            });
        });

        // Khi hover slider thì tạm dừng auto (tuỳ, có thể bỏ nếu không muốn)
        const slider = document.querySelector('.dv5-classes-slider');
        slider.addEventListener('mouseenter', stopAuto);
        slider.addEventListener('mouseleave', startAuto);

        // Khởi tạo
        goToSlide(0);
        startAuto();
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accItems = document.querySelectorAll('.dv5-acc-item');
    const slides = document.querySelectorAll('.dv5-slide');
    const track = document.querySelector('.dv5-slider-track');
    const prevBtn = document.getElementById('dv5CulturePrev');
    const nextBtn = document.getElementById('dv5CultureNext');

    if (!track || slides.length === 0) return;

    let current = 0;

    function updateAccordion(toIndex) {
        accItems.forEach(item => item.classList.remove('dv5-acc-item-active'));
        const activeItem = Array.from(accItems).find(i => Number(i.dataset.index) === toIndex);
        if (activeItem) activeItem.classList.add('dv5-acc-item-active');
    }

    function updateSlides(toIndex) {
        slides.forEach(slide => slide.classList.remove('dv5-slide-active'));
        const activeSlide = Array.from(slides).find(s => Number(s.dataset.index) === toIndex);
        if (activeSlide) activeSlide.classList.add('dv5-slide-active');
    }

    function updateTrackPosition(toIndex) {
        const firstSlide = slides[0];
        const slideWidth = firstSlide.offsetWidth;
        const styles = window.getComputedStyle(firstSlide);
        const gap = parseFloat(styles.marginRight || 0) || 40; // fallback
        const offset = (slideWidth + gap) * toIndex;
        track.style.transform = `translateX(-${offset}px)`;
    }

    function goTo(index) {
        const total = slides.length;
        current = (index + total) % total;
        updateAccordion(current);
        updateSlides(current);
        updateTrackPosition(current);
    }

    // click vào từng tiêu đề
    accItems.forEach(item => {
        item.querySelector('.dv5-acc-toggle').addEventListener('click', () => {
            const idx = Number(item.dataset.index);
            goTo(idx);
        });
    });

    // arrows
    prevBtn.addEventListener('click', () => goTo(current - 1));
    nextBtn.addEventListener('click', () => goTo(current + 1));

    // lần đầu
    window.setTimeout(() => {
        updateTrackPosition(current);
    }, 0);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // id của track: nhớ đặt trong HTML là id="danceReviewTrack"
    const track   = document.getElementById('danceReviewTrack');
    const prevBtn = document.getElementById('danceReviewPrev');
    const nextBtn = document.getElementById('danceReviewNext');

    if (!track || !prevBtn || !nextBtn) return;

    const getStep = () => {
        const card = track.querySelector('.rf-dance-review-card');
        if (!card) return 300;

        const style = window.getComputedStyle(track);
        const gap = parseFloat(style.columnGap || style.gap || 0);
        return card.offsetWidth + gap;
    };

    prevBtn.addEventListener('click', () => {
        track.scrollBy({ left: -getStep(), behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
        track.scrollBy({ left: getStep(), behavior: 'smooth' });
    });
});
</script>

@endpush