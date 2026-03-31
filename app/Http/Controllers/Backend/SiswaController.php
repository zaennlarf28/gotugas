<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Alert;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->with('classes')
            ->latest()
            ->get();

        return view('backend.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $classes = Classes::all();

        return view('backend.siswa.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'classes'  => 'required|array',
        ]);

        $siswa = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        $siswa->classes()->sync($request->classes);

        toast('Siswa berhasil ditambahkan', 'success');

        return redirect()->route('backend.siswa.index');
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
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email,' . $siswa->id,
            'classes' => 'required|array',
        ]);

        $siswa->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $siswa->classes()->sync($request->classes);

        toast('Data siswa berhasil diperbarui', 'success');

        return redirect()->route('backend.siswa.index');
    }

    public function destroy(User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            abort(404);
        }

        $siswa->classes()->detach();
        $siswa->delete();

        toast('Siswa berhasil dihapus', 'success');

        return redirect()->route('backend.siswa.index');
    }
}
