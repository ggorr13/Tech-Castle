<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/products', [ProductController::class, 'allProducts']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart']);
    Route::get('/cart/list', [CartController::class, 'cartList']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart']);

    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/orders', [OrderController::class, 'userOrderHistory']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('/products', ProductController::class);
    });
});

