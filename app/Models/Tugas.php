<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'judul',
        'perintah',
        'deskripsi',
        'deadline',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pengumpulan_tugas()
{
    return $this->hasMany(\App\Models\PengumpulanTugas::class);
}

public function pengumpulan()
{
    return $this->hasMany(\App\Models\PengumpulanTugas::class);
}
// app/Models/Tugas.php — tambah method ini
public function reads()
{
    return $this->hasMany(TugasRead::class);
}

public function isReadBy($siswaId): bool
{
    return $this->reads()->where('siswa_id', $siswaId)->exists();
}

public function mapel()
{
    return $this->belongsTo(Mapel::class);
}
}
