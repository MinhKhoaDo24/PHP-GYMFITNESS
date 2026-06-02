@extends('layout')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
@endpush


<!-- HERO BANNER -->
<section class="hero-banner">

    <video autoplay muted loop playsinline" class="banner-video">
      <source src="https://res.cloudinary.com/dyk9mzb5t/video/upload/v1763131649/1114_xiw66b.mp4" type="video/mp4">
    </video>
     <!-- Lớp phủ tối -->
  <div class="overlay"></div>
    <div class="banner-content highlighted dynamic-overlay">
            <h1>Chào mừng đến với Rise Fitness & Yoga</h1>
            <p class="slogan">Chinh phục vóc dáng, bứt phá giới hạn!</p>
            <div class="banner-buttons">
                <a href="{{ route('dang-ky-tap-thu') }}" class="cta-button highlighted rect-button animated" style="color: #fff;">Đăng ký tập thử</a>
                <a href="{{ route('services.gym') }}" class="cta-button highlighted rect-button animated" style="color: #fff;">Xem Dịch Vụ</a>
                <a href="{{ route('services') }}" class="cta-button highlighted rect-button animated" style="color: #fff;">Xem Dịch Vụ</a>
            </div>
        </div>  
    </div>
    <div class="marquee-container">
            <div class="marquee">
                <a href="{{ route('services.gym') }}">Gym</a>  <a href="{{ route('services.swimming') }}">Swimming</a>  <a href="{{ route('services.kickboxing') }}">Kick Boxing</a>  <a href="{{ route('services.dance') }}">Dance</a>  <a href="{{ route('services.yoga') }}">Yoga</a>
                <a href="{{ route('services.gym') }}">Gym</a>  <a href="{{ route('services.swimming') }}">Swimming</a>  <a href="{{ route('services.kickboxing') }}">Kick Boxing</a>  <a href="{{ route('services.dance') }}">Dance</a>  <a href="{{ route('services.yoga') }}">Yoga</a>
                <a href="{{ route('services.gym') }}">Gym</a>  <a href="{{ route('services.swimming') }}">Swimming</a>  <a href="{{ route('services.kickboxing') }}">Kick Boxing</a>  <a href="{{ route('services.dance') }}">Dance</a>  <a href="{{ route('services.yoga') }}">Yoga</a>
                <a href="{{ route('services.gym') }}">Gym</a>  <a href="{{ route('services.swimming') }}">Swimming</a>  <a href="{{ route('services.kickboxing') }}">Kick Boxing</a>  <a href="{{ route('services.dance') }}">Dance</a>  <a href="{{ route('services.yoga') }}">Yoga</a>
            </div>
        </div>
    </div>
    </header>
</section>
<!-- About - về chúng tôi -->
<section id="about">
        <div class="about-container">
        <div class="about-image slideshow">
            <img src="/frontend/img/gym-equipment.jpg" alt="Gym 1"class="slide active">
            <img src="/frontend/img/gym-equipment2.jpg" alt="Gym 2" class="slide">
            <img src="/frontend/img/gym-equipment3.jpg" alt="Gym 3" class="slide">
            <img src="/frontend/img/gym-equipment4.jpg" alt="Gym 4" class="slide">
            <img src="/frontend/img/gym-equipment5.jpg" alt="Gym 5" class="slide">
        </div>
        <div class="about-content">
            <h2>Về Chúng Tôi</h2>
            <p>Chào mừng bạn đến với phòng tập hiện đại nhất trong thành phố! Chúng tôi tự hào mang đến không gian tập luyện được trang bị máy móc hiện đại, đội ngũ huấn luyện viên chuyên nghiệp, cùng các lớp học đa dạng. Hãy đến và trải nghiệm không gian tập luyện đẳng cấp, nơi bạn có thể cải thiện sức khỏe và nâng cao chất lượng cuộc sống!</p>
            <div class="about-details">
                <div class="schedule">
                    <div class="icon"><i class="fas fa-clock"></i></div>
                    <p>Thứ 2 - Thứ 6: 6:00 - 23:00</p>
                    <p>Thứ 7: 6:00 - 22:00</p>
                    <p>Chủ nhật: 6:00 - 20:00</p>
                </div>
                <div class="location">
                    <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                    <p>12 Phố Chùa Bộc, Quang Trung, Đống Đa, Hà Nội</p>
                </div>
            </div>
            <div class="about-buttons">
                <a href="{{ route('dang-ky-tap-thu') }}" class="cta-button highlighted">Đăng ký ngay</a>
                <a href="{{ URL::to('/services') }}" class="cta-button">Xem thêm</a>
            </div>
        </div>
    </div>
