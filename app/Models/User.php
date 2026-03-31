<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'alamat',
        'no_telepon',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // 🔽 Tempel method ini di bawah atau atas relasi-relasi seperti guru/siswa
    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('storage/' . $this->foto_profil);
        }

        // fallback avatar otomatis
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff';
    }

    public function getRoleTextAttribute()
    {
        return ucfirst($this->role);
    }

    // kelas (guru & siswa)
    public function classes()
    {
        return $this->belongsToMany(
            Classes::class,
            'class_user',
            'user_id',
            'class_id'
        )->withTimestamps();
    }

    // mapel (khusus guru)
    public function mapels()
    {
        return $this->belongsToMany(
            Mapel::class,
            'mapel_user',
            'user_id',
            'mapel_id'
        )->withTimestamps();
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id')->withTimestamps();
    }

    public function notifications()
{
    return $this->hasMany(Notification::class);
}
}
