@extends('layouts.frontend')

@section('content')

<style>
/* =============================================
   GoTugas — Profile Page
   Aesthetic: Refined SaaS / Luxury Education
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
  --gt-border:      rgba(26,107,60,0.10);
  --gt-border-mid:  rgba(26,107,60,0.18);
  --gt-shadow-sm:   0 2px 12px rgba(26,107,60,0.07);
  --gt-shadow-md:   0 8px 32px rgba(26,107,60,0.12);
  --gt-shadow-lg:   0 24px 64px rgba(26,107,60,0.14);
  --gt-font-display: 'Raleway', sans-serif;
  --gt-font-body:    'Ubuntu', sans-serif;
  --sp: 8px; /* base spacing unit */
}

/* ── Page shell ── */
.gt-profile-page {
  min-height: calc(100vh - 66px);
  background: var(--gt-cream);
  padding: calc(var(--sp) * 6) 0 calc(var(--sp) * 12);
  position: relative;
  overflow: hidden;
}

/* Ambient background shapes */
.gt-profile-page::before {
  content: '';
  position: absolute;
  width: 600px; height: 600px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.13) 0%, transparent 65%);
  top: -180px; right: -160px;
  pointer-events: none;
}
.gt-profile-page::after {
  content: '';
  position: absolute;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,107,60,0.06) 0%, transparent 70%);
  bottom: -120px; left: -100px;
  pointer-events: none;
}

/* Dot grid */
.gt-pg-grid {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.09) 1px, transparent 1px);
  background-size: 28px 28px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black, transparent);
  pointer-events: none;
}

/* ── Back button ── */
.gt-back {
  display: inline-flex;
  align-items: center;
  gap: calc(var(--sp) * 0.75);
  font-family: var(--gt-font-body);
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--gt-muted);
  text-decoration: none;
  padding: calc(var(--sp) * 0.875) calc(var(--sp) * 1.75);
  border-radius: 50px;
  background: rgba(255,255,255,0.85);
  border: 1.5px solid var(--gt-border-mid);
  margin-bottom: calc(var(--sp) * 3);
  transition: all 0.22s ease;
  backdrop-filter: blur(8px);
  position: relative;
  z-index: 2;
}
.gt-back:hover {
  color: var(--gt-green);
  border-color: rgba(26,107,60,0.3);
  background: var(--gt-lime-soft);
  transform: translateX(-3px);
}

/* ── Layout: sidebar + main ── */
.gt-profile-layout {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: calc(var(--sp) * 3);
  align-items: start;
  position: relative;
  z-index: 2;
}
@media (max-width: 900px) {
  .gt-profile-layout { grid-template-columns: 1fr; }
}

