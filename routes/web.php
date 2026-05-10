<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// --- ZONA SATPAM (Wajib Login) ---
// Pakai middleware 'auth' buat ngecek sesi login
Route::middleware('auth')->group(function () {
    // 1. Rute Beranda (Feed Utama)
    Route::get('/beranda', function() {
        return view('beranda'); // Nanti Nabila bikin piring beranda.blade.php
    })->name('beranda');

    // Rute Daftar Kontak
    Route::get('/contacts', [ChatController::class, 'contactList']);

    // RUTE SEARCH BARU LU TARUH SINI
    Route::get('/search', [UserController::class, 'search']);

    // 2. Rute Chat (Nanti diakses lewat tombol di sidebar)
    Route::get('/chat/private/{targetUserId}', [ChatController::class, 'createOrFindPrivateChat']);
    Route::get('/chat/{roomId}', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'store']);

    // 3. Rute Profil Diri Sendiri (Pojok Kiri Atas)
    // Nanti narik data dari PortfolioController
});



// --- ZONA BEBAS ---

// 1. Ini rute buat NAMPILIN halaman form loginnya. 
// TANDA ->name('login') INI YANG PALING PENTING BIAR SATPAMNYA GAK BINGUNG!
Route::get('/login', function () {
    return view('auth.login'); // Sesuaikan sama file blade bikinan kawan lu
})->name('login');

// Rute buat nampilin halaman form register
Route::get('/register', function () {
    return view('auth.register'); // Pastiin kawan lu udah bikin file register.blade.php di dalem folder auth
})->name('register');

// 2. Rute POST yang lu bikin tadi tetep dibiarin aja di bawahnya
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
// ... (dan lain-lain)