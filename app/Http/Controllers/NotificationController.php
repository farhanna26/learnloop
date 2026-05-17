<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Ambil notifikasi buat user yang login, bawa data pengirimnya (sender)
        $notifications = auth()->user()->notifications()->with('sender')->latest()->get();

        // Tandai semua sebagai sudah dibaca (is_read = true) pas halaman dibuka
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return view('notifications', compact('notifications'));
    }
}