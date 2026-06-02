@extends('layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/dangkitapthu.css') }}">
@endpush

@section('content')

<section class="trial-register-page">
    <div class="trial-register__overlay"></div>

    <div class="trial-register__left">
        <div class="trial-register__image">
            <img src="{{ asset('frontend/img/dangkitapthu-hero.jpg') }}" alt="Đăng ký tập thử" >
        </div>

        <div class="trial-register__text">
            <h1 id="typingText">BẮT ĐẦU XÂY DỰNG<br>SỨC KHOẺ<br>NGAY HÔM NAY!</h1>
            <p class="trial-register__sub">
                Đăng ký nhận ưu đãi tháng<br>
                hoặc Combo trải nghiệm 7 ngày miễn phí và 2 buổi tập thử cùng HLV.
            </p>
        </div>
    </div>

    <div class="trial-register__right">
        <div class="trial-register__form-wrapper">
            <h2>Đăng ký tập thử</h2>

            {{-- FORM SUBMIT --}}
            <form action="{{ route('dang-ky-tap-thu.store') }}" method="POST" class="trial-register__form" id="trialForm">
                @csrf

                <div class="form-group">
                    <label>Họ và tên <span>*</span></label>
                    <input type="text" name="ho_ten" placeholder="Nhập tên của bạn" value="{{ auth()->check() ? auth()->user()->hoten : '' }}" required>
                    @error('ho_ten')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Nhập email của bạn" value="{{ auth()->check() ? auth()->user()->email : '' }}">
                    @error('email')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Số điện thoại <span>*</span></label>
                    <input type="text" name="so_dien_thoai" placeholder="Nhập số điện thoại" value="{{ auth()->check() ? auth()->user()->sdt : '' }}" required>
                    @error('so_dien_thoai')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Môn thể thao ưa thích <span>*</span></label>
                    <select name="mon_ua_thich">
                        <option value="">Chọn môn thể thao</option>
                        @foreach($mon_ua_thich as $m)
                            <option value="{{ $m }}">{{ ucfirst($m) }}</option>
                        @endforeach
                    </select>
                    @error('mon_ua_thich')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Cơ sở tập luyện <span>*</span></label>
                    <select name="co_so_tap">
                        <option value="">Chọn cơ sở tập luyện</option>
                        @foreach($co_so_tap as $cs)
                            <option value="{{ $cs }}">{{ $cs }}</option>
                        @endforeach
                    </select>
                    @error('co_so_tap')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Khung giờ mong muốn <span>*</span></label>
                    <select name="gio_mong_muon">
                        <option value="">Chọn giờ</option>
                        @foreach($gio_mong_muon as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </select>
                    @error('gio_mong_muon')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Ngày muốn tập thử <span>*</span></label>
                    <input type="date" name="ngay_mong_muon" required>
                    @error('ngay_mong_muon')
                        <small class="text-danger" style="color: red; font-style: italic;">{{ $message }}</small>
                    @enderror
                </div>


                <button type="submit" class="trial-register__submit" id="btnSendForm">
                    Gửi thông tin
                </button>

                <p class="trial-register__note">
                    Bằng việc gửi thông tin, bạn đồng ý cho Rise Fitness liên hệ tư vấn qua điện thoại/Zalo.
                </p>
            </form>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "",
            text: "{{ session('success') }}",
            confirmButtonColor: "#0284c7",
            confirmButtonText: "OK"
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: "error",
            title: "Thông báo",
            text: "{{ $errors->first() }}",
            confirmButtonColor: "#ef4444",
            confirmButtonText: "OK"
        });
    @endif
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    const lines = [
        "BẮT ĐẦU XÂY DỰNG",
        "SỨC KHOẺ",
        "NGAY HÔM NAY!"
    ];

    const typingElement = document.getElementById("typingText");
    let lineIndex = 0;
    let charIndex = 0;

    function type() {
        if (lineIndex < lines.length) {
            let currentLine = lines[lineIndex];

            if (charIndex < currentLine.length) {
                typingElement.innerHTML = 
                    lines.slice(0, lineIndex).join("\n") +   // dòng trước đó
                    (lineIndex > 0 ? "\n" : "") +            // xuống dòng
                    currentLine.substring(0, charIndex + 1) + 
                    "<span class='cursor'></span>";

                charIndex++;
                setTimeout(type, 60); // tốc độ gõ (ms)
            } else {
                charIndex = 0;
                lineIndex++;
                setTimeout(type, 400); // delay trước khi chuyển dòng mới
            }
        }
    }

    type();
});
</script>



@endsection
