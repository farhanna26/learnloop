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
#[Fillable(['name', 'email', 'password', 'description', 'photo', 'location', 'linkedin', 'gmail', 'role'])]
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
        // UDAH GUE FIX: Tambahin 'follows' sebagai nama tabelnya
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')
                    ->withTimestamps();
    }

    // Helper untuk cek status follow
    public function isFollowing(User $user)
    {
        return $this->followings()->where('followed_id', $user->id)->exists();
    }

    // TAMBAHAN BARU: Relasi ke tabel posts biar bisa ngitung jumlah postingan
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // TAMBAHAN: Relasi ke Notifikasi
    // Satu user bisa punya banyak notifikasi
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // TAMBAHAN: Helper untuk hitung notif belum dibaca
    public function unreadNotificationsCount()
    {
        // Hitung berapa notif yang is_read nya masih false
        return $this->hasMany(Notification::class)
                    ->where('is_read', false)
                    ->count();
    }
}