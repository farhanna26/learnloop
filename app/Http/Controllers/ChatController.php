<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message; 
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 

class ChatController extends Controller
{
    // 1. Nampilin Isi Chat di Room Tertentu (UDAH DI-UPDATE NAMA HEADER-NYA)
    public function index($roomId) 
    {
        $room = Room::with('users')->findOrFail($roomId);

        $messages = Message::with('user')
                        ->where('room_id', $roomId)
                        ->get(); 

        // LOGIKA PENENTUAN NAMA & DATA PARTNER
        $chatTitle = 'Ruang Obrolan';
        $otherUser = null; // Tambahin ini

        if ($room->type === 'private') {
            $otherUser = $room->users->where('id', '!=', auth()->id())->first();
            $chatTitle = $otherUser ? $otherUser->name : 'User Tidak Diketahui';
        } else {
            $chatTitle = $room->name ?? 'Grup Tanpa Nama';
        }

        // Kita kirim $otherUser juga ke compact
        return view('chat', compact('messages', 'room', 'chatTitle', 'otherUser'));
    }

    // 2. Fungsi Kirim Pesan
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Woi, login dulu!'], 401);
        }

        $user = auth()->user();

        try {
            $chat = Message::create([
                'room_id'  => $request->room_id,
                'username' => $user->name,
                'text' => $request->message,
            ]);

            broadcast(new MessageSent($user->name, $request->message, $request->room_id));

            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 3. Resepsionis: Cari atau Bikin Kamar Private
    public function createOrFindPrivateChat($targetUserId)
    {
        $myId = auth()->id();

        if ($myId == $targetUserId) {
            return back()->with('error', 'Gak bisa ngechat diri sendiri bos!');
        }

        $room = Room::where('type', 'private')
            ->whereHas('users', function ($query) use ($myId) {
                $query->where('user_id', $myId);
            })
            ->whereHas('users', function ($query) use ($targetUserId) {
                $query->where('user_id', $targetUserId);
            })
            ->first();

        if (!$room) {
            $room = Room::create([
                'name' => null,
                'type' => 'private'
            ]);
            $room->users()->attach([$myId, $targetUserId]);
        }

        return redirect('/chat/' . $room->id);
    }

    // 4. Daftar Kontak & Grup
    public function contactList()
    {
        $myId = auth()->id();

        $users = User::where('id', '!=', $myId)->get();

        $groups = Room::where('type', 'group')
            ->whereHas('users', function ($query) use ($myId) {
                $query->where('user_id', $myId);
            })->get();

        return view('contacts', compact('users', 'groups'));
    }
}