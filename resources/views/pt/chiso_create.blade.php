@extends('pt_layout')

@section('pt_content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('pt.chiso.index', $dangKy->id) }}" class="btn btn-sm btn-outline-secondary mb-2"><i class="bi bi-arrow-left"></i> Quay lại</a>
            <h3 class="fw-bold mb-0">Thêm Chỉ Số Mới: {{ $dangKy->user->hoten }}</h3>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <form action="{{ route('pt.chiso.store', $dangKy->id) }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ngày ghi nhận <span class="text-danger">*</span></label>
                        <input type="date" name="ngay_ghi_nhan" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <h5 class="fw-bold text-success mb-3 border-bottom pb-2">Chỉ số cơ thể</h5>
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Chiều cao (cm) <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="chieu_cao" id="chieu_cao" class="form-control" placeholder="VD: 170.5" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Cân nặng (kg) <span class="text-danger">*</span></label>
                        <input type="number" step="0.1" name="can_nang" id="can_nang" class="form-control" placeholder="VD: 65.0" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">BMI (Dự kiến)</label>
                        <input type="text" id="bmi_preview" class="form-control bg-light" readonly placeholder="Tự động tính">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Lượng mỡ (%)</label>
                        <input type="number" step="0.1" name="luong_mo" class="form-control" placeholder="VD: 15.2">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Lượng nước (%)</label>
                        <input type="number" step="0.1" name="luong_nuoc" class="form-control" placeholder="VD: 55.0">
                    </div>
                </div>

                <h5 class="fw-bold text-success mb-3 border-bottom pb-2">Tư vấn & Nhắc nhở</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thói quen sống & Chế độ ăn</label>
                        <textarea name="thoi_quen_song" class="form-control" rows="4" placeholder="Ghi chú về chế độ ăn uống, giấc ngủ..."></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-danger">Nhắc nhở riêng</label>
                        <textarea name="nhac_nho" class="form-control" rows="4" placeholder="Lưu ý về tập luyện, các vùng cơ yếu cần chú ý..."></textarea>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4 fw-bold" style="background: #10b981; border-color: #10b981;">
                        <i class="bi bi-save me-1"></i> Lưu Chỉ Số
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heightInput = document.getElementById('chieu_cao');
        const weightInput = document.getElementById('can_nang');
        const bmiPreview = document.getElementById('bmi_preview');

        function calculateBMI() {
            const h = parseFloat(heightInput.value);
            const w = parseFloat(weightInput.value);
            
            if (h > 0 && w > 0) {
                const hMeters = h / 100;
                const bmi = w / (hMeters * hMeters);
                bmiPreview.value = bmi.toFixed(1);
            } else {
                bmiPreview.value = '';
            }
        }

        heightInput.addEventListener('input', calculateBMI);
        weightInput.addEventListener('input', calculateBMI);
    });
</script>
@endsection
