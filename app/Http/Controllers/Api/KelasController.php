<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Lihat semua kelas yang diikuti
    public function index(Request $request)
    {
        $kelas = $request->user()
            ->kelas()
            ->with(['mapel', 'guru', 'tugas'])
            ->withPivot('created_at')
            ->get()
            ->map(fn($k) => [
                'id'           => $k->id,
                'nama_kelas'   => $k->nama_kelas,
                'kode_kelas'   => $k->kode_kelas,
                'mapel'        => $k->mapel?->nama_mapel,
                'guru'         => $k->guru?->name,
                'total_tugas'  => $k->tugas->count(),
                'bergabung'    => $k->pivot->created_at?->format('d M Y'),
            ]);

        return response()->json(['kelas' => $kelas]);
    }

    // Detail kelas + daftar tugas
    public function show(Request $request, $id)
    {
        $kelas = $request->user()
            ->kelas()
            ->with(['mapel', 'guru', 'tugas'])
            ->where('kelas.id', $id)
            ->firstOrFail();

        return response()->json([
            'kelas' => [
                'id'         => $kelas->id,
                'nama_kelas' => $kelas->nama_kelas,
                'kode_kelas' => $kelas->kode_kelas,
                'mapel'      => $kelas->mapel?->nama_mapel,
                'guru'       => $kelas->guru?->name,
                'tugas'      => $kelas->tugas->map(fn($t) => [
                    'id'       => $t->id,
                    'judul'    => $t->judul,
                    'perintah' => $t->perintah,
                    'deadline' => $t->deadline,
                ]),
            ],
        ]);
    }

    // Join kelas pakai kode
    public function join(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|string',
        ]);

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->first();

        if (!$kelas) {
            return response()->json(['message' => 'Kode kelas tidak ditemukan'], 404);
        }

        $user = $request->user();

        if ($user->kelas()->where('kelas_id', $kelas->id)->exists()) {
            return response()->json(['message' => 'Kamu sudah tergabung di kelas ini'], 409);
        }

        $user->kelas()->attach($kelas->id);

        return response()->json([
            'message' => 'Berhasil join kelas',
            'kelas'   => [
                'id'         => $kelas->id,
                'nama_kelas' => $kelas->nama_kelas,
                'mapel'      => $kelas->mapel?->nama_mapel,
            ],
        ]);
    }

    // Keluar kelas
    public function keluar(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->kelas()->where('kelas_id', $id)->exists()) {
            return response()->json(['message' => 'Kamu tidak tergabung di kelas ini'], 404);
        }

        $user->kelas()->detach($id);

        return response()->json(['message' => 'Berhasil keluar dari kelas']);
    }
}