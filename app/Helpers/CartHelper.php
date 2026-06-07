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
        session()->put('cart', $cart);  // Ghi mảng giỏ hàng vào Session của trình duyệt

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
     */// 2. Hàm dọn sạch giỏ hàng (dùng sau khi đặt hàng thành công)
    public static function clearCart(): void
    {
        session()->forget('cart'); // Xóa sạch giỏ hàng khỏi Session

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

    /**
     * Xóa chỉ các sản phẩm đã thanh toán thành công khỏi Session và CSDL.
     *
     * @return void
     */
    public static function clearCompletedCheckout(): void
    {
        $checkoutItems = session('checkout_items');
        if ($checkoutItems) {
            $cart = session('cart', []);
            foreach ($checkoutItems as $key => $item) {
                if (isset($cart[$key])) {
                    unset($cart[$key]);
                }
            }
            session()->put('cart', $cart);
            session()->forget('checkout_items');

            // Đồng bộ CSDL nếu đã đăng nhập
            if (Auth::check()) {
                Auth::user()->update(['cart_data' => $cart]);
            }
        } else {
            self::clearCart();
        }
    }
}

