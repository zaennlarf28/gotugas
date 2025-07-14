<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::all();
        return view('guru.mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('guru.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required|string|unique:mata_pelajaran,mata_pelajaran',
        ]);

        MataPelajaran::create([
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        return redirect()->route('guru.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        return view('guru.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, $id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $request->validate([
            'mata_pelajaran' => 'required|string|unique:mata_pelajaran,mata_pelajaran,' . $id,
        ]);

        $mapel->update([
            'mata_pelajaran' => $request->mata_pelajaran,
        ]);

        return redirect()->route('guru.mapel.index')->with('success', 'Mata pelajaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();

        return redirect()->route('guru.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
