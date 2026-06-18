<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // === FUNGSI PENCARIAN TEMAN ===
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $users = [];

        if ($keyword) {
            $users = User::where('id', '!=', auth()->id())
                        ->where('name', 'LIKE', '%' . $keyword . '%')
                        ->get();
        }

        // Kalau request datengnya dari JavaScript (AJAX), balikin data mentah JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($users);
        }

        // Kalau ngebuka dari URL biasa, balikin piringan HTML
        return view('search', compact('users', 'keyword'));
    }

    // === FUNGSI LIHAT PROFIL (ORANG LAIN ATAU SENDIRI) ===
    public function showProfile($id)
    {
        // PAKE WITHCOUNT: Biar dia ngitungin jumlah followers, followings, dan posts sekaligus
        $user = User::withCount(['followers', 'followings', 'posts'])->findOrFail($id);

        // Cek apakah user yang login lagi nge-follow user yang profilnya dibuka
        $isFollowing = auth()->check() ? auth()->user()->isFollowing($user) : false;
        
        // Kirim variabel isFollowing ke tampilan
        return view('profile', compact('user', 'isFollowing'));
    }

    // === FUNGSI EKSEKUSI TOMBOL FOLLOW ===
    public function toggleFollow($id)
    {
        $user = auth()->user();
        $targetUser = User::findOrFail($id);

        if ($user->id === $targetUser->id) {
            return response()->json(['success' => false, 'message' => 'Gak bisa follow diri sendiri!']);
        }

        if ($user->isFollowing($targetUser)) {
            $user->followings()->detach($targetUser->id);
            $status = 'unfollowed';
            $isFollowing = false;
            
            // (Opsional) Lu bisa hapus notifnya kalau dia unfollow, tapi biasanya dibiarin aja
        } else {
            $user->followings()->attach($targetUser->id);
            $status = 'followed';
            $isFollowing = true;

            // --- INI LOGIKA NOTIFIKASINYA ---
            try {
                \App\Models\Notification::create([
                    'user_id' => $targetUser->id, // Target (Miss Zaychik)
                    'sender_id' => $user->id,      // Pelaku (Farhan)
                    'type' => 'follow',            // Jenisnya
                    'is_read' => false
                ]);
            } catch (\Exception $e) {
                // Kalau notifikasi gagal, follow tetap jalan
            }
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'is_following' => $isFollowing
        ]);
    }

    // === FUNGSI SIMPAN EDIT PROFIL (FOTO, BANNER, SOSMED, & KOORDINAT) ===
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        // Tambahkan validasi untuk linkedin dan portfolio
        $validated = $request->validate([
            'description' => 'nullable|string|max:500',
            'linkedin'    => 'nullable|url',
            'portfolio'   => 'nullable|url',
            'photo'       => 'nullable|image|max:3072',
            'banner'      => 'nullable|image|max:3072', 
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'photo_' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('profile-photos'), $filename);
            $user->photo = 'profile-photos/' . $filename;
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $filename = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('profile-banners'), $filename); 
            $user->banner = 'profile-banners/' . $filename;
        }

        // PERBAIKAN: Masukkan data sosial media dan data koordinat agar tersimpan ke database
        $user->description = $validated['description'];
        $user->linkedin    = $validated['linkedin'];
        $user->portfolio   = $validated['portfolio'];
        
        // Menangkap data pergeseran posisi gambar dari form slider
        $user->banner_x    = $request->input('banner_x', 50);
        $user->banner_y    = $request->input('banner_y', 50);
        $user->photo_x     = $request->input('photo_x', 50);
        $user->photo_y     = $request->input('photo_y', 50);

        $user->save();

        return redirect('/profile')->with('success', 'Berhasil Edit Profile');
    }
}