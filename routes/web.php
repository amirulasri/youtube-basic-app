<?php

use App\Http\Controllers\YoutubeController;
use Illuminate\Support\Facades\Route;

Route::get('/youtube', [YoutubeController::class, 'index'])->name('youtube.search');

// Route::get('/', function () {
//     return view('welcome');
// });
