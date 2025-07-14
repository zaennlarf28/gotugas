@extends('layouts.frontend')

@section('content')
<div class="container mt-5" style="max-width: 500px;">
    {{-- Tombol Kembali --}}
    <div class="mb-3">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i>
        </a>
    </div>

    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body p-4">
            <h4 class="mb-4 fw-bold text-center">🎓 Gabung ke Kelas</h4>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('siswa.kelas.join.proses') }}">
                @csrf

                <div class="mb-3">
                    <label for="kode_kelas" class="form-label fw-semibold">Kode Kelas</label>
                    <input type="text" name="kode_kelas" id="kode_kelas" class="form-control form-control-lg rounded-3" placeholder="Masukkan kode kelas..." required>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Gabung Sekarang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
