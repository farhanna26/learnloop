<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi tetap sama
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:creator,learner', 
        ]);

        // 2. Simpan user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // 3. Langsung login-in biar sat-set
        Auth::login($user);

        // 4. LEMPAR KE BERANDA (Bukan JSON lagi!)
        // Kita bawa pesan 'success' pake session flash
        return redirect()->route('beranda')->with('success', 'Selamat Datang! Akun ' . $request->role . ' berhasil dibuat.');
    }

    // INI FUNGSI YANG DICARIIN SAMA LARAVEL TADI!
    public function login(Request $request)
    {
        // 1. Validasi inputan dari form darurat tadi
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba cocokin KTP (email & password) ke database
        if (Auth::attempt($credentials)) {
            // Kalau cocok, buatin sesi login (biar gak gampang di-hack)
            $request->session()->regenerate();

            // Pas login sukses, tendang ke Beranda, bukan langsung ke Chat
            return redirect()->intended('/beranda'); 
        }

        // 3. Kalau email/password salah, balikin ke form login
        return back()->withErrors([
            'email' => 'Email atau password salah bro!',
        ]);
    }
    
    // Jangan lupa bikin fungsi logout sekalian biar gampang ngetes ganti akun
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}