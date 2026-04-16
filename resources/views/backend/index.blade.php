@extends('layouts.backend')

@section('styles')
<style>
.dash-stat-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    position: relative;
}
.dash-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12) !important;
}
.dash-stat-card .card-inner {
    padding: 24px 22px 20px;
    position: relative;
    z-index: 1;
}
.dash-stat-card .bg-shape {
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    bottom: -30px;
    right: -20px;
    opacity: 0.12;
    z-index: 0;
}
.dash-stat-card .icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
    font-size: 1.4rem;
}
.dash-stat-card .stat-num {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}
.dash-stat-card .stat-label {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    opacity: 0.75;
}
.dash-stat-card .stat-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    letter-spacing: 0.04em;
}

/* Welcome banner */
.welcome-banner {
    background: linear-gradient(135deg, #1a476b 0%, #226888 60%, #2a4aa3 100%);
    border-radius: 20px;
    padding: 28px 32px;
    position: relative;
    overflow: hidden;
    color: #fff;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    top: -80px; right: -60px;
}
.welcome-banner::after {
    content: '';
    position: absolute;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    bottom: -40px; left: 60px;
}
.welcome-banner .dot-grid {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
    background-size: 22px 22px;
}
.welcome-banner h3 { font-weight: 800; font-size: 1.35rem; margin-bottom: 4px; position: relative; z-index: 1; }
.welcome-banner p  { font-size: 0.875rem; opacity: 0.82; margin: 0; position: relative; z-index: 1; }
.welcome-banner .avatar-wrap {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: 2.5px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    flex-shrink: 0;
    position: relative; z-index: 1;
}
.welcome-banner .time-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 50px;
    padding: 5px 14px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #fff;
    position: relative; z-index: 1;
}

/* Quick links */
.quick-link-card {
    border: 1.5px solid rgba(0,0,0,0.06);
    border-radius: 16px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    transition: all 0.22s ease;
    background: #fff;
}
.quick-link-card:hover {
    border-color: rgba(26,107,60,0.3);
    background: #f6fbf8;
    color: inherit;
    transform: translateX(4px);
}
.quick-link-card .ql-icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.quick-link-card .ql-title {
    font-weight: 700; font-size: 0.875rem; margin-bottom: 1px;
}
.quick-link-card .ql-sub {
    font-size: 0.75rem; color: #888;
}

/* Section divider */
.section-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #6b8a77;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(0,0,0,0.07);
}

