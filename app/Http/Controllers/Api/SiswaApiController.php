<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;

class SiswaApiController extends Controller
{
    public function kelasSaya()
    {
        return Auth::user()
            ->kelas()
            ->with('mapel', 'guru')
            ->get();
    }

    public function tugasByKelas($id)
    {
        return Tugas::where('kelas_id', $id)
            ->with('pengumpulan')
            ->orderBy('deadline')
            ->get();
    }

    public function kumpulkan(Request $request, $id)
    {
        $path = $request->file('file')->store('tugas_siswa', 'public');

        $data = PengumpulanTugas::create([
            'tugas_id' => $id,
            'siswa_id' => Auth::id(),
            'file' => $path,
            'catatan' => $request->catatan,
        ]);

        return response()->json([
            'message' => 'Tugas berhasil dikumpulkan',
            'data' => $data
        ]);
    }
}