<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message; 
use Illuminate\Support\Facades\Auth; 

class ChatController extends Controller
{
    public function index()
    {
        // Narik semua pesan sekalian sama data user-nya (Eager Loading)
        $messages = Message::with('user')->get(); 

        // Nampilin ke piring chat.blade.php
        return view('chat', compact('messages'));
    }

    // 2. Fungsi buat ngirim pesan
    public function store(Request $request)
{
    // 1. Validasi
    $request->validate([
        'message' => 'required|string', // Wajib ngisi pesan
        'room_id' => 'required|exists:rooms,id', // Wajib ngirim ID kamar!
    ]);

    // 2. Proteksi kalau belum login (biar gak error null pointer)
    if (!auth()->check()) {
        return response()->json(['error' => 'Woi, login dulu!'], 401);
    }

    $user = auth()->user();

    try {
        // 3. Simpan ke database
        // Pastiin di tabel messages lu emang ada kolom 'user_id' dan 'message'
        $chat = Message::create([
            'room_id'  => $request->room_id,
            'username' => $user->name,
            'text' => $request->message,
        ]);

        // 4. Kirim sinyal (Urutannya: Nama, baru Pesan)
        broadcast(new MessageSent($user->name, $request->message, $request->room_id));

        return response()->json(['status' => 'success']);
        
    } catch (\Exception $e) {
        // Kalau error 500 muncul lagi, cek tab 'Response' di browser. 
        // Lu bakal liat alasan sebenernya kenapa dia meledak.
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}