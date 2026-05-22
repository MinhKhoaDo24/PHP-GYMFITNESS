<!-- CSS -->
@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/services.css') }}">
@endpush


@extends('layout')

@section('content')
<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>VỀ CHÚNG TÔI</h1>
    </div>
</section>
<section class="hero-section">
    <div class="hero-container">
        
        <!-- Left Images -->
        <div class="hero-images">
            <div class="hero-img img-1">
                <img src="/frontend/img/Gioi-thieu/gioi-thieu-2.jpg" alt="Stretching Woman">
            </div>

            <div class="hero-img img-2">
                <img src="/frontend/img/Gioi-thieu/gioi-thieu-3.jpg" alt="Bodybuilder">
            </div>
        </div>

        <!-- Right Content -->
        <div class="hero-content">
            <h1 class="hero-title" id="typingText"
                data-text="Transform your mindset, transform your body.">
            </h1>


            <p class="hero-desc">
               Chúng tôi sẽ thiết kế cho bạn một chương trình dinh dưỡng khoa học và<br> cá nhân hóa,
            giúp giảm cân an toàn, cải thiện vóc dáng, đồng thời nâng<br> cao sức khỏe 
            và tăng cường năng lượng cho toàn bộ cơ thể. Mỗi thực đơn <br>đều được tối 
            ưu theo nhu cầu riêng của bạn, mang lại hiệu quả bền vững <br>và cảm giác 
            tràn đầy sức sống mỗi ngày.
            </p>

            <div class="hero-stats">
                <div class="stat">
                    <h2>999+</h2>
                    <p>Khách hàng thân thiết</p>
                </div>
                <div class="stat">
                    <h2>98%</h2>
                    <p>Tỉ lệ hiệu quả</p>
                </div>
                <div class="stat">
                    <h2>5+</h2>
                    <p>Năm kinh nghiệm thực chiến</p>
                </div>
            </div>
            <a href="{{ route('dang-ky-tap-thu') }}" class="hero-btn">ĐĂNG KÝ</a>
        </div>

    </div>
</section>
<section class="about-story">
    <div class="story-container">

        <!-- Ảnh -->
        <div class="story-slider">
            <div class="story-images">
                <img src="/frontend/img/Gioi-thieu/gioi-thieu-5.jpg" class="active" alt="gym 1">
                <img src="/frontend/img/Gioi-thieu/gioi-thieu-7.jpg" alt="gym 2">
                <img src="/frontend/img/Gioi-thieu/gioi-thieu-8.jpg" alt="gym 3">
            </div>

            <!-- Nút chuyển ảnh -->
            <button class="arrow left" id="prev">&#10094;</button>
            <button class="arrow right" id="next">&#10095;</button>
        </div>


        <!-- Nội dung -->
        <div class="story-content">
            <h2 class="story-title">Câu Chuyện Của Chúng Tôi</h2>

            <p class="story-text">
                Rise Fitness & Yoga được thành lập vào năm 2015 với sứ mệnh mang đến giải pháp tập luyện toàn diện cho cộng đồng. 
                Từ một phòng gym nhỏ với vài thiết bị cơ bản, chúng tôi đã không ngừng phát triển và mở rộng để trở thành một trong 
                những hệ thống fitness hàng đầu tại Việt Nam.
            </p>

            <p class="story-text">
                Chúng tôi tin rằng mỗi người đều xứng đáng có một cơ thể khỏe mạnh và tinh thần tích cực. Với đội ngũ huấn luyện viên 
                chuyên nghiệp, thiết bị hiện đại và môi trường tập luyện năng động, Rise Fitness cam kết đồng hành cùng bạn trên mọi 
                bước đường.
            </p>

            <!-- Các giá trị -->
            <div class="story-values">

                <div class="value-item">
                    <i class="fa-solid fa-heart-circle-plus value-icon"></i>
                    <div>
                        <h4>Sức khỏe</h4>
                        <p>Ưu tiên hàng đầu</p>
                    </div>
                </div>

                <div class="value-item">
                    <i class="fa-solid fa-shield-halved value-icon"></i>
                    <div>
                        <h4>Uy tín</h4>
                        <p>Đáng tin cậy</p>
                    </div>
                </div>

                <div class="value-item">
                    <i class="fa-solid fa-medal value-icon"></i>
                    <div>
                        <h4>Chất lượng</h4>
                        <p>Cam kết hàng đầu</p>
                    </div>
                </div>

                <div class="value-item">
                    <i class="fa-solid fa-headset value-icon"></i>
                    <div>
                        <h4>Hỗ trợ</h4>
                        <p>Tận tâm 24/7</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
<section class="landing-hero">

    <div class="landing-bg"></div>

    <div class="landing-overlay"></div>

    <div class="landing-content">
        <span class="landing-sub">GYM LIFESTYLE</span>
        <h1 class="landing-title">
            Tập đúng – Ăn chuẩn <br> Sở hữu body mơ ước
        </h1>
        <p class="landing-desc">
            Chúng tôi cung cấp các sản phẩm hỗ trợ tập luyện, phụ kiện gym và đồ thể thao cao cấp.<br>
            Giúp bạn duy trì động lực và đạt hiệu quả tối đa trong từng buổi tập.
        </p>
        <a href="{{ url('/viewAll') }}" class="hero-btn">KHÁM PHÁ SẢN PHẨM</a>
    </div>
