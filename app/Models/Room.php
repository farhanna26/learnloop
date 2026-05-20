<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // 👈 INI KTP YANG BIKIN ERROR TADI

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'photo', 'description'];

    // 👈 INI WAJIB ADA BIAR KAMARNYA BISA DIISI BANYAK ORANG
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // 👈 INI WAJIB ADA BIAR KAMARNYA BISA NYIMPEN PESAN
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Tambahin relasi ini di bawah relasi yang udah ada
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}