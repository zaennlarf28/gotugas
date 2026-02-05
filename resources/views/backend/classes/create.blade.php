@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Kelas</h4>

    <form action="{{ route('backend.classes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('backend.classes.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
