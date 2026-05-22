@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/services.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/dichvu1.css') }}">
@endpush

@section('content')
    <section class="service-banner-gym d-flex align-items-center justify-content-center">
        <div class="banner-gym-overlay"></div>

        <div class="banner-gym-content text-center">
            <h1 class="banner-gym-title">GYM</h1>

            <a href="{{ route('dang-ky-tap-thu') }}" class="banner-gym-btn">
                Miễn Phí Tập Thử
            </a>
        </div>
    </section>

    <section class="gym-info-section">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="left gym-info-left">
                        <h2 class="gym-info-heading">
                            BỨT PHÁ MỌI GIỚI HẠN<br>
                            CƠ THỂ CÙNG GYM
                        </h2>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="right gym-info-right">
                        <p>
                            Gym là hình thức tập luyện sử dụng hệ thống máy móc, tạ tự do và các bài tập kháng lực
                            để tác động có chủ đích lên từng nhóm cơ. Thông qua việc sắp xếp bài tập theo giáo án rõ ràng,
                            người tập có thể kiểm soát mức tạ, số lần lặp và thời gian nghỉ, từ đó xây dựng vóc dáng
                            và sức mạnh một cách có kế hoạch.
                        </p>
                        <p>
                            Khi tập gym đều đặn, bạn không chỉ nâng cao sức khỏe tim mạch, xương khớp mà còn giải tỏa
                            căng thẳng, ngủ sâu hơn và tinh thần thoải mái hơn.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: LỢI ÍCH GYM – SLIDER 6 ẢNH --}}
    <section class="gym-benefit-slider-section py-5">
        <div class="container position-relative">

            {{-- Vùng slider --}}
            <div class="gym-slider-viewport mx-auto">
                <div class="gym-slider-track d-flex">

                    {{-- SLIDE 1 --}}
                    <div class="gym-slide">
                        <img src="{{ asset('frontend/img/gym-slide-1.jpg') }}" alt="Cải Thiện Tim Mạch">
                        <div class="gym-slide-overlay"></div>

                        <div class="gym-slide-content gym-slide-content-left">
                            <h3 class="gym-slide-title">CẢI THIỆN TIM MẠCH</h3>
                            <p class="gym-slide-text">
                                Các bài tập gym giúp tim hoạt động hiệu quả hơn, tăng lưu thông máu và
                                hỗ trợ phòng ngừa bệnh lý tim mạch.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 2 --}}
                    <div class="gym-slide">
                        <img src="{{ asset('frontend/img/gym-slide-2.jpg') }}" alt="Giảm Stress và Lo Âu">
                        <div class="gym-slide-overlay"></div>

                        <div class="gym-slide-content gym-slide-content-left">
                            <h3 class="gym-slide-title">GIẢM STRESS VÀ LO ÂU</h3>
                            <p class="gym-slide-text">
                                Vận động đều đặn kích thích giải phóng endorphin, giúp tinh thần thư giãn,
                                giảm căng thẳng và lo âu.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 3 --}}
                    <div class="gym-slide">
                        <img src="{{ asset('frontend/img/gym-slide-3.jpg') }}" alt="Tăng Cường Sức Mạnh">
                        <div class="gym-slide-overlay"></div>

                        <div class="gym-slide-content gym-slide-content-left">
                            <h3 class="gym-slide-title">TĂNG CƯỜNG SỨC MẠNH</h3>
                            <p class="gym-slide-text">
                                Tập tạ và kháng lực giúp gia tăng sức mạnh cơ bắp, cải thiện khả năng vận động
                                và hiệu suất sinh hoạt hằng ngày.
                            </p>
                        </div>
                    </div>

                    {{-- ========================== --}}
                    {{-- SLIDE 4 – NỘI DUNG MỚI --}}
                    {{-- ========================== --}}
                    <div class="gym-slide">
                        <img src="{{ asset('frontend/img/gym-slide-4.jpg') }}" alt="Kiểm Soát Cân Nặng">
                        <div class="gym-slide-overlay"></div>

                        <div class="gym-slide-content gym-slide-content-left">
                            <h3 class="gym-slide-title">KIỂM SOÁT CÂN NẶNG</h3>
                            <p class="gym-slide-text">
                                Kết hợp luyện tập và dinh dưỡng phù hợp giúp đốt cháy calo,
                                hỗ trợ duy trì hoặc điều chỉnh cân nặng hiệu quả.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 5 – NỘI DUNG MỚI --}}
                    <div class="gym-slide">
                        <img src="{{ asset('frontend/img/gym-slide-5.jpg') }}" alt="Tăng Sức Bền Cơ Thể">
                        <div class="gym-slide-overlay"></div>

                        <div class="gym-slide-content gym-slide-content-left">
                            <h3 class="gym-slide-title">TĂNG SỨC BỀN CƠ THỂ</h3>
                            <p class="gym-slide-text">
                                Các bài tập cardio và thể lực cải thiện sức bền, giúp cơ thể hoạt động lâu
                                hơn mà không bị mệt mỏi.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 6 – NỘI DUNG MỚI --}}
                    <div class="gym-slide">
                        <img src="{{ asset('frontend/img/gym-slide-6.jpg') }}" alt="Cải Thiện Tư Thế">
                        <div class="gym-slide-overlay"></div>

                        <div class="gym-slide-content gym-slide-content-left">
                            <h3 class="gym-slide-title">CẢI THIỆN TƯ THẾ</h3>
                            <p class="gym-slide-text">
                                Việc luyện tập đúng kỹ thuật hỗ trợ cân bằng cơ thể, giảm đau mỏi
                                và cải thiện tư thế trong sinh hoạt hằng ngày.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Nút điều hướng --}}
            <button type="button"
                    class="gym-slider-arrow gym-slider-prev d-flex align-items-center justify-content-center">
                <i class="bi bi-chevron-left gym-arrow-icon"></i>
            </button>

            <button type="button"
                    class="gym-slider-arrow gym-slider-next d-flex align-items-center justify-content-center">
                <i class="bi bi-chevron-right gym-arrow-icon"></i>
            </button>

        </div>
    </section>

    {{-- SECTION KHÁM PHÁ KHÔNG GIAN GYM --}}
    <section class="gym-gallery-section">
        <div class="container">
            <div class="gym-gallery-header text-center">
                <h2 class="gym-gallery-title">
                    KHÁM PHÁ KHÔNG GIAN TẬP GYM TẠI RISE FITNESS
                </h2>
            </div>

            <div class="gym-gallery-viewport">
                <div class="gym-gallery-track d-flex">
                    {{-- Ảnh 1 --}}
                    <div class="gym-gallery-item">
                        <img src="{{ asset('frontend/img/gym-gallery-1.jpg') }}"
                            alt="Gym 1" class="gym-gallery-img">
                    </div>

                    {{-- Ảnh 2 --}}
                    <div class="gym-gallery-item">
                        <img src="{{ asset('frontend/img/gym-gallery-2.jpg') }}"
                            alt="Gym 2" class="gym-gallery-img">
                    </div>

                    {{-- Ảnh 3 --}}
                    <div class="gym-gallery-item">
                        <img src="{{ asset('frontend/img/gym-gallery-3.jpg') }}"
                            alt="Gym 3" class="gym-gallery-img">
                    </div>

                    {{-- Ảnh 4 --}}
                    <div class="gym-gallery-item">
                        <img src="{{ asset('frontend/img/gym-gallery-4.jpg') }}"
                            alt="Gym 4" class="gym-gallery-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: TẠI SAO NÊN CHỌN RISE FITNESS --}}
    <section class="rf-why-section">
        <div class="container">
            <h2 class="rf-why-title text-center">
                TẠI SAO NÊN CHỌN RISE FITNESS
            </h2>

            <div class="row rf-why-row">
                {{-- Cột trái: ảnh --}}
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="rf-why-image-wrapper">
                        {{-- Đổi tên file ảnh cho đúng với ảnh của bạn trong public/frontend/img/ --}}
                        <img src="{{ asset('frontend/img/hlv-gym.jpg') }}"
                            alt="Tập gym tại Rise Fitness"
                            class="rf-why-image">
                    </div>
                </div>

                {{-- Cột phải: accordion + nút --}}
                <div class="col-12 col-lg-6">
                    <div class="rf-why-accordion">

                        {{-- 1. Không gian tập luyện hiện đại, rộng rãi --}}
                        <div class="rf-why-item">
                            <button type="button" class="rf-why-item-header" onclick="toggleWhyItem(this)">
                                <span class="rf-why-item-title">Không gian tập luyện hiện đại, rộng rãi</span>
                                <span class="rf-why-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="rf-why-desc">
                                Rise Fitness được thiết kế với mặt sàn rộng, khu tập rõ ràng cho từng nhóm bài,
                                hệ thống ánh sáng và âm thanh tối ưu giúp bạn luôn thoải mái và tập trung khi tập luyện.
                            </div>
                        </div>

                        {{-- 2. Trang thiết bị đa dạng, chuẩn phòng tập chuyên nghiệp --}}
                        <div class="rf-why-item">
                            <button type="button" class="rf-why-item-header" onclick="toggleWhyItem(this)">
                                <span class="rf-why-item-title">Trang thiết bị đa dạng, chuẩn phòng tập chuyên nghiệp</span>
                                <span class="rf-why-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="rf-why-desc">
                                Máy móc được sắp xếp khoa học, đủ cho các nhóm cơ và nhiều cấp độ từ cơ bản đến nâng cao,
                                thường xuyên bảo trì để đảm bảo hoạt động ổn định và an toàn cho người tập.
                            </div>
                        </div>

                        {{-- 3. Đội ngũ nhân sự chuyên nghiệp --}}
                        <div class="rf-why-item">
                            <button type="button" class="rf-why-item-header" onclick="toggleWhyItem(this)">
                                <span class="rf-why-item-title">Đội ngũ nhân sự chuyên nghiệp</span>
                                <span class="rf-why-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="rf-why-desc">
                                Từ lễ tân, tư vấn đến đội ngũ hỗ trợ phòng tập, mọi nhân sự tại Rise Fitness đều được đào tạo bài bản,
                                phục vụ nhiệt tình, sẵn sàng giải đáp thắc mắc và hỗ trợ bạn trong suốt quá trình tập luyện.
                            </div>
                        </div>

                        {{-- 4. Môi trường năng động, truyền cảm hứng --}}
                        <div class="rf-why-item">
                            <button type="button" class="rf-why-item-header" onclick="toggleWhyItem(this)">
                                <span class="rf-why-item-title">Môi trường năng động, truyền cảm hứng</span>
                                <span class="rf-why-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="rf-why-desc">
                                Bầu không khí tại Rise Fitness được xây dựng để tạo động lực: mọi người cùng tập, cùng cố gắng,
                                giúp bạn dễ duy trì thói quen tập luyện lâu dài và hạn chế bỏ cuộc giữa chừng.
                            </div>
                        </div>

                        {{-- 5. Tiện ích & dịch vụ hỗ trợ đồng bộ --}}
                        <div class="rf-why-item">
                            <button type="button" class="rf-why-item-header" onclick="toggleWhyItem(this)">
                                <span class="rf-why-item-title">Tiện ích & dịch vụ hỗ trợ đồng bộ</span>
                                <span class="rf-why-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="rf-why-desc">
                                Từ khu locker, tắm rửa, gửi đồ đến tư vấn dinh dưỡng, nhắc lịch tập và theo dõi chỉ số cơ bản,
                                Rise Fitness giúp bạn chăm sóc sức khỏe một cách trọn vẹn trước – trong – sau buổi tập.
                            </div>
                        </div>

                    </div>

                    <div class="rf-why-cta-wrapper">
                        <a href="{{ route('dang-ky-tap-thu') }}" class="rf-why-cta-btn">
                            Liên hệ tư vấn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.rf-packages')

    {{-- SECTION: TRẢI NGHIỆM CỦA KHÁCH HÀNG TẠI RISE FITNESS --}}
    <section class="rf-testimonial-section">
        <div class="container">

            {{-- TITLE --}}
            <div class="rf-testimonial-heading text-center">
                <p class="rf-testimonial-eyebrow">
                    TRẢI NGHIỆM CỦA KHÁCH HÀNG TẠI
                </p>
                <h2 class="rf-testimonial-title">
                    RISE FITNESS CENTER
                </h2>
            </div>

            <div class="row g-4 rf-testimonial-row">
                {{-- CỘT TRÁI: 2 CARD LỚN --}}
                <div class="col-lg-8">
                    <div class="row g-4">
                        {{-- CARD LỚN 1 --}}
                        <div class="col-md-6">
                            <div class="rf-testi-big-card">
                                <img src="{{ asset('frontend/img/tc-gym-1.jpg') }}"
                                    alt="Khách hàng Gym tại Rise">
                                <div class="rf-testi-big-overlay"></div>
                                <div class="rf-testi-big-content">
                                    <p class="rf-testi-big-quote">
                                        “Chương trình giảm cân của các bạn HLV
                                        đã giúp mình thay đổi tích cực, mình giảm
                                        được 7kg và duy trì vóc dáng cân đối, khỏe
                                        khoắn“
                                    </p>
                                    <p class="rf-testi-big-name">
                                        Phạm Tùng Linh X Gym
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- CARD LỚN 2 --}}
                        <div class="col-md-6">
                            <div class="rf-testi-big-card">
                                <img src="{{ asset('frontend/img/tc-swim-1.jpg') }}"
                                    alt="Khách hàng Bơi tại Rise">
                                <div class="rf-testi-big-overlay"></div>
                                <div class="rf-testi-big-content">
                                    <p class="rf-testi-big-quote">
                                        “Em học bơi sinh tồn từ hồi 5 tuổi hiện tại
                                        đã tự tin nắm rõ và chinh phục mọi kiểu bơi
                                        dưới sự hướng dẫn nhiệt tình của đội ngũ HLV“
                                    </p>
                                    <p class="rf-testi-big-name">
                                        Lê Chí Thành X Bơi
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: 4 TESTIMONIAL NHỎ --}}
                <div class="col-lg-4">
                    <div class="rf-testi-mini-list">
                        {{-- MINI 1 --}}
                        <div class="rf-testi-mini">
                            <div class="rf-testi-mini-img">
                                <img src="{{ asset('frontend/img/tc-yoga-1.jpg') }}"
                                    alt="Yoga khách hàng 1">
                            </div>
                            <div class="rf-testi-mini-text">
                                <p class="rf-testi-mini-quote">
                                    Yoga tại Rise đã giúp tôi tìm lại sự
                                    cân bằng trong tâm hồn.
                                </p>
                                <p class="rf-testi-mini-name">
                                    Cao Ngọc Mai
                                </p>
                            </div>
                        </div>

                        {{-- MINI 2 --}}
                        <div class="rf-testi-mini">
                            <div class="rf-testi-mini-img">
                                <img src="{{ asset('frontend/img/tc-yoga-2.jpg') }}"
                                    alt="Yoga khách hàng 2">
                            </div>
                            <div class="rf-testi-mini-text">
                                <p class="rf-testi-mini-quote">
                                    Yoga giúp tôi kết nối với bản thân
                                    theo cách sâu sắc nhất.
                                </p>
                                <p class="rf-testi-mini-name">
                                    Nguyễn Lan Anh
                                </p>
                            </div>
                        </div>

                        {{-- MINI 3 --}}
                        <div class="rf-testi-mini">
                            <div class="rf-testi-mini-img">
                                <img src="{{ asset('frontend/img/tc-dance-1.jpg') }}"
                                    alt="Dance khách hàng">
                            </div>
                            <div class="rf-testi-mini-text">
                                <p class="rf-testi-mini-quote">
                                    Dance tại Rise kết nối tôi với năng
                                    lượng tích cực.
                                </p>
                                <p class="rf-testi-mini-name">
                                    Trần Bích Phượng
                                </p>
                            </div>
                        </div>

                        {{-- MINI 4 --}}
                        <div class="rf-testi-mini rf-testi-mini-last">
                            <div class="rf-testi-mini-img">
                                <img src="{{ asset('frontend/img/tc-kick-1.jpg') }}"
                                    alt="Kick boxing khách hàng">
                            </div>
                            <div class="rf-testi-mini-text">
                                <p class="rf-testi-mini-quote">
                                    Kick boxing là nơi giúp tôi vượt qua
                                    giới hạn bản thân.
                                </p>
                                <p class="rf-testi-mini-name">
                                    Trần Đức Hải
                                </p>
                            </div>
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
        const track   = document.querySelector('.gym-slider-track');
        const slides  = Array.from(document.querySelectorAll('.gym-slide'));
        const prevBtn = document.querySelector('.gym-slider-prev');
        const nextBtn = document.querySelector('.gym-slider-next');

        if (!track || slides.length === 0) return;

        let currentIndex = 0;

        function updateSlider() {
            const slideWidth = slides[0].offsetWidth + 12; // 12px ~ margin/gap
            track.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
        }

        function goNext() {
            currentIndex = (currentIndex + 1) % slides.length;  // chạy vòng tròn
            updateSlider();
        }

        function goPrev() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider();
        }

        nextBtn.addEventListener('click', goNext);
        prevBtn.addEventListener('click', goPrev);

        // cập nhật khi resize
        window.addEventListener('resize', updateSlider);

        // set vị trí ban đầu
        updateSlider();
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* ========== SLIDER LỢI ÍCH GYM (CÁC VÒNG TRÒN ICON) ========== */
        const track    = document.querySelector('.gym-benefits-track');
        const items    = Array.from(document.querySelectorAll('.gym-benefit-item'));
        const viewport = document.querySelector('.gym-benefits-viewport');
        const prevBtn  = document.querySelector('.benefit-arrow-prev');
        const nextBtn  = document.querySelector('.benefit-arrow-next');

        if (track && items.length > 0 && viewport && prevBtn && nextBtn) {
            let current = 0;

            function getStepWidth() {
                const first  = items[0].getBoundingClientRect();
                const styles = window.getComputedStyle(track);
                const gap    = parseFloat(styles.gap) || 0;
                return first.width + gap;
            }

            function getVisibleCount() {
                const step    = getStepWidth();
                const vpWidth = viewport.getBoundingClientRect().width;
                const count   = Math.floor(vpWidth / step);
                return Math.max(1, count);
            }

            function getMaxIndex() {
                const visible = getVisibleCount();
                return Math.max(0, items.length - visible);
            }

            function updateSlider() {
                const maxIndex = getMaxIndex();

                if (current < 0) current = 0;
                if (current > maxIndex) current = maxIndex;

                const step = getStepWidth();
                track.style.transform = `translateX(-${current * step}px)`;

                const atStart = current === 0;
                const atEnd   = current === maxIndex;

                prevBtn.disabled = atStart;
                nextBtn.disabled = atEnd;

                prevBtn.classList.toggle('disabled', atStart);
                nextBtn.classList.toggle('disabled', atEnd);
            }

            prevBtn.addEventListener('click', function () {
                if (current > 0) {
                    current -= 1;
                    updateSlider();
                }
            });

            nextBtn.addEventListener('click', function () {
                const maxIndex = getMaxIndex();
                if (current < maxIndex) {
                    current += 1;
                    updateSlider();
                }
            });

            updateSlider();
            window.addEventListener('resize', updateSlider);
        }

        /* ========== SLIDER ẢNH KHÔNG GIAN GYM (TRƯỢT LIÊN TỤC) ========== */
        const galleryViewport = document.querySelector('.gym-gallery-viewport');
        const galleryTrack    = document.querySelector('.gym-gallery-track');

        if (galleryViewport && galleryTrack) {
            let autoTimer = null;
            let isMouseDown = false;
            let startX = 0;
            let scrollStart = 0;

            function startAuto() {
                stopAuto();
                autoTimer = setInterval(function () {
                    const vpWidth   = galleryViewport.clientWidth;
                    const maxScroll = galleryViewport.scrollWidth - vpWidth;

                    if (maxScroll <= 0) return;

                    // Nếu đã ở cuối => nhảy về đầu, lần tick sau lại trượt sang phải
                    if (galleryViewport.scrollLeft >= maxScroll - 5) {
                        galleryViewport.scrollLeft = 0;
                    } else {
                        galleryViewport.scrollBy({
                            left: vpWidth,
                            behavior: 'smooth'
                        });
                    }
                }, 5000); // thời gian mỗi lần trượt (ms)
            }

            function stopAuto() {
                if (autoTimer) {
                    clearInterval(autoTimer);
                    autoTimer = null;
                }
            }

            // Kéo bằng chuột
            galleryViewport.addEventListener('mousedown', function (e) {
                isMouseDown = true;
                galleryViewport.classList.add('is-dragging');
                startX = e.pageX - galleryViewport.offsetLeft;
                scrollStart = galleryViewport.scrollLeft;
                stopAuto();
            });

            galleryViewport.addEventListener('mouseleave', function () {
                if (isMouseDown) {
                    isMouseDown = false;
                    galleryViewport.classList.remove('is-dragging');
                    startAuto();
                }
            });

            galleryViewport.addEventListener('mouseup', function () {
                if (isMouseDown) {
                    isMouseDown = false;
                    galleryViewport.classList.remove('is-dragging');
                    startAuto();
                }
            });

            galleryViewport.addEventListener('mousemove', function (e) {
                if (!isMouseDown) return;
                e.preventDefault();
                const x = e.pageX - galleryViewport.offsetLeft;
                const walk = x - startX;
                galleryViewport.scrollLeft = scrollStart - walk;
            });

            // Cảm ứng – dừng auto khi chạm, chạy lại khi thả
            galleryViewport.addEventListener('touchstart', function () {
                stopAuto();
            }, { passive: true });

            galleryViewport.addEventListener('touchend', function () {
                startAuto();
            });

            // Khi resize thì không cần tính lại gì phức tạp, auto-slide vẫn dùng scrollBy theo width mới
            window.addEventListener('resize', function () {
                // không làm gì đặc biệt; auto vẫn dùng viewportWidth hiện tại ở lần tick sau
            });

            // Bắt đầu auto slide
            startAuto();
        }
    });
</script>

<script>
    function toggleWhyItem(button) {
        const item  = button.closest('.rf-why-item');          // item hiện tại
        const list  = document.querySelectorAll('.rf-why-item');
        const isActive = item.classList.contains('active');

        // Đóng tất cả
        list.forEach(function (i) {
            i.classList.remove('active');
        });

        // Nếu item này đang đóng thì mở
        if (!isActive) {
            item.classList.add('active');
        }
    }
</script>

@endpush






