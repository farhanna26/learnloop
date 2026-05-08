<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Halaman Landing (Utama)
Route::get('/', [PostController::class, 'index']);

// Halaman Login & Daftar
Route::get('/auth', function () {
    return view('auth-custom');
});

// // Halaman Home (Instagram Style)
// Route::get('/home', function () {
//     return view('home');
// });

use App\Models\Post;

Route::get('/home', function () {
    // Ambil semua data post terbaru dari database
    $posts = Post::latest()->get(); 
    
    // Kirim data posts ke halaman home
    return view('home', compact('posts'));
});

// Route lainnya (jika masih diperlukan)
Route::get('/feed', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
