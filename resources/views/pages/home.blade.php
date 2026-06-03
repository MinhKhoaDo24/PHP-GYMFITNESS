@extends('layout')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/health_station.css') }}">
@endpush


<!-- HERO BANNER -->
<section class="hero-banner">

    <video autoplay muted loop playsinline class="banner-video">
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
        @php 
            $isExpired = \Carbon\Carbon::parse($km->ngay_ket_thuc)->isPast() || $km->trang_thai == 0;
        @endphp
        <div class="voucher-card {{ $isExpired ? 'expired' : '' }}">
            <div class="voucher-content">

                <h3>Nhập mã: {{ $km->ma_code }}</h3>

                <p>
                    {{ $km->mo_ta ?? 'Ưu đãi hấp dẫn dành cho bạn!' }}
                </p>

                @if($isExpired)
                <button class="copy-btn" onclick="showExpiredAlertHome()">
                    Đã hết hạn
                </button>
                @else
                <button class="copy-btn active-btn" data-code="{{ $km->ma_code }}">
                    Sao chép mã
                </button>
                @endif

            </div>
            <div class="voucher-barcode"></div>
            
            @if($isExpired)
                <div class="expired-stamp-home">HẾT HẠN</div>
            @endif
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
                            <span class="new-price">{{ number_format($sp->gia_duoc_giam, 0, ',', '.') }}đ</span>
                            <span class="old-price">{{ number_format($sp->giasp, 0, ',', '.') }}đ</span>
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
        <h2 class="top-sell-title">Sản phẩm nổi bật!</h2>

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
                        <span class="new-price">{{ number_format($sp->gia_duoc_giam, 0, ',', '.') }}đ</span>
                        <span class="old-price">{{ number_format($sp->giasp, 0, ',', '.') }}đ</span>
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
                        <span class="new-price">{{ number_format($sp->gia_duoc_giam, 0, ',', '.') }}đ</span>
                        <span class="old-price">{{ number_format($sp->giasp, 0, ',', '.') }}đ</span>
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
                            <span class="new-price">{{ number_format($sp->gia_duoc_giam, 0, ',', '.') }}đ</span>
                            <span class="old-price">{{ number_format($sp->giasp, 0, ',', '.') }}đ</span>
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

<section id="health-station">
  <div class="hs-container">
    <div class="hs-grid">
      <div class="hs-content">
        <h2>Trạm Đo Sức Khỏe Thông Minh</h2>
        <p>Kiểm tra chỉ số BMI, BMR và TDEE của bạn để nhận lộ trình tập luyện và dinh dưỡng "đo ni đóng giày" từ chuyên gia.</p>
        <form id="hs-form" action="{{ route('health.results') }}" method="GET">
          
          <div class="form-row">
            <div class="form-group">
              <label for="gender">Giới tính</label>
              <select id="gender" name="gender" required>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
              </select>
            </div>
            <div class="form-group">
              <label for="age">Tuổi</label>
              <input type="number" id="age" name="age" placeholder="Ví dụ: 25" required min="10" max="100">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="height">Chiều cao (cm)</label>
              <input type="number" id="height" name="height" placeholder="Ví dụ: 170" required min="100" max="250">
            </div>
            <div class="form-group">
              <label for="weight">Cân nặng (kg)</label>
              <input type="number" id="weight" name="weight" placeholder="Ví dụ: 65" required min="30" max="200">
            </div>
          </div>

          <div class="form-group">
            <label for="activity">Tần suất vận động</label>
            <select id="activity" name="activity" required>
              <option value="sedentary">Ít vận động (Việc văn phòng, không tập)</option>
              <option value="light">Vận động nhẹ (Tập 1-3 ngày/tuần)</option>
              <option value="moderate">Vận động vừa (Tập 3-5 ngày/tuần)</option>
              <option value="active">Vận động nhiều (Tập 6-7 ngày/tuần)</option>
              <option value="very_active">Vận động rất nhiều (Tập nặng 2 lần/ngày)</option>
            </select>
          </div>

          <div class="form-group">
            <label for="goal">Mục tiêu của bạn</label>
            <select id="goal" name="goal" required>
              <option value="lose_fat">Giảm mỡ, Giảm cân</option>
              <option value="gain_muscle">Tăng cơ, Tăng cân</option>
              <option value="maintain">Giữ dáng, Tăng độ dẻo dai</option>
            </select>
          </div>

          <button type="submit" class="hs-submit-btn">Phân tích thể trạng ngay <i class="fa-solid fa-arrow-right"></i></button>
        </form>
      </div>
      <div class="hs-image">
        <img src="https://hoangphucphoto.com/wp-content/uploads/2025/04/anh-fitness-2.jpg" alt="Health Station">
        <div class="image-overlay-hs glassmorphism">
          <h3>Phân tích 360&deg;</h3>
          <ul>
            <li><i class="fa-solid fa-check"></i> Chỉ số khối cơ thể (BMI)</li>
            <li><i class="fa-solid fa-check"></i> Trao đổi chất cơ bản (BMR)</li>
            <li><i class="fa-solid fa-check"></i> Tổng Calo tiêu thụ (TDEE)</li>
          </ul>
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





@push('scripts')
<script src="{{ asset('frontend/script/about.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
<script>
    function showExpiredAlertHome() {
        Swal.fire({
            icon: 'error',
            title: 'Rất tiếc!',
            text: 'Mã khuyến mãi này đã hết hạn và không thể sử dụng!',
            confirmButtonText: 'Đã hiểu'
        });
    }


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
document.querySelectorAll(".copy-btn.active-btn").forEach(btn => {
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
    // Tự động thiết lập ngày kết thúc là Chủ Nhật tuần này lúc 23:59:59
    function getNextSundayEnd() {
        const now = new Date();
        const resultDate = new Date(now);
        const day = now.getDay();
        const diff = (day === 0 ? 0 : 7 - day); // Số ngày đến Chủ Nhật
        resultDate.setDate(now.getDate() + diff);
        resultDate.setHours(23, 59, 59, 999);
        return resultDate.getTime();
    }

    const endDate = getNextSundayEnd();

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

        // Hiển thị dạng 2 chữ số
        const formatNumber = num => String(num).padStart(2, '0');

        document.getElementById("days").innerHTML = formatNumber(days);
        document.getElementById("hours").innerHTML = formatNumber(hours);
        document.getElementById("minutes").innerHTML = formatNumber(minutes);
        document.getElementById("seconds").innerHTML = formatNumber(seconds);

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