/* ── Card base ── */
.gt-card {
  background: rgba(255,255,255,0.95);
  border-radius: 24px;
  border: 1.5px solid var(--gt-border);
  box-shadow: var(--gt-shadow-md);
  backdrop-filter: blur(12px);
  overflow: hidden;
  animation: fadeSlideUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes fadeSlideUp {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── Sidebar card ── */
.gt-sidebar-card {
  animation-delay: 0s;
}

/* Avatar section */
.gt-avatar-section {
  background: linear-gradient(160deg, var(--gt-green) 0%, var(--gt-green-mid) 100%);
  padding: calc(var(--sp) * 5) calc(var(--sp) * 3) calc(var(--sp) * 4);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.gt-avatar-section::before {
  content: '';
  position: absolute;
  width: 200px; height: 200px;
  border-radius: 50%;
  background: rgba(255,255,255,0.06);
  top: -60px; right: -50px;
}
.gt-avatar-section::after {
  content: '';
  position: absolute;
  width: 120px; height: 120px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
  bottom: -40px; left: -30px;
}

.gt-avatar-ring {
  display: inline-block;
  position: relative;
  z-index: 1;
  margin-bottom: calc(var(--sp) * 2);
}
.gt-avatar-ring::before {
  content: '';
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--gt-lime), rgba(255,255,255,0.4));
  z-index: -1;
}
.gt-avatar-ring img {
  width: 96px; height: 96px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid rgba(255,255,255,0.9);
  display: block;
}

/* Online indicator */
.gt-avatar-ring::after {
  content: '';
  position: absolute;
  width: 18px; height: 18px;
  border-radius: 50%;
  background: var(--gt-lime);
  border: 3px solid #fff;
  bottom: 4px; right: 4px;
  box-shadow: 0 0 0 3px rgba(76,222,128,0.3);
  animation: onlinePulse 2.5s ease-in-out infinite;
}
@keyframes onlinePulse {
  0%,100% { box-shadow: 0 0 0 3px rgba(76,222,128,0.3); }
  50%      { box-shadow: 0 0 0 6px rgba(76,222,128,0.1); }
}

.gt-sidebar-name {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.15rem;
  color: #fff;
  margin-bottom: calc(var(--sp) * 0.5);
  position: relative;
  z-index: 1;
}
.gt-sidebar-email {
  font-family: var(--gt-font-body);
  font-size: 0.8rem;
  color: rgba(255,255,255,0.7);
  margin-bottom: calc(var(--sp) * 2);
  position: relative;
  z-index: 1;
}

/* Role badge */
.gt-role-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--gt-font-body);
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  padding: 5px 14px;
  border-radius: 50px;
  position: relative;
  z-index: 1;
}
.gt-role-badge.siswa   { background: rgba(76,222,128,0.25); color: #d4f7e2; border: 1px solid rgba(76,222,128,0.4); }
.gt-role-badge.guru    { background: rgba(251,191,36,0.2); color: #fde68a; border: 1px solid rgba(251,191,36,0.35); }
.gt-role-badge.admin   { background: rgba(239,68,68,0.2); color: #fecaca; border: 1px solid rgba(239,68,68,0.35); }
.gt-role-badge .bi { font-size: 0.7rem; }

/* Sidebar body */
.gt-sidebar-body {
  padding: calc(var(--sp) * 3);
}

/* Quick stat chips */
.gt-stat-chips {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: calc(var(--sp) * 1.5);
  margin-bottom: calc(var(--sp) * 3);
}
.gt-stat-chip {
  background: var(--gt-cream);
  border: 1.5px solid var(--gt-border);
  border-radius: 16px;
  padding: calc(var(--sp) * 2) calc(var(--sp) * 1.5);
  text-align: center;
  transition: all 0.22s ease;
}
.gt-stat-chip:hover {
  border-color: rgba(76,222,128,0.45);
  background: var(--gt-lime-soft);
  transform: translateY(-2px);
}
.gt-stat-chip-val {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.3rem;
  color: var(--gt-text);
  line-height: 1;
}
.gt-stat-chip-label {
  font-family: var(--gt-font-body);
  font-size: 0.68rem;
  color: var(--gt-muted);
  font-weight: 500;
  margin-top: 3px;
}

/* Sidebar divider */
.gt-sidebar-divider {
  height: 1px;
  background: var(--gt-border);
  margin: calc(var(--sp) * 2.5) 0;
}

/* Sidebar nav links */
.gt-sidebar-nav a {
  display: flex;
  align-items: center;
  gap: calc(var(--sp) * 1.5);
  font-family: var(--gt-font-body);
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--gt-muted);
  text-decoration: none;
  padding: calc(var(--sp) * 1.25) calc(var(--sp) * 1.5);
  border-radius: 12px;
  transition: all 0.2s ease;
  margin-bottom: 4px;
}
.gt-sidebar-nav a:hover,
.gt-sidebar-nav a.active {
  background: var(--gt-lime-soft);
  color: var(--gt-green);
}
.gt-sidebar-nav a .bi {
  width: 20px;
  text-align: center;
  font-size: 1rem;
  flex-shrink: 0;
}
.gt-sidebar-nav a .nav-arrow {
  margin-left: auto;
  font-size: 0.75rem;
  opacity: 0;
  transform: translateX(-4px);
  transition: all 0.2s;
}
.gt-sidebar-nav a:hover .nav-arrow {
  opacity: 1;
  transform: translateX(0);
}

/* ── Main content cards ── */
.gt-main-stack {
  display: flex;
  flex-direction: column;
  gap: calc(var(--sp) * 3);
}

/* Card header */
.gt-card-header {
  padding: calc(var(--sp) * 3) calc(var(--sp) * 4);
  border-bottom: 1.5px solid var(--gt-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}
.gt-card-header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}
.gt-card-header-icon {
  width: 40px; height: 40px;
  border-radius: 12px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.05rem;
  color: var(--gt-green);
  flex-shrink: 0;
}
.gt-card-header-title {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1rem;
  color: var(--gt-text);
  margin: 0;
}
.gt-card-header-sub {
  font-family: var(--gt-font-body);
  font-size: 0.78rem;
  color: var(--gt-muted);
  margin-top: 2px;
}

/* Card body */
.gt-card-body {
  padding: calc(var(--sp) * 4);
}

/* Info rows */
.gt-info-list {
  display: flex;
  flex-direction: column;
  gap: 0;
}
.gt-info-row {
  display: grid;
  grid-template-columns: 200px 1fr;
  align-items: center;
  padding: calc(var(--sp) * 2.5) 0;
  border-bottom: 1px solid var(--gt-border);
  gap: 16px;
  transition: background 0.18s;
}
.gt-info-row:last-child { border-bottom: none; }
.gt-info-row:hover { background: rgba(212,247,226,0.18); margin: 0 calc(var(--sp) * -4); padding-left: calc(var(--sp) * 4); padding-right: calc(var(--sp) * 4); border-radius: 10px; }

.gt-info-label {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: var(--gt-font-body);
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--gt-muted);
  text-transform: uppercase;
  letter-spacing: 0.06em;
}
.gt-info-label .bi {
  width: 32px; height: 32px;
  border-radius: 10px;
  background: var(--gt-cream);
  border: 1.5px solid var(--gt-border);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.85rem;
  color: var(--gt-green);
  flex-shrink: 0;
}
.gt-info-val {
  font-family: var(--gt-font-body);
  font-size: 0.9rem;
  font-weight: 500;
  color: var(--gt-text);
}
.gt-info-val.empty {
  color: #aac5b5;
  font-style: italic;
  font-weight: 400;
}

/* Empty state pill */
.gt-empty-pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.78rem;
  color: #aac5b5;
  background: var(--gt-cream);
  border: 1.5px dashed rgba(26,107,60,0.14);
  padding: 4px 12px;
  border-radius: 50px;
  font-family: var(--gt-font-body);
}

