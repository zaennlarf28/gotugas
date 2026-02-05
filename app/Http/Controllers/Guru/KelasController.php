<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
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
            ->get(); // ⛔ JANGAN paginate
            
        return view('guru.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $mapels = Auth::user()->mapels; // relasi
        return view('guru.kelas.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'mapel_id'   => 'required|exists:mapels,id',
        ]);

        do {
            $kode = strtoupper(Str::random(6));
        } while (Kelas::where('kode_kelas', $kode)->exists());

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'mapel_id'   => $request->mapel_id,
            'kode_kelas' => $kode,
            'guru_id'    => Auth::id(),
        ]);

        return redirect()
            ->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil dibuat')
            ->with('kode_kelas', $kode);
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

        return redirect()
            ->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui');
            
    }

    public function destroy(Kelas $kelas)
    {
        $this->authorizeGuru($kelas);
        $kelas->delete();

        return back()->with('success', 'Kelas berhasil dihapus');
    }

    private function authorizeGuru(Kelas $kelas)
    {
        if ($kelas->guru_id !== Auth::id()) {
            abort(403);
        }
    }
}
