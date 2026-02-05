@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Mapel</h4>

    <form action="{{ route('backend.mapel.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('backend.mapel.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
