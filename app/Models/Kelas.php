<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'mata_pelajaran_id',
        'guru_id',
    ];

    // Relasi: kelas dimiliki oleh satu guru (user)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

   public function siswa()
{
    return $this->belongsToMany(User::class, 'kelas_siswa', 'kelas_id', 'siswa_id')->withTimestamps();
}

    
    // Relasi: kelas punya banyak tugas
    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    } 

    public function permintaanJoin()
{
    return $this->hasMany(PermintaanJoin::class);
}

public function mataPelajaran()
{
    return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
}



    

    // (Opsional) kalau nanti ada siswa masuk kelas
    // public function siswa()
    // {
    //     return $this->belongsToMany(User::class, 'kelas_user', 'kelas_id', 'user_id');
    // }
}