</section>

<section class="benefit-section" style='margin-bottom: 20px;'>
    <div class="benefit-container">

        <div class="benefit-item">
            <div class="benefit-icon"><i class="fa-solid fa-rotate-right"></i></div>
            <span>Trả hàng trong 30 ngày</span>
        </div>

        <div class="benefit-item">
            <div class="benefit-icon"><i class="fa-solid fa-truck-fast"></i></div>
            <span>Giao hàng miễn phí</span>
        </div>

        <div class="benefit-item">
            <div class="benefit-icon"><i class="fa-solid fa-money-check-dollar"></i></div>
            <span>Thanh toán linh hoạt</span>
        </div>

        <div class="benefit-item">
            <div class="benefit-icon"><i class="fa-solid fa-phone"></i></div>
            <span>Hotline: 18006750</span>
        </div>

    </div>
</section>

<section class="voucher-section">
    <div class="voucher-container">

        @foreach ($vouchers as $km)
        <div class="voucher-card">
            <div class="voucher-content">

                <h3>Nhập mã: {{ $km->ma_code }}</h3>

                <p>
                    {{ $km->mo_ta ?? 'Ưu đãi hấp dẫn dành cho bạn!' }}
                </p>

                <button class="copy-btn" data-code="{{ $km->ma_code }}">
                    Sao chép mã
                </button>

            </div>
            <div class="voucher-barcode"></div>
        </div>
        @endforeach

    </div>
</section>

<section class="sale-section container">

    <!-- TITLE -->
    <div class="sale-header">

        <div class="header-left">
            <h2>Ưu đãi hot! Đừng bỏ lỡ <span class="save-badge">SAVE 60%</span></h2>
            <p>Sản phẩm sale đến khi hết hàng. Tiết kiệm đến 60%, đừng bỏ lỡ bạn ơi...</p>
        </div>

        <div class="header-right">
            <div class="countdown-wrapper">
                <div class="time-box">
                    <span id="days">00</span>
                    <small>Ngày</small>
                </div>
                <div class="time-box">
                    <span id="hours">00</span>
                    <small>Giờ</small>
                </div>
                <div class="time-box">
                    <span id="minutes">00</span>
                    <small>Phút</small>
                </div>
                <div class="time-box">
                    <span id="seconds">00</span>
                    <small>Giây</small>
                </div>
            </div>
        </div>

    </div>



    <div class="sale-content">

        <!-- LEFT BANNER -->
        <div class="sale-banner">
            <img src="/frontend/img/Gioi-thieu/section-sale.webp" alt="Sale Banner">
        </div>

        <!-- RIGHT PRODUCT SLIDER -->
        <div class="sale-slider">

            <!-- Mũi tên trái -->
            <button class="arrow-btn left" id="slideLeft">
                <i class="fa fa-chevron-left"></i>
            </button>

            <!-- Slider wrapper -->
            <div class="sale-slider-wrapper" id="saleWrapper">

                @foreach($sanphams as $sp)
                    <div class="sale-item" data-href="{{ route('detail', ['id' => $sp->id_sanpham]) }}">
                        <!-- IMAGE -->
                        <div class="sale-img">
                            @php
                                $img = $sp->images->first();
                                $imagePath1 = $img ? str_replace('\\', '/', $img->duong_dan) : 'frontend/upload/default.jpg';
                            @endphp
                            <img src="{{ asset($imagePath1) }}" alt="{{ $sp->tensp }}">
                        </div>
                        <!-- ICON HOVER -->
                        <div class="hover-icons">
                            <!-- Nút thêm vào giỏ hàng -->
                            <a href="#" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart', $sp->id_sanpham) }}"
                               data-id="{{ $sp->id_sanpham }}"
                               data-name="{{ $sp->tensp }}"
                               data-co-size="{{ $sp->co_size }}"
                               data-sizes="{{ $sp->co_size == 1 ? json_encode($sp->sizes->map(function($s){ return ['id'=>$s->id_size,'name'=>$s->ten_size,'qty'=>$s->pivot->soluong,'surcharge'=>(int)$s->pivot->gia_cong_them]; })) : '' }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>


                            <!-- Nút xem chi tiết -->
                            <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="icon-btn" title="Xem chi tiết">
                                <i class="fa fa-search"></i>
                            </a>

                        </div>

                        <!-- NAME -->
                        <h3 class="sale-name">{{ $sp->tensp }}</h3>

                        <!-- PRICE -->
                        <div class="sale-price">
                            <span class="new-price">{{ number_format($sp->gia_duoc_giam) }}đ</span>
                            <span class="old-price">{{ number_format($sp->giasp) }}đ</span>
                            <span class="discount">-{{ $sp->giamgia }}%</span>
                        </div>

                        <!-- INFO -->
                        <div class="product-rating" style="color: #ffb800; font-size: 12px; margin: 4px 0 6px; text-align: left;">
                            @php
                                $avgRating = $sp->comments_avg_rating ?? 5;
                                $cntRating = $sp->comments_count ?? 0;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    <i class="fa fa-star"></i>
                                @else
                                    <i class="fa fa-star-o"></i>
                                @endif
                            @endfor
                            <span style="color: #aaa; font-size: 11px; margin-left: 4px;">({{ $cntRating }})</span>
                        </div>
                        <div class="benefit">🔥 Giá tốt nhất thị trường</div>
                        <div class="gift">🎁 Quà tặng trị giá 100.000đ</div>

                        <!-- PROGRESS BAR -->
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ rand(30,80) }}%"></div>
                        </div>

                        <span class="sold">{{ $sp->sold }} sản phẩm đã bán</span>

                    </div>
                @endforeach

            </div>

            <!-- Mũi tên phải -->
            <button class="arrow-btn right" id="slideRight">
                <i class="fa fa-chevron-right"></i>
            </button>

        </div>
    </div>

