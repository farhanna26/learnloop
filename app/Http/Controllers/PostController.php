<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 5);
        $loginUserId = auth()->id(); 
        $profileUserId = $request->query('user_id'); // Nangkap ID user dari halaman Profil

        // 1. Mulai rakit query pake kodingan lu yang efisien
        $query = Post::with(['user', 'comments.user'])
                    ->withCount('likes')
                    ->withCount('comments')
                    // Cek apakah user yang login udah nge-like postingan ini
                    ->withExists(['likes as is_liked' => function($q) use ($loginUserId) {
                        $q->where('user_id', $loginUserId);
                    }]);

        // 2. FILTER: Kalau ada 'user_id' yang dikirim dari JS, berarti lagi di halaman Profil
        if ($profileUserId) {
            $query->where('user_id', $profileUserId);
        }

        // 3. Eksekusi query-nya
        $posts = $query->latest()
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
            'user_id' => auth()->id(), // AMAN DARI HARDCODE
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
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id' 
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'parent_id' => $request->parent_id,
            'body'    => $request->body
        ]);

        $comment->load('user');

        // --- LOGIKA NOTIFIKASI KOMENTAR ---
        $post = Post::findOrFail($postId);
        // Jangan kirim notif kalau ngomen postingan sendiri
        if ($post->user_id !== auth()->id()) {
            \App\Models\Notification::create([
                'user_id' => $post->user_id,      // Pemilik Postingan
                'sender_id' => auth()->id(),      // Yang Komen
                'type' => 'comment',
                'reference_id' => $post->id,      // ID Postingan
                'is_read' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Komentar/Balasan Berhasil Ditambahkan',
            'data'    => $comment
        ], 201);
    }

    // Sistem Toggle Like (Like/Unlike)
    public function toggleLike($postId)
    {
        $userId = auth()->id(); 
        $existingLike = Like::where('user_id', $userId)->where('post_id', $postId)->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['status' => 'unliked', 'message' => 'Unlike berhasil'], 200);
        }

        Like::create([
            'user_id' => $userId,
            'post_id' => $postId
        ]);

        // --- LOGIKA NOTIFIKASI LIKE ---
        $post = Post::findOrFail($postId);
        if ($post->user_id !== $userId) {
            \App\Models\Notification::create([
                'user_id' => $post->user_id,
                'sender_id' => $userId,
                'type' => 'like',
                'reference_id' => $post->id,
                'is_read' => false
            ]);
        }

        return response()->json(['status' => 'liked', 'message' => 'Like berhasil'], 201);
    }

    // Mengambil 1 detail postingan beserta komentar (Untuk Modal Notifikasi)
    public function show($id)
    {
        try {
            // Kita tarik data Postingan, sekalian bawa data User pembuatnya dan data Komentar+Usernya
            $post = Post::with(['user', 'comments.user'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $post
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Postingan tidak ditemukan'
            ], 404);
        }
    }
}