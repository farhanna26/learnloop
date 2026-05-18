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
    // 1. Nampilin Isi Chat
    public function index($roomId) 
    {
        $room = Room::with('users')->findOrFail($roomId);

        $messages = Message::with('user')
                        ->where('room_id', $roomId)
                        ->get(); 

        $chatTitle = 'Ruang Obrolan';
        $otherUser = null;

        if ($room->type === 'private') {
            $otherUser = $room->users->where('id', '!=', auth()->id())->first();
            $chatTitle = $otherUser ? $otherUser->name : 'User Tidak Diketahui';
        } else {
            $chatTitle = $room->name ?? 'Grup Tanpa Nama';
        }

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

    // 3. Resepsionis Private Chat
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

    // 4. Daftar Kontak & Grup (LOGIKA BARU)
    public function contactList()
    {
        $user = auth()->user();
        $myId = $user->id;

        // A. Pesan Pribadi: Cuma nampilin yang KITA FOLLOW
        $users = $user->followings;

        // B. Grup: Nampilin grup yang kita udah gabung
        $groups = Room::where('type', 'group')
            ->whereHas('users', function ($query) use ($myId) {
                $query->where('user_id', $myId);
            })->get();

        // C. Cari Mutuals (Saling Follow) buat modal Invite Grup
        $followerIds = $user->followers->pluck('id')->toArray();
        // Dari orang yang kita follow, saring yang ID-nya ada di daftar follower kita
        $mutuals = $user->followings->whereIn('id', $followerIds);

        return view('contacts', compact('users', 'groups', 'mutuals'));
    }

    // 5. Fungsi Bikin Grup & Ngirim Undangan
    public function createGroup(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'nullable|array', // array isinya ID mutuals yang diceklis
            'members.*' => 'exists:users,id'
        ]);

        $user = auth()->user();

        // 2. Bikin Room Grupnya di Database
        $room = Room::create([
            'name' => $request->name,
            'type' => 'group'
        ]);

        // 3. Masukin si Pembuat Grup (Kita) langsung ke dalem room
        $room->users()->attach($user->id);

        // 4. Kirim Undangan ke Mutuals yang diceklis (lewat Notifikasi)
        if ($request->has('members')) {
            foreach ($request->members as $memberId) {
                \App\Models\Notification::create([
                    'user_id' => $memberId,       // Target yang diundang
                    'sender_id' => $user->id,     // Kita yang ngundang
                    'type' => 'group_invite',     // Tipe notif baru nih!
                    'reference_id' => $room->id,  // Simpen ID Room biar nanti gampang pas Accept
                    'is_read' => false
                ]);
            }
        }

        // 5. Balikin ke halaman Pesan pake pesan sukses
        return back()->with('success', 'Grup berhasil dibuat! Undangan udah dikirim ke temen lu.');
    }

    // 6. Terima Undangan Grup
    public function acceptInvite($notificationId)
    {
        $notification = \App\Models\Notification::findOrFail($notificationId);
        
        // Keamanan: Pastiin notif ini beneran buat user yang lagi login
        if ($notification->user_id !== auth()->id()) {
            return back()->with('error', 'Akses ditolak!');
        }

        // Cari grupnya
        $room = Room::findOrFail($notification->reference_id);
        
        // Masukin user ke dalem grup (cek dulu biar nggak duplikat)
        if (!$room->users->contains(auth()->id())) {
            $room->users()->attach(auth()->id());
        }

        // Hapus notifnya biar bersih dari daftar
        $notification->delete();

        return back()->with('success', 'Berhasil gabung ke grup!');
    }

    // 7. Tolak Undangan Grup
    public function rejectInvite($notificationId)
    {
        $notification = \App\Models\Notification::findOrFail($notificationId);
        
        if ($notification->user_id !== auth()->id()) {
            return back()->with('error', 'Akses ditolak!');
        }

        // Langsung hapus aja notifnya tanpa dimasukin ke grup
        $notification->delete();

        return back()->with('success', 'Undangan grup ditolak.');
    }
    // 8. Halaman Info Grup
    public function groupInfo($roomId)
    {
        $room = Room::with('users')->findOrFail($roomId);
        
        // Keamanan: Cuma member yang bisa liat info grup
        if (!$room->users->contains(auth()->id())) {
            return redirect('/contacts')->with('error', 'Lu bukan anggota grup ini!');
        }

        $user = auth()->user();
        
        // Cari mutuals yang BELUM masuk grup ini buat di-invite
        $followerIds = $user->followers->pluck('id')->toArray();
        $mutuals = $user->followings->whereIn('id', $followerIds);
        
        $existingMemberIds = $room->users->pluck('id')->toArray();
        $invitableMutuals = $mutuals->whereNotIn('id', $existingMemberIds);

        return view('group-info', compact('room', 'invitableMutuals'));
    }

    // 9. Update Info Grup
    public function updateGroup(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        
        // Keamanan
        if (!$room->users->contains(auth()->id())) {
            return back()->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:3072'
        ]);

        $room->name = $request->name;
        $room->description = $request->description;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('group_photos', 'public');
            $room->photo = $path;
        }

        $room->save();

        return back()->with('success', 'Info grup berhasil diupdate!');
    }

    // 10. Invite Member Tambahan
    public function inviteToGroup(Request $request, $roomId)
    {
        $request->validate([
            'members' => 'required|array',
            'members.*' => 'exists:users,id'
        ]);

        $user = auth()->user();

        foreach ($request->members as $memberId) {
            // Cek biar nggak ngirim dobel kalau udah di-invite/udah masuk
            $isAlreadyMember = \DB::table('room_user')->where('room_id', $roomId)->where('user_id', $memberId)->exists();
            
            if (!$isAlreadyMember) {
                \App\Models\Notification::create([
                    'user_id' => $memberId,
                    'sender_id' => $user->id,
                    'type' => 'group_invite',
                    'reference_id' => $roomId,
                    'is_read' => false
                ]);
            }
        }

        return back()->with('success', 'Undangan tambahan berhasil disebar!');
    }
}