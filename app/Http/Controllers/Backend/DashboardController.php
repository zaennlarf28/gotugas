<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{

public function index()
{
    $jumlahUser = User::count();
    $jumlahGuru = User::where('role', 'guru')->count();
    $jumlahSiswa = User::where('role', 'siswa')->count();

    return view('backend.index', compact('jumlahUser', 'jumlahGuru', 'jumlahSiswa'));
}


}
