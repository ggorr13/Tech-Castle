<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// When you create an API it's always a good idea to have versioning like v1, so when you need to upgrade your product
// it will be much easier
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Not sure if you really need names for your routes
Route::get('/products', [ProductController::class, 'allProducts']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Cart could be used without authentication (was mentioned in the task)
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart']);
    Route::get('/cart/list', [CartController::class, 'cartList']);
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart']);

    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::get('/orders', [OrderController::class, 'userOrderHistory']);

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('/products', ProductController::class);
    });
});

