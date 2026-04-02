<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\TugasRead;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Detail tugas + status pengumpulan
    public function show(Request $request, $id)
    {
        $tugas = Tugas::with(['kelas', 'pengumpulan_tugas' => function ($q) use ($request) {
            $q->where('siswa_id', $request->user()->id);
        }])->findOrFail($id);

        // Mark as read
        TugasRead::firstOrCreate([
            'tugas_id' => $tugas->id,
            'siswa_id' => $request->user()->id,
        ], ['read_at' => now()]);

        $pengumpulan = $tugas->pengumpulan_tugas->first();

        return response()->json([
            'tugas' => [
                'id'          => $tugas->id,
                'judul'       => $tugas->judul,
                'perintah'    => $tugas->perintah,
                'deskripsi'   => $tugas->deskripsi,
                'deadline'    => $tugas->deadline,
                'kelas'       => $tugas->kelas?->nama_kelas,
                'pengumpulan' => $pengumpulan ? [
                    'id'      => $pengumpulan->id,
                    'status'  => $pengumpulan->status,
                    'nilai'   => $pengumpulan->nilai,
                    'catatan' => $pengumpulan->catatan,
                    'file'    => asset('storage/' . $pengumpulan->file),
                ] : null,
            ],
        ]);
    }

    // Kumpulkan tugas
    public function kumpulkan(Request $request, $id)
    {
        $request->validate([
            'file'    => 'required|file|max:10240',
            'catatan' => 'nullable|string',
        ]);

        $tugas = Tugas::findOrFail($id);

        if (now()->gt($tugas->deadline)) {
            return response()->json(['message' => 'Deadline sudah lewat'], 422);
        }

        if (PengumpulanTugas::where('tugas_id', $id)
                ->where('siswa_id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Sudah mengumpulkan tugas ini'], 409);
        }

        $path = $request->file('file')->store('tugas_siswa', 'public');

        $pengumpulan = PengumpulanTugas::create([
            'tugas_id' => $id,
            'siswa_id' => $request->user()->id,
            'file'     => $path,
            'catatan'  => $request->catatan,
            'status'   => 'dikirim',
        ]);

        return response()->json([
            'message'     => 'Tugas berhasil dikumpulkan',
            'pengumpulan' => [
                'id'     => $pengumpulan->id,
                'status' => $pengumpulan->status,
                'file'   => asset('storage/' . $pengumpulan->file),
            ],
        ], 201);
    }
}