<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Alert;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        // Tampilkan konfirmasi hapus
        confirmDelete('Hapus Data!', 'Apakah Anda yakin ingin menghapus user ini?');

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name'     => 'required|string|max:255',
        //     'email'    => 'required|email|unique:users,email',
        //     'password' => 'required|string|min:6|confirmed',
        //     'role'     => 'required',
        // ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        toast('User berhasil dibuat', 'success');
        return redirect()->route('backend.users.index');
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // $request->validate([
        //     'name'     => 'required|string|max:255',
        //     'email'    => 'required|email|unique:users,email,' . $user->id,
        //     'password' => 'nullable|string|min:6|confirmed',
        //     'role'     => 'required|in:admin,guru,siswa',
        // ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        toast('User berhasil diperbarui', 'success');
        return redirect()->route('backend.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        toast('User berhasil dihapus', 'success');
        return redirect()->route('backend.users.index');
    }
}
