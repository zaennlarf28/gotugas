@extends('layouts.frontend')

@section('content')
@php
  // Pastikan $kelasSaya selalu Collection, apapun yang dikirim controller
  $kelasSaya = collect($kelasSaya ?? []);
@endphp

<style>
/* =============================================
   GoTugas — Home Page Styles
   Aesthetic: Fresh & Modern Education App
   Palette: Deep forest green + lime accent + cream
============================================= */

:root {
  --gt-green:       #1a6b3c;
  --gt-green-mid:   #22883f;
  --gt-lime:        #4cde80;
  --gt-lime-soft:   #d4f7e2;
  --gt-cream:       #f6fbf8;
  --gt-white:       #ffffff;
  --gt-text:        #12291d;
  --gt-muted:       #6b8a77;
  --gt-border:      rgba(26,107,60,0.12);
  --gt-card-shadow: 0 2px 20px rgba(26,107,60,0.09);
  --gt-font-display: 'Raleway', sans-serif;
  --gt-font-body:    'Ubuntu', sans-serif;
}

/* ── Hero ───────────────────────────────── */
.gt-hero {
  min-height: calc(100vh - 66px);
  background: var(--gt-cream);
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  padding: 80px 0 60px;
}

/* Decorative blobs */
.gt-hero::before {
  content: '';
  position: absolute;
  width: 520px; height: 520px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.18) 0%, transparent 70%);
  top: -120px; right: -100px;
  pointer-events: none;
}
.gt-hero::after {
  content: '';
  position: absolute;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,107,60,0.08) 0%, transparent 70%);
  bottom: -80px; left: -60px;
  pointer-events: none;
}

/* Floating shape decoration */
.gt-hero-shape {
  position: absolute;
  border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
  background: linear-gradient(135deg, rgba(76,222,128,0.13), rgba(26,107,60,0.06));
  animation: morphBlob 8s ease-in-out infinite;
}
.gt-hero-shape-1 { width: 280px; height: 280px; top: 10%; right: 8%; animation-delay: 0s; }
.gt-hero-shape-2 { width: 160px; height: 160px; bottom: 15%; right: 28%; animation-delay: 3s; }
@keyframes morphBlob {
  0%,100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
  33%     { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; }
  66%     { border-radius: 30% 70% 30% 70% / 50% 60% 40% 50%; }
}

/* Grid dots background */
.gt-hero-grid {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.12) 1px, transparent 1px);
  background-size: 28px 28px;
  pointer-events: none;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 100%);
}

/* Hero text */
.gt-hero-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--gt-font-body);
  font-size: 0.78rem;
  font-weight: 600;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--gt-green);
  background: var(--gt-lime-soft);
  border: 1px solid rgba(76,222,128,0.4);
  padding: 5px 14px;
  border-radius: 50px;
  margin-bottom: 22px;
  animation: fadeSlideUp 0.6s ease both;
}
.gt-hero-eyebrow .dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--gt-lime);
  animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot {
  0%,100% { transform: scale(1); opacity:1; }
  50%      { transform: scale(1.5); opacity:0.6; }
}

.gt-hero-title {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: clamp(2rem, 4.5vw, 3.2rem);
  line-height: 1.18;
  color: var(--gt-text);
  margin-bottom: 18px;
  animation: fadeSlideUp 0.7s 0.1s ease both;
}
.gt-hero-title .highlight {
  position: relative;
  color: var(--gt-green);
  white-space: nowrap;
}
.gt-hero-title .highlight::after {
  content: '';
  position: absolute;
  left: 0; bottom: 2px;
  width: 100%; height: 6px;
  background: var(--gt-lime);
  border-radius: 4px;
  z-index: -1;
  opacity: 0.45;
}

.gt-hero-subtitle {
  font-family: var(--gt-font-body);
  font-size: 1.05rem;
  color: var(--gt-muted);
  line-height: 1.7;
  max-width: 460px;
  margin-bottom: 36px;
  animation: fadeSlideUp 0.7s 0.2s ease both;
}

.gt-hero-actions {
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
  animation: fadeSlideUp 0.7s 0.3s ease both;
}

