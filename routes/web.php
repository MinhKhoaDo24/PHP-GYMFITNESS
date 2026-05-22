<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{AdminController, ProductController, DanhmucController, OrderController, KhuyenmaiController, UserController, DangkidichvuController};

use App\Http\Controllers\{
    HomeController,
    AuthController,
    OrderViewController,
    CartController,
    CommentController,
    ForgotPasswordController,
    ProfileController
};
use App\Repositories\DangkidichvuRepository;;
use App\Http\Controllers\MailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

//Frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/api/danhmuc', [DanhmucController::class, 'getDanhmucs']);
Route::get('/sanpham/detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/congiong', [HomeController::class, 'congiong']);
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/viewAll', [HomeController::class, 'viewAll'])->name('viewAll');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/dang-ky-tap-thu', [HomeController::class, 'dangKyTapThu'])->name('dang-ky-tap-thu');
// Hiển thị form
Route::get('/dang-ky-tap-thu', [DangkidichvuController::class, 'showForm'])->name('dang-ky-tap-thu');
// Lưu form
Route::post('/dang-ky-tap-thu', [DangkidichvuController::class, 'store'])->name('dang-ky-tap-thu.store');


Route::get('/ajax/filter-products', [HomeController::class, 'ajaxFilter'])->name('ajax.filter.products');


//Dichvu
Route::get('/dich-vu', [HomeController::class, 'dichvu1'])->name('services.main');
Route::get('/dich-vu/gym', function () {
    return view('pages.dichvu1');   // resources/views/pages/dichvu1.blade.php
})->name('services.gym');

Route::get('/dich-vu/yoga', function () {
    return view('pages.dichvu2');
})->name('services.yoga');

Route::get('/dich-vu/swimming', function () {
    return view('pages.dichvu3');
})->name('services.swimming');

Route::get('/dich-vu/kick-boxing', function () {
    return view('pages.dichvu4');
})->name('services.kickboxing');

Route::get('/dich-vu/dance', function () {
    return view('pages.dichvu5');
})->name('services.dance');

//cart
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::get('add-go-to-cart/{id}', [CartController::class, 'addGoToCart'])->name('add_go_to_cart');
Route::patch('update-cart', [CartController::class, 'update'])->name('update_cart');
Route::get('/remove-from-cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/capnhat-thongtin', [OrderViewController::class, 'capnhatThongTin'])->name('donhang.update');

Route::post('/apply-promo', [CartController::class, 'applyPromo'])->name('promo.apply');
Route::post('/dathang', [CartController::class, 'dathang'])->name('dathang');
Route::post('/vnpay', [CartController::class, 'vnpay'])->name('vnpay');
Route::get('/thongbaodathang', [CartController::class, 'thongbaodathang'])->name('thongbaodathang');
Route::get('/comments/{sanpham_id}', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store'])->name('comment.post');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comment.update');

//order
Route::get('/donhang', [OrderViewController::class, 'donhang']);

Route::prefix('/')->middleware('orderview')->group(function () {
    Route::get('/donhang/edit/{id}', [OrderViewController::class, 'edit'])->name('donhang.edit');
});
Route::post('/donhang/cancel/{id}', [OrderViewController::class, 'cancel'])->name('donhang.cancel');


Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::post('/kiem-tra-email', [AuthController::class, 'kiemTraEmail'])->name('kiemtra.email');

Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.forgot');

// Gửi email khôi phục mật khẩu
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Hiển thị form đặt lại mật khẩu (kèm token)
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

// Xử lý đặt lại mật khẩu
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot.send');

Route::post('/mail', [MailController::class, 'subscribe'])
        ->name('mail.subscribe');




//admin
Route::prefix('/')->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::post('/signinDashboard', [AdminController::class, 'signin_dashboard']);
});

Route::prefix('/admin')->group(function () {
    // API cho biểu đồ KHÔNG nên để trong admin.login
    Route::get('/chart/revenue', [AdminController::class, 'revenueChart']);
    Route::get('/chart/orders', [AdminController::class, 'orderChart']);
    Route::get('/chart/customers', [AdminController::class, 'customerChart']);
    Route::get('/chart/sold', [AdminController::class, 'soldChart']);
});



Route::prefix('/')->middleware('admin.login')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin_logout', [AdminController::class, 'admin_logout']);

    Route::get('/admin/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/admin/product/search', [AdminController::class, 'search'])->name('adminSearch');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/admin/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/admin/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/admin/product/{product}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::delete('/admin/product/delete-multiple', [ProductController::class, 'deleteMultiple'])->name('product.delete-multiple');


    Route::get('/admin/danhmuc', [DanhmucController::class, 'index'])->name('danhmuc.index');
    Route::get('/admin/danhmuc/create', [DanhmucController::class, 'create'])->name('danhmuc.create');
    Route::post('/admin/danhmuc', [DanhmucController::class, 'store'])->name('danhmuc.store');
    Route::get('/admin/danhmuc/edit/{danhmuc}', [DanhmucController::class, 'edit'])->name('danhmuc.edit');
    Route::put('/admin/danhmuc/update/{danhmuc}', [DanhmucController::class, 'update'])->name('danhmuc.update');
    Route::delete('/admin/danhmuc/{danhmuc}/destroy', [DanhmucController::class, 'destroy'])->name('danhmuc.destroy');
    Route::post('/admin/danhmuc/{id}/restore', [DanhmucController::class, 'restore'])->name('danhmuc.restore');
    Route::get('/danhmuc', [DanhmucController::class, 'getDanhmucs']);

    Route::get('/admin/orders/pending',  [OrderController::class,'Pending'])->name('orders.pending');
    Route::get('/admin/orders/shipping', [OrderController::class,'Shipping'])->name('orders.shipping');
    Route::get('/admin/orders/done',     [OrderController::class,'Done'])->name('orders.done');
    Route::get('admin/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('admin/orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/admin/orders/{id}',      [OrderController::class,'show'])->name('orders.show');

    Route::get('/admin/khuyenmai', [KhuyenmaiController::class, 'index'])->name('khuyenmai.index');
    Route::get('/admin/khuyenmai/create', [KhuyenmaiController::class, 'create'])->name('khuyenmai.create');
    Route::post('/admin/khuyenmai', [KhuyenmaiController::class, 'store'])->name('khuyenmai.store');
    Route::get('/admin/khuyenmai/{id}/edit', [KhuyenmaiController::class, 'edit'])->name('khuyenmai.edit');
    Route::put('/admin/khuyenmai/{id}', [KhuyenmaiController::class, 'update'])->name('khuyenmai.update');
    Route::delete('/admin/khuyenmai/{id}', [KhuyenmaiController::class, 'destroy'])->name('khuyenmai.destroy');
    Route::post('/admin/khuyenmai/{id}/restore', [KhuyenmaiController::class, 'restore'])->name('khuyenmai.restore');

    Route::resource('/admin/users', UserController::class);
    Route::post('/admin/users/{id}/restore', [UserController::class, 'restore'])
    ->name('users.restore');

    Route::resource('/admin/dangki', DangkidichvuController::class);

});
