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
    Route::get('/api/posts/{id}', [PostController::class, 'show']);
    Route::post('/assignments', [App\Http\Controllers\ChatController::class, 'storeAssignment']);
    Route::post('/submissions', [App\Http\Controllers\ChatController::class, 'storeSubmission']);
    Route::post('/submissions/{id}/grade', [App\Http\Controllers\ChatController::class, 'gradeSubmission']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::put('/posts/{id}', [PostController::class, 'update']);

    // 3. === RUTE CHAT ===
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
    Route::post('/chat/group/{id}/update', [App\Http\Controllers\ChatController::class, 'updateGroup'])->name('chat.group.update');

    // Rute Baru AI Mentor dengan Fitur History
    Route::get('/ai-mentor', [App\Http\Controllers\AiMentorController::class, 'index']);
    Route::post('/ai-mentor/ask', [App\Http\Controllers\AiMentorController::class, 'ask']);
    Route::post('/ai-mentor/pin/{id}', [App\Http\Controllers\AiMentorController::class, 'togglePin']);
    Route::delete('/ai-mentor/delete/{id}', [App\Http\Controllers\AiMentorController::class, 'deleteChat']);


    // 4. === RUTE PROFIL ===
    
    // Rute buat nampilin form edit profil 
    Route::get('/profile/edit', function () {
        $user = Auth::user();
        return view('addprofile', compact('user'));
    })->name('profile.edit');

    // Rute buat nyimpen data edit profil (Ngambil dari UserController)
    Route::post('/profile/edit', [UserController::class, 'updateProfile'])->name('profile.update');

    // Rute profil diri sendiri (Nggak pake ID)
    Route::get('/profile', function () {
        // Pake withCount juga di sini biar angkanya kebawa!
        $user = User::withCount(['followers', 'followings', 'posts'])->find(Auth::id());
        return view('profile', compact('user'));
    })->name('profile.me');

    // Rute profil orang lain (Pake ID)
    Route::get('/profile/{id}', [UserController::class, 'showProfile'])->name('profile.show');

    // --- TAMBAHIN RUTE INI BUAT TOMBOL FOLLOW ---
    Route::post('/profile/{id}/follow', [UserController::class, 'toggleFollow']);

    // 5. Rute Notifikasi
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    
    // 6. RUTE LEADERBOARD
    Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index']);
    Route::get('/leaderboard/data', [App\Http\Controllers\LeaderboardController::class, 'getData']);
});