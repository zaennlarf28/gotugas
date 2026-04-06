<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $guru = User::where('role', 'guru')
            ->with(['classes', 'mapels'])
            ->latest()
            ->get();

        $classes = Classes::all();

        return view('backend.guru.index', compact('guru', 'classes'));
    }

    public function create()
    {
        $classes = Classes::all();
        $mapels  = Mapel::all();

        return view('backend.guru.create', compact('classes', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'classes'  => 'required|array',
            'mapels'   => 'required|array',
        ]);

        $guru = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        $guru->classes()->sync($request->classes);
        $guru->mapels()->sync($request->mapels);

        return redirect()
            ->route('backend.guru.index')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit(User $guru)
    {
        // 🔥 GANTI isGuru()
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $classes = Classes::all();
        $mapels  = Mapel::all();

        return view('backend.guru.edit', compact('guru', 'classes', 'mapels'));
    }

    public function update(Request $request, User $guru)
    {
        // 🔥 GANTI isGuru()
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email,' . $guru->id,
            'classes' => 'required|array',
            'mapels'  => 'required|array',
        ]);

        $guru->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $guru->classes()->sync($request->classes);
        $guru->mapels()->sync($request->mapels);

        return redirect()
            ->route('backend.guru.index')
            ->with('success', 'Data guru diperbarui');
    }

    public function destroy(User $guru)
    {
        // 🔥 GANTI isGuru()
        if ($guru->role !== 'guru') {
            abort(404);
        }

        // 🔒 lebih aman: hapus relasi pivot dulu
        $guru->classes()->detach();
        $guru->mapels()->detach();

        $guru->delete();

        return back()->with('success', 'Guru berhasil dihapus');
    }
}
