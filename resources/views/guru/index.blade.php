@extends('layouts.guru')

@section('styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-left: 4px solid;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .stat-card.primary {
        border-left-color: #4e73df;
    }
    
    .stat-card.warning {
        border-left-color: #f6c23e;
    }
    
    .stat-card.success {
        border-left-color: #1cc88a;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .quick-action-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .quick-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }
    
    .activity-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: -26px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: white;
        border: 3px solid #4e73df;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- Welcome Banner -->
    <div class="card welcome-card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-2">
                        <i class="ti ti-hand-stop me-2"></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="mb-0 opacity-75">
                        <i class="ti ti-calendar me-1"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-column gap-2">
                        <span class="badge bg-white bg-opacity-25 text-white px-3 py-2">
                            <i class="ti ti-user-check me-1"></i>
                            Status: Guru Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Kelas -->
        <div class="col-md-4 mb-4">
            <div class="card stat-card primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary-subtle text-primary me-3">
                            <i class="ti ti-school"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Total Kelas</small>
                            <h2 class="mb-0 fw-bold">{{ $totalKelas }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ route('guru.kelas.index') }}" 
                           class="text-primary text-decoration-none d-flex align-items-center">
                            <span class="me-auto">Lihat Semua Kelas</span>
                            <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tugas -->
        <div class="col-md-4 mb-4">
            <div class="card stat-card warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning-subtle text-warning me-3">
                            <i class="ti ti-clipboard-list"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Total Tugas</small>
                            <h2 class="mb-0 fw-bold">{{ $totalTugas }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ route('guru.tugas.index') }}" 
                           class="text-warning text-decoration-none d-flex align-items-center">
                            <span class="me-auto">Lihat Semua Tugas</span>
                            <i class="ti ti-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengumpulan Hari Ini -->
        <div class="col-md-4 mb-4">
            <div class="card stat-card success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success-subtle text-success me-3">
                            <i class="ti ti-check"></i>
                        </div>
                        <div class="flex-grow-1">
                            <small class="text-muted d-block mb-1">Kelas Aktif</small>
                            <h2 class="mb-0 fw-bold">{{ $totalKelas }}</h2>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <span class="text-success d-flex align-items-center">
                            <i class="ti ti-trending-up me-1"></i>
                            Semua kelas berjalan baik
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="ti ti-bolt me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('guru.kelas.create') }}" class="text-decoration-none">
                                <div class="card quick-action-card border-0 bg-primary-subtle">
                                    <div class="card-body text-center py-4">
                                        <div class="mb-3">
                                            <i class="ti ti-plus" style="font-size: 2.5rem; color: var(--bs-primary);"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-primary">Buat Kelas Baru</h6>
                                        <small class="text-muted">Tambahkan kelas untuk mata pelajaran</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <div class="dropdown">
                                <a href="#" class="text-decoration-none" data-bs-toggle="dropdown">
                                    <div class="card quick-action-card border-0 bg-warning-subtle">
                                        <div class="card-body text-center py-4">
                                            <div class="mb-3">
                                                <i class="ti ti-file-plus" style="font-size: 2.5rem; color: var(--bs-warning);"></i>
                                            </div>
                                            <h6 class="mb-0 fw-bold text-warning">Buat Tugas Baru</h6>
                                            <small class="text-muted">Pilih kelas untuk tugas baru</small>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    @forelse(App\Models\Kelas::where('guru_id', Auth::id())->get() as $k)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('guru.tugas.create', ['kelas' => $k->id]) }}">
                                                {{ $k->nama_kelas }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="px-3 py-2 text-muted">Belum ada kelas</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('guru.kelas.index') }}" class="text-decoration-none">
                                <div class="card quick-action-card border-0 bg-info-subtle">
                                    <div class="card-body text-center py-4">
                                        <div class="mb-3">
                                            <i class="ti ti-list" style="font-size: 2.5rem; color: var(--bs-info);"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-info">Lihat Semua Kelas</h6>
                                        <small class="text-muted">Kelola kelas yang sudah ada</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('guru.tugas.index') }}" class="text-decoration-none">
                                <div class="card quick-action-card border-0 bg-success-subtle">
                                    <div class="card-body text-center py-4">
                                        <div class="mb-3">
                                            <i class="ti ti-folder-open" style="font-size: 2.5rem; color: var(--bs-success);"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-success">Lihat Semua Tugas</h6>
                                        <small class="text-muted">Cek pengumpulan siswa</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips & Info -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="ti ti-bulb me-2"></i>
                        Tips & Informasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <h6 class="mb-1 fw-semibold">Kelola Kelas Efektif</h6>
                            <small class="text-muted">
                                Gunakan kode kelas untuk memudahkan siswa bergabung
                            </small>
                        </div>

                        <div class="activity-item">
                            <h6 class="mb-1 fw-semibold">Buat Tugas Terstruktur</h6>
                            <small class="text-muted">
                                Beri deadline yang jelas dan deskripsi lengkap
                            </small>
                        </div>

                        <div class="activity-item">
                            <h6 class="mb-1 fw-semibold">Cek Pengumpulan Rutin</h6>
                            <small class="text-muted">
                                Nilai tugas siswa tepat waktu untuk feedback optimal
                            </small>
                        </div>

                        <div class="activity-item">
                            <h6 class="mb-1 fw-semibold">Komunikasi Aktif</h6>
                            <small class="text-muted">
                                Berikan catatan pada nilai untuk motivasi siswa
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card border-0 shadow-sm mt-3 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="ti ti-info-circle me-2"></i>
                        Informasi Sistem
                    </h6>
                    <small class="d-block mb-2">
                        <i class="ti ti-user me-1 text-primary"></i>
                        <strong>Guru:</strong> {{ Auth::user()->name }}
                    </small>
                    <small class="d-block mb-2">
                        <i class="ti ti-mail me-1 text-primary"></i>
                        <strong>Email:</strong> {{ Auth::user()->email }}
                    </small>
                    <small class="d-block">
                        <i class="ti ti-clock me-1 text-primary"></i>
                        <strong>Login:</strong> {{ \Carbon\Carbon::now()->translatedFormat('H:i') }} WIB
                    </small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection