@extends('layouts.guru')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-pencil-square me-1"></i> Edit Kelas</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('guru.kelas.update', $kelas->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control rounded"
                        value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                </div>

                <div class="mb-3">
                    <label for="mata_pelajaran_id" class="form-label fw-semibold">Mata Pelajaran</label>
                    <select name="mata_pelajaran_id" class="form-select rounded" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}" {{ $kelas->mata_pelajaran_id == $m->id ? 'selected' : '' }}>
                                {{ $m->mata_pelajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('guru.kelas.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-warning text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