/* Edit button */
.gt-edit-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.82rem;
  padding: 9px 20px;
  border-radius: 50px;
  background: var(--gt-green);
  color: #fff;
  border: none;
  text-decoration: none;
  transition: all 0.24s ease;
  box-shadow: 0 4px 14px rgba(26,107,60,0.28);
}
.gt-edit-btn:hover {
  background: var(--gt-green-mid);
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(26,107,60,0.35);
}
.gt-edit-btn .bi { font-size: 0.85rem; }

/* Secondary button */
.gt-sec-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.82rem;
  padding: 8px 18px;
  border-radius: 50px;
  background: transparent;
  color: var(--gt-muted);
  border: 1.5px solid var(--gt-border-mid);
  text-decoration: none;
  transition: all 0.22s ease;
}
.gt-sec-btn:hover {
  border-color: rgba(26,107,60,0.28);
  color: var(--gt-green);
  background: var(--gt-lime-soft);
}

/* Activity timeline */
.gt-timeline {
  display: flex;
  flex-direction: column;
  gap: 0;
}
.gt-timeline-item {
  display: grid;
  grid-template-columns: 36px 1fr;
  gap: 16px;
  padding: calc(var(--sp) * 2) 0;
  position: relative;
}
.gt-timeline-item:not(:last-child)::after {
  content: '';
  position: absolute;
  left: 18px;
  top: calc(var(--sp) * 2 + 36px);
  width: 1px;
  height: calc(100% - 36px - var(--sp) * 2);
  background: var(--gt-border);
  transform: translateX(-50%);
}
.gt-timeline-dot {
  width: 36px; height: 36px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.9rem;
  flex-shrink: 0;
}
.gt-timeline-dot.green { background: var(--gt-lime-soft); color: var(--gt-green); }
.gt-timeline-dot.blue  { background: #e8f0fe; color: #4285f4; }
.gt-timeline-dot.amber { background: #fff8e1; color: #f59e0b; }
.gt-timeline-content-title {
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.875rem;
  color: var(--gt-text);
  line-height: 1.3;
}
.gt-timeline-content-sub {
  font-family: var(--gt-font-body);
  font-size: 0.75rem;
  color: var(--gt-muted);
  margin-top: 2px;
}

/* Responsive */
@media (max-width: 600px) {
  .gt-info-row { grid-template-columns: 1fr; }
  .gt-card-body { padding: calc(var(--sp) * 3); }
  .gt-card-header { padding: calc(var(--sp) * 2.5) calc(var(--sp) * 3); }
  .gt-info-row:hover { margin: 0; padding-left: 0; padding-right: 0; }
  .gt-stat-chips { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="gt-profile-page">
  <div class="gt-pg-grid"></div>

  <div class="container position-relative" style="z-index:2;">

    {{-- Back button --}}
    <a href="{{ url('/') }}" class="gt-back">
      <i class="bi bi-arrow-left"></i>
      Kembali ke Beranda
    </a>

    <div class="gt-profile-layout">

      {{-- ── SIDEBAR ── --}}
      <aside>
        <div class="gt-card gt-sidebar-card">

          {{-- Avatar banner --}}
          <div class="gt-avatar-section">
            <div class="gt-avatar-ring">
              <img src="{{ $user->foto_profil_url }}" alt="Foto Profil">
            </div>
            <div class="gt-sidebar-name">{{ $user->name }}</div>
            <div class="gt-sidebar-email">{{ $user->email }}</div>
            @php
              $roleClass = match($user->role) {
                'admin' => 'admin',
                'guru'  => 'guru',
                default => 'siswa',
              };
              $roleIcon = match($user->role) {
                'admin' => 'bi-shield-fill',
                'guru'  => 'bi-mortarboard-fill',
                default => 'bi-person-fill',
              };
            @endphp
            <span class="gt-role-badge {{ $roleClass }}">
              <i class="bi {{ $roleIcon }}"></i>
              {{ ucfirst($user->role) }}
            </span>
          </div>

          {{-- Sidebar body --}}
          <div class="gt-sidebar-body">

            {{-- Quick stats --}}
            @if($user->role === 'siswa')
            <div class="gt-stat-chips">
              <div class="gt-stat-chip">
                <div class="gt-stat-chip-val">{{ $user->kelas()->count() }}</div>
                <div class="gt-stat-chip-label">Kelas</div>
              </div>
              <div class="gt-stat-chip">
                <div class="gt-stat-chip-val">{{ $user->kelas()->withCount('tugas')->get()->sum('tugas_count') }}</div>
                <div class="gt-stat-chip-label">Tugas</div>
              </div>
            </div>
            @endif

            <div class="gt-sidebar-divider"></div>

            {{-- Nav --}}
            <nav class="gt-sidebar-nav">
              <a href="{{ route('profil') }}" class="active">
                <i class="bi bi-person-circle"></i>
                Profil Saya
                <i class="bi bi-chevron-right nav-arrow"></i>
              </a>
              <a href="{{ route('profil.edit') }}">
                <i class="bi bi-pencil-square"></i>
                Edit Profil
                <i class="bi bi-chevron-right nav-arrow"></i>
              </a>
              @if($user->role === 'siswa')
              <a href="{{ url('/') }}#services">
                <i class="bi bi-easel2-fill"></i>
                Kelas Saya
                <i class="bi bi-chevron-right nav-arrow"></i>
              </a>
              @endif
              <div class="gt-sidebar-divider"></div>
              <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" style="
                  all: unset;
                  display: flex;
                  align-items: center;
                  gap: 12px;
                  width: 100%;
                  font-family: var(--gt-font-body);
                  font-size: 0.875rem;
                  font-weight: 500;
                  color: #e53935;
                  padding: 10px 12px;
                  border-radius: 12px;
                  transition: background 0.2s;
                  cursor: pointer;
                ">
                  <i class="bi bi-box-arrow-right" style="width:20px;text-align:center;font-size:1rem;"></i>
                  Keluar
                </button>
              </form>
            </nav>

          </div>
        </div>
      </aside>

      {{-- ── MAIN CONTENT ── --}}
      <div class="gt-main-stack">

        {{-- Card: Info Pribadi --}}
        <div class="gt-card" style="animation-delay:0.08s;">
          <div class="gt-card-header">
            <div class="gt-card-header-left">
              <div class="gt-card-header-icon">
                <i class="bi bi-person-vcard-fill"></i>
              </div>
              <div>
                <div class="gt-card-header-title">Informasi Pribadi</div>
                <div class="gt-card-header-sub">Data diri & kontak kamu</div>
              </div>
            </div>
            <a href="{{ route('profil.edit') }}" class="gt-edit-btn">
              <i class="bi bi-pencil-fill"></i>
              Edit Profil
            </a>
          </div>

          <div class="gt-card-body">
            <div class="gt-info-list">

              <div class="gt-info-row">
                <div class="gt-info-label">
                  <i class="bi bi-person-fill"></i>
                  Nama Lengkap
                </div>
                <div class="gt-info-val">{{ $user->name }}</div>
              </div>

              <div class="gt-info-row">
                <div class="gt-info-label">
                  <i class="bi bi-envelope-fill"></i>
                  Email
                </div>
                <div class="gt-info-val">{{ $user->email }}</div>
              </div>

              <div class="gt-info-row">
                <div class="gt-info-label">
                  <i class="bi bi-telephone-fill"></i>
                  No Telepon
                </div>
                <div class="gt-info-val">
                  @if($user->no_telepon)
                    {{ $user->no_telepon }}
                  @else
                    <span class="gt-empty-pill">
                      <i class="bi bi-plus-circle"></i> Belum diisi
                    </span>
                  @endif
                </div>
              </div>

              <div class="gt-info-row">
                <div class="gt-info-label">
                  <i class="bi bi-geo-alt-fill"></i>
                  Alamat
                </div>
                <div class="gt-info-val">
                  @if($user->alamat)
                    {{ $user->alamat }}
                  @else
                    <span class="gt-empty-pill">
                      <i class="bi bi-plus-circle"></i> Belum diisi
                    </span>
                  @endif
                </div>
              </div>

              <div class="gt-info-row">
                <div class="gt-info-label">
                  <i class="bi bi-shield-fill-check"></i>
                  Peran
                </div>
                <div class="gt-info-val">{{ ucfirst($user->role) }}</div>
              </div>

            </div>
          </div>
        </div>

        {{-- Card: Aktivitas Terbaru (optional decorative) --}}
        <div class="gt-card" style="animation-delay:0.16s;">
          <div class="gt-card-header">
            <div class="gt-card-header-left">
              <div class="gt-card-header-icon">
                <i class="bi bi-activity"></i>
              </div>
              <div>
                <div class="gt-card-header-title">Aktivitas Terbaru</div>
                <div class="gt-card-header-sub">Riwayat kegiatan kamu di GoTugas</div>
              </div>
            </div>
          </div>
          <div class="gt-card-body">
            <div class="gt-timeline">
              @if($user->role === 'siswa')
                @forelse($user->kelas()->latest('kelas_siswa.created_at')->take(3)->get() as $kelas)
                <div class="gt-timeline-item">
                  <div class="gt-timeline-dot green"><i class="bi bi-easel2-fill"></i></div>
                  <div>
                    <div class="gt-timeline-content-title">Bergabung ke kelas <strong>{{ $kelas->nama_kelas }}</strong></div>
                    <div class="gt-timeline-content-sub">{{ $kelas->mapel->nama_mapel ?? '-' }} · {{ $kelas->pivot->created_at->diffForHumans() }}</div>
                  </div>
                </div>
                @empty
                <div style="text-align:center;padding:32px 0;color:var(--gt-muted);font-family:var(--gt-font-body);font-size:0.875rem;">
                  <i class="bi bi-clock-history" style="font-size:2rem;display:block;margin-bottom:8px;opacity:0.4;"></i>
                  Belum ada aktivitas
                </div>
                @endforelse
              @else
              <div class="gt-timeline-item">
                <div class="gt-timeline-dot green"><i class="bi bi-check2-circle"></i></div>
                <div>
                  <div class="gt-timeline-content-title">Akun berhasil dibuat</div>
                  <div class="gt-timeline-content-sub">{{ $user->created_at->diffForHumans() }}</div>
                </div>
              </div>
              @endif

              <div class="gt-timeline-item">
                <div class="gt-timeline-dot blue"><i class="bi bi-person-check-fill"></i></div>
                <div>
                  <div class="gt-timeline-content-title">Profil terdaftar di GoTugas</div>
                  <div class="gt-timeline-content-sub">{{ $user->created_at->format('d M Y') }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>{{-- /gt-main-stack --}}
    </div>{{-- /gt-profile-layout --}}
  </div>{{-- /container --}}
</div>{{-- /gt-profile-page --}}

@endsection