.gt-btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.9rem;
  padding: 13px 26px;
  border-radius: 50px;
  background: var(--gt-green);
  color: #fff;
  border: none;
  text-decoration: none;
  transition: all 0.25s ease;
  box-shadow: 0 4px 18px rgba(26,107,60,0.28);
}
.gt-btn-primary:hover {
  background: var(--gt-green-mid);
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(26,107,60,0.36);
}
.gt-btn-primary .bi { font-size: 1rem; }

.gt-btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.9rem;
  padding: 12px 24px;
  border-radius: 50px;
  background: transparent;
  color: var(--gt-green);
  border: 2px solid var(--gt-border);
  text-decoration: none;
  transition: all 0.25s ease;
}
.gt-btn-secondary:hover {
  border-color: var(--gt-green);
  background: var(--gt-lime-soft);
  color: var(--gt-green);
  transform: translateY(-2px);
}

/* Stats strip */
.gt-hero-stats {
  display: flex;
  gap: 32px;
  margin-top: 44px;
  animation: fadeSlideUp 0.7s 0.4s ease both;
}
.gt-stat-item {
  display: flex;
  flex-direction: column;
}
.gt-stat-num {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.6rem;
  color: var(--gt-text);
  line-height: 1;
}
.gt-stat-label {
  font-family: var(--gt-font-body);
  font-size: 0.75rem;
  color: var(--gt-muted);
  margin-top: 3px;
  font-weight: 500;
}
.gt-stat-divider {
  width: 1px;
  background: var(--gt-border);
  align-self: stretch;
}

/* Hero image */
.gt-hero-img-wrap {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeSlideUp 0.8s 0.2s ease both;
}
.gt-hero-img-card {
  position: relative;
  border-radius: 28px;
  overflow: hidden;
  box-shadow: 0 24px 60px rgba(26,107,60,0.18), 0 2px 8px rgba(0,0,0,0.06);
  max-width: 480px;
  width: 100%;
}
.gt-hero-img-card img {
  width: 100%;
  display: block;
}
.gt-hero-img-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(160deg, rgba(76,222,128,0.08) 0%, transparent 60%);
  z-index: 1;
  pointer-events: none;
}

/* Floating mini cards on hero */
.gt-float-card {
  position: absolute;
  background: var(--gt-white);
  border-radius: 14px;
  box-shadow: 0 8px 28px rgba(0,0,0,0.10);
  padding: 10px 14px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: var(--gt-font-body);
  animation: floatY 4s ease-in-out infinite;
  z-index: 10;
}
.gt-float-card-1 {
  bottom: -18px; left: -20px;
  animation-delay: 0s;
}
.gt-float-card-2 {
  top: -14px; right: -10px;
  animation-delay: 2s;
}
@keyframes floatY {
  0%,100% { transform: translateY(0); }
  50%      { transform: translateY(-8px); }
}
.gt-float-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem;
}
.gt-float-icon.green { background: var(--gt-lime-soft); color: var(--gt-green); }
.gt-float-icon.amber { background: #fff8e1; color: #f59e0b; }
.gt-float-title { font-size: 0.78rem; font-weight: 700; color: var(--gt-text); line-height: 1.2; }
.gt-float-sub   { font-size: 0.68rem; color: var(--gt-muted); }

@keyframes fadeSlideUp {
  from { opacity: 0; transform: translateY(22px); }
  to   { opacity: 1; transform: translateY(0); }
}


/* ── Kelas Section ──────────────────────── */
.gt-kelas-section {
  padding: 80px 0 100px;
  background: #fff;
  position: relative;
}
.gt-kelas-section::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--gt-lime), var(--gt-green), var(--gt-lime));
  background-size: 200% 100%;
  animation: shimmerBar 3s linear infinite;
}
@keyframes shimmerBar {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Section header */
.gt-section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 40px;
  flex-wrap: wrap;
  gap: 16px;
}
.gt-section-eyebrow {
  font-family: var(--gt-font-body);
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--gt-green);
  background: var(--gt-lime-soft);
  padding: 4px 12px;
  border-radius: 50px;
  display: inline-block;
  margin-bottom: 8px;
}
.gt-section-title {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: clamp(1.5rem, 3vw, 2rem);
  color: var(--gt-text);
  margin: 0;
  line-height: 1.2;
}
.gt-section-sub {
  font-family: var(--gt-font-body);
  font-size: 0.9rem;
  color: var(--gt-muted);
  margin-top: 6px;
}

