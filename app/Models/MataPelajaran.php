<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = ['mata_pelajaran'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'mata_pelajaran_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
