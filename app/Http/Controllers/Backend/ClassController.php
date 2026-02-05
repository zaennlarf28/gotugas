<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use Illuminate\Http\Request;
use Alert;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::latest()->get();

        confirmDelete('Hapus Data!', 'Apakah Anda yakin ingin menghapus kelas ini?');

        return view('backend.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('backend.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        Classes::create($request->all());

        toast('Kelas berhasil ditambahkan', 'success');

        return redirect()->route('backend.classes.index');
    }

    public function edit(Classes $class)
    {
        return view('backend.classes.edit', compact('class'));
    }

    public function update(Request $request, Classes $class)
    {
        $class->update($request->all());

        toast('Kelas berhasil diperbarui', 'success');

        return redirect()->route('backend.classes.index');
    }

    public function destroy(Classes $class)
    {
        $class->delete();

        toast('Kelas berhasil dihapus', 'success');

        return redirect()->route('backend.classes.index');
    }
}
