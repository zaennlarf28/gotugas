<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['nama_kelas'];

    public function guru()
    {
        return $this->belongsToMany(
            Guru::class,
            'class_guru',
            'class_id',
            'guru_id'
        );
    }
}
