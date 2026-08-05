<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Morfiqo Smart Sizing API Routes
Route::get('/products/{product_id}/recommend-size', [\App\Http\Controllers\Api\SizeRecommendationController::class, 'recommendSize']);
