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

// Customer & General Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\Web\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\Web\CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{item}', [\App\Http\Controllers\Web\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [\App\Http\Controllers\Web\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\Web\CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/orders', [\App\Http\Controllers\Web\OrderController::class, 'index'])->name('orders.index');
    
    Route::post('/reviews/{orderItem}', [\App\Http\Controllers\Web\ReviewController::class, 'store'])->name('reviews.store');
    
    Route::get('/profile', [\App\Http\Controllers\Web\Customer\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Web\Customer\ProfileController::class, 'update'])->name('profile.update');
});

// Seller Web Routes
Route::middleware(['auth', 'role:store_owner|super_admin'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Web\Seller\DashboardController::class, 'index'])->name('seller.dashboard');
    
    Route::resource('products', \App\Http\Controllers\Web\Seller\ProductController::class)->names([
        'create' => 'seller.products.create',
        'store' => 'seller.products.store',
        'edit' => 'seller.products.edit',
        'update' => 'seller.products.update',
        'destroy' => 'seller.products.destroy',
    ]);
    
    Route::post('products/{product}/sizes', [\App\Http\Controllers\Web\Seller\ProductSizeController::class, 'store'])->name('seller.sizes.store');
    Route::delete('products/{product}/sizes/{size}', [\App\Http\Controllers\Web\Seller\ProductSizeController::class, 'destroy'])->name('seller.sizes.destroy');

    Route::get('/orders', [\App\Http\Controllers\Web\Seller\OrderController::class, 'index'])->name('seller.orders.index');
    Route::put('/orders/{order}', [\App\Http\Controllers\Web\Seller\OrderController::class, 'update'])->name('seller.orders.update');
});

// Admin Web Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\Web\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/stores', [\App\Http\Controllers\Web\Admin\StoreController::class, 'index'])->name('stores.index');
    Route::get('/orders', [\App\Http\Controllers\Web\Admin\OrderController::class, 'index'])->name('orders.index');
});

