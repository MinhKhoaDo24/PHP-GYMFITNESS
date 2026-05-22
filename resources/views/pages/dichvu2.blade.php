@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/services.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/dichvu2.css') }}">
@endpush

@section('content')
        {{-- BANNER YOGA --}}
    <section class="service-banner-yoga d-flex align-items-center justify-content-center">
        <div class="banner-yoga-overlay"></div>

        <div class="banner-yoga-content text-center">
            <h1 class="banner-yoga-title">YOGA</h1>

            <a href="{{ route('dang-ky-tap-thu') }}" class="banner-yoga-btn">
                Miễn Phí Tập Thử
            </a>
        </div>
    </section>

    {{-- SECTION: KẾT NỐI THÂN - TÂM - TRÍ CÙNG YOGA --}}
    <section id="yoga-intro" class="yoga-intro-section">
        <div class="container text-center">
            <h2 class="yoga-intro-heading yoga-fade-slide">
                KẾT NỐI THÂN - TÂM - TRÍ CÙNG YOGA
            </h2>

            <p class="yoga-intro-text yoga-fade-slide yoga-fade-delay">
                Một bộ môn tuyệt vời để điều hòa cơ thể, hơi thở và tâm trí
                thông qua các bài tập Yoga đa dạng chủ đề, giúp bạn tìm đến sự
                dẻo dai và thư giãn từ bên trong.
            </p>
        </div>
    </section>

    {{-- SECTION: LỢI ÍCH YOGA – SLIDER 3 ẢNH --}}
    <section class="yoga-benefit-slider-section py-5">
        <div class="container position-relative">

            {{-- Vùng slider --}}
            <div class="yoga-slider-viewport mx-auto">
                <div class="yoga-slider-track d-flex">
                    {{-- SLIDE 1 --}}
                    <div class="yoga-slide">
                        <img src="{{ asset('frontend/img/yoga-slide-1.jpg') }}" alt="Thư giãn xương khớp">
                        <div class="yoga-slide-overlay"></div>

                        <div class="yoga-slide-content yoga-slide-content-left">
                            <h3 class="yoga-slide-title">THƯ GIÃN XƯƠNG KHỚP</h3>
                            <p class="yoga-slide-text">
                                Yoga giúp thư giãn xương khớp bằng cách tăng cường
                                sự linh hoạt và sức mạnh của cơ bắp, cải thiện tuần hoàn máu,
                                và giảm căng thẳng.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 2 --}}
                    <div class="yoga-slide">
                        <img src="{{ asset('frontend/img/yoga-slide-2.jpg') }}" alt="Cân bằng tâm trí">
                        <div class="yoga-slide-overlay"></div>

                        <div class="yoga-slide-content yoga-slide-content-right text-end">
                            <h3 class="yoga-slide-title">CÂN BẰNG TÂM TRÍ</h3>
                            <p class="yoga-slide-text">
                                Yoga giúp bạn tăng khả năng kết nối giữa cơ thể và tâm hồn,
                                tìm lại sự bình tĩnh trong tâm trí và cảm giác an yên nội tại.
                            </p>
                        </div>
                    </div>

                    {{-- SLIDE 3 --}}
                    <div class="yoga-slide">
                        <img src="{{ asset('frontend/img/yoga-slide-3.jpg') }}" alt="Điều hòa hơi thở">
                        <div class="yoga-slide-overlay"></div>

                        <div class="yoga-slide-content yoga-slide-content-left">
                            <h3 class="yoga-slide-title">ĐIỀU HÒA HƠI THỞ</h3>
                            <p class="yoga-slide-text">
                                Áp dụng phương pháp thở đúng trong quá trình tập lẫn
                                cuộc sống thường ngày để tăng sự tập trung và thư giãn cho cơ thể.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút điều hướng --}}
            <button type="button"
                    class="yoga-slider-arrow yoga-slider-prev d-flex align-items-center justify-content-center">
                <span class="yoga-arrow-icon">&lt;</span>
            </button>

            <button type="button"
                    class="yoga-slider-arrow yoga-slider-next d-flex align-items-center justify-content-center">
                <span class="yoga-arrow-icon">&gt;</span>
            </button>

        </div>
    </section>

    {{-- SECTION: KHÁM PHÁ KHÔNG GIAN YOGA --}}
    <section class="yoga-space-section">
        <div class="container">

            {{-- TIÊU ĐỀ 2 DÒNG --}}
            <div class="yoga-space-heading">
                <h2 class="yoga-space-title-left">
                    KHÁM PHÁ KHÔNG GIAN
                </h2>
                <h2 class="yoga-space-title-right">
                    YOGA TẠI RISE FITNESS
                </h2>
            </div>

            {{-- HÀNG 3 ẢNH --}}
            <div class="row g-3 yoga-space-row">
                <div class="col-12 col-md-4">
                    <div class="yoga-space-img">
                        <img src="{{ asset('frontend/img/yoga-space-1.jpg') }}" alt="Không gian Yoga 1">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="yoga-space-img">
                        <img src="{{ asset('frontend/img/yoga-space-2.jpg') }}" alt="Không gian Yoga 2">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="yoga-space-img">
                        <img src="{{ asset('frontend/img/yoga-space-3.jpg') }}" alt="Không gian Yoga 3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: TẠI SAO NÊN TẬP YOGA TẠI RISE FITNESS CENTER --}}
    <section class="rf-yoga-why-center">
        <div class="container">
            <div class="row g-4 align-items-start">
                {{-- CỘT TRÁI: TIÊU ĐỀ --}}
                <div class="col-lg-5">
                    <div class="rf-yoga-why-heading">
                        <p class="rf-yoga-why-line">TẠI SAO NÊN TẬP</p>
                        <p class="rf-yoga-why-line">YOGA TẠI</p>
                        <p class="rf-yoga-why-line">RISE FITNESS CENTER?</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dang-ky-tap-thu') }}" class="rf-yoga-why-btn">
                            Liên hệ tư vấn
                        </a>
                    </div>

                </div>

                {{-- CỘT PHẢI: SLIDE CUỘN DỌC --}}
                <div class="col-lg-7">
                    <div class="yoga-reason-wrapper">
                        {{-- NHÓM 1: 2 ẢNH + 2 LÝ DO --}}
                        <div class="yoga-reason-group mb-5">
                            <div class="row g-4">
                                {{-- LÝ DO 1 --}}
                                <div class="col-md-6">
                                    <div class="yoga-reason-card">
                                        <img src="{{ asset('frontend/img/yoga-why-1.jpg') }}"                                                   
                                            alt="Cải thiện cơ thể">
                                        <div class="yoga-reason-text">
                                            <h4 class="yoga-reason-title">CẢI THIỆN CƠ THỂ</h4>
                                            <p class="yoga-reason-desc">
                                                Các bài tập Yoga giúp kéo giãn cơ, tăng sức mạnh lõi,
                                                cải thiện tư thế và giảm đau nhức xương khớp sau
                                                giờ làm việc căng thẳng.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- LÝ DO 2 --}}
                                <div class="col-md-6">
                                    <div class="yoga-reason-card yoga-reason-card-lower ">
                                        <img src="{{ asset('frontend/img/yoga-why-2.jpg') }}"
                                            alt="Cá nhân hóa lộ trình">
                                        <div class="yoga-reason-text text-end">
                                            <h4 class="yoga-reason-title">CÁ NHÂN HÓA LỘ TRÌNH</h4>
                                            <p class="yoga-reason-desc">
                                                Lớp học được thiết kế theo nhiều cấp độ, từ cơ bản
                                                đến nâng cao, giúp bạn dễ dàng lựa chọn lộ trình
                                                phù hợp với mục tiêu và thể trạng.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- NHÓM 2: 2 ẢNH + 2 LÝ DO (CUỘN XUỐNG SẼ THẤY) --}}
                        <div class="yoga-reason-group mb-5">
                            <div class="row g-4">
                                {{-- LÝ DO 3 --}}
                                <div class="col-md-6">
                                    <div class="yoga-reason-card">
                                        <img src="{{ asset('frontend/img/yoga-why-3.jpg') }}"
                                            alt="Không gian chuyên nghiệp">
                                        <div class="yoga-reason-text">
                                            <h4 class="yoga-reason-title">KHÔNG GIAN CHUYÊN NGHIỆP</h4>
                                            <p class="yoga-reason-desc">
                                                Phòng tập sạch sẽ, yên tĩnh, trang thiết bị chuẩn studio,
                                                giúp bạn tập trung, thư giãn và tận hưởng trọn vẹn
                                                từng buổi tập Yoga.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- LÝ DO 4 --}}
                                <div class="col-md-6">
                                    <div class="yoga-reason-card yoga-reason-card-lower">
                                        <img src="{{ asset('frontend/img/yoga-why-4.jpg') }}"
                                            alt="Tiết kiệm & linh hoạt">
                                        <div class="yoga-reason-text text-end">
                                            <h4 class="yoga-reason-title">TIẾT KIỆM &amp; LINH HOẠT</h4>
                                            <p class="yoga-reason-desc">
                                                Đa dạng khung giờ và gói tập, bạn dễ dàng sắp xếp lịch
                                                phù hợp với công việc mà vẫn duy trì thói quen tập luyện
                                                đều đặn, chi phí tối ưu.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bạn có thể thêm nhóm 3, 4... nếu muốn --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.rf-packages')

    {{-- SECTION: CHIA SẺ CỦA KHÁCH HÀNG TẠI RISE FITNESS CENTER --}}
    <section class="rf-yoga-review-section">
        <div class="container">

            {{-- HEADING 1 DÒNG --}}
            <div class="text-center rf-yoga-review-heading">
                <h2 class="rf-yoga-review-title">
                    Chia sẻ của khách hàng tại RISE FITNESS CENTER
                </h2>
            </div>

            {{-- SLIDER --}}
            <div class="rf-yoga-review-slider-wrapper">
                <div class="rf-yoga-review-track" id="yogaReviewTrack">

                    {{-- CARD 1 – NGUYỄN LAN ANH (giữ nguyên nội dung mẫu) --}}
                    <article class="rf-yoga-review-card">
                        <div class="rf-yoga-review-image">
                            <img src="{{ asset('frontend/img/tc-yoga-3.jpg') }}" alt="Nguyễn Lan Anh Yoga">
                        </div>
                        <div class="rf-yoga-review-body">
                            <p class="rf-yoga-review-name">
                                NGUYỄN LAN ANH <span class="rf-yoga-review-x">×</span> YOGA
                            </p>
                            <p class="rf-yoga-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-yoga-review-text">
                                Công việc bận rộn khiến mình tưởng như không thể tập luyện nhưng
                                được đồng nghiệp động viên nên mình đã duy trì được thói quen tập
                                buổi trưa. Chỉ 1 tiếng thôi nhưng cơ thể sảng khoái và thư giãn
                                xương khớp vô cùng. May mắn là ở Rise có nhiều khung giờ để các
                                chị em được theo đuổi bộ môn này.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 2 – CAO NGỌC MAI (giữ nguyên nội dung mẫu) --}}
                    <article class="rf-yoga-review-card">
                        <div class="rf-yoga-review-image">
                            <img src="{{ asset('frontend/img/tc-yoga-4.jpg') }}" alt="Cao Ngọc Mai Yoga">
                        </div>
                        <div class="rf-yoga-review-body">
                            <p class="rf-yoga-review-name">
                                CAO NGỌC MAI <span class="rf-yoga-review-x">×</span> YOGA
                            </p>
                            <p class="rf-yoga-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-yoga-review-text">
                                Yoga đã khiến mình từ một người nóng nảy và vội vàng trở thành phiên
                                bản bình tĩnh hơn, biết tận hưởng cuộc sống, quan sát và cảm nhận hơn.
                                Cảm ơn Rise vì đã cho tôi 1 tiếng mỗi ngày để cải thiện cơ thể
                                và chất lượng cuộc sống.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 3 – TRẦN THU HÀ (tạo mới) --}}
                    <article class="rf-yoga-review-card">
                        <div class="rf-yoga-review-image">
                            <img src="{{ asset('frontend/img/tc-yoga-5.jpg') }}" alt="Trần Thu Hà Yoga">
                        </div>
                        <div class="rf-yoga-review-body">
                            <p class="rf-yoga-review-name">
                                TRẦN THU HÀ <span class="rf-yoga-review-x">×</span> YOGA
                            </p>
                            <p class="rf-yoga-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-yoga-review-text">
                                Sau khi sinh em bé, mình bị đau lưng và mất ngủ kéo dài. Được bạn bè
                                giới thiệu mình đăng ký tập Yoga tại Rise. Sau 3 tháng, lưng đỡ đau hẳn,
                                ngủ sâu hơn và tinh thần cũng nhẹ nhàng, tích cực hơn rất nhiều.
                            </p>
                        </div>
                    </article>

                    {{-- CARD 4 – LÊ HOÀNG NAM (tạo mới) --}}
                    <article class="rf-yoga-review-card">
                        <div class="rf-yoga-review-image">
                            <img src="{{ asset('frontend/img/tc-yoga-6.jpg') }}" alt="Lê Hoàng Nam Yoga">
                        </div>
                        <div class="rf-yoga-review-body">
                            <p class="rf-yoga-review-name">
                                LÊ HOÀNG NAM <span class="rf-yoga-review-x">×</span> YOGA
                            </p>
                            <p class="rf-yoga-review-stars">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </p>
                            <p class="rf-yoga-review-text">
                                Mình vốn tập gym là chính, nhưng khi thêm các buổi Yoga vào lịch tập
                                tại Rise thì khớp gối và vai linh hoạt hơn hẳn, cơ thể phục hồi nhanh
                                hơn sau những buổi tạ nặng. HLV hướng dẫn kỹ giúp mình chỉnh sửa tư thế
                                ngồi làm việc, giảm hẳn đau mỏi lưng cổ.
                            </p>
                        </div>
                    </article>

                </div>
            </div>

            {{-- ARROW BUTTONS --}}
            <div class="rf-yoga-review-arrows">
                <button type="button" class="rf-yoga-review-arrow" id="yogaReviewPrev">‹</button>
                <button type="button" class="rf-yoga-review-arrow" id="yogaReviewNext">›</button>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // chạy 1 lần rồi thôi
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.yoga-fade-slide').forEach(el => {
        observer.observe(el);
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const track   = document.querySelector('.yoga-slider-track');
        const slides  = Array.from(document.querySelectorAll('.yoga-slide'));
        const prevBtn = document.querySelector('.yoga-slider-prev');
        const nextBtn = document.querySelector('.yoga-slider-next');

        if (!track || slides.length === 0) return;

        let currentIndex = 0;

        function updateSlider() {
            const slideWidth = slides[0].offsetWidth + 12; // 12px ~ margin/gap
            track.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
        }

        function goNext() {
            currentIndex = (currentIndex + 1) % slides.length;       // chạy vòng tròn
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
    // id của track: nhớ đặt trong HTML là id="yogaReviewTrack"
    const track   = document.getElementById('yogaReviewTrack');
    const prevBtn = document.getElementById('yogaReviewPrev');
    const nextBtn = document.getElementById('yogaReviewNext');

    // nếu thiếu cái nào thì thôi
    if (!track || !prevBtn || !nextBtn) return;

    const getStep = () => {
        // class card: rf-yoga-review-card (đúng như bạn đặt trong HTML)
        const card = track.querySelector('.rf-yoga-review-card');
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