</section>

<div style='margin-top: 10px;'>
  <img src="/frontend/img/Gioi-thieu/section-image-1.webp" alt="Sale 40%" class="sale-banner-img">
  
</div>


<section class="top-sell-section">
    <div class="container">
        <h2 class="top-sell-title">Top sản phẩm bán chạy!</h2>

        <div class="top-sell-grid">
            @foreach($sanphams as $sp)
                <div class="sale-item" data-href="{{ route('detail', ['id' => $sp->id_sanpham]) }}">
                    <!-- IMAGE -->
                    <div class="sale-img">
                        @php
                            $img = $sp->images->first();
                            $imagePath1 = $img ? str_replace('\\', '/', $img->duong_dan) : 'frontend/upload/default.jpg';
                        @endphp

                        <img src="{{ asset($imagePath1) }}" alt="{{ $sp->tensp }}">
                    </div>

                    <!-- ICON HOVER -->
                    <div class="hover-icons">

                        <!-- Nút thêm vào giỏ hàng -->
                        <a href="#" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart', $sp->id_sanpham) }}"
                           data-id="{{ $sp->id_sanpham }}"
                           data-name="{{ $sp->tensp }}"
                           data-co-size="{{ $sp->co_size }}"
                           data-sizes="{{ $sp->co_size == 1 ? json_encode($sp->sizes->map(function($s){ return ['id'=>$s->id_size,'name'=>$s->ten_size,'qty'=>$s->pivot->soluong,'surcharge'=>(int)$s->pivot->gia_cong_them]; })) : '' }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>


                        <!-- Nút xem chi tiết -->
                        <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="icon-btn" title="Xem chi tiết">
                            <i class="fa fa-search"></i>
                        </a>

                    </div>

                    <!-- NAME -->
                    <h3 class="sale-name">{{ $sp->tensp }}</h3>

                    <!-- PRICE -->
                    <div class="sale-price">
                        <span class="new-price">{{ number_format($sp->gia_duoc_giam) }}đ</span>
                        <span class="old-price">{{ number_format($sp->giasp) }}đ</span>
                        <span class="discount">-{{ $sp->giamgia }}%</span>
                    </div>

                    <!-- INFO -->
                    <div class="product-rating" style="color: #ffb800; font-size: 12px; margin: 4px 0 6px; text-align: left;">
                        @php
                            $avgRating = $sp->comments_avg_rating ?? 5;
                            $cntRating = $sp->comments_count ?? 0;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($avgRating))
                                <i class="fa fa-star"></i>
                            @else
                                <i class="fa fa-star-o"></i>
                            @endif
                        @endfor
                        <span style="color: #aaa; font-size: 11px; margin-left: 4px;">({{ $cntRating }})</span>
                    </div>
                    <div class="benefit">🔥 Giá tốt nhất thị trường</div>
                    <div class="gift">🎁 Quà tặng trị giá 100.000đ</div>

                    <!-- PROGRESS BAR -->
                    <div class="progress-bar">
                        <div class="progress" style="width: {{ rand(30,80) }}%"></div>
                    </div>

                    <span class="sold">{{ $sp->sold }} sản phẩm đã bán</span>

                </div>
            @endforeach
        </div>

        <div class="view-more-container">
            <a href="/viewAll" class="view-more-btn">Xem tất cả →</a>
        </div>
    </div>
