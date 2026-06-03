<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class CartHelper
{
    /**
     * Lưu giỏ hàng vào Session VÀ đồng bộ vào CSDL nếu user đã đăng nhập.
     *
     * Thay thế các lệnh session()->put('cart', $cart) trực tiếp.
     *
     * @param array $cart
     * @return void
     */
    public static function saveCart(array $cart): void
    {
        session()->put('cart', $cart);

        // Đồng bộ vào Database nếu đã đăng nhập
        if (Auth::check()) {
            Auth::user()->update(['cart_data' => $cart]);
        }
    }

    /**
     * Xóa giỏ hàng khỏi Session VÀ làm trống trong CSDL nếu user đã đăng nhập.
     * Dùng khi thanh toán thành công.
     *
     * Thay thế lệnh session()->forget('cart') trực tiếp.
     *
     * @return void
     */
    public static function clearCart(): void
    {
        session()->forget('cart');

        // Xóa giỏ hàng trong Database nếu đã đăng nhập
        if (Auth::check()) {
            Auth::user()->update(['cart_data' => null]);
        }
    }

    /**
     * Hợp nhất 2 giỏ hàng lại với nhau.
     * - Nếu 2 giỏ có cùng sản phẩm/size (cùng key), cộng gộp số lượng.
     * - Nếu khác nhau, thêm sản phẩm đó vào.
     *
     * @param array $guestCart  Giỏ hàng khách vãng lai (từ Session hiện tại)
     * @param array $dbCart     Giỏ hàng đã lưu trong CSDL
     * @return array            Giỏ hàng đã được hợp nhất
     */
    public static function mergeCarts(array $guestCart, array $dbCart): array
    {
        $merged = $dbCart;

        foreach ($guestCart as $key => $item) {
            if (isset($merged[$key])) {
                // Cùng sản phẩm/size → cộng gộp số lượng
                $merged[$key]['quantity'] += $item['quantity'];
            } else {
                // Sản phẩm mới → thêm vào
                $merged[$key] = $item;
            }
        }

        return $merged;
    }
}
