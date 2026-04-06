@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Tambah Guru</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.guru.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Guru</label>
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
                    <label>Mata Pelajaran</label>
                    <select name="mapels[]" class="form-control" multiple required>
                        @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <select name="classes[]" class="form-control" multiple required>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Simpan</button>
                <a href="{{ route('backend.guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection