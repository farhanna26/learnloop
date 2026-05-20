<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->with(['sender', 'reference'])
            ->latest()
            ->get();

        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return view('notifications', compact('notifications'));
    }
}