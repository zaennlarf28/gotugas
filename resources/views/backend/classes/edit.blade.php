@extends('layouts.backend')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Kelas</h4>

    <form action="{{ route('backend.classes.update', $class->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control"
                   value="{{ $class->nama_kelas }}" required>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('backend.classes.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
