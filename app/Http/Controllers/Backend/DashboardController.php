<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Classes;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahUser  = User::count();
        $jumlahGuru  = User::where('role', 'guru')->count();
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahMapel = Mapel::count();
        $jumlahKelas = Classes::count();

        return view('backend.index', compact(
            'jumlahUser',
            'jumlahGuru',
            'jumlahSiswa',
            'jumlahMapel',
            'jumlahKelas'
        ));
    }
}