</section>

<div style='margin-top: 10px;'>
  <img src="/frontend/img/Gioi-thieu/section-image-2.webp" alt="Sale 40%" class="sale-banner-img">
</div>

<section class="top-sell-section">
    <div class="container">
        <h2 class="section-badge">QUẦN TẬP</h2>

        <div class="top-sell-grid">
            @foreach($alls->where('id_danhmuc', 1)->take(8) as $sp)
                <div class="sale-item" data-href="{{ route('detail', ['id' => $sp->id_sanpham]) }}">
                    <!-- IMAGE -->
                    <div class="sale-img">
                        @php
                            $img = $sp->images->first();
                            $imagePath1 = $img ? str_replace('\\', '/', $img->duong_dan) : 'frontend/upload/default.jpg';
                        @endphp

                        <img src="{{ asset($imagePath1) }}" alt="{{ $sp->tensp }}">
                    </div>

                    <!-- ICON HOVER -->
                    <div class="hover-icons">

                        <!-- Nút thêm vào giỏ hàng -->
                        <a href="#" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart', $sp->id_sanpham) }}"
                           data-id="{{ $sp->id_sanpham }}"
                           data-name="{{ $sp->tensp }}"
                           data-co-size="{{ $sp->co_size }}"
                           data-sizes="{{ $sp->co_size == 1 ? json_encode($sp->sizes->map(function($s){ return ['id'=>$s->id_size,'name'=>$s->ten_size,'qty'=>$s->pivot->soluong,'surcharge'=>(int)$s->pivot->gia_cong_them]; })) : '' }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>


                        <!-- Nút xem chi tiết -->
                        <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="icon-btn" title="Xem chi tiết">
                            <i class="fa fa-search"></i>
                        </a>

                    </div>

                    <!-- NAME -->
                    <h3 class="sale-name">{{ $sp->tensp }}</h3>

                    <!-- PRICE -->
                    <div class="sale-price">
                        <span class="new-price">{{ number_format($sp->gia_duoc_giam) }}đ</span>
                        <span class="old-price">{{ number_format($sp->giasp) }}đ</span>
                        <span class="discount">-{{ $sp->giamgia }}%</span>
                    </div>

                    <!-- INFO -->
                    <div class="benefit">🔥 Giá tốt nhất thị trường</div>
                    <div class="gift">🎁 Quà tặng trị giá 100.000đ</div>

                    <!-- PROGRESS BAR -->
                    <div class="progress-bar">
                        <div class="progress" style="width: {{ rand(30,80) }}%"></div>
                    </div>

                    <span class="sold">{{ $sp->sold }} sản phẩm đã bán</span>

                </div>
            @endforeach
        </div>

        <div class="view-more-container">
            <a href="#" class="view-more-btn">Xem tất cả →</a>
        </div>
    </div>
</section>

<div style='margin-top: 10px;'>
  <img src="/frontend/img/Gioi-thieu/section-image-2.webp" alt="Sale 40%" class="sale-banner-img">
