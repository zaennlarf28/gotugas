<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasRead extends Model
{
    protected $fillable = ['tugas_id', 'siswa_id', 'read_at'];

    // app/Models/Tugas.php — tambah method ini
public function reads()
{
    return $this->hasMany(TugasRead::class);
}

public function isReadBy($siswaId): bool
{
    return $this->reads()->where('siswa_id', $siswaId)->exists();
}
}
