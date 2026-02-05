<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'mapel_id',
        'guru_id'
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'class_user', 'kelas_id', 'user_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
