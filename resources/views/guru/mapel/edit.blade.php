@extends('layouts.guru')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-pencil-square me-1"></i> Edit Mata Pelajaran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('guru.mapel.update', $mapel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="mata_pelajaran" class="form-label fw-semibold">Nama Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran" class="form-control rounded" value="{{ old('mata_pelajaran', $mapel->mata_pelajaran) }}" required>
                    @error('mata_pelajaran')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('guru.mapel.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-warning text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
