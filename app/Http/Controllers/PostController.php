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
        $type = $request->query('type', 'portfolio'); // Nangkap tipe dari JS, default 'portfolio'
        $loginUserId = auth()->id(); 
        $profileUserId = $request->query('user_id'); 

        // 1. Mulai rakit query
        $query = Post::with(['user', 'comments.user', 'category', 'room', 'room.users']) // Bawa data kategori sekalian
                    ->withCount('likes')
                    ->withCount('comments')
                    ->withExists(['likes as is_liked' => function($q) use ($loginUserId) {
                        $q->where('user_id', $loginUserId);
                    }])
                    ->where('type', $type); // FILTER TIPE POSTINGAN DI SINI!

        // 2. FILTER: Kalau ada 'user_id'
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
            'type' => 'nullable|in:portfolio,learning', 
            'category_id' => 'nullable|exists:categories,id',
            'create_class' => 'nullable', // Tangkep input checkbox
            'class_name' => 'nullable|string|max:255' // Tangkep nama kelas
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('posts', $filename, 'public');
        }

        $roomId = null; // Default kosong

        // LOGIC BARU: Bikin Ruang Kelas kalau checkbox dicentang
        if ($request->has('create_class') && $request->create_class !== 'false' && !empty($request->class_name)) {
            $room = \App\Models\Room::create([
                'name' => $request->class_name,
                'type' => 'classroom', // Otomatis jadi tipe kelas
            ]);
            // Otomatis jadiin yang upload sebagai Creator kelas
            $room->users()->attach(auth()->id(), ['role' => 'creator']);
            $roomId = $room->id;
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'image'   => $imagePath, 
            'type'    => $request->type ?? 'portfolio', 
            'category_id' => $request->category_id,
            'room_id' => $roomId // <-- Tautin postingan ke kelas yang baru dibikin
        ]);

        // Tambahin 'room' di load biar data kelas kebawa ke Frontend Javascript lu
        $post->load('user', 'room', 'room.users');
        
        // Kasih default value buat UI
        $post->likes_count = 0;
        $post->comments_count = 0;
        $post->is_liked = false;
        $post->comments = [];

        return response()->json([
            'success' => true,
            'message' => 'Postingan & Materi Berhasil Dibuat',
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