<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/profile', function () {
    $user = User::first();
    return view('profile', compact('user'));
});

Route::get('/addprofile', function () {
    $user = User::first();
    return view('addprofile', compact('user'));
});

Route::post('/addprofile', function (Request $request) {
    $user = User::first();

    if (! $user) {
        abort(404, 'User not found.');
    }

    $validated = $request->validate([
        'description' => 'nullable|string|max:500',
        'photo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $photo->getClientOriginalName());
        $destination = public_path('profile-photos');

        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $photo->move($destination, $filename);
        $user->photo = 'profile-photos/' . $filename;
    }

    $user->description = $validated['description'] ?? $user->description;
    $user->save();

    return redirect('/profile')->with('success', 'Profil berhasil disimpan.');
});
