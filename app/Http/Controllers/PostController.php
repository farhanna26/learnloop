<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Mengambil semua postingan (Feed) dengan Paginasi + Status Like
    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 5);
        $userId = Auth::id();

        $posts = Post::with(['user', 'comments.user'])
                    ->withCount('likes')
                    ->withCount('comments')
                    // Cek apakah user yang login udah nge-like postingan ini
                    ->withExists(['likes as is_liked' => function($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }])
                    ->latest()
                    ->skip($offset) 
                    ->take($limit)  
                    ->get();
        
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
            'content' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,pdf|max:10240', 
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('posts', $filename, 'public');
        }

        $post = Post::create([
            'user_id' => Auth::id(), // AMAN DARI HARDCODE
            'content' => $request->content,
            'image'   => $imagePath, 
        ]);

        $post->load('user');
        
        // Kasih default value buat UI
        $post->likes_count = 0;
        $post->comments_count = 0;
        $post->is_liked = false;
        $post->comments = [];

        return response()->json([
            'success' => true,
            'message' => 'Postingan Berhasil Dibuat',
            'data'    => $post
        ], 201);
    }

    // Menambah Komentar
    public function storeComment(Request $request, int $postId)
    {
        $post = Post::findOrFail($postId);

        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id' // Validasi parent_id kalau ada
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $request->parent_id, // Masukin parent_id-nya
            'body'    => $request->body
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Komentar/Balasan Berhasil Ditambahkan',
            'data'    => $comment
        ], 201);
    }

    // Sistem Toggle Like (Like/Unlike)
    public function toggleLike(int $postId)
    {
        $userId = Auth::id(); // AMAN DARI HARDCODE
        $existingLike = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['status' => 'unliked', 'message' => 'Unlike berhasil'], 200);
        }

        Like::create([
            'user_id' => $userId,
            'post_id' => $postId
        ]);

        return response()->json(['status' => 'liked', 'message' => 'Like berhasil'], 201);
    }
}