</section>
<section class="stats-section">
    <div class="stats-header">
        <h2>Hành trình đến <span>body lý tưởng</span> của bạn bắt đầu từ đây.</h2>
        <p>Hàng nghìn người đã thay đổi cuộc sống của họ tốt hơn từng ngày.</p>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <h1 class="count" data-target="78">0</h1>
            <p>Thiết bị tập luyện</p>
        </div>

        <div class="stat-box">
            <h1 class="count" data-target="23">0</h1>
            <p>Huấn luyện viên chuyên nghiệp</p>
        </div>

        <div class="stat-box">
            <h1 class="count" data-target="999">0</h1>
            <p>Khách hàng thân thiết</p>
        </div>

        <div class="stat-box">
            <h1 class="count" data-target="16">0</h1>
            <p>Chương trình luyện tập</p>
        </div>
    </div>
</section>
<section class="why-choose-us">
    <div class="container">

        <h2 class="why-title">Tại Sao Chọn Chúng Tôi?</h2>
        <p class="why-subtitle">Những lý do khiến khách hàng tin tưởng</p>

        <div class="why-grid">

            <!-- 1 -->
            <div class="why-item">
                <div class="why-icon">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <h4 class="why-name">Sản phẩm chất lượng cao</h4>
                <p>Nhập khẩu chính hãng từ các thương hiệu hàng đầu thế giới</p>
            </div>

            <!-- 2 -->
            <div class="why-item">
                <div class="why-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h4 class="why-name">Giao hàng nhanh</h4>
                <p>Vận chuyển toàn quốc, giao hàng trong 24-48h</p>
            </div>

            <!-- 3 -->
            <div class="why-item">
                <div class="why-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <h4 class="why-name">Huấn luyện viên đạt chuẩn</h4>
                <p>Đội ngũ PT có chứng chỉ quốc tế, kinh nghiệm lâu năm</p>
            </div>

            <!-- 4 -->
            <div class="why-item">
                <div class="why-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h4 class="why-name">Hỗ trợ 24/7</h4>
                <p>Luôn sẵn sàng tư vấn và giải đáp mọi thắc mắc</p>
            </div>

            <!-- 5 -->
            <div class="why-item">
                <div class="why-icon">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <h4 class="why-name">Giá cả minh bạch</h4>
                <p>Không phát sinh chi phí ẩn, chính sách giá rõ ràng</p>
            </div>

            <!-- 6 -->
            <div class="why-item">
                <div class="why-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h4 class="why-name">Bảo hành chính hãng</h4>
                <p>Cam kết bảo hành đầy đủ theo tiêu chuẩn nhà sản xuất</p>
            </div>

        </div>

    </div>
</section>
<section class="trial-wrapper">
    <div class="trial-container">

        <!-- MAP -->
        <div class="trial-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1316.8423346314796!2d105.82753225955905!3d21.008962701887917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac800f450807%3A0x419a49bcd94b693a!2sBanking%20Academy!5e0!3m2!1sen!2sus!4v1764307110053!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- FORM -->
        <div class="trial-form">
            <h2><span style="color:#34A4E0">Đăng Ký Tập Thử Miễn Phí</span></h2>
            <p class="trial-sub" style="color: #fff">Điền thông tin để đội ngũ Rise Fitness hỗ trợ bạn trong 24 giờ.</p>

            <form>
                <div class="input-group">
                    <label>Họ và tên <span class="required">*</span></label>
                    <input type="text" placeholder="Nhập họ và tên">
                </div>

                <div class="input-group">
                    <label>Số điện thoại <span class="required">*</span></label>
                    <input type="text" placeholder="Nhập số điện thoại">
                </div>

                <div class="input-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" placeholder="Nhập email">
                </div>

                <div class="input-group">
                    <label>Môn thể thao tập thử <span class="required">*</span></label>
                    <select>
                        <option>Gym</option>
                        <option>Yoga</option>
                        <option>Zumba</option>
                        <option>Boxing</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Khung giờ <span class="required">*</span></label>
                    <select>
                        <option>6h – 9h</option>
                        <option>9h – 12h</option>
                        <option>14h – 17h</option>
                        <option>18h – 21h</option>
                    </select>
                </div>

                <button class="trial-btn">Đăng ký</button>
            </form>
        </div>

    </div>
</section>


<script>
    const images = document.querySelectorAll('.story-images img');
    let index = 0;

    function showImage(i) {
        images.forEach(img => img.classList.remove('active'));
        images[i].classList.add('active');
    }

    document.getElementById("next").onclick = () => {
        index = (index + 1) % images.length;
        showImage(index);
    };

    document.getElementById("prev").onclick = () => {
        index = (index - 1 + images.length) % images.length;
        showImage(index);
    };
</script>

<script>
    const el = document.getElementById("typingText");
    const text = el.dataset.text;
    let i = 0;

    function type() {
        if (i < text.length) {
            el.textContent = text.substring(0, i + 1);
            i++;
            setTimeout(type, 40);
        }
    }

    window.onload = type;
</script>
<script>
    const counters = document.querySelectorAll('.count');
    let statsStarted = false; // tránh chạy lại nhiều lần

    function startCounting() {
        counters.forEach(counter => {
            counter.innerText = "0";

            const updateCounter = () => {
                const target = +counter.getAttribute('data-target');
                const current = +counter.innerText;
                const increment = target / 100;

                if (current < target) {
                    counter.innerText = `${Math.ceil(current + increment)}`;
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target >= 999 ? (target + "+") : target;
                }
            };

            updateCounter();
        });
    }

    // Intersection Observer
    const section = document.querySelector('.stats-section');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !statsStarted) {
                startCounting();
                statsStarted = true;
            }
        });
    }, { threshold: 0.3 });

    observer.observe(section);
</script>


@endsection