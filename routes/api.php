<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController; // Đảm bảo namespace đúng

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/cart/update', [CartController::class, 'update']);
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove']);
    // Các API routes khác cần bảo vệ
});
Route::middleware('auth:sanctum')->post('/cart/sync', [Api\CartController::class, 'sync']);

// Các API routes công khai (nếu có)
