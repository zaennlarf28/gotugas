@extends('layouts.frontend')

@section('content')
<div class="container mt-4">

    {{-- Tombol Kembali --}}
    <div class="mb-3">
        <a href="{{ url('/')}}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i>
        </a>
    </div>

    <div class="mb-4 text-center">
        <h3 class="fw-bold">{{ $kelas->nama_kelas }}</h3>
        <div class="text-muted">
            <span class="me-3">
                <i class="bi bi-book me-1 text-primary"></i>
                {{ $kelas->mataPelajaran->mata_pelajaran }}
            </span>
            <span>
                <i class="bi bi-clipboard-check me-1 text-success"></i>
                {{ $tugas->count() }} Tugas
            </span>
        </div>
    </div>

    @php
        $backgroundColors = [
            '#f1f8e9', // hijau pucat
            '#e3f2fd', // biru langit
            '#fff3bf', // kuning pastel
            '#f8f9fa', // abu muda
            '#ede7f6', // ungu muda
        ];
    @endphp

    <div class="row mt-3">
        @forelse ($tugas as $t)
            @php
                $randomColor = $backgroundColors[array_rand($backgroundColors)];
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: {{ $randomColor }};">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-semibold">{{ $t->judul }}</h5>
                            <p class="text-muted small">{{ $t->perintah }}</p>
                            <div class="text-danger small">
                                Deadline:
                                {{ \Carbon\Carbon::parse($t->deadline)->translatedFormat('l, d F Y H:i') }}
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <a href="{{ route('siswa.tugas.show', $t->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i> Kerjakan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center rounded-3">
                    Belum ada tugas untuk kelas ini.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Tombol keluar kelas --}}
    <div class="text-center mt-4">
        <form action="{{ route('siswa.kelas.keluar', $kelas->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin keluar dari kelas ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4">
                <i class="bi bi-box-arrow-left me-1"></i> Keluar dari Kelas
            </button>
        </form>
    </div>
</div>
@endsection
