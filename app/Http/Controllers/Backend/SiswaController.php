<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->with('classes')
            ->latest()
            ->get();

        $classes = Classes::all();

        return view('backend.siswa.index', compact('siswa', 'classes'));
    }

    public function create()
    {
        $classes = Classes::all();

        return view('backend.siswa.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|min:6',
            'classes'     => 'required|array',
            'nis'         => 'nullable|string|max:20|unique:users,nis',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'siswa',
            'nis'        => $request->nis,
            'alamat'     => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ];

        // Upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $siswa = User::create($data);

        $siswa->classes()->sync($request->classes);

        return redirect()
            ->route('backend.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit(User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        $classes = Classes::all();

        return view('backend.siswa.edit', compact('siswa', 'classes'));
    }

    public function update(Request $request, User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,' . $siswa->id,
            'classes'     => 'required|array',
            'nis'         => 'nullable|string|max:20|unique:users,nis,' . $siswa->id,
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'nis'        => $request->nis,
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
            if ($siswa->foto_profil) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $siswa->update($data);

        $siswa->classes()->sync($request->classes);

        return redirect()
            ->route('backend.siswa.index')
            ->with('success', 'Data siswa diperbarui');
    }

    public function destroy(User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        // Hapus foto profil jika ada
        if ($siswa->foto_profil) {
            Storage::disk('public')->delete($siswa->foto_profil);
        }

        $siswa->classes()->detach();
        $siswa->delete();

        return back()->with('success', 'Siswa berhasil dihapus');
    }
}