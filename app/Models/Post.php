<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Kita tambahkan 'type' dan 'category_id' ke fillable
    protected $fillable = ['user_id', 'content', 'image', 'type', 'category_id'];

    
    // 1. Hubungan ke User (Pembuat Postingan)
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

    // 4. Hubungan ke Category (Agar bisa load nama kategori)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