</div>

    <section class="top-sell-section">
        <div class="container">
            <h2 class="section-badge">ÁO TẬP</h2>

            <div class="top-sell-grid">
                @foreach($alls->where('id_danhmuc', 1)->take(8) as $sp)
                    <div class="sale-item" data-href="{{ route('detail', ['id' => $sp->id_sanpham]) }}">

                        <!-- IMAGE -->
                        <div class="sale-img">
                            @php
                                $img = $sp->images->first();
                                $imagePath1 = $img ? str_replace('\\', '/', $img->duong_dan) : 'frontend/upload/default.jpg';
                            @endphp

                            <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="full-link"></a> 
                            <img src="{{ asset($imagePath1) }}" alt="{{ $sp->tensp }}">
                        </div>

                        <!-- ICON HOVER -->
                        <div class="hover-icons">

                            <!-- Nút thêm vào giỏ hàng -->
                            <a href="#" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart', $sp->id_sanpham) }}"
                               data-id="{{ $sp->id_sanpham }}"
                               data-name="{{ $sp->tensp }}"
                               data-co-size="{{ $sp->co_size }}"
                               data-sizes="{{ $sp->co_size == 1 ? json_encode($sp->sizes->map(function($s){ return ['id'=>$s->id_size,'name'=>$s->ten_size,'qty'=>$s->pivot->soluong,'surcharge'=>(int)$s->pivot->gia_cong_them]; })) : '' }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>


                            <!-- Nút xem chi tiết -->
                            <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="icon-btn" title="Xem chi tiết">
                                <i class="fa fa-search"></i>
                            </a>

                        </div>

                        <!-- NAME -->
                        <h3 class="sale-name">{{ $sp->tensp }}</h3>

                        <!-- PRICE -->
                        <div class="sale-price">
                            <span class="new-price">{{ number_format($sp->gia_duoc_giam) }}đ</span>
                            <span class="old-price">{{ number_format($sp->giasp) }}đ</span>
                            <span class="discount">-{{ $sp->giamgia }}%</span>
                        </div>

                        <!-- INFO -->
                        <div class="benefit">🔥 Giá tốt nhất thị trường</div>
                        <div class="gift">🎁 Quà tặng trị giá 100.000đ</div>

                        <!-- PROGRESS BAR -->
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ rand(30,80) }}%"></div>
                        </div>

                        <span class="sold">{{ $sp->sold }} sản phẩm đã bán</span>

                    </div>
                @endforeach
            </div>

            <div class="view-more-container">
                <a href="#" class="view-more-btn">Xem tất cả →</a>
            </div>
        </div>
    </section>