/* Animate on load */
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeSlideUp 0.45s 0.05s ease both; }
.anim-2 { animation: fadeSlideUp 0.45s 0.12s ease both; }
.anim-3 { animation: fadeSlideUp 0.45s 0.19s ease both; }
.anim-4 { animation: fadeSlideUp 0.45s 0.26s ease both; }
.anim-5 { animation: fadeSlideUp 0.45s 0.33s ease both; }
.anim-6 { animation: fadeSlideUp 0.45s 0.40s ease both; }
.anim-7 { animation: fadeSlideUp 0.45s 0.47s ease both; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4 px-4">

    {{-- ── Welcome Banner ────────────────────────────────── --}}
    <div class="welcome-banner shadow-sm mb-4 anim-1">
        <div class="dot-grid"></div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="avatar-wrap">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <h3>Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p>Kelola seluruh data sistem GoTugas dari sini. Semua dalam kendalimu.</p>
            </div>
            <div class="d-none d-md-block">
                <span class="time-chip">
                    <i class="ti ti-calendar"></i>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Section: Pengguna ──────────────────────────────── --}}
    <div class="section-label anim-2">
        <i class="ti ti-users"></i> Data Pengguna
    </div>

    <div class="row g-3 mb-4">

        {{-- Total Akun --}}
        <div class="col-md-4 anim-2">
            <div class="dash-stat-card shadow-sm h-100" style="background: linear-gradient(135deg, #e8f4ff 0%, #dbeeff 100%);">
                <div class="bg-shape" style="background:#2196f3;"></div>
                <div class="card-inner">
                    <span class="stat-badge" style="background:rgba(33,150,243,0.15);color:#0d47a1;">
                        <i class="ti ti-users me-1" style="font-size:0.65rem;"></i>Pengguna
                    </span>
                    <div class="icon-wrap" style="background:rgba(33,150,243,0.15);">
                        <i class="ti ti-users" style="color:#1565c0;"></i>
                    </div>
                    <div class="stat-num" style="color:#0d47a1;">{{ $jumlahUser }}</div>
                    <div class="stat-label" style="color:#1565c0;">Total Akun Terdaftar</div>
                    <div class="mt-3 pt-2" style="border-top:1px solid rgba(21,101,192,0.12);">
                        <a href="#" class="text-decoration-none d-flex align-items-center gap-1"
                           style="font-size:0.78rem;font-weight:600;color:#1565c0;">
                            Lihat semua <i class="ti ti-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jumlah Guru --}}
        <div class="col-md-4 anim-3">
            <div class="dash-stat-card shadow-sm h-100" style="background: linear-gradient(135deg, #eafaf0 0%, #d4f7e2 100%);">
                <div class="bg-shape" style="background:#22883f;"></div>
                <div class="card-inner">
                    <span class="stat-badge" style="background:rgba(34,136,63,0.15);color:#1a6b3c;">
                        <i class="ti ti-briefcase me-1" style="font-size:0.65rem;"></i>Guru
                    </span>
                    <div class="icon-wrap" style="background:rgba(34,136,63,0.15);">
                        <i class="ti ti-briefcase" style="color:#1a6b3c;"></i>
                    </div>
                    <div class="stat-num" style="color:#1a6b3c;">{{ $jumlahGuru }}</div>
                    <div class="stat-label" style="color:#22883f;">Total Guru Aktif</div>
                    <div class="mt-3 pt-2" style="border-top:1px solid rgba(26,107,60,0.12);">
                        <a href="{{ route('backend.guru.index') }}" class="text-decoration-none d-flex align-items-center gap-1"
                           style="font-size:0.78rem;font-weight:600;color:#1a6b3c;">
                            Kelola guru <i class="ti ti-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jumlah Siswa --}}
        <div class="col-md-4 anim-4">
            <div class="dash-stat-card shadow-sm h-100" style="background: linear-gradient(135deg, #fff8e1 0%, #fef3c7 100%);">
                <div class="bg-shape" style="background:#f59e0b;"></div>
                <div class="card-inner">
                    <span class="stat-badge" style="background:rgba(245,158,11,0.15);color:#b45309;">
                        <i class="ti ti-school me-1" style="font-size:0.65rem;"></i>Siswa
                    </span>
                    <div class="icon-wrap" style="background:rgba(245,158,11,0.15);">
                        <i class="ti ti-school" style="color:#b45309;"></i>
                    </div>
                    <div class="stat-num" style="color:#b45309;">{{ $jumlahSiswa }}</div>
                    <div class="stat-label" style="color:#b45309;">Total Siswa Terdaftar</div>
                    <div class="mt-3 pt-2" style="border-top:1px solid rgba(180,83,9,0.12);">
                        <a href="{{ route('backend.siswa.index') }}" class="text-decoration-none d-flex align-items-center gap-1"
                           style="font-size:0.78rem;font-weight:600;color:#b45309;">
                            Kelola siswa <i class="ti ti-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Section: Akademik ──────────────────────────────── --}}
    <div class="section-label anim-5">
        <i class="ti ti-book"></i> Data Akademik
    </div>

    <div class="row g-3 mb-4">

        {{-- Card Mapel --}}
        <div class="col-md-6 anim-5">
            <div class="dash-stat-card shadow-sm h-100" style="background: linear-gradient(135deg, #f3e8ff 0%, #ede7f6 100%);">
                <div class="bg-shape" style="background:#7c3aed;"></div>
                <div class="card-inner">
                    <span class="stat-badge" style="background:rgba(124,58,237,0.13);color:#4a148c;">
                        <i class="ti ti-book-2 me-1" style="font-size:0.65rem;"></i>Akademik
                    </span>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="icon-wrap mb-0" style="background:rgba(124,58,237,0.13);">
                            <i class="ti ti-book-2" style="color:#6d28d9;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <div class="stat-num" style="color:#4a148c;">{{ $jumlahMapel ?? \App\Models\Mapel::count() }}</div>
                            <div class="stat-label" style="color:#6d28d9;">Mata Pelajaran</div>
                        </div>
                    </div>
                    <p style="font-size:0.8rem;color:#6d28d9;opacity:0.85;margin:0 0 14px;">
                        Kelola semua mata pelajaran yang tersedia di sistem GoTugas.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.mapel.index') }}"
                           class="btn btn-sm rounded-pill fw-600"
                           style="background:rgba(124,58,237,0.13);color:#4a148c;border:none;font-size:0.78rem;font-weight:600;padding:6px 16px;">
                            <i class="ti ti-list me-1"></i>Lihat Semua
                        </a>
                        <a href="{{ route('backend.mapel.create') }}"
                           class="btn btn-sm rounded-pill"
                           style="background:#6d28d9;color:#fff;border:none;font-size:0.78rem;font-weight:600;padding:6px 16px;">
                            <i class="ti ti-plus me-1"></i>Tambah Mapel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Classes --}}
        <div class="col-md-6 anim-6">
            <div class="dash-stat-card shadow-sm h-100" style="background: linear-gradient(135deg, #fce4ec 0%, #fce4ec 100%);">
                <div class="bg-shape" style="background:#e91e63;"></div>
                <div class="card-inner">
                    <span class="stat-badge" style="background:rgba(233,30,99,0.12);color:#880e4f;">
                        <i class="ti ti-door me-1" style="font-size:0.65rem;"></i>Akademik
                    </span>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="icon-wrap mb-0" style="background:rgba(233,30,99,0.12);">
                            <i class="ti ti-door" style="color:#c2185b;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <div class="stat-num" style="color:#880e4f;">{{ $jumlahKelas ?? \App\Models\Classes::count() }}</div>
                            <div class="stat-label" style="color:#c2185b;">Kelas Tersedia</div>
                        </div>
                    </div>
                    <p style="font-size:0.8rem;color:#c2185b;opacity:0.85;margin:0 0 14px;">
                        Kelola kelas sekolah untuk pengelompokan guru dan siswa di sistem.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('backend.classes.index') }}"
                           class="btn btn-sm rounded-pill"
                           style="background:rgba(233,30,99,0.12);color:#880e4f;border:none;font-size:0.78rem;font-weight:600;padding:6px 16px;">
                            <i class="ti ti-list me-1"></i>Lihat Semua
                        </a>
                        <a href="{{ route('backend.classes.create') }}"
                           class="btn btn-sm rounded-pill"
                           style="background:#c2185b;color:#fff;border:none;font-size:0.78rem;font-weight:600;padding:6px 16px;">
                            <i class="ti ti-plus me-1"></i>Tambah Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Section: Aksi Cepat ────────────────────────────── --}}
    <div class="section-label anim-7">
        <i class="ti ti-bolt"></i> Aksi Cepat
    </div>

    <div class="row g-3 anim-7">
        <div class="col-md-3 col-6">
            <a href="{{ route('backend.guru.create') }}" class="quick-link-card">
                <span class="ql-icon" style="background:#eafaf0;">
                    <i class="ti ti-user-plus" style="color:#1a6b3c;"></i>
                </span>
                <div>
                    <div class="ql-title">Tambah Guru</div>
                    <div class="ql-sub">Daftarkan guru baru</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('backend.siswa.create') }}" class="quick-link-card">
                <span class="ql-icon" style="background:#fff8e1;">
                    <i class="ti ti-user-check" style="color:#b45309;"></i>
                </span>
                <div>
                    <div class="ql-title">Tambah Siswa</div>
                    <div class="ql-sub">Daftarkan siswa baru</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('backend.mapel.create') }}" class="quick-link-card">
                <span class="ql-icon" style="background:#f3e8ff;">
                    <i class="ti ti-book-2" style="color:#6d28d9;"></i>
                </span>
                <div>
                    <div class="ql-title">Tambah Mapel</div>
                    <div class="ql-sub">Buat mata pelajaran</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('backend.classes.create') }}" class="quick-link-card">
                <span class="ql-icon" style="background:#fce4ec;">
                    <i class="ti ti-door" style="color:#c2185b;"></i>
                </span>
                <div>
                    <div class="ql-title">Tambah Kelas</div>
                    <div class="ql-sub">Buat kelas baru</div>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection