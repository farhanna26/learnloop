<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Endpoint untuk Content Feed LearnLoop
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/fetch', [PostController::class, 'fetchPosts']);
Route::post('/posts', [PostController::class, 'store']);
Route::post('/posts/{id}/comment', [PostController::class, 'storeComment']);
Route::post('/posts/{id}/like', [PostController::class, 'toggleLike']);
