<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

Route::post('/shorturls', [UrlController::class, 'create']);
Route::get('/shorturls/{shortcode}', [UrlController::class, 'stats']);
Route::get('/{shortcode}', [UrlController::class, 'redirect']);