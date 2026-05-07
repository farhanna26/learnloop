<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 1. Fungsi buat Daftar Akun Baru (Register)
    public function register(Request $request)
    {
        // Validasi data yang dikirim dari frontend
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // Tambahin validasi role biar user gak bisa ngirim role ngasal (harus creator/learner)
            'role' => 'required|in:creator,learner', 
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Masukin data rolenya ke database
            'role' => $request->role,
        ]);

        // Langsung login-in usernya abis daftar
        Auth::login($user);

        return response()->json(['status' => 'success', 'message' => 'Akun berhasil dibuat sebagai ' . $request->role . '!']);
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