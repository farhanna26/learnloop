<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AiMentorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LeaderboardController;

// =========================================================================
// --- ZONA BEBAS (Akses Tanpa Login) ---
// =========================================================================
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


// =========================================================================
// --- ZONA SATPAM (Wajib Login / Middleware Auth) ---
// =========================================================================
Route::middleware('auth')->group(function () {
    
    // 1. Rute Beranda & Kontak
    Route::get('/beranda', function() {
        return view('beranda');
    })->name('beranda');

    // TAMBAHKAN BARIS INI BIAR NGGAK 404 LAGI:
    Route::get('/feed', function () {
        return view('feed');
    })->name('feed');

    // Rute Tampilan Form Upload Karya
    Route::get('/upload-karya', function() {
        return view('upload');
    })->name('upload.karya');
    
    Route::get('/contacts', [ChatController::class, 'contactList']);
    Route::get('/search', [UserController::class, 'search']);

    // 2. === RUTE POSTINGAN & SOSMED ===
    Route::get('/posts/fetch', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/posts/{id}/comment', [PostController::class, 'storeComment']);
    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike']);
    Route::get('/api/posts/{id}', [PostController::class, 'show']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    
    // Rute Tugas & Pengumpulan (Submissions)
    Route::post('/assignments', [ChatController::class, 'storeAssignment']);
    Route::post('/submissions', [ChatController::class, 'storeSubmission']);
    Route::post('/submissions/{id}/grade', [ChatController::class, 'gradeSubmission']);

    // 3. === RUTE CHAT & KELOMPOK ===
    Route::get('/chat/private/{targetUserId}', [ChatController::class, 'createOrFindPrivateChat']);
    Route::get('/chat/{roomId}', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'store']);
    Route::post('/chat/group/create', [ChatController::class, 'createGroup']);
    Route::post('/chat/group/accept/{notificationId}', [ChatController::class, 'acceptInvite']);
    Route::post('/chat/group/reject/{notificationId}', [ChatController::class, 'rejectInvite']);

    // --- RUTE GROUP SETTINGS & INFO ---
    Route::get('/chat/group/{roomId}/info', [ChatController::class, 'groupInfo'])->name('chat.group.info');
    Route::post('/chat/group/{roomId}/update', [ChatController::class, 'updateGroup'])->name('chat.group.update');
    Route::post('/chat/group/{roomId}/invite', [ChatController::class, 'inviteToGroup'])->name('chat.group.invite');

    // 4. === RUTE AI MENTOR dengan Fitur History ===
    Route::get('/ai-mentor', [AiMentorController::class, 'index']);
    Route::post('/ai-mentor/ask', [AiMentorController::class, 'ask']);
    Route::post('/ai-mentor/pin/{id}', [AiMentorController::class, 'togglePin']);
    Route::delete('/ai-mentor/delete/{id}', [AiMentorController::class, 'deleteChat']);

    // 5. === RUTE PROFIL ===
    
    // Rute menampilkan form edit profil 
    Route::get('/profile/edit', function () {
        $user = Auth::user();
        return view('addprofile', compact('user'));
    })->name('profile.edit');

    // Rute menyimpan data edit profil (Diolah di UserController)
    Route::post('/profile/edit', [UserController::class, 'updateProfile'])->name('profile.update');

    // Rute profil diri sendiri (Otomatis mengambil User Login)
    Route::get('/profile', function () {
        $user = User::withCount(['followers', 'followings', 'posts'])->find(Auth::id());
        return view('profile', compact('user'));
    })->name('profile.me');

    // Rute profil pengguna lain berdasarkan ID
    Route::get('/profile/{id}', [UserController::class, 'showProfile'])->name('profile.show');

    // Rute interaksi tombol follow/unfollow
    Route::post('/profile/{id}/follow', [UserController::class, 'toggleFollow']);

    // 6. === RUTE NOTIFIKASI ===
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    // 7. === RUTE LEADERBOARD ===
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/leaderboard/data', [LeaderboardController::class, 'getData']);
    
});