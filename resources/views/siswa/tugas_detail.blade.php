@extends('layouts.frontend')

@section('content')
<div class="container mt-4">
    {{-- Tombol Kembali --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i>
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            {{-- Judul & Deskripsi Tugas --}}
            <h4 class="fw-bold mb-2">{{ $tugas->judul }}</h4>
            <p class="text-muted">Deskripsi: {{ $tugas->deskripsi }}</p>

            @php
                $pengumpulan = $tugas->pengumpulan_tugas->where('siswa_id', Auth::id())->first();
            @endphp

            @if ($pengumpulan)
                <div class="alert alert-info rounded-3">
                    <h6 class="mb-2"><i class="bi bi-info-circle me-1"></i> Status Pengumpulan</h6>
                    @if ($pengumpulan->status === 'dikirim')
                        <p class="mb-1">Kamu sudah mengumpulkan tugas.</p>
                        <p><em>Menunggu penilaian dari guru.</em></p>
                    @elseif ($pengumpulan->status === 'dinilai')
                        <p class="mb-1">Tugas sudah dinilai.</p>
                        <h6 class="text-success">Nilai: {{ $pengumpulan->nilai }}</h6>
                    @endif

                    <a href="{{ asset('storage/' . $pengumpulan->file) }}" class="btn btn-outline-primary btn-sm rounded-pill mt-2" target="_blank">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat File yang Dikirim
                    </a>
                </div>
            @else
                {{-- Form Pengumpulan Tugas --}}
                <form method="POST" action="{{ route('siswa.tugas.kumpulkan', $tugas->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Upload File</label>
                        <input type="file" class="form-control" name="file" required>
                        <div class="form-text">Format yang diperbolehkan: PDF, DOCX, JPG, PNG, dll.</div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-semibold">Deskripsi / Catatan</label>
                        <textarea class="form-control" name="catatan" rows="4" placeholder="Tulis keterangan tambahan di sini..."></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-send-check me-1"></i> Kumpulkan
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
