@extends('layouts.guru')

@section('styles')
<style>
    .card-pengumpulan {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .card-pengumpulan:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .card-pengumpulan.status-dikirim {
        border-left: 4px solid #28a745;
    }

    .card-pengumpulan.status-belum {
        border-left: 4px solid #6c757d;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .file-preview {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .file-preview:hover {
        transform: scale(1.05);
    }

    .nilai-input {
        width: 80px;
    }

    .filter-btn {
        transition: all 0.2s ease;
    }

    .filter-btn.active {
        transform: scale(1.05);
    }

    .avatar-student {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        color: white;
    }

    .back-button:hover {
        transform: translateX(-3px);
        transition: transform 0.2s ease;
    }

    .empty-state {
        padding: 4rem 2rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('guru.tugas.index') }}" class="btn btn-light btn-sm back-button mb-2">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1 fw-bold">Pengumpulan Tugas</h4>
        <p class="text-muted mb-0">{{ $tugas->judul }}</p>
    </div>

    <!-- Info Tugas Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-start">
                        <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
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
                                    <strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('d M Y, H:i') }}
                                </small>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="ti ti-align-left me-1"></i>
                                {{ $tugas->deskripsi }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-md-end mt-3 mt-md-0">
                        @php
                            $totalPengumpulan = $tugas->pengumpulan->count();
                            $sudahDinilai = $tugas->pengumpulan->whereNotNull('nilai')->count();
                            $belumDinilai = $totalPengumpulan - $sudahDinilai;
                        @endphp
                        <div class="d-flex flex-column gap-2">
                            <span class="badge bg-primary-subtle text-primary">
                                <i class="ti ti-users me-1"></i>
                                Total: {{ $totalPengumpulan }} Pengumpulan
                            </span>
                            <span class="badge bg-success-subtle text-success">
                                <i class="ti ti-check me-1"></i>
                                Dinilai: {{ $sudahDinilai }}
                            </span>
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="ti ti-clock me-1"></i>
                                Belum: {{ $belumDinilai }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($tugas->pengumpulan->isEmpty())
        <!-- Empty State -->
        <div class="card border-0 shadow-sm">
            <div class="card-body empty-state text-center">
                <div class="mb-4">
                    <i class="ti ti-inbox" style="font-size: 5rem; color: #e0e0e0;"></i>
                </div>
                <h5 class="mb-2">Belum Ada Pengumpulan</h5>
                <p class="text-muted mb-0">
                    Belum ada siswa yang mengumpulkan tugas ini.<br>
                    Pengumpulan akan muncul di sini setelah siswa mengirimkan tugasnya.
                </p>
            </div>
        </div>
    @else

        <!-- Filter Buttons -->
        <div class="mb-4">
            <div class="btn-group shadow-sm" role="group">
                <button type="button" 
                        class="btn btn-outline-primary active filter-btn" 
                        data-filter="all">
                    <i class="ti ti-list me-1"></i>
                    Semua ({{ $totalPengumpulan }})
                </button>
                <button type="button" 
                        class="btn btn-outline-warning filter-btn" 
                        data-filter="belum">
                    <i class="ti ti-clock me-1"></i>
                    Belum Dinilai ({{ $belumDinilai }})
                </button>
                <button type="button" 
                        class="btn btn-outline-success filter-btn" 
                        data-filter="dinilai">
                    <i class="ti ti-check me-1"></i>
                    Sudah Dinilai ({{ $sudahDinilai }})
                </button>
            </div>
        </div>

        <!-- Pengumpulan Cards -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($tugas->pengumpulan as $p)
            @php
                $statusKelas = $p->status === 'dikirim' ? 'status-dikirim' : 'status-belum';
                $nilaiStatus = is_null($p->nilai) ? 'belum' : 'dinilai';
                
                // Generate color for avatar
                $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'];
                $colorIndex = ord(substr($p->siswa->name ?? 'A', 0, 1)) % count($colors);
                $avatarColor = $colors[$colorIndex];
                
                // Get initials
                $nameParts = explode(' ', $p->siswa->name ?? 'Unknown');
                $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
            @endphp
            <div class="col tugas-card" data-status="{{ $nilaiStatus }}">
                <div class="card h-100 card-pengumpulan {{ $statusKelas }} shadow-sm">
                    <div class="card-body d-flex flex-column">
                        
                        <!-- Student Header -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-student me-3" style="background-color: {{ $avatarColor }}">
                                {{ $initials }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $p->siswa->name ?? 'Siswa tidak ditemukan' }}</h6>
                                <small class="text-muted">
                                    <i class="ti ti-clock me-1"></i>
                                    {{ $p->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="mb-3">
                            <span class="status-badge {{ $p->status === 'dikirim' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                <i class="ti {{ $p->status === 'dikirim' ? 'ti-check' : 'ti-clock' }} me-1"></i>
                                {{ ucfirst($p->status) }}
                            </span>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">
                                <i class="ti ti-message me-1"></i>
                                <strong>Catatan Siswa:</strong>
                            </small>
                            <p class="mb-0">{{ $p->catatan ?? '-' }}</p>
                        </div>

                        <!-- File Preview -->
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">
                                <i class="ti ti-file me-1"></i>
                                <strong>File:</strong>
                            </small>
                            @php 
                                $ext = pathinfo($p->file, PATHINFO_EXTENSION); 
                                $fileUrl = asset('storage/' . $p->file);
                            @endphp

                            <div class="d-flex align-items-center gap-2">
                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <a href="{{ $fileUrl }}" target="_blank">
                                        <img src="{{ $fileUrl }}" 
                                             class="file-preview" 
                                             alt="Preview"
                                             title="Klik untuk memperbesar">
                                    </a>
                                    <a href="{{ $fileUrl }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i>
                                        Lihat
                                    </a>
                                @elseif ($ext === 'pdf')
                                    <a href="{{ $fileUrl }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-danger">
                                        <i class="ti ti-file-type-pdf me-1"></i>
                                        Lihat PDF
                                    </a>
                                @elseif (in_array($ext, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                                    <a href="{{ $fileUrl }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-primary">
                                        <i class="ti ti-download me-1"></i>
                                        Unduh {{ strtoupper($ext) }}
                                    </a>
                                @else
                                    <a href="{{ $fileUrl }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-secondary">
                                        <i class="ti ti-download me-1"></i>
                                        Unduh File
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Nilai Section -->
                        <div class="mt-auto pt-3 border-top">
                            <small class="text-muted d-block mb-2">
                                <i class="ti ti-star me-1"></i>
                                <strong>Nilai:</strong>
                            </small>
                            
                            @if ($p->status === 'dikirim' && is_null($p->nilai))
                                <form action="{{ route('guru.tugas.nilai', $p->id) }}" 
                                      method="POST" 
                                      class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" 
                                           name="nilai" 
                                           class="form-control nilai-input" 
                                           min="0" 
                                           max="100" 
                                           placeholder="0-100"
                                           required>
                                    <button type="submit" 
                                            class="btn btn-sm btn-primary">
                                        <i class="ti ti-check me-1"></i>
                                        Simpan
                                    </button>
                                </form>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success text-white fs-5 px-3 py-2">
                                        {{ $p->nilai ?? '-' }}
                                    </span>
                                    @if($p->nilai)
                                        <small class="text-success">
                                            <i class="ti ti-check"></i>
                                            Sudah dinilai
                                        </small>
                                    @endif
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
                // Update active state
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                // Filter cards
                cards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else if (filter === 'belum' && status === 'belum') {
                        card.style.display = 'block';
                    } else if (filter === 'dinilai' && status === 'dinilai') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Form validation for nilai
        document.querySelectorAll('form[action*="nilai"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const nilaiInput = this.querySelector('input[name="nilai"]');
                const nilai = parseInt(nilaiInput.value);
                
                if (nilai < 0 || nilai > 100) {
                    e.preventDefault();
                    alert('Nilai harus antara 0-100!');
                    return false;
                }
                
                if (!confirm(`Simpan nilai ${nilai}?`)) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    });
</script>
@endpush