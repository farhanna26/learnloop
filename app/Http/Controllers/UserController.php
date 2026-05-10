<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
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
}