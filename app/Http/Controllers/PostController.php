<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Mengambil semua postingan (Feed)
    public function index()
    {
        $posts = Post::with(['user', 'comments.user'])->withCount('likes')->latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Daftar Feed Berhasil Diambil',
            'data'    => $posts
        ], 200);
    }

    // Membuat postingan baru
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = Post::create([
            'user_id' => 1, // Sementara hardcode ID 1 sebelum sistem login aktif
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Postingan Berhasil Dibuat',
            'data'    => $post
        ], 201);
    }

    // Menambah Komentar
    public function storeComment(Request $request, $postId)
    {
        $request->validate(['body' => 'required']);

        $comment = Comment::create([
            'user_id' => 1, 
            'post_id' => $postId,
            'body'    => $request->body
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar Berhasil Ditambahkan',
            'data'    => $comment
        ], 201);
    }

    // Sistem Toggle Like (Like/Unlike)
    public function toggleLike($postId)
    {
        $userId = 1;
        $existingLike = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['message' => 'Unlike berhasil'], 200);
        }

        Like::create([
            'user_id' => $userId,
            'post_id' => $postId
        ]);

        return response()->json(['message' => 'Like berhasil'], 201);
    }
}