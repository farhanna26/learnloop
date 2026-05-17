<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Tambahin ini biar relasinya nggak bingung nyari alamat
use App\Models\User; 

class Message extends Model
{
    use HasFactory;

    // 1. Kolom yang boleh diisi
    // PASTIKAN di phpMyAdmin/Migration lu nama kolomnya emang 'message', bukan 'text'!
    protected $fillable = ['room_id', 'username', 'text'];

    // 2. Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'name');
    }

    // 3. Relasi ke Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}