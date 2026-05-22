@if ($products->total() === 0)
    <p class="text-center mt-4" style="font-weight:600; color:#555;">
        KHÔNG CÓ SẢN PHẨM PHÙ HỢP
    </p>
@else
    @if ($products->hasPages())
        <div class="pagination-wrapper">
            {!! $products->links('pagination::bootstrap-4') !!}
        </div>
    @endif
@endif
