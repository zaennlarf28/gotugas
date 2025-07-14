@extends('layouts.guru')

@section('styles')
<style>
    .card-siswa {
        transition: all 0.3s ease;
        border-left: 5px solid #0d6efd;
        border-radius: 10px;
    }

    .card-siswa.dikirim {
        border-left-color: #198754;
    }

    .card-siswa.belum {
        border-left-color: #6c757d;
    }

    .card-siswa:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .img-thumb {
        max-width: 70px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .icon-label {
        font-size: 0.9rem;
        color: #555;
    }

    .card-title i {
        color: #0d6efd;
        margin-right: 6px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt-4">
    <h4 class="fw-bold mb-3">📥 Pengumpulan Tugas: {{ $tugas->judul }}</h4>

    @if ($tugas->pengumpulan->isEmpty())
        <div class="alert alert-info text-center">Belum ada pengumpulan tugas.</div>
    @else

        {{-- Filter --}}
        <div class="mb-4">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" data-filter="all">Semua</button>
                <button type="button" class="btn btn-outline-secondary" data-filter="belum">Belum Dinilai</button>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tugas->pengumpulan as $p)
            @php
                $statusKelas = $p->status === 'dikirim' ? 'dikirim' : 'belum';
                $nilaiStatus = is_null($p->nilai) ? 'belum' : 'dinilai';
            @endphp
            <div class="col tugas-card" data-status="{{ $nilaiStatus }}">
                <div class="card h-100 card-siswa {{ $statusKelas }} shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            <i class="bi bi-person-circle"></i>
                            {{ $p->siswa->name ?? 'Siswa tidak ditemukan' }}
                        </h5>

                        <p class="icon-label mb-1">
                            <i class="bi bi-chat-left-text"></i>
                            <strong>Catatan:</strong> {{ $p->catatan ?? '-' }}
                        </p>

                        <div class="mb-2">
                            <p class="icon-label mb-1">
                                <i class="bi bi-file-earmark"></i> <strong>File:</strong>
                            </p>
                            @php $ext = pathinfo($p->file, PATHINFO_EXTENSION); @endphp

                            @if ($ext === 'pdf')
                                <a href="{{ asset('storage/' . $p->file) }}" target="_blank" class="btn btn-sm btn-outline-danger">Lihat PDF</a>
                            @elseif (in_array($ext, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                                <a href="{{ asset('storage/' . $p->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    Unduh & Buka di Office
                                </a>
                            @elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <a href="{{ asset('storage/' . $p->file) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $p->file) }}" class="img-thumb mt-1" alt="Gambar">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $p->file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Unduh File</a>
                            @endif
                        </div>

                        <p class="icon-label mb-2 mt-auto">
                            <i class="bi bi-info-circle"></i>
                            <strong>Status:</strong>
                            <span class="badge bg-{{ $p->status === 'dikirim' ? 'secondary' : 'primary' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </p>

                        <div>
                            <p class="icon-label mb-1"><i class="bi bi-pencil-square"></i> <strong>Nilai:</strong></p>
                            @if ($p->status === 'dikirim' && is_null($p->nilai))
                            <form action="{{ route('guru.tugas.nilai', $p->id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <input type="number" name="nilai" class="form-control form-control-sm me-2" style="width: 70px;" min="0" max="100" required>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                            @else
                                <span class="text-muted">{{ $p->nilai ?? '-' }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('[data-filter]');
        const cards = document.querySelectorAll('.tugas-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                cards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    if (filter === 'all' || status === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