/* Alert */
.gt-alert {
  border: none;
  border-radius: 14px;
  padding: 14px 18px;
  font-family: var(--gt-font-body);
  font-size: 0.9rem;
  margin-bottom: 28px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.gt-alert-success { background: var(--gt-lime-soft); color: var(--gt-green); }
.gt-alert-danger  { background: #fff0f0; color: #c0392b; }
.gt-alert .bi { font-size: 1.1rem; }

/* Kelas card */
.gt-kelas-card {
  background: var(--gt-white);
  border: 1.5px solid var(--gt-border);
  border-radius: 20px;
  padding: 28px 24px;
  height: 100%;
  position: relative;
  transition: all 0.28s cubic-bezier(0.34,1.56,0.64,1);
  overflow: hidden;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  box-shadow: var(--gt-card-shadow);
}
.gt-kelas-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--gt-green), var(--gt-lime));
  border-radius: 20px 20px 0 0;
  opacity: 0;
  transition: opacity 0.25s;
}
.gt-kelas-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 40px rgba(26,107,60,0.14);
  border-color: rgba(76,222,128,0.5);
}
.gt-kelas-card:hover::before { opacity: 1; }

/* Background pattern on card */
.gt-kelas-card::after {
  content: '';
  position: absolute;
  width: 140px; height: 140px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.09) 0%, transparent 70%);
  bottom: -40px; right: -30px;
  pointer-events: none;
  transition: transform 0.3s;
}
.gt-kelas-card:hover::after { transform: scale(1.3); }

/* Badge tugas baru */
.gt-badge-new {
  position: absolute;
  top: 16px; right: 16px;
  background: linear-gradient(135deg, #e53935, #ef5350);
  color: #fff;
  font-family: var(--gt-font-body);
  font-size: 0.7rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 50px;
  display: flex;
  align-items: center;
  gap: 4px;
  box-shadow: 0 3px 10px rgba(229,57,53,0.35);
  letter-spacing: 0.01em;
  animation: badgePop 0.4s cubic-bezier(0.34,1.56,0.64,1) both;
}
.gt-badge-new .bi { font-size: 0.65rem; }
@keyframes badgePop {
  from { opacity:0; transform: scale(0.7); }
  to   { opacity:1; transform: scale(1); }
}

/* Icon */
.gt-card-icon {
  width: 52px; height: 52px;
  border-radius: 16px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 18px;
  transition: all 0.25s;
  flex-shrink: 0;
}
.gt-card-icon .bi {
  font-size: 1.4rem;
  color: var(--gt-green);
  transition: transform 0.25s;
}
.gt-kelas-card:hover .gt-card-icon {
  background: var(--gt-green);
}
.gt-kelas-card:hover .gt-card-icon .bi {
  color: #fff;
  transform: rotate(-6deg) scale(1.1);
}

/* Card text */
.gt-card-nama {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.05rem;
  color: var(--gt-text);
  margin-bottom: 4px;
  line-height: 1.25;
}
.gt-card-mapel {
  font-family: var(--gt-font-body);
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--gt-green);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.gt-card-mapel .bi { font-size: 0.75rem; }

.gt-card-meta {
  margin-top: auto;
  padding-top: 16px;
  border-top: 1px solid var(--gt-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}
.gt-card-guru {
  display: flex;
  align-items: center;
  gap: 6px;
  font-family: var(--gt-font-body);
  font-size: 0.78rem;
  color: var(--gt-muted);
}
.gt-card-guru .bi { font-size: 0.75rem; }
.gt-card-date {
  font-family: var(--gt-font-body);
  font-size: 0.72rem;
  color: var(--gt-muted);
  display: flex;
  align-items: center;
  gap: 4px;
}

/* Arrow */
.gt-card-arrow {
  position: absolute;
  bottom: 24px; right: 22px;
  width: 30px; height: 30px;
  border-radius: 50%;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.85rem;
  color: var(--gt-green);
  opacity: 0;
  transform: translateX(-6px);
  transition: all 0.25s;
}
.gt-kelas-card:hover .gt-card-arrow {
  opacity: 1;
  transform: translateX(0);
}

/* Empty state */
.gt-empty {
  text-align: center;
  padding: 64px 24px;
  background: var(--gt-cream);
  border-radius: 24px;
  border: 2px dashed var(--gt-border);
}
.gt-empty-icon {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
  font-size: 2rem;
  color: var(--gt-green);
}
.gt-empty-title {
  font-family: var(--gt-font-display);
  font-weight: 700;
  font-size: 1.1rem;
  color: var(--gt-text);
  margin-bottom: 8px;
}
.gt-empty-sub {
  font-family: var(--gt-font-body);
  font-size: 0.9rem;
  color: var(--gt-muted);
  margin-bottom: 24px;
}

/* Scroll top */
#scroll-top {
  background: var(--gt-green);
  border-radius: 50%;
  width: 44px; height: 44px;
  box-shadow: 0 4px 14px rgba(26,107,60,0.35);
  color: #fff;
  font-size: 1.3rem;
  transition: all 0.2s;
}
#scroll-top:hover {
  background: var(--gt-green-mid);
  transform: translateY(-3px);
}

