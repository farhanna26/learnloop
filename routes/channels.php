<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-channel', function ($user) {
    return true; // Semua yang login boleh masuk
});
