<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Fungsi 1: Buat nampilin halaman web dan narik riwayat chat lama
    public function index()
    {
        // Ambil 50 pesan terakhir dari database
        $messages = Message::latest()->take(50)->get()->reverse()->values();
        
        // Nanti kita arahin ke file view 'chat.blade.php'
        return view('chat', compact('messages')); 
    }

    // Fungsi 2: Buat nerima ketikan pesan baru dari user
    public function store(Request $request)
    {
        // 1. Simpan pesan ke database
        $message = Message::create([
            'username' => $request->username,
            'text' => $request->text
        ]);

        // 2. Tembak sinyal ke Reverb! (Kayak yang lu lakuin di Tinker tadi)
        broadcast(new MessageSent("{$message->username} bilang: {$message->text}"));

        // 3. Kasih balasan ke browser kalau sukses
        return response()->json(['status' => 'Pesan terkirim!']);
    }
}