<section id="bmi">
  <div class="bmi-container">
    <div class="bmi-grid">
      <div class="bmi-content">
        <h2>Tính Chỉ Số BMI</h2>
        <p>Kiểm tra chỉ số BMI của bạn để có cái nhìn tổng quan về tình trạng sức khỏe và nhận được lời khuyên từ chuyên gia.</p>
        <form id="bmi-form">
          <div class="form-group">
            <label for="height">Chiều cao (cm)</label>
            <input type="number" id="height" placeholder="Nhập chiều cao">
          </div>
          <div class="form-group">
            <label for="weight">Cân nặng (kg)</label>
            <input type="number" id="weight" placeholder="Nhập cân nặng">
          </div>
          <button type="submit">Tính BMI</button>
        </form>
        <div id="bmi-result" class="bmi-result hidden">
          <div class="result-box">
            <h3>Kết quả BMI của bạn</h3>
            <div class="result-row">
              <span>Chỉ số BMI:</span>
              <span id="bmi-value">0</span>
            </div>
            <p id="bmi-message"></p>
          </div>
        </div>
      </div>
      <div class="bmi-image">
        <img src="https://hoangphucphoto.com/wp-content/uploads/2025/04/anh-fitness-2.jpg" alt="BMI Visualization">
        <div class="image-overlay">
          <h3>Tại sao cần tính BMI?</h3>
          <p>BMI giúp bạn đánh giá mức độ cân đối của cơ thể, từ đó có kế hoạch tập luyện và dinh dưỡng phù hợp.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="testimonial-section">
    <div class="container">

        <div class="testimonial-header">
            <i class="fa-solid fa-comment-dots testimonial-icon"></i>
            <h2>Phản hồi từ khách hàng</h2>
            <p>Khách hàng nói gì về chúng tôi?</p>
        </div>

        <!-- NÚT MŨI TÊN -->
        <div class="testimonial-arrow left-arrow"><i class="fa-solid fa-chevron-left"></i></div>
        <div class="testimonial-arrow right-arrow"><i class="fa-solid fa-chevron-right"></i></div>

        <div class="testimonial-row">

            <!-- ITEM 1 -->
            <div class="testimonial-item">
                <img src="/frontend/img/Gioi-thieu/danh-gia.webp" class="testimonial-avatar">
                <h3 class="testimonial-name">Long Lê</h3>
                <p class="testimonial-role">Designer</p>
                <p class="testimonial-text">
                    Được bạn bè giới thiệu qua Lofi Gym, thấy anh chủ tư vấn tận tình 
                    về chế độ tập luyện. Giờ mình đã lên được 8kg. Cảm ơn shop nhiều nhé.
                </p>
                <div class="testimonial-quote">❞</div>
            </div>

            <!-- ITEM 2 -->
            <div class="testimonial-item">
                <img src="/frontend/img/Gioi-thieu/danh-gia-1.webp" class="testimonial-avatar">
                <h3 class="testimonial-name">Thiên Phước</h3>
                <p class="testimonial-role">Nhân viên kinh doanh</p>
                <p class="testimonial-text">
                    Đã dùng rất nhiều sản phẩm của Lofi Gym và đạt được kết quả khá tốt. 
                    Giá hợp lý, sản phẩm chất lượng, ship nhanh.
                </p>
                <div class="testimonial-quote">❞</div>
            </div>

            <!-- ITEM 3 -->
            <div class="testimonial-item">
                <img src="/frontend/img/Gioi-thieu/danh-gia-3.webp" class="testimonial-avatar">
                <h3 class="testimonial-name">Dương Dũng</h3>
                <p class="testimonial-role">Hướng dẫn viên</p>
                <p class="testimonial-text">
                    Sản phẩm chất lượng, nhân viên tư vấn nhiệt tình. 
                    Shop không tính phí ship nên khá bất ngờ. Sẽ quay lại ủng hộ!
                </p>
                <div class="testimonial-quote">❞</div>
            </div>

            <!-- ITEM 4 -->
            <div class="testimonial-item">
                <img src="/frontend/img/Gioi-thieu/danh-gia-1.webp" class="testimonial-avatar">
                <h3 class="testimonial-name">Minh Trần</h3>
                <p class="testimonial-role">Kỹ sư</p>
                <p class="testimonial-text">
                    Lần đầu mua thử nhưng chất lượng tốt hơn mong đợi. Hỗ trợ nhiệt tình,
                    sẽ giới thiệu bạn bè đến mua.
                </p>
                <div class="testimonial-quote">❞</div>
            </div>

            <!-- ITEM 5 -->
            <div class="testimonial-item">
                <img src="/frontend/img/Gioi-thieu/danh-gia-1.webp" class="testimonial-avatar">
                <h3 class="testimonial-name">Ngọc Anh</h3>
                <p class="testimonial-role">Giáo viên</p>
                <p class="testimonial-text">
                    Ship cực nhanh, hàng đóng gói kỹ. Đã dùng 1 tuần và cảm thấy cơ thể
                    khỏe hơn rất nhiều.
                </p>
                <div class="testimonial-quote">❞</div>
            </div>

            <!-- ITEM 6 -->
            <div class="testimonial-item">
                <img src="/frontend/img/Gioi-thieu/danh-gia-6.webp" class="testimonial-avatar">
                <h3 class="testimonial-name">Hải Nam</h3>
                <p class="testimonial-role">Nhân viên văn phòng</p>
                <p class="testimonial-text">
                    Combo tập luyện rất ok, giá tốt, tư vấn đầy đủ. Mình rất hài lòng 
                    và sẽ tiếp tục ủng hộ shop!
                </p>
                <div class="testimonial-quote">❞</div>
            </div>

        </div>
    </div>
</section>





<div id="cart-toast" class="cart-toast">
    <span class="cart-toast__text"></span>
