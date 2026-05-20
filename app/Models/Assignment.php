<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'title', 'description', 'file_path', 'deadline'];

    // Kasih tau Laravel kalau 'deadline' itu tipe DateTime, bukan string biasa
    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}