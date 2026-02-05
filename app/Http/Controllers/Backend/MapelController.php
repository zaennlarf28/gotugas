<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Alert;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::latest()->get();

        // 🔔 konfirmasi hapus (SAMA KAYAK USER)
        confirmDelete('Hapus Data!', 'Apakah Anda yakin ingin menghapus mapel ini?');

        return view('backend.mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('backend.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'kode_mapel' => 'required|unique:mapels',
        ]);

        Mapel::create($request->all());

        // 🔔 toast sukses
        toast('Mapel berhasil ditambahkan', 'success');

        return redirect()->route('backend.mapel.index');
    }

    public function edit(Mapel $mapel)
    {
        return view('backend.mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'kode_mapel' => 'required|unique:mapels,kode_mapel,' . $mapel->id,
        ]);

        $mapel->update($request->all());

        toast('Mapel berhasil diperbarui', 'success');

        return redirect()->route('backend.mapel.index');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();

        toast('Mapel berhasil dihapus', 'success');

        return redirect()->route('backend.mapel.index');
    }
}