</div>
@push('scripts')
<script src="{{ asset('frontend/script/about.js') }}"></script>
@endpush
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.js-add-to-cart');
    const toast = document.getElementById('cart-toast');
    const toastText = toast.querySelector('.cart-toast__text');
    let toastTimeout;

    buttons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const url = this.dataset.url;
            if (!url) return;

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(async res => {
                // Tránh lỗi JSON.parse khi Laravel trả HTML
                let data = {};
                try {
                    data = await res.json();
                } catch (e) {
                    data = { message: "Đã thêm sản phẩm vào giỏ hàng!" };
                }
                showCartToast(data.message);

                // Cập nhật số lượng giỏ hàng ở header
                if (data.cart_count !== undefined) {
                    const badge = document.querySelector('.navbar__shoppingCart span');
                    if (badge) {
                        badge.textContent = data.cart_count;
                    }
                }
            })
            .catch(() => {
                showCartToast('Có lỗi xảy ra, vui lòng thử lại!');
            });
        });
    });

    function showCartToast(message) {
        toastText.textContent = message;
        toast.classList.add('show');

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 2000);
    }
});



// === Tính BMI ===
    const bmiForm = document.getElementById('bmi-form');
    if (bmiForm) {
        bmiForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const height = parseFloat(document.getElementById('height').value) / 100;
            const weight = parseFloat(document.getElementById('weight').value);
            const bmiValue = document.getElementById('bmi-value');
            const bmiMessage = document.getElementById('bmi-message');
            const bmiResult = document.getElementById('bmi-result');

            if (height > 0 && weight > 0) {
                const bmi = weight / (height * height);
                bmiValue.textContent = bmi.toFixed(1);

                let message = '';
                if (bmi < 18.5) {
                    message = 'Bạn đang thiếu cân. Hãy đến với chúng tôi để có chế độ ăn uống và tập luyện hợp lý!';
                } else if (bmi < 25) {
                    message = 'Bạn đang có cân nặng bình thường. Tiếp tục duy trì lối sống lành mạnh!';
                } else if (bmi < 30) {
                    message = 'Bạn đang có dấu hiệu thừa cân. Hãy đến với chúng tôi để có kế hoạch tập luyện và dinh dưỡng phù hợp!';
                } else {
                    message = 'Bạn đang thừa cân. Hãy đến với chúng tôi để được tư vấn và hỗ trợ giảm cân hiệu quả!';
                }

                bmiMessage.textContent = message;
                bmiResult.classList.remove('hidden');
            } else {
                alert('Vui lòng nhập chiều cao và cân nặng hợp lệ!');
            }
        });
    }
</script>
<script>
    const row = document.querySelector('.testimonial-row');
    const left = document.querySelector('.left-arrow');
    const right = document.querySelector('.right-arrow');

    right.addEventListener('click', () => {
        row.scrollBy({ left: 350, behavior: "smooth" });
    });

    left.addEventListener('click', () => {
        row.scrollBy({ left: -350, behavior: "smooth" });
    });
</script>
<script>
document.querySelectorAll(".copy-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        let code = btn.getAttribute("data-code");
        navigator.clipboard.writeText(code);
        btn.innerText = "Đã sao chép!";
        setTimeout(() => btn.innerText = "Sao chép mã", 1500);
    });
});
</script>

<script>
    const wrapper = document.getElementById('saleWrapper');
    const step = 260; // mỗi lần trượt 1 item

    document.getElementById("slideLeft").onclick = () => {
        wrapper.scrollLeft -= step;
    };

    document.getElementById("slideRight").onclick = () => {
        wrapper.scrollLeft += step;
    };
</script>

<script>
    // Set ngày kết thúc
    const endDate = new Date("2025-12-31 23:59:59").getTime();

    const timer = setInterval(function () {
        const now = new Date().getTime();
        const distance = endDate - now;

        if (distance < 0) {
            clearInterval(timer);
            document.getElementById("days").innerHTML = "00";
            document.getElementById("hours").innerHTML = "00";
            document.getElementById("minutes").innerHTML = "00";
            document.getElementById("seconds").innerHTML = "00";
            return;
        }

        // Tính toán
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Hiển thị
        document.getElementById("days").innerHTML = days;
        document.getElementById("hours").innerHTML = hours;
        document.getElementById("minutes").innerHTML = minutes;
        document.getElementById("seconds").innerHTML = seconds;

    }, 1000);


    document.querySelectorAll('.sale-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Không click khi bấm vào icon
            if (e.target.closest('.icon-btn')) return;

            window.location.href = this.dataset.href;
        });
    });

</script>



@endsection

