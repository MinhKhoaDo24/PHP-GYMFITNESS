@extends('layout')

@section('content')
<style>
    /* page-header */
    .page-header {
        height: 300px;
        background-image: url('/frontend/img/kick-offer-2.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        overflow: hidden;
        position: relative;
    }

    .header-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    }

    .header-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.45), 0 0 12px rgba(255, 255, 255, 0.15);
        z-index: 3;
        animation: slideUp 0.9s ease-out forwards;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translate(-50%, -20%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }

    .register-wrapper {
        background: #f1f5f9;
        min-height: 100vh;
        color: #334155;
        padding: 60px 0;
    }

    .rf-white-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .rf-package-header-img {
        height: 320px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .rf-package-header-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.8) 100%);
    }

    .rf-badge-type {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(52, 164, 224, 0.9);
        border: 1px solid #34A4E0;
        color: #fff;
        padding: 6px 16px;
        border-radius: 99px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .rf-price-box-active {
        border: 2px solid #34A4E0 !important;
        background: rgba(52, 164, 224, 0.05) !important;
        transform: translateY(-4px);
    }

    .rf-price-option-card {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .rf-price-option-card:hover {
        border-color: rgba(52, 164, 224, 0.5);
        background: rgba(52, 164, 224, 0.02);
    }

    .rf-price-radio {
        position: absolute;
        top: 20px;
        right: 20px;
        accent-color: #34A4E0;
        width: 18px;
        height: 18px;
    }

    .rf-switch-pt {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
    }

    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #34A4E0;
        border-color: #34A4E0;
    }

    .rf-btn-submit {
        background: linear-gradient(135deg, #34A4E0 0%, #1d4ed8 100%);
        border: none;
        color: white;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-radius: 12px;
        padding: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(52, 164, 224, 0.2);
    }

    .rf-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(52, 164, 224, 0.3);
        filter: brightness(1.1);
        color: white;
    }

    .rf-total-box {
        background: rgba(52, 164, 224, 0.05);
        border: 1px dashed rgba(52, 164, 224, 0.4);
        border-radius: 16px;
    }
</style>

<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>ĐĂNG KÝ GÓI TẬP</h1>
    </div>
</section>

<div class="register-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="rf-white-card">
                    <div class="row no-gutters">
                        
                        {{-- Cột Trái: Ảnh và Mô tả gói tập --}}
                        <div class="col-md-5 d-flex flex-column justify-content-between" style="background: #ffffff; border-right: 1px solid #e2e8f0;">
                            <div>
                                <div class="rf-package-header-img" style="background-image: url('{{ asset($goitap->hinh_anh) }}');">
                                    <span class="rf-badge-type">{{ $goitap->loai_goi }}</span>
                                    <div class="rf-package-header-overlay">
                                        <div style="position: absolute; bottom: 20px; left: 20px; right: 20px;">
                                            <h2 class="font-weight-extrabold text-white mb-1" style="font-size: 28px; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $goitap->ten_goi }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <p class="font-weight-bold mb-4" style="font-size: 16px; color: #34A4E0;">{{ $goitap->mo_ta_ngan }}</p>
                                    
                                    <div class="text-muted pl-4 mb-4" style="font-size: 14px; line-height: 1.8;">
                                        {!! $goitap->mo_ta_chi_tiet !!}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 border-top" style="border-color: #e2e8f0;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted font-weight-bold">Phụ thu PT/Tháng:</span>
                                    <span class="font-weight-bold" style="font-size: 18px; color: #0f172a;">+ {{ number_format($goitap->gia_pt_them, 0, ',', '.') }} đ</span>
                                </div>
                            </div>
                        </div>

                        {{-- Cột Phải: Form cấu hình đăng ký --}}
                        <div class="col-md-7 p-4 p-lg-5">
                            <h3 class="font-weight-bold mb-4" style="font-size: 22px; color: #0f172a;"> Đăng ký gói tập của bạn </h3>
                            
                            <form action="{{ route('goitap.register.store', $goitap->slug) }}" method="POST" id="rfRegisterForm">
                                @csrf

                                {{-- Bước 1: Chọn thời gian tập --}}
                                <div class="form-group mb-4">
                                    <label class="text-muted font-weight-bold mb-3 d-block" style="color: #475569 !important;">1. Chọn thời gian luyện tập:</label>
                                    <div class="row g-3">
                                        @foreach($goitap->prices as $price)
                                        <div class="col-6 mb-3">
                                            <div class="rf-price-option-card {{ $loop->first ? 'rf-price-box-active' : '' }}" 
                                                 data-id="{{ $price->id }}"
                                                 data-months="{{ $price->so_thang }}"
                                                 data-price="{{ $price->gia_khuyen_mai ?? $price->gia_goc }}">
                                                
                                                <input type="radio" 
                                                       name="id_goitap_gia" 
                                                       value="{{ $price->id }}" 
                                                       class="rf-price-radio"
                                                       {{ $loop->first ? 'checked' : '' }}>
                                                
                                                <div class="font-weight-bold mb-1" style="font-size: 18px; color: #0f172a;">{{ $price->so_thang }} Tháng</div>
                                                
                                                <div class="font-weight-bold" style="font-size: 15px; color: #34A4E0;">
                                                    {{ number_format($price->gia_khuyen_mai ?? $price->gia_goc, 0, ',', '.') }} đ
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    ~ {{ number_format(($price->gia_khuyen_mai ?? $price->gia_goc) / $price->so_thang, 0, ',', '.') }} đ/tháng
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Bước 2: Chọn tập cùng PT --}}
                                <div class="form-group mb-4">
                                    <label class="text-muted font-weight-bold mb-3 d-block" style="color: #475569 !important;">2. Huấn luyện viên cá nhân (PT):</label>
                                    <div class="rf-switch-pt d-flex align-items-center justify-content-between">
                                        <div>
                                            <h5 class="font-weight-bold mb-1" style="font-size: 16px; color: #0f172a;">Tập cùng PT chuyên nghiệp</h5>
                                            <p class="text-muted mb-0 small">Hỗ trợ đo chỉ số, lên thực đơn dinh dưỡng riêng biệt.</p>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="co_pt" value="1" class="custom-control-input" id="ptSwitch">
                                            <label class="custom-control-label" for="ptSwitch"></label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Bước 3: Ghi chú --}}
                                <div class="form-group mb-4">
                                    <label class="text-muted font-weight-bold mb-2" style="color: #475569 !important;">3. Ghi chú thêm (nếu có):</label>
                                    <textarea name="ghi_chu" class="form-control bg-transparent" rows="2" placeholder="Nhập ghi chú hoặc yêu cầu đặc biệt của bạn..." style="border-color: #cbd5e1; border-radius: 10px; color: #334155;"></textarea>
                                </div>

                                {{-- Tóm tắt thanh toán --}}
                                <div class="rf-total-box p-4 mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted font-weight-bold">Giá gói tập:</span>
                                        <span class="font-weight-bold" style="color: #0f172a;" id="lblBasePrice">0 đ</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="text-muted font-weight-bold">Phụ thu PT:</span>
                                        <span class="font-weight-bold" style="color: #0f172a;" id="lblPTPrice">0 đ</span>
                                    </div>
                                    <hr style="border-top: 1px dashed #cbd5e1;">
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <span class="font-weight-bold" style="font-size: 16px; color: #0f172a;">TỔNG TIỀN:</span>
                                        <span class="font-weight-extrabold" style="font-size: 24px; color: #34A4E0;" id="lblTotalPrice">0 đ</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-block rf-btn-submit">
                                    <i class="bi bi-shield-check mr-2"></i> ĐĂNG KÝ GÓI TẬP NGAY
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ptSwitch = document.getElementById('ptSwitch');
        const priceOptionCards = document.querySelectorAll('.rf-price-option-card');
        const lblBasePrice = document.getElementById('lblBasePrice');
        const lblPTPrice = document.getElementById('lblPTPrice');
        const lblTotalPrice = document.getElementById('lblTotalPrice');

        const ptMonthlyFee = {{ $goitap->gia_pt_them }};

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
        }

        function calculateTotal() {
            // Lấy card đang được chọn
            const selectedCard = document.querySelector('.rf-price-option-card.rf-price-box-active');
            if (!selectedCard) return;

            const basePrice = parseInt(selectedCard.dataset.price);
            const months = parseInt(selectedCard.dataset.months);
            const hasPT = ptSwitch.checked;

            const ptPrice = hasPT ? (ptMonthlyFee * months) : 0;
            const totalPrice = basePrice + ptPrice;

            lblBasePrice.innerText = formatCurrency(basePrice);
            lblPTPrice.innerText = formatCurrency(ptPrice);
            lblTotalPrice.innerText = formatCurrency(totalPrice);
        }

        // Đăng ký sự kiện click chọn card giá
        priceOptionCards.forEach(card => {
            card.addEventListener('click', function () {
                priceOptionCards.forEach(c => c.classList.remove('rf-price-box-active'));
                this.classList.add('rf-price-box-active');
                
                const radio = this.querySelector('.rf-price-radio');
                if (radio) radio.checked = true;

                calculateTotal();
            });
        });

        // Đăng ký sự kiện switch PT
        ptSwitch.addEventListener('change', function () {
            calculateTotal();
        });

        // Chạy tính toán lần đầu
        calculateTotal();
    });
</script>
@endsection
