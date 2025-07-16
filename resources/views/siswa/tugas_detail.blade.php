@extends('layouts.frontend')

@section('content')
<div class="container py-4">
    {{-- Tombol Kembali --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow rounded-4">
        <div class="card-body p-4">

            {{-- Judul dan Deskripsi --}}
            <h3 class="fw-bold mb-2 text-primary">{{ $tugas->judul }}</h3>
            <p class="text-muted mb-1"><strong>Deskripsi:</strong> {{ $tugas->deskripsi }}</p>
            <p class="text-muted"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d F Y H:i') }}</p>

            @php
                use Carbon\Carbon;
                $now = Carbon::now();
                $deadline = Carbon::parse($tugas->deadline);
                $pengumpulan = $tugas->pengumpulan_tugas->where('siswa_id', Auth::id())->first();
            @endphp

            {{-- Sudah Lewat Deadline dan Belum Kumpul --}}
            @if ($deadline < $now && !$pengumpulan)
                <div class="alert alert-warning rounded-3 mt-4 d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <div>
                        Deadline tugas sudah lewat. Kamu tidak bisa mengumpulkan tugas ini.
                    </div>
                </div>

            {{-- Sudah Mengumpulkan --}}
            @elseif ($pengumpulan)
                <div class="alert alert-info rounded-3 mt-4">
                    <h6 class="mb-2 fw-bold"><i class="bi bi-info-circle me-1"></i> Status Pengumpulan</h6>

                    @if ($pengumpulan->status === 'dikirim')
                        <p class="mb-1">Kamu sudah mengumpulkan tugas.</p>
                        <p class="fst-italic">Menunggu penilaian dari guru.</p>
                    @elseif ($pengumpulan->status === 'dinilai')
                        <p class="mb-1">Tugas sudah dinilai.</p>
                        <h6 class="text-success fw-bold">Nilai: {{ $pengumpulan->nilai }}</h6>
                    @endif

                    <a href="{{ asset('storage/' . $pengumpulan->file) }}" class="btn btn-outline-primary btn-sm rounded-pill mt-3" target="_blank">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Lihat File
                    </a>

                    @if ($pengumpulan->status === 'dikirim')
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <a href="{{ route('siswa.tugas.edit', $pengumpulan->id) }}" class="btn btn-warning btn-sm rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('siswa.tugas.batalkan', $pengumpulan->id) }}" onsubmit="return confirm('Yakin ingin membatalkan pengumpulan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            {{-- Form Pengumpulan --}}
            @else
                <hr class="my-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-upload me-1"></i> Form Pengumpulan Tugas</h5>
                <form method="POST" action="{{ route('siswa.tugas.kumpulkan', $tugas->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Upload File</label>
                        <input type="file" class="form-control" name="file" required>
                        <div class="form-text">Format: PDF, DOCX, JPG, PNG, dll.</div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-semibold">Deskripsi / Catatan</label>
                        <textarea class="form-control" name="catatan" rows="4" placeholder="Tulis keterangan tambahan di sini..."></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="bi bi-send-check me-1"></i> Kumpulkan
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
