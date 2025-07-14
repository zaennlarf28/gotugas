@extends('layouts.guru')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Mata Pelajaran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.mapel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="mata_pelajaran" class="form-label fw-semibold">Nama Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran" class="form-control rounded" value="{{ old('mata_pelajaran') }}" required>
                    @error('mata_pelajaran')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('guru.mapel.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
