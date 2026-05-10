<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message; 
use Illuminate\Support\Facades\Auth; 

class ChatController extends Controller
{

public function createOrFindPrivateChat($targetUserId)
{
    // 1. Ambil ID kita yang lagi login
    $myId = auth()->id();

    // Kalau nekat mau ngechat diri sendiri, cegah aja (opsional)
    if ($myId == $targetUserId) {
        return back()->with('error', 'Gak bisa ngechat diri sendiri bos!');
    }

    // 2. Cari kamar private yang penghuninya KITA BERDUA doang
    $room = \App\Models\Room::where('type', 'private')
        ->whereHas('users', function ($query) use ($myId) {
            $query->where('user_id', $myId);
        })
        ->whereHas('users', function ($query) use ($targetUserId) {
            $query->where('user_id', $targetUserId);
        })
        ->first();

    // 3. Kalau kamarnya belum ada (belum pernah chatan sama sekali)
    if (!$room) {
        // Bikin kamar baru
        $room = \App\Models\Room::create([
            'name' => null, // Private chat nggak butuh nama grup
            'type' => 'private'
        ]);

        // Langsung masukin KTP lu berdua ke kamar itu
        $room->users()->attach([$myId, $targetUserId]);
    }

    // 4. Langsung tendang ke rute chat yang udah ada!
    return redirect('/chat/' . $room->id);
}

    public function index($roomId) // Paksa controller minta ID kamar dari URL
    {
        // Cari kamar berdasarkan ID, kalau nggak ada, munculin error 404
        $room = \App\Models\Room::findOrFail($roomId);

        // Tarik pesan yang cuma ada di kamar itu aja!
        $messages = \App\Models\Message::with('user')
                        ->where('room_id', $roomId)
                        ->get(); 

        // Lempar ke piring chat.blade.php
        return view('chat', compact('messages', 'room'));
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

    public function contactList()
    {
        $myId = auth()->id();

        // 1. Narik semua user (Buat Private Chat) KECUALI yang lagi login
        $users = \App\Models\User::where('id', '!=', $myId)->get();

        // 2. Narik semua kamar tipe 'group' yang KITA JADI MEMBERNYA
        $groups = \App\Models\Room::where('type', 'group')
            ->whereHas('users', function ($query) use ($myId) {
                $query->where('user_id', $myId);
            })->get();

        // Lempar dua-duanya ke piring contacts.blade.php
        return view('contacts', compact('users', 'groups'));
    }
}