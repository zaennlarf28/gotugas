<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;
use Alert;

class TugasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['tugas', 'mapel'])
            ->where('guru_id', Auth::id())
            ->get();

        return view('guru.tugas.index', compact('kelas'));
    }

    public function create(Kelas $kelas)
    {
        if ($kelas->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.tugas.create', compact('kelas'));
    }

    public function store(Request $request, Kelas $kelas)
    {
        if ($kelas->guru_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul'     => 'required|max:100',
            'perintah'  => 'required|max:200',
            'deskripsi' => 'required|max:500',
            'deadline'  => 'required|date|after_or_equal:today',
        ]);

        Tugas::create([
            'kelas_id'  => $kelas->id,
            'judul'     => $request->judul,
            'perintah'  => $request->perintah,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
        ]);

        Alert::success('Berhasil', 'Tugas berhasil ditambahkan');

        return redirect()->route('guru.tugas.index');
    }

    public function edit($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);

        // 🔥 FIX UTAMA (anti null)
        if (!$tugas->kelas || $tugas->kelas->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.tugas.create', compact('tugas'));
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);

        // 🔥 FIX UTAMA
        if (!$tugas->kelas || $tugas->kelas->guru_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul'     => 'required|max:100',
            'perintah'  => 'required|max:200',
            'deskripsi' => 'required|max:500',
            'deadline'  => 'required|date',
        ]);

        $tugas->update([
            'judul'     => $request->judul,
            'perintah'  => $request->perintah,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
        ]);

        Alert::success('Berhasil', 'Tugas berhasil diperbarui');

        return redirect()->route('guru.tugas.index');
    }

    public function destroy($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);

        // 🔥 FIX UTAMA
        if (!$tugas->kelas || $tugas->kelas->guru_id !== Auth::id()) {
            abort(403);
        }

        $tugas->delete();

        Alert::success('Berhasil', 'Tugas berhasil dihapus');

        return back();
    }

    public function lihatPengumpulan($tugasId)
    {
        $tugas = Tugas::with([
            'kelas',
            'pengumpulan' => function ($q) {
                $q->latest();
            },
            'pengumpulan.siswa'
        ])->findOrFail($tugasId);

        // 🔥 FIX UTAMA
        if (!$tugas->kelas || $tugas->kelas->guru_id !== Auth::id()) {
            abort(403);
        }

        return view('guru.tugas.pengumpulan', compact('tugas'));
    }

    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        $pengumpulan = PengumpulanTugas::with('tugas.kelas')->findOrFail($id);

        // 🔥 FIX UTAMA
        if (
            !$pengumpulan->tugas ||
            !$pengumpulan->tugas->kelas ||
            $pengumpulan->tugas->kelas->guru_id !== Auth::id()
        ) {
            abort(403);
        }

        $pengumpulan->update([
            'nilai' => $request->nilai,
            'status' => 'dinilai'
        ]);

        Alert::success('Berhasil', 'Nilai berhasil diberikan');

        return back();
    }
}