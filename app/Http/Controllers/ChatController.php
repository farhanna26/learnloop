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
    // 1. Nampilin Isi Chat (Diupgrade buat Classroom + Sensor Notif)
    public function index($roomId) 
    {
        // Tarik data ruangan beserta membernya
        $room = Room::with('users')->findOrFail($roomId);

        // Keamanan: Cek apakah user tergabung di ruangan ini
        if (!$room->users->contains(auth()->id())) {
            return redirect('/contacts')->with('error', 'Lu bukan anggota ruangan ini, beb!');
        }

        // Tarik pesan chat
        $messages = Message::with('user')
                        ->where('room_id', $roomId)
                        ->get(); 

        // LOGIKA BARU: Lunturin titik merah pesannya!
        // Kita tandai semua pesan di kamar ini (yang BUKAN dari kita) jadi is_read = true
        Message::where('room_id', $roomId)
            ->where('username', '!=', auth()->user()->name)
            ->update(['is_read' => true]);

        $chatTitle = 'Ruang Obrolan';
        $otherUser = null;

        if ($room->type === 'private') {
            $otherUser = $room->users->where('id', '!=', auth()->id())->first();
            $chatTitle = $otherUser ? $otherUser->name : 'User Tidak Diketahui';
        } else {
            $chatTitle = $room->name ?? 'Grup Tanpa Nama';
        }

        // LOGIKA BARU: Tarik data tugas + data jawaban mahasiswa sekaligus
        $assignments = [];
        if ($room->type === 'classroom') {
            // Kita bawa data submissions beserta data user yang ngumpul tugasnya
            $assignments = $room->assignments()->with('submissions.user')->latest()->get(); 
        }

        // Pastikan variabel $assignments dikirim ke view juga
        return view('chat', compact('messages', 'room', 'chatTitle', 'otherUser', 'assignments'));
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

    // 4. Daftar Kontak, Grup & Kelas
    public function contactList()
    {
        $user = auth()->user();
        $myId = $user->id;

        // A. Pesan Pribadi (Following)
        $users = $user->followings;

        // B. Grup Diskusi Standar
        $groups = Room::where('type', 'group')
            ->whereHas('users', function ($query) use ($myId) {
                $query->where('user_id', $myId);
            })->get();

        // C. Ruang Kelas Pembelajaran (BARU)
        $classrooms = Room::where('type', 'classroom')
            ->whereHas('users', function ($query) use ($myId) {
                $query->where('user_id', $myId);
            })->get();

        // D. Mutuals (Saling Follow) buat modal Invite
        $followerIds = $user->followers->pluck('id')->toArray();
        $mutuals = $user->followings->whereIn('id', $followerIds);

        return view('contacts', compact('users', 'groups', 'classrooms', 'mutuals'));
    }

    // 5. Fungsi Bikin Grup/Kelas & Ngirim Undangan
    public function createGroup(Request $request)
    {
        // 1. Validasi Inputan (Tambah validasi type)
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:group,classroom', // Bisa grup biasa atau ruang kelas
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id'
        ]);

        $user = auth()->user();

        // Keamanan: Cuma Creator yang boleh bikin Ruang Kelas!
        if ($request->type === 'classroom' && $user->role !== 'creator') {
            return back()->with('error', 'Cuma Creator yang bisa bikin Ruang Kelas, beb!');
        }

        // 2. Bikin Room di Database
        $room = Room::create([
            'name' => $request->name,
            'type' => $request->type // Simpen tipenya sesuai yang dipilih
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

    // 9. Update Info Grup & Kelas
    public function updateGroup(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        
        // Keamanan: Pastiin yang ngedit beneran member di dalemnya
        if (!$room->users->contains(auth()->id())) {
            return back()->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072'
        ]);

        $room->name = $request->name;
        $room->description = $request->description;

        // Logic buat ngurusin upload foto baru
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('group_photos', 'public');
            $room->photo = $path;
        }

        $room->save();

        // Biar pesannya dinamis: Kalau diedit di kelas bilangnya "Kelas", kalau di grup bilangnya "Grup"
        $jenis = $room->type === 'classroom' ? 'Kelas' : 'Grup';
        return back()->with('success', "Mantap! Info $jenis berhasil diperbarui.");
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

    // 11. Fungsi Menerbitkan Tugas Baru (Khusus Creator)
    public function storeAssignment(Request $request)
    {
        // 1. TAMBAHIN INI BUAT CEK LOG
        \Log::info('Data tugas masuk:', $request->all());

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240' // Max 10MB
        ]);

        // Keamanan: Cuma Creator yang boleh bikin tugas
        if (auth()->user()->role !== 'creator') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak, cuma Creator yang bisa!'], 403);
        }

        $path = null;
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('assignments', 'public');
        }

        $assignment = \App\Models\Assignment::create([
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => date('Y-m-d H:i:s', strtotime($request->deadline)),
            'file_path' => $path
        ]);

        // Kirim notifikasi ke semua member kelas kecuali si creator
        $room = Room::findOrFail($request->room_id);
        $creator = auth()->user();

        foreach ($room->users as $member) {
            if ($member->id === $creator->id) continue; // Skip si creator sendiri

            \App\Models\Notification::create([
                'user_id'      => $member->id,
                'sender_id'    => $creator->id,
                'type'         => 'new_assignment',
                'reference_id' => $assignment->id,
                'is_read'      => false
            ]);
        }
        return response()->json(['success' => true]);
    }

    // 12. Fungsi Kumpul Tugas (Learner)
    public function storeSubmission(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file_path' => 'required|file|mimes:pdf,zip,doc,docx,png,jpg|max:10240'
        ]);

        $assignment = \App\Models\Assignment::findOrFail($request->assignment_id);

        // Cek status pengumpulan: telat atau on-time
        $status = now()->greaterThan($assignment->deadline) ? 'late' : 'ontime';

        // Simpen file
        $path = $request->file('file_path')->store('submissions', 'public');

        // Simpen ke tabel submissions
        \App\Models\Submission::create([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
            'file_path' => $path,
            'status' => $status
        ]);

        // KODINGAN BARU: Tembak Notifikasi ke Creator di kelas tersebut
        $creators = $assignment->room->users()->where('role', 'creator')->get();
        foreach ($creators as $creator) {
            \App\Models\Notification::create([
                'user_id' => $creator->id,       // Targetnya si Creator
                'sender_id' => auth()->id(),     // Pelakunya si Learner yang login
                'type' => 'submit_assignment',   // Tipe notif baru!
                'reference_id' => $assignment->id, 
                'is_read' => false
            ]);
        }

        return response()->json([
            'success' => true, 
            'status' => ($status === 'late' ? 'Tugas terlambat dikumpulkan' : 'Tugas berhasil dikumpulkan tepat waktu')
        ]);
    }

    // 13. Fungsi Beri Nilai Tugas (Khusus Creator)
    public function gradeSubmission(Request $request, $submissionId)
    {
        $request->validate([
            'grade' => 'required|integer|min:0|max:100'
        ]);

        if (auth()->user()->role !== 'creator') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak, beb!'], 403);
        }

        $submission = \App\Models\Submission::findOrFail($submissionId);
        $submission->grade = $request->grade;
        $submission->save();

        return response()->json(['success' => true]);
    }
}