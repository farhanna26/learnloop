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
    // Mengambil semua postingan (Feed) dengan Paginasi
    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 5);

        $posts = Post::with(['user', 'comments.user'])
                    ->withCount('likes')
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
   // Membuat postingan baru
    public function store(Request $request)
    {
        // 1. Validasi (tambahkan rule untuk image)
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,pdf|max:10240', // Max 10MB
        ]);

        $imagePath = null;

        // 2. Logika simpan file fisik
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Simpan ke folder 'storage/app/public/posts'
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('posts', $filename, 'public');
        }

        // 3. Simpan ke database
        $post = Post::create([
            'user_id' => auth()->id(), // <--- GANTI JADI INI BIAR GAK HARDCODE LAGI
            'content' => $request->content,
            'image'   => $imagePath, 
        ]);

        // Load relasi user agar tampilan di frontend langsung muncul namanya
        $post->load('user');

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