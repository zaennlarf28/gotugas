<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = ['nama_mapel', 'kode_mapel'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function guru()
    {
        return $this->belongsToMany(User::class, 'mapel_user');
    }
}
