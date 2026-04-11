<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'name'       => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6',
            'classes'    => 'required|array',
            'mapels'     => 'required|array',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
            'alamat'   => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ];

        // Upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $guru = User::create($data);

        $guru->classes()->sync($request->classes);
        $guru->mapels()->sync($request->mapels);

        return redirect()
            ->route('backend.guru.index')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit(User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $classes = Classes::all();
        $mapels  = Mapel::all();

        return view('backend.guru.edit', compact('guru', 'classes', 'mapels'));
    }

    public function update(Request $request, User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,' . $guru->id,
            'classes'     => 'required|array',
            'mapels'      => 'required|array',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'alamat'     => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Upload foto baru jika ada
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama
            if ($guru->foto_profil) {
                Storage::disk('public')->delete($guru->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $guru->update($data);

        $guru->classes()->sync($request->classes);
        $guru->mapels()->sync($request->mapels);

        return redirect()
            ->route('backend.guru.index')
            ->with('success', 'Data guru diperbarui');
    }

    public function destroy(User $guru)
    {
        if ($guru->role !== 'guru') {
            abort(404);
        }

        // Hapus foto profil jika ada
        if ($guru->foto_profil) {
            Storage::disk('public')->delete($guru->foto_profil);
        }

        $guru->classes()->detach();
        $guru->mapels()->detach();
        $guru->delete();

        return back()->with('success', 'Guru berhasil dihapus');
    }
}