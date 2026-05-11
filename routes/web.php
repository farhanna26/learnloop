<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

// --- ZONA BEBAS ---
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// --- ZONA SATPAM (Wajib Login) ---
Route::middleware('auth')->group(function () {
    
    // 1. Rute Beranda & Kontak
    Route::get('/beranda', function() {
        return view('beranda');
    })->name('beranda');
    
    Route::get('/contacts', [ChatController::class, 'contactList']);
    Route::get('/search', [UserController::class, 'search']);

    // 2. === RUTE POSTINGAN & SOSMED ===
    Route::get('/posts/fetch', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/posts/{id}/comment', [PostController::class, 'storeComment']);
    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike']);

    // 3. === RUTE CHAT ===
    Route::get('/chat/private/{targetUserId}', [ChatController::class, 'createOrFindPrivateChat']);
    Route::get('/chat/{roomId}', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'store']);

    // 4. === RUTE PROFIL (Punya Aya) ===
    Route::get('/profile', function () {
        $user = Auth::user(); // Gue ganti jadi Auth::user biar yang muncul profil user yg login
        return view('profile', compact('user'));
    });

    Route::get('/addprofile', function () {
        $user = Auth::user();
        return view('addprofile', compact('user'));
    });

    Route::post('/addprofile', function (Request $request) {
    $user = Auth::user();
    
    $validated = $request->validate([
        'description' => 'nullable|string|max:500',
        'photo' => 'nullable|image|max:2048',
        'banner' => 'nullable|image|max:3072', // Banner biasanya lebih gede sizenya
    ]);

    // Logika Simpan Foto Profil (Tetap Sama)
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $filename = 'photo_' . time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path('profile-photos'), $filename);
        $user->photo = 'profile-photos/' . $filename;
    }

    // LOGIKA BARU: Simpan Banner
    if ($request->hasFile('banner')) {
        $banner = $request->file('banner');
        $filename = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
        $banner->move(public_path('profile-banners'), $filename); // Kita pisah foldernya biar rapi
        $user->banner = 'profile-banners/' . $filename;
    }

    $user->description = $validated['description'];
    $user->save();

    return redirect('/profile')->with('success', 'Berhasil Edit Profile');
});
});