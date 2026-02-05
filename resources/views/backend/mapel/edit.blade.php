@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Mapel</h4>

    <form action="{{ route('backend.mapel.update', $mapel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control"
                   value="{{ $mapel->nama_mapel }}" required>
        </div>

        <div class="mb-3">
            <label>Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control"
                   value="{{ $mapel->kode_mapel }}" required>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('backend.mapel.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
