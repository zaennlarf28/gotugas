<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function show($id)
    {
        $tugas = \App\Models\Tugas::with('pengumpulan_tugas')->findOrFail($id);
        return view('siswa.tugas_detail', compact('tugas'));
    }

    public function kumpulkan(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        if (now()->gt($tugas->deadline)) {
        return back()->with('error', 'Deadline sudah lewat. Tidak bisa mengumpulkan tugas.');
    }

        $path = $request->file('file')->store('tugas_siswa', 'public');

        PengumpulanTugas::create([
            'tugas_id' => $id,
            'siswa_id' => Auth::id(),
            'file' => $path,
            'catatan' => $request->input('catatan'),
            'status' => 'dikirim',
        ]);

        return back()->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // ✅ Tambahkan ini:
    public function editPengumpulan($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        if ($pengumpulan->siswa_id !== Auth::id()) {
            abort(403);
        }

        return view('siswa.tugas_edit', compact('pengumpulan'));
    }

    public function updatePengumpulan(Request $request, $id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        if ($pengumpulan->siswa_id !== Auth::id()) {
            abort(403);
        }

        $pengumpulan->catatan = $request->catatan;

        if ($request->hasFile('file')) {
            Storage::delete('public/' . $pengumpulan->file);
            $pengumpulan->file = $request->file('file')->store('tugas_siswa', 'public');
        }

        $pengumpulan->save();

        return redirect()->route('siswa.tugas.show', $pengumpulan->tugas_id)->with('success', 'Pengumpulan berhasil diperbarui.');
    }

    public function destroyPengumpulan($id)
    {
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        if ($pengumpulan->siswa_id !== Auth::id()) {
            abort(403);
        }

        Storage::delete('public/' . $pengumpulan->file);
        $pengumpulan->delete();

        return redirect()->route('siswa.tugas.show', $pengumpulan->tugas_id)->with('success', 'Pengumpulan berhasil dibatalkan.');
    }
}
