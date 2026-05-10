<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'content', 'image'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Hubungan ke Like (Agar withCount('likes') bekerja)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 3. Hubungan ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}