<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiChat extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'is_pinned'];

    public function messages()
    {
        return $this->hasMany(AiMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}