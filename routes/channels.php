<?php

use Illuminate\Support\Facades\Broadcast;

// SEMENTARA: Kita "sogok" satpamnya biar lu bisa ngetes WebSocket-nya jalan dulu.
// Nanti kalau pesannya udah sukses nongol real-time tanpa refresh, 
// baru lu balikin lagi ke kodingan lu yang ngecek tabel pivot ya!

Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    return true; 
});
