<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Mapel;

class GuruController extends Controller
{
   public function index()
{
    $guruId = auth()->id();

    $totalKelas = Kelas::where('guru_id', $guruId)->count();

    $totalTugas = Tugas::whereHas('kelas', function ($q) use ($guruId) {
        $q->where('guru_id', $guruId);
    })->count();

    $tugasSelesai = Tugas::whereHas('pengumpulan', function ($q) {
        $q->whereNotNull('file');
    })->whereHas('kelas', function ($q) use ($guruId) {
        $q->where('guru_id', $guruId);
    })->count();

    $totalMapel = \App\Models\Mapel::count(); // tambahkan ini

    return view('guru.index', compact('totalKelas', 'totalTugas', 'totalMapel'));
}

}
