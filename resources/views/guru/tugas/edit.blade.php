@extends('layouts.guru')

@section('content')
<div class="container-fluid content-wrapper mt-4">
    <div class="card shadow-sm">
        <div class="card-header {{ isset($tugas) ? 'bg-warning text-white' : 'bg-success text-white' }}">
            <h5 class="mb-0">{{ isset($tugas) ? 'Edit Tugas' : 'Tambah Tugas' }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ isset($tugas) ? route('guru.tugas.update', $tugas->id) : route('guru.tugas.store', ['kelas' => $kelas->id]) }}">
                @csrf
                @if(isset($tugas))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $tugas->judul ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Perintah</label>
                    <input type="text" name="perintah" class="form-control" value="{{ old('perintah', $tugas->perintah ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi', $tugas->deskripsi ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="datetime-local" name="deadline" class="form-control" value="{{ old('deadline', isset($tugas) ? date('Y-m-d\TH:i', strtotime($tugas->deadline)) : '') }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn {{ isset($tugas) ? 'btn-warning' : 'btn-success' }}">
                        {{ isset($tugas) ? 'Update' : 'Tambah' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
