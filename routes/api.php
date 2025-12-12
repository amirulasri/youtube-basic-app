<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Search with capability check and rate limiter
    Route::get('/youtube/search', [SearchController::class, 'youtube'])
        ->middleware('capability:search', 'throttle:youtube-search')
        ->name('api.youtube.search');

    // Example other endpoints with different capabilities
    // Route::post('/upload', [UploadController::class, 'store'])->middleware('capability:upload','throttle:upload-api');
});