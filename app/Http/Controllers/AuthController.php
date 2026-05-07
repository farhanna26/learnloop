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
}