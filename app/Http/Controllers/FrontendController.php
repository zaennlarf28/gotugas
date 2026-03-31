<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        // Belum login atau bukan siswa → kirim collection kosong
        $kelasSaya = collect();

        if (Auth::check()) {
            $user = Auth::user();

            // Guru & admin diarahkan ke dashboard masing-masing
            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }

            if ($user->role === 'admin') {
                return redirect()->route('backend.dashboard');
            }

            // Siswa → ambil kelas sebagai Eloquent Collection (bukan array)
            if ($user->role === 'siswa') {
                $kelasSaya = $user->kelas()
                    ->with(['mapel', 'guru', 'tugas.reads'])
                    ->withPivot('created_at')
                    ->get(); // <-- Collection, bukan array
            }
        }

        return view('index', compact('kelasSaya'));
    }
}