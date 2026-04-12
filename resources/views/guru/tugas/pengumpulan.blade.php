@extends('layouts.guru')

@section('styles')
<style>
    /* ── Card pengumpulan ── */
    .card-pengumpulan {
        transition: all 0.3s ease;
        border: 1.5px solid #e0e0e0;
    }
    .card-pengumpulan:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    }
    .card-pengumpulan.status-dikirim  { border-left: 4px solid #28a745; }
    .card-pengumpulan.status-dinilai  { border-left: 4px solid #0d6efd; }
    .card-pengumpulan.status-revisi   { border-left: 4px solid #ffc107; }

    /* ── Avatar siswa ── */
    .student-avatar {
        width: 52px; height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.12);
        flex-shrink: 0;
    }

    /* ── Badge status ── */
    .status-badge {
        padding: 0.45rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* ── File preview ── */
    .file-preview {
        max-width: 90px; max-height: 90px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .file-preview:hover { transform: scale(1.06); }

    /* ── Nilai input ── */
    .nilai-input { width: 90px; }

    /* ── Filter btn ── */
    .filter-btn { transition: all 0.2s ease; }
    .filter-btn.active { transform: scale(1.04); }

    /* ── Back button ── */
    .back-button:hover { transform: translateX(-3px); transition: transform 0.2s ease; }

    /* ── New badge ── */
    .badge-baru {
        position: absolute;
        top: 12px; right: 12px;
        background: linear-gradient(135deg, #e53935, #ef5350);
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 50px;
        box-shadow: 0 2px 8px rgba(229,57,53,0.35);
        animation: popIn 0.35s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes popIn {
        from { opacity:0; transform: scale(0.7); }
        to   { opacity:1; transform: scale(1); }
    }

    .empty-state { padding: 4rem 2rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('guru.tugas.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Pengumpulan Tugas</h4>
        <p class="text-muted mb-0">{{ $tugas->judul }}</p>
    </div>

    {{-- Info Tugas --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-start">
                        <div class="d-flex align-items-center justify-content-center me-3 bg-primary-subtle text-primary rounded-circle"
                             style="width:52px;height:52px;flex-shrink:0;">
                            <i class="ti ti-clipboard-list fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-2 fw-bold">{{ $tugas->judul }}</h5>
                            <div class="d-flex flex-wrap gap-3 mb-2">
                                <small class="text-muted">
                                    <i class="ti ti-chalkboard me-1"></i>
                                    <strong>Kelas:</strong> {{ $tugas->kelas->nama_kelas }}
                                </small>
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i>
                                    <strong>Deadline:</strong>
                                    {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y, H:i') }}
                                </small>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="ti ti-align-left me-1"></i>{{ $tugas->deskripsi }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-md-end mt-3 mt-md-0">
                        @php
                            $totalP    = $tugas->pengumpulan->count();
                            $dinilai   = $tugas->pengumpulan->whereNotNull('nilai')->count();
                            $belum     = $totalP - $dinilai;
                            $baru      = $tugas->pengumpulan
                                            ->where('created_at', '>=', now()->subHours(24))
                                            ->whereNull('nilai')->count();
                        @endphp
                        <div class="d-flex flex-column gap-2 align-items-md-end">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="ti ti-users me-1"></i>Total: {{ $totalP }}
                            </span>
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                <i class="ti ti-check me-1"></i>Dinilai: {{ $dinilai }}
                            </span>
                            <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                <i class="ti ti-clock me-1"></i>Belum Dinilai: {{ $belum }}
                            </span>
                            @if($baru > 0)
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="ti ti-bell me-1"></i>Baru (24 jam): {{ $baru }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($tugas->pengumpulan->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body empty-state text-center">
                <i class="ti ti-inbox" style="font-size:5rem;color:#e0e0e0;"></i>
                <h5 class="mt-3 mb-2">Belum Ada Pengumpulan</h5>
                <p class="text-muted mb-0">
                    Belum ada siswa yang mengumpulkan tugas ini.
                </p>
            </div>
        </div>
    @else

        {{-- Filter --}}
        <div class="mb-4">
            <div class="btn-group shadow-sm" role="group">
                <button type="button" class="btn btn-outline-primary active filter-btn" data-filter="all">
                    <i class="ti ti-list me-1"></i>Semua ({{ $totalP }})
                </button>
                @if($baru > 0)
                    <button type="button" class="btn btn-outline-danger filter-btn" data-filter="baru">
                        <i class="ti ti-bell me-1"></i>Baru ({{ $baru }})
                    </button>
                @endif
                <button type="button" class="btn btn-outline-warning filter-btn" data-filter="belum">
                    <i class="ti ti-clock me-1"></i>Belum Dinilai ({{ $belum }})
                </button>
                <button type="button" class="btn btn-outline-success filter-btn" data-filter="dinilai">
                    <i class="ti ti-check me-1"></i>Dinilai ({{ $dinilai }})
                </button>
            </div>
        </div>

        {{-- Cards --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tugas->pengumpulan as $p)
            @php
                $isBaru      = $p->created_at >= now()->subHours(24) && is_null($p->nilai);
                $nilaiStatus = is_null($p->nilai) ? 'belum' : 'dinilai';
                $statusKelas = 'status-' . $p->status;
            @endphp
            <div class="col tugas-card" data-status="{{ $nilaiStatus }}" data-baru="{{ $isBaru ? 'yes' : 'no' }}">
                <div class="card h-100 card-pengumpulan {{ $statusKelas }} shadow-sm position-relative">

                    {{-- Badge baru --}}
                    @if($isBaru)
                        <span class="badge-baru">
                            <i class="bi bi-lightning-fill me-1"></i>Baru
                        </span>
                    @endif

                    <div class="card-body d-flex flex-column">

                        {{-- ── Header siswa dengan foto profil ── --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            {{-- ✅ Foto profil siswa dinamis --}}
                            <img src="{{ $p->siswa->foto_profil_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($p->siswa->name ?? 'S') . '&background=0D8ABC&color=fff' }}"
                                 alt="{{ $p->siswa->name ?? 'Siswa' }}"
                                 class="student-avatar">
                            <div class="overflow-hidden">
                                <h6 class="mb-0 fw-bold text-truncate">
                                    {{ $p->siswa->name ?? 'Siswa tidak ditemukan' }}
                                </h6>
                                <small class="text-muted text-truncate d-block">
                                    {{ $p->siswa->email ?? '-' }}
                                </small>
                                @if($p->siswa->nis ?? false)
                                    <small class="text-muted">
                                        <i class="ti ti-id-badge" style="font-size:0.7rem;"></i>
                                        {{ $p->siswa->nis }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        {{-- Waktu kirim --}}
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="ti ti-clock me-1"></i>
                                Dikumpulkan {{ $p->created_at->diffForHumans() }}
                                <span class="ms-1 text-muted opacity-75">
                                    ({{ $p->created_at->translatedFormat('d M Y, H:i') }})
                                </span>
                            </small>
                        </div>

                        {{-- Status badge --}}
                        <div class="mb-3">
                            @if($p->status === 'dikirim')
                                <span class="status-badge bg-success-subtle text-success">
                                    <i class="ti ti-send me-1"></i>Dikirim
                                </span>
                            @elseif($p->status === 'dinilai')
                                <span class="status-badge bg-primary-subtle text-primary">
                                    <i class="ti ti-star me-1"></i>Sudah Dinilai
                                </span>
                            @else
                                <span class="status-badge bg-warning-subtle text-warning">
                                    <i class="ti ti-refresh me-1"></i>Revisi
                                </span>
                            @endif
                        </div>

                        {{-- Catatan siswa --}}
                        @if($p->catatan)
                            <div class="mb-3 p-2 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">
                                    <i class="ti ti-message me-1"></i>Catatan:
                                </small>
                                <small>{{ $p->catatan }}</small>
                            </div>
                        @endif

                        {{-- File --}}
                        <div class="mb-3">
                            <small class="text-muted fw-semibold d-block mb-2">
                                <i class="ti ti-paperclip me-1"></i>File Tugas:
                            </small>
                            @php
                                $ext     = pathinfo($p->file, PATHINFO_EXTENSION);
                                $fileUrl = asset('storage/' . $p->file);
                            @endphp
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']))
                                    <a href="{{ $fileUrl }}" target="_blank">
                                        <img src="{{ $fileUrl }}" class="file-preview" alt="Preview">
                                    </a>
                                    <a href="{{ $fileUrl }}" target="_blank"
                                       class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="ti ti-eye me-1"></i>Lihat
                                    </a>
                                @elseif(strtolower($ext) === 'pdf')
                                    <a href="{{ $fileUrl }}" target="_blank"
                                       class="btn btn-sm btn-danger rounded-pill">
                                        <i class="ti ti-file-type-pdf me-1"></i>Lihat PDF
                                    </a>
                                @elseif(in_array(strtolower($ext), ['doc','docx','ppt','pptx','xls','xlsx']))
                                    <a href="{{ $fileUrl }}" target="_blank"
                                       class="btn btn-sm btn-primary rounded-pill">
                                        <i class="ti ti-download me-1"></i>Unduh {{ strtoupper($ext) }}
                                    </a>
                                @else
                                    <a href="{{ $fileUrl }}" target="_blank"
                                       class="btn btn-sm btn-secondary rounded-pill">
                                        <i class="ti ti-download me-1"></i>Unduh File
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- ── Nilai ── --}}
                        <div class="mt-auto pt-3 border-top">
                            @if(is_null($p->nilai))
                                <small class="text-muted fw-semibold d-block mb-2">
                                    <i class="ti ti-star me-1"></i>Beri Nilai:
                                </small>
                                <form action="{{ route('guru.tugas.nilai', $p->id) }}"
                                      method="POST" class="d-flex align-items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="number" name="nilai"
                                           class="form-control nilai-input"
                                           min="0" max="100"
                                           placeholder="0–100" required>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                                        <i class="ti ti-check me-1"></i>Simpan
                                    </button>
                                </form>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                                         style="width:50px;height:50px;font-size:1.1rem;
                                                background:{{ $p->nilai >= 75 ? '#1cc88a' : ($p->nilai >= 60 ? '#f6c23e' : '#e74a3b') }};">
                                        {{ $p->nilai }}
                                    </div>
                                    <div>
                                        <small class="text-success fw-semibold d-block">Sudah Dinilai</small>
                                        <small class="text-muted">
                                            {{ $p->nilai >= 75 ? 'Bagus!' : ($p->nilai >= 60 ? 'Cukup' : 'Perlu perbaikan') }}
                                        </small>
                                    </div>
                                </div>
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
                    const isBaru = card.getAttribute('data-baru') === 'yes';

                    if (filter === 'all') {
                        card.style.display = '';
                    } else if (filter === 'baru' && isBaru) {
                        card.style.display = '';
                    } else if (filter === 'belum' && status === 'belum') {
                        card.style.display = '';
                    } else if (filter === 'dinilai' && status === 'dinilai') {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Validasi nilai
        document.querySelectorAll('form[action*="nilai"]').forEach(form => {
            form.addEventListener('submit', function (e) {
                const nilai = parseInt(this.querySelector('input[name="nilai"]').value);
                if (nilai < 0 || nilai > 100) {
                    e.preventDefault();
                    alert('Nilai harus antara 0–100!');
                    return;
                }
                if (!confirm('Simpan nilai ' + nilai + '?')) e.preventDefault();
            });
        });
    });
</script>
@endpush