/* AOS override for stagger */
[data-aos] { pointer-events: none; }
[data-aos].aos-animate { pointer-events: auto; }

@media (max-width: 768px) {
  .gt-hero { padding: 50px 0 40px; min-height: auto; }
  .gt-hero-stats { gap: 20px; }
  .gt-float-card { display: none; }
  .gt-section-header { flex-direction: column; align-items: flex-start; }
  .gt-kelas-section { padding: 60px 0 80px; }
}
</style>

{{-- ══════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════ --}}
<section class="gt-hero">
  <div class="gt-hero-grid"></div>
  <span class="gt-hero-shape gt-hero-shape-1"></span>
  <span class="gt-hero-shape gt-hero-shape-2"></span>

  <div class="container position-relative">
    <div class="row align-items-center gy-5">

      {{-- Left text --}}
      <div class="col-lg-6 order-2 order-lg-1">
        <div class="gt-hero-eyebrow">
          <span class="dot"></span>
          Platform Tugas Sekolah
        </div>
        <h1 class="gt-hero-title">
          Belajar Lebih Mudah<br>
          Bersama <span class="highlight">GoTugas</span>
        </h1>
        <p class="gt-hero-subtitle">
          Kerjakan tugas, pantau kelas, dan berkomunikasi dengan guru — semua dalam satu platform yang mudah digunakan.
        </p>
        <div class="gt-hero-actions">
          <a href="{{ url('join') }}" class="gt-btn-primary">
            <i class="bi bi-plus-circle-fill"></i>
            Masuk Kelas
          </a>
          <a href="#services" class="gt-btn-secondary">
            <i class="bi bi-grid-fill"></i>
            Kelas Saya
          </a>
        </div>
        @php
          $kelasSayaCol   = collect($kelasSaya);
          $totalTugas     = $kelasSayaCol->sum(fn($k) => collect($k->tugas)->count());
          $totalTugasBaru = $kelasSayaCol->sum(
              fn($k) => collect($k->tugas)->filter(fn($t) => !$t->isReadBy(Auth::id()))->count()
          );
        @endphp
        <div class="gt-hero-stats">
          <div class="gt-stat-item">
            <span class="gt-stat-num">{{ $kelasSayaCol->count() }}</span>
            <span class="gt-stat-label">Kelas Aktif</span>
          </div>
          <div class="gt-stat-divider"></div>
          <div class="gt-stat-item">
            <span class="gt-stat-num">{{ $totalTugas }}</span>
            <span class="gt-stat-label">Total Tugas</span>
          </div>
          <div class="gt-stat-divider"></div>
          <div class="gt-stat-item">
            <span class="gt-stat-num">{{ $totalTugasBaru }}</span>
            <span class="gt-stat-label">Tugas Baru</span>
          </div>
        </div>
      </div>

      {{-- Right image --}}
      <div class="col-lg-6 order-1 order-lg-2">
        <div class="gt-hero-img-wrap">
          <div class="gt-hero-img-card">
            <img src="{{ asset('assets/frontend/img/hero-img.png') }}"
                 class="img-fluid" alt="GoTugas Illustration">
          </div>
          {{-- Floating cards --}}
          <div class="gt-float-card gt-float-card-1">
            <span class="gt-float-icon green"><i class="bi bi-journal-check"></i></span>
            <div>
              <div class="gt-float-title">Tugas Selesai</div>
              <div class="gt-float-sub">Hari ini</div>
            </div>
          </div>
          <div class="gt-float-card gt-float-card-2">
            <span class="gt-float-icon amber"><i class="bi bi-bell-fill"></i></span>
            <div>
              <div class="gt-float-title">Tugas Baru!</div>
              <div class="gt-float-sub">Cek sekarang</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ══════════════════════════════════════════════
     KELAS SAYA SECTION
