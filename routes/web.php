<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController; // Đảm bảo bạn có ProfileController nếu sử dụng route này
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\ProductController; // Đảm bảo bạn có ProductController nếu sử dụng route này





// Bao bọc TẤT CẢ các route web trong group middleware 'web'
Route::middleware('web')->group(function () {

    // Route trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Các route Đăng nhập
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']); // Không cần name('login') lần thứ hai cho POST

    // Các route Đăng ký
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']); // Không cần name('register') lần thứ hai cho POST

    // Route Đăng xuất (luôn là POST)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Các route yêu cầu người dùng đã đăng nhập (middleware 'auth')
    Route::middleware('auth')->group(function () {
        Route::get('/account', [AccountController::class, 'index'])->name('account.info');

        // Các route Profile (nếu bạn đang sử dụng Laravel Breeze/Jetstream hoặc đã tạo chúng)
        // Đảm bảo bạn có ProfileController và các method edit, update, destroy
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('/password/update', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');
        // Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
        // Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/cart', [CartController::class, 'showCartPage'])->name('cart.index');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/products/{id}', [ProductController::class, 'getProductDetails']);



    });
// ...existing code...


});
