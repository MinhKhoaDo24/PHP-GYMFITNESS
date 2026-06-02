{{-- SECTION: CÁC GÓI DỊCH VỤ --}}
<section class="rf-packages-section">
    <div class="container">

        {{-- Tiêu đề --}}
        <div class="text-center rf-packages-heading">
            <div class="rf-packages-eyebrow">
                CÁC GÓI DỊCH VỤ
            </div>
            <h2 class="rf-packages-title">
                TẠI RISE FITNESS
            </h2>
        </div>

        {{-- Slider --}}
        <div class="rf-packages-slider-wrapper">
            <div class="rf-packages-track" id="rfPackagesTrack">
                {{-- Render từ dữ liệu backend --}}
                @forelse($goitaps as $goitap)
                    <div class="rf-package-card">
                        {{-- Hiển thị badge "Best" nếu is_best = 1 --}}
                        @if($goitap->is_best == 1)
                            <span class="rf-package-badge rf-package-badge-best">Best</span>
                        @endif

                        <div class="rf-package-image">
                            <img src="{{ asset($goitap->hinh_anh) }}" alt="{{ $goitap->ten_goi }}">
                        </div>
                        <div class="rf-package-body">
                            <h3 class="rf-package-name">{{ $goitap->ten_goi }}</h3>
                            <p class="rf-package-subtitle rf-package-type-{{ $goitap->loai_goi }}">
                                @php
                                    $loaiGoi = $goitap->loai_goi;
                                    $loaiGoiDisplay = ucfirst($loaiGoi);
                                @endphp
                                {{ $loaiGoiDisplay }}
                            </p>
                            <ul class="rf-package-list">
                                {{-- Xử lý mo_ta_chi_tiet: hỗ trợ cả HTML cũ và plain text mới --}}
                                @php
                                    $moTa = trim($goitap->mo_ta_chi_tiet);
                                    $items = [];

                                    // Kiểm tra nếu là HTML format (có <li> tags)
                                    if (strpos($moTa, '<li>') !== false) {
                                        // Extract content từ <li>...</li>
                                        if (preg_match_all('/<li[^>]*>(.*?)<\/li>/s', $moTa, $matches)) {
                                            $items = array_map('trim', $matches[1]);
                                            // Remove HTML entities & tags
                                            $items = array_map(fn($item) => html_entity_decode(strip_tags($item)), $items);
                                        }
                                    } else {
                                        // Plain text format: split by newline
                                        $items = array_filter(
                                            array_map('trim', explode("\n", $moTa)),
                                            fn($line) => !empty($line)
                                        );
                                    }

                                    // Fallback nếu không có items
                                    if (empty($items)) {
                                        $items = [$goitap->mo_ta_ngan];
                                    }
                                @endphp

                                @foreach($items as $item)
                                    @if(!empty($item))
                                        <li>{{ $item }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="rf-package-button">
                            <a href="{{ route('goitap.register.show', $goitap->slug) }}">Đăng kí</a>
                        </div>
                    </div>
                @empty
                    {{-- Hiển thị thông báo nếu không có gói tập nào --}}
                    <div style="text-align: center; padding: 40px; width: 100%;">
                        <p>Hiện tại không có gói tập nào. Vui lòng quay lại sau!</p>
                    </div>
                @endforelse
            </div>

            {{-- Arrow buttons --}}
            <div class="rf-packages-arrows">
                <button type="button"
                    class="rf-packages-arrow rf-packages-arrow-prev d-flex align-items-center justify-content-center"
                    aria-label="Gói trước">
                    <i class="bi bi-chevron-left gym-arrow-icon"></i>
                </button>

                <button type="button"
                    class="rf-packages-arrow rf-packages-arrow-next d-flex align-items-center justify-content-center"
                    aria-label="Gói tiếp theo">
                    <i class="bi bi-chevron-right gym-arrow-icon"></i>
                </button>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const track = document.getElementById('rfPackagesTrack');
            const cards = track.querySelectorAll('.rf-package-card');
            if (!cards.length) return;

            const prevBtn = document.querySelector('.rf-packages-arrow-prev');
            const nextBtn = document.querySelector('.rf-packages-arrow-next');

            // tính chiều rộng 1 card (kèm margin-right)
            function getStep() {
                const card = cards[0];
                const style = window.getComputedStyle(card);
                const marginRight = parseFloat(style.marginRight) || 0;
                return card.offsetWidth + marginRight;
            }

            function scrollByStep(direction) {
                const step = getStep();
                track.scrollBy({
                    left: direction * step,
                    behavior: 'smooth'
                });
            }

            prevBtn.addEventListener('click', function () {
                scrollByStep(-1);
            });

            nextBtn.addEventListener('click', function () {
                scrollByStep(1);
            });
        });
    </script>
@endpush