══════════════════════════════════════════════ --}}
<section id="services" class="gt-kelas-section">
  <div class="container">

    {{-- Header --}}
    <div class="gt-section-header" data-aos="fade-up">
      <div>
        <span class="gt-section-eyebrow">Ruang Belajar</span>
        <h2 class="gt-section-title">Kelas Saya</h2>
        <p class="gt-section-sub">Daftar kelas yang telah kamu ikuti</p>
      </div>
      <a href="{{ url('join') }}" class="gt-btn-primary" style="font-size:0.82rem;padding:10px 20px;">
        <i class="bi bi-plus-lg"></i> Tambah Kelas
      </a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
      <div class="gt-alert gt-alert-success" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size:0.75rem;"></button>
      </div>
    @endif
    @if (session('error'))
      <div class="gt-alert gt-alert-danger" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ session('error') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size:0.75rem;"></button>
      </div>
    @endif

    {{-- Cards grid --}}
    <div class="row gy-4">
      @forelse($kelasSaya as $index => $kelas)
        @php
          $jumlahBaru = collect($kelas->tugas)
              ->filter(fn($t) => !$t->isReadBy(Auth::id()))
              ->count();
        @endphp
        <div class="col-lg-4 col-md-6"
             data-aos="fade-up"
             data-aos-delay="{{ ($index % 3) * 100 }}">
          <a href="{{ route('siswa.kelas.show', $kelas->id) }}"
             class="gt-kelas-card text-decoration-none d-flex">

            {{-- New tasks badge --}}
            @if($jumlahBaru > 0)
              <span class="gt-badge-new">
                <i class="bi bi-lightning-fill"></i>
                {{ $jumlahBaru }} Tugas Baru
              </span>
            @endif

            {{-- Icon --}}
            <div class="gt-card-icon">
              <i class="bi bi-easel2-fill"></i>
            </div>

            {{-- Name & mapel --}}
            <div class="gt-card-nama">{{ $kelas->nama_kelas }}</div>
            <div class="gt-card-mapel">
              <i class="bi bi-book-fill"></i>
              {{ $kelas->mapel->nama_mapel ?? '-' }}
            </div>

            {{-- Footer meta --}}
            <div class="gt-card-meta">
              <div class="gt-card-guru">
                <i class="bi bi-person-fill"></i>
                {{ $kelas->guru->name }}
              </div>
              <div class="gt-card-date">
                <i class="bi bi-calendar3"></i>
                {{ $kelas->pivot->created_at->format('d M Y') }}
              </div>
            </div>

            {{-- Arrow --}}
            <span class="gt-card-arrow"><i class="bi bi-arrow-right"></i></span>

          </a>
        </div>
      @empty
        <div class="col-12" data-aos="fade-up">
          <div class="gt-empty">
            <div class="gt-empty-icon">
              <i class="bi bi-journal-x"></i>
            </div>
            <div class="gt-empty-title">Belum Ada Kelas</div>
            <p class="gt-empty-sub">Kamu belum bergabung di kelas manapun.<br>Masukkan kode kelas untuk mulai belajar!</p>
            <a href="{{ url('join') }}" class="gt-btn-primary">
              <i class="bi bi-plus-circle-fill"></i>
              Masuk Kelas Sekarang
            </a>
          </div>
        </div>
      @endforelse
    </div>

  </div>
</section>

{{-- Scroll Top --}}
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<div id="preloader"></div>

@endsection