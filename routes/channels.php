<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    // Mengecek di tabel pivot room_user, apakah user ini ada di room tersebut
    return \DB::table('room_user')
        ->where('room_id', $roomId)
        ->where('user_id', $user->id)
        ->exists();
});
