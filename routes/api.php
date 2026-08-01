<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// Morfiqo Smart Sizing API Routes
Route::get('/products/{product_id}/recommend-size', [\App\Http\Controllers\Api\SizeRecommendationController::class, 'recommendSize']);
