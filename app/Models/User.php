<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// KITA GABUNGIN: Fillable standar lu + data profil buatan Aya
#[Fillable(['name', 'email', 'password', 'description', 'photo', 'location', 'linkedin', 'gmail'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // KITA TETEP PAKE: Sistem Follow biar fitur sosmed jalan
    // Narik data siapa aja yang KITA follow (Following)
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')
                    ->withTimestamps();
    }

    // Narik data siapa aja yang nge-follow KITA (Followers)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followed_id', 'follower_id')
                    ->withTimestamps();
    }

    // Helper untuk cek status follow
    public function isFollowing(User $user)
    {
        return $this->followings()->where('followed_id', $user->id)->exists();
    }
}