@extends('admin_layout')

@section('admin_content')
    <div class="container-fluid p-0">
        <div class="mb-4">
            <a href="{{ route('admin.goitap.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <h3 class="fw-bold">Chỉnh Sửa Gói Tập</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form id="formGoiTap" action="{{ route('admin.goitap.update', $goitap->id_goitap) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Cột trái: Thông tin cơ bản --}}
                        <div class="col-lg-6 border-end">
                            <h5 class="fw-bold mb-3 text-primary">Thông Tin Cơ Bản</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên Gói Tập <span class="text-danger">*</span></label>
                                <input type="text" name="ten_goi" value="{{ old('ten_goi', $goitap->ten_goi) }}"
                                    class="form-control" placeholder="Ví dụ: Premium Diamond" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Môn Tập (Mô tả ngắn) <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="mo_ta_ngan" value="{{ old('mo_ta_ngan', $goitap->mo_ta_ngan) }}"
                                    class="form-control" placeholder="Ví dụ: Gym + Boxing + Bơi" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phân Loại <span class="text-danger">*</span></label>
                                    <select name="loai_goi" class="form-select" required>
                                        <option value="silver" {{ $goitap->loai_goi == 'silver' ? 'selected' : '' }}>Silver
                                        </option>
                                        <option value="gold" {{ $goitap->loai_goi == 'gold' ? 'selected' : '' }}>Gold</option>
                                        <option value="diamond" {{ $goitap->loai_goi == 'diamond' ? 'selected' : '' }}>Diamond
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phụ Thu PT / Tháng <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="gia_pt_them"
                                            value="{{ old('gia_pt_them', $goitap->gia_pt_them) }}" class="form-control"
                                            min="0" required>
                                        <span class="input-group-text">đ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Hình Ảnh Gói Tập</label>
                                @if($goitap->hinh_anh)
                                    <div class="mb-2">
                                        <img src="{{ asset($goitap->hinh_anh) }}" alt="Current Image" class="rounded border"
                                            style="width: 120px; height: 75px; object-fit: cover;">
                                    </div>
                                @endif
                                <input type="file" name="hinh_anh" class="form-control">
                                <div class="form-text">Để trống nếu không muốn thay đổi ảnh. Hỗ trợ định dạng jpeg, png,
                                    jpg, webp tối đa 2MB.</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_best" value="1"
                                        id="isBestSwitch" {{ $goitap->is_best ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="isBestSwitch">Đánh dấu gói tập Nổi bật
                                        (Badge BEST)</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô Tả Chi Tiết (Danh sách đặc quyền) <span
                                        class="text-danger">*</span></label>
                                <textarea name="mo_ta_chi_tiet" class="form-control" rows="5"
                                    placeholder="Mỗi dòng một đặc quyền:&#10;Đặc quyền 1&#10;Đặc quyền 2&#10;Đặc quyền 3"
                                    required>{{ old('mo_ta_chi_tiet', $goitap->mo_ta_chi_tiet) }}</textarea>
                            </div>
                        </div>

                        {{-- Cột phải: Cấu hình bảng giá --}}
                        <div class="col-lg-6 ps-lg-4">
                            <h5 class="fw-bold mb-3 text-primary">Cấu Hình Bảng Giá</h5>

                            <div class="p-3 bg-light rounded mb-4 text-muted small">
                                Cập nhật giá trị tiền gốc (VNĐ) tương ứng với từng mốc thời gian của gói tập.
                                Giá phải tăng dần theo thời hạn: <strong>1 tháng &lt; 3 tháng &lt; 6 tháng &lt; 12 tháng</strong>.
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Giá Gói Tập 1 Tháng <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price_1" value="{{ old('price_1', $prices[1] ?? '') }}"
                                        class="form-control" min="0" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Giá Gói Tập 3 Tháng <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price_3" value="{{ old('price_3', $prices[3] ?? '') }}"
                                        class="form-control" min="0" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Giá Gói Tập 6 Tháng <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price_6" value="{{ old('price_6', $prices[6] ?? '') }}"
                                        class="form-control" min="0" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Giá Gói Tập 12 Tháng <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="price_12" value="{{ old('price_12', $prices[12] ?? '') }}"
                                        class="form-control" min="0" required>
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.goitap.index') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-5"
                            style="background-color: #34A4E0; border-color: #34A4E0;">Cập Nhật Gói Tập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('formGoiTap').addEventListener('submit', function (e) {
            // Lấy giá trị từ các ô input và chuyển về kiểu số nguyên (Integer)
            let p1 = parseInt(document.querySelector('input[name="price_1"]').value) || 0;
            let p3 = parseInt(document.querySelector('input[name="price_3"]').value) || 0;
            let p6 = parseInt(document.querySelector('input[name="price_6"]').value) || 0;
            let p12 = parseInt(document.querySelector('input[name="price_12"]').value) || 0;

            let errorMessages = [];

            // Kiểm tra các điều kiện logic tăng dần
            if (p3 <= p1) {
                errorMessages.push("- Giá gói 3 tháng phải lớn hơn giá gói 1 tháng.");
            }
            if (p6 <= p3) {
                errorMessages.push("- Giá gói 6 tháng phải lớn hơn giá gói 3 tháng.");
            }
            if (p12 <= p6) {
                errorMessages.push("- Giá gói 12 tháng phải lớn hơn giá gói 6 tháng.");
            }

            // Nếu có lỗi, chặn việc submit form và hiển thị thông báo
            if (errorMessages.length > 0) {
                e.preventDefault(); // Ngăn form gửi dữ liệu lên server

                let alertText = "Cảnh báo lỗi logic giá tập:\n" + errorMessages.join("\n");
                alert(alertText);
            }
        });
    </script>
@endsection