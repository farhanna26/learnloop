<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;

// SEBELUMNYA: return view('chat'); -> SALAH karena gak bawa data
// SEKARANG: Panggil Controller biar dia yang ambilin data chat dari database
Route::get('/', [ChatController::class, 'index']);

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat/send', [ChatController::class, 'store']);

// Rute buat Satpam (Auth)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);