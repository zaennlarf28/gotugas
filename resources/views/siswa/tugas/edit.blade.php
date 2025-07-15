@extends('layouts.frontend')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold mb-3">Edit Pengumpulan Tugas</h4>

    <form method="POST" action="{{ route('siswa.tugas.update', $pengumpulan->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="file" class="form-label fw-semibold">Ganti File (jika perlu)</label>
            <input type="file" class="form-control" name="file">
            <div class="form-text">Biarkan kosong jika tidak ingin mengganti.</div>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label fw-semibold">Deskripsi / Catatan</label>
            <textarea class="form-control" name="catatan" rows="4">{{ $pengumpulan->catatan }}</textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
