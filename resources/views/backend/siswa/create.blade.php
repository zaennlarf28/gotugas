@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Siswa</h4>

    <form action="{{ route('backend.siswa.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <select name="classes[]" class="form-control" multiple required>
                @foreach($classes as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('backend.siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
