<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('mapel')
            ->where('guru_id', Auth::id())
            ->latest()
            ->get();

        return view('guru.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $mapels = Auth::user()->mapels;
        return view('guru.kelas.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'mapel_id'   => 'required|exists:mapels,id',
        ]);

        // 🔥 generate kode unik
        do {
            $kode = strtoupper(Str::random(6));
        } while (Kelas::where('kode_kelas', $kode)->exists());

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'mapel_id'   => $request->mapel_id,
            'kode_kelas' => $kode,
            'guru_id'    => Auth::id(),
        ]);

        // 🔥 GANTI ke SweetAlert
        toast('Kelas berhasil dibuat', 'success');

        return redirect()
            ->route('guru.kelas.index')
            ->with('kode_kelas', $kode); // tetap kirim kode buat ditampilkan
    }

    public function edit(Kelas $kelas)
    {
        $this->authorizeGuru($kelas);

        $mapels = Auth::user()->mapels;
        return view('guru.kelas.edit', compact('kelas', 'mapels'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $this->authorizeGuru($kelas);

        $request->validate([
            'nama_kelas' => 'required',
            'mapel_id'   => 'required|exists:mapels,id',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'mapel_id'   => $request->mapel_id,
        ]);

        // 🔥 SweetAlert
        toast('Kelas berhasil diperbarui', 'success');

        return redirect()->route('guru.kelas.index');
    }

    public function destroy(Kelas $kelas)
    {
        $this->authorizeGuru($kelas);

        $kelas->delete();

        // 🔥 SweetAlert
        toast('Kelas berhasil dihapus', 'success');

        return redirect()->route('guru.kelas.index');
    }

    private function authorizeGuru(Kelas $kelas)
    {
        if ($kelas->guru_id !== Auth::id()) {
            abort(403);
        }
    }
}