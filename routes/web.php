<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [\App\Http\Controllers\Web\ProductController::class, 'show'])->name('products.show');

// Web Auth Routes
Route::get('/login', [\App\Http\Controllers\Web\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Web\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Web\AuthController::class, 'logout'])->name('logout');
Route::get('/register', [\App\Http\Controllers\Web\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register/customer', [\App\Http\Controllers\Web\AuthController::class, 'registerCustomer'])->name('register.customer');
Route::post('/register/seller', [\App\Http\Controllers\Web\AuthController::class, 'registerSeller'])->name('register.seller');

// Seller Web Routes
Route::middleware(['auth', 'role:store_owner|super_admin'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Web\Seller\DashboardController::class, 'index'])->name('seller.dashboard');
});
