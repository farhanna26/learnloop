<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

// Hapus Auth jika belum digunakan, atau gunakan jika sistem login sudah siap

class PostController extends Controller
{
    // 1. Mengambil semua postingan (Feed)
    public function index()
    {
        // Mengambil data dengan Eager Loading agar tidak berat (N+1 Problem)
        $posts = Post::with(['user', 'comments.user'])
            ->withCount('likes')
            ->latest()
            ->get();

        return view('home', compact('posts'));
    }

    // 2. Membuat postingan baru
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:10240',
            'caption' => 'required',
        ]);

        // 2. Simpan file fisik ke folder storage
        $path = $request->file('file')->store('posts', 'public');

        // 3. Simpan ke database (PASTIKAN ADA KOLOM IMAGE)
        Post::create([
            'user_id' => 1,
            'content' => $request->caption,
            'image' => $path, // BARIS INI WAJIB ADA agar database tidak NULL
        ]);
        // dd($request->all(), $request->file('file')); 

        return redirect()->back()->with('success', 'Postingan Berhasil Dibuat');
    }

    // 3. Menambah Komentar
    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'user_id' => 1,
            'post_id' => $postId,
            'body' => $request->body,
        ]);

        // Jika request via AJAX/Javascript
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar Berhasil Ditambahkan',
                'data' => $comment,
            ], 201);
        }

        return redirect()->back();
    }

    // 4. Sistem Toggle Like (Like/Unlike)
    public function toggleLike($postId)
    {
        $userId = 1; // Pastikan ini sesuai dengan user yang sedang login nanti
        $existingLike = Like::where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();

            return response()->json(['message' => 'Unlike berhasil', 'status' => 'unliked'], 200);
        }

        Like::create([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);

        return response()->json(['message' => 'Like berhasil', 'status' => 'liked'], 201);
    }
}
