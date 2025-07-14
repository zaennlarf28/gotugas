<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class BackendController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahSiswa = User::where('role', 'siswa')->count();

        return view('backend.index', compact('jumlahUser', 'jumlahGuru', 'jumlahSiswa'));
    }
}
