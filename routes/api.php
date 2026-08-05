<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register/customer', [\App\Http\Controllers\Api\AuthController::class, 'registerCustomer']);
Route::post('/register/seller', [\App\Http\Controllers\Api\AuthController::class, 'registerSeller']);

// Seller Routes
Route::middleware(['auth:sanctum', 'role:store_owner|super_admin'])->prefix('seller')->group(function () {
    Route::apiResource('products', \App\Http\Controllers\Api\Seller\StoreProductController::class);
    Route::post('products/{product}/sizes', [\App\Http\Controllers\Api\Seller\ProductSizeController::class, 'store']);
    Route::delete('products/{product}/sizes/{size}', [\App\Http\Controllers\Api\Seller\ProductSizeController::class, 'destroy']);
});

// Morfiqo Smart Sizing API Routes
Route::get('/products/{product_id}/recommend-size', [\App\Http\Controllers\Api\SizeRecommendationController::class, 'recommendSize']);
