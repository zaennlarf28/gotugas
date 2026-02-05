@extends('layouts.backend')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Tambah Guru</h4>

    <form action="{{ route('backend.guru.store') }}" method="POST">
        @csrf

        {{-- NAMA --}}
        <div class="mb-3">
            <label class="form-label">Nama Guru</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required>
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   required>
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   required>
        </div>

        {{-- MAPEL --}}
        <div class="mb-3">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mapels[]"
                    class="form-control"
                    multiple
                    required>
                @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}">
                        {{ $mapel->nama_mapel }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">
                * Bisa pilih lebih dari satu mapel
            </small>
        </div>

        {{-- KELAS --}}
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="classes[]"
                    class="form-control"
                    multiple
                    required>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">
                        {{ $class->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">
                * Kelas ini untuk relasi awal (opsional untuk manajemen)
            </small>
        </div>

        {{-- BUTTON --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                Simpan Guru
            </button>
            <a href="{{ route('backend.guru.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>
@endsection
