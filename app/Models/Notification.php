<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = ['user_id', 'sender_id', 'type', 'reference_id', 'is_read'];

    // Relasi: Notifikasi ini punya siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Siapa pelakunya?
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}