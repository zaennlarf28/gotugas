<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'judul',
        'perintah',
        'deskripsi',
        'kelas_id',
        'deadline',
        'tipe',
    ];

    // Relasi: Tugas milik satu kelas
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

public function mataPelajaran()
{
    return $this->belongsTo(MataPelajaran::class);
}

}
