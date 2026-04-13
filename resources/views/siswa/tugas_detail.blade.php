@extends('layouts.frontend')

@section('content')

<style>
:root {
  --gt-green:      #1a6b3c;
  --gt-green-mid:  #22883f;
  --gt-lime:       #4cde80;
  --gt-lime-soft:  #d4f7e2;
  --gt-cream:      #f6fbf8;
  --gt-text:       #12291d;
  --gt-muted:      #6b8a77;
  --gt-border:     rgba(26,107,60,0.12);
  --gt-shadow:     0 4px 32px rgba(26,107,60,0.10);
  --gt-font-d:     'Raleway', sans-serif;
  --gt-font-b:     'Ubuntu', sans-serif;
}

.gt-page {
  min-height: calc(100vh - 66px);
  background: var(--gt-cream);
  padding: 48px 0 80px;
  position: relative;
  overflow: hidden;
}
.gt-page::before {
  content: '';
  position: absolute;
  width: 480px; height: 480px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.12) 0%, transparent 65%);
  top: -120px; right: -80px;
  pointer-events: none;
}
.gt-dot-grid {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.08) 1px, transparent 1px);
  background-size: 28px 28px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black, transparent);
  pointer-events: none;
}

/* Back button */
.gt-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: var(--gt-font-b);
  font-size: 0.82rem; font-weight: 600;
  color: var(--gt-muted); text-decoration: none;
  padding: 7px 16px;
  border-radius: 50px;
  background: rgba(255,255,255,0.85);
  border: 1.5px solid var(--gt-border);
  margin-bottom: 28px;
  transition: all 0.22s ease;
  backdrop-filter: blur(8px);
}
.gt-back:hover {
  color: var(--gt-green);
  border-color: rgba(26,107,60,0.28);
  background: var(--gt-lime-soft);
  transform: translateX(-3px);
}

/* Layout */
.gt-layout {
  display: grid;
  grid-template-columns: 1fr 360px;
  gap: 24px;
  align-items: start;
}
@media (max-width: 900px) {
  .gt-layout { grid-template-columns: 1fr; }
}

/* Card base */
.gt-card {
  background: rgba(255,255,255,0.97);
  border-radius: 24px;
  border: 1.5px solid var(--gt-border);
  box-shadow: var(--gt-shadow);
  overflow: hidden;
  animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes fadeUp {
  from { opacity:0; transform: translateY(20px); }
  to   { opacity:1; transform: translateY(0); }
}

/* Hero header card */
.gt-hero-header {
  background: linear-gradient(135deg, var(--gt-green) 0%, var(--gt-green-mid) 100%);
  padding: 32px 36px;
  position: relative;
  overflow: hidden;
}
.gt-hero-header::before {
  content: '';
  position: absolute;
  width: 220px; height: 220px; border-radius: 50%;
  background: rgba(255,255,255,0.05);
  top: -70px; right: -50px;
}
.gt-hpat {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
  background-size: 18px 18px;
}
.gt-hero-icon {
  width: 52px; height: 52px;
  border-radius: 16px;
  background: rgba(255,255,255,0.18);
  border: 2px solid rgba(255,255,255,0.28);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem;
  margin-bottom: 16px;
  position: relative; z-index: 1;
}
.gt-hero-title {
  font-family: var(--gt-font-d);
  font-weight: 800; font-size: 1.35rem;
  color: #fff; margin: 0 0 6px;
  position: relative; z-index: 1;
  line-height: 1.25;
}
.gt-hero-cmd {
  font-family: var(--gt-font-b);
  font-size: 0.9rem;
  color: rgba(255,255,255,0.8);
  margin: 0 0 16px;
  position: relative; z-index: 1;
}
.gt-hero-chips {
  display: flex; flex-wrap: wrap; gap: 8px;
  position: relative; z-index: 1;
}
.gt-chip {
  display: inline-flex; align-items: center; gap: 5px;
  font-family: var(--gt-font-b);
  font-size: 0.76rem; font-weight: 600;
  padding: 5px 12px;
  border-radius: 50px;
}
.gt-chip.white  { background: rgba(255,255,255,0.18); color: #fff; border: 1px solid rgba(255,255,255,0.28); }
.gt-chip.danger { background: rgba(229,57,53,0.2); color: #ffcdd2; border: 1px solid rgba(229,57,53,0.35); }
.gt-chip.warn   { background: rgba(251,191,36,0.2); color: #fde68a; border: 1px solid rgba(251,191,36,0.35); }
.gt-chip.ok     { background: rgba(76,222,128,0.2); color: #d4f7e2; border: 1px solid rgba(76,222,128,0.35); }

/* Card body */
.gt-body { padding: 32px 36px; }
@media (max-width: 600px) {
  .gt-hero-header { padding: 24px 22px; }
  .gt-body { padding: 22px 20px; }
}

/* Deskripsi */
.gt-desc-label {
  font-family: var(--gt-font-b);
  font-size: 0.72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.08em;
  color: var(--gt-muted); margin-bottom: 10px;
  display: flex; align-items: center; gap: 6px;
}
.gt-desc-label .bi { color: var(--gt-green); font-size: 0.75rem; }
.gt-desc-text {
  font-family: var(--gt-font-b);
  font-size: 0.925rem; color: var(--gt-text);
  line-height: 1.75;
  margin: 0;
}

.gt-divider {
  height: 1px;
  background: var(--gt-border);
  margin: 24px 0;
}

/* Status banner */
.gt-status-banner {
  border-radius: 16px;
  padding: 20px 22px;
  border: 1.5px solid;
  margin-bottom: 0;
}
.gt-status-banner.submitted {
  background: #edf5ff;
  border-color: rgba(21,101,192,0.2);
}
.gt-status-banner.graded {
  background: var(--gt-lime-soft);
  border-color: rgba(26,107,60,0.2);
}
.gt-status-banner.late {
  background: #fff5f5;
  border-color: rgba(192,57,43,0.2);
}
.gt-status-title {
  font-family: var(--gt-font-d);
  font-weight: 700; font-size: 0.95rem;
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 6px;
}
.gt-status-title.submitted { color: #1565c0; }
.gt-status-title.graded    { color: var(--gt-green); }
.gt-status-title.late      { color: #c0392b; }
.gt-status-sub {
  font-family: var(--gt-font-b);
  font-size: 0.85rem; color: var(--gt-muted);
  margin: 0;
}

/* Score big */
.gt-score-wrap {
  display: flex; align-items: center; gap: 16px;
  margin: 16px 0 0;
}
.gt-score-circle {
  width: 72px; height: 72px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--gt-green), var(--gt-green-mid));
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 16px rgba(26,107,60,0.3);
}
.gt-score-num {
  font-family: var(--gt-font-d);
  font-weight: 800; font-size: 1.5rem;
  color: #fff; line-height: 1;
}
.gt-score-info-label {
  font-family: var(--gt-font-b);
  font-size: 0.75rem; color: var(--gt-muted);
  text-transform: uppercase; letter-spacing: 0.06em;
}
.gt-score-info-val {
  font-family: var(--gt-font-d);
  font-weight: 700; font-size: 1.05rem;
  color: var(--gt-green);
}

/* File pill */
.gt-file-pill {
  display: inline-flex; align-items: center; gap: 10px;
  background: var(--gt-cream);
  border: 1.5px solid var(--gt-border);
  border-radius: 12px;
  padding: 12px 16px;
  text-decoration: none;
  color: var(--gt-text);
  font-family: var(--gt-font-b);
  font-size: 0.875rem; font-weight: 500;
  transition: all 0.22s ease;
  margin-top: 12px;
}
.gt-file-pill:hover {
  border-color: rgba(26,107,60,0.3);
  background: var(--gt-lime-soft);
  color: var(--gt-green);
  transform: translateY(-1px);
}
.gt-file-icon-wrap {
  width: 36px; height: 36px;
  border-radius: 10px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  color: var(--gt-green);
  font-size: 1rem;
  flex-shrink: 0;
  transition: background 0.2s;
}
.gt-file-pill:hover .gt-file-icon-wrap {
  background: rgba(26,107,60,0.15);
}

/* Action buttons */
.gt-action-row {
  display: flex; flex-wrap: wrap; gap: 10px;
  margin-top: 20px;
}
.gt-btn {
  display: inline-flex; align-items: center; gap: 7px;
  font-family: var(--gt-font-b);
  font-weight: 600; font-size: 0.875rem;
  padding: 10px 22px;
  border-radius: 50px;
  border: none; cursor: pointer;
  text-decoration: none;
  transition: all 0.22s ease;
}
.gt-btn-edit {
  background: #fff8e1;
  color: #b45309;
  border: 1.5px solid rgba(180,83,9,0.2);
}
.gt-btn-edit:hover {
  background: #fef3c7;
  color: #b45309;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(180,83,9,0.15);
}
.gt-btn-cancel {
  background: #fff0f0;
  color: #c0392b;
  border: 1.5px solid rgba(192,57,43,0.2);
}
.gt-btn-cancel:hover {
  background: #fee2e2;
  color: #c0392b;
  transform: translateY(-1px);
}

/* Upload form */
.gt-section-title {
  font-family: var(--gt-font-d);
  font-weight: 700; font-size: 1rem;
  color: var(--gt-text); margin: 0 0 20px;
  display: flex; align-items: center; gap: 8px;
}
.gt-section-title .bi { color: var(--gt-green); }

.gt-field { margin-bottom: 20px; }
.gt-label {
  font-family: var(--gt-font-b);
  font-size: 0.72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.07em;
  color: var(--gt-muted); margin-bottom: 8px;
  display: block;
}

/* Dropzone */
.gt-drop {
  position: relative;
  border: 2px dashed rgba(26,107,60,0.22);
  border-radius: 16px;
  background: var(--gt-cream);
  padding: 28px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.22s;
}
.gt-drop:hover, .gt-drop.on {
  border-color: var(--gt-lime);
  background: rgba(212,247,226,0.3);
}
.gt-drop input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.gt-drop-icon {
  width: 48px; height: 48px;
  border-radius: 14px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 10px;
  font-size: 1.3rem; color: var(--gt-green);
}
.gt-drop-t {
  font-family: var(--gt-font-b);
  font-weight: 700; font-size: 0.875rem;
  color: var(--gt-text); margin-bottom: 3px;
}
.gt-drop-s {
  font-family: var(--gt-font-b);
  font-size: 0.75rem; color: var(--gt-muted);
}
#gt-fn {
  display: none;
  margin-top: 8px;
  font-family: var(--gt-font-b);
  font-size: 0.75rem; font-weight: 600;
  color: var(--gt-green);
  background: var(--gt-lime-soft);
  padding: 3px 12px; border-radius: 50px;
}

.gt-textarea {
  width: 100%;
  font-family: var(--gt-font-b);
  font-size: 0.9rem; color: var(--gt-text);
  background: var(--gt-cream);
  border: 2px solid var(--gt-border);
  border-radius: 14px;
  padding: 14px 16px;
  resize: vertical; outline: none;
  transition: all 0.22s; min-height: 110px;
}
.gt-textarea::placeholder { color: #aac5b5; }
.gt-textarea:focus { border-color: var(--gt-lime); background: #fff; box-shadow: 0 0 0 4px rgba(76,222,128,0.12); }

.gt-submit-btn {
  width: 100%;
  font-family: var(--gt-font-d);
  font-weight: 700; font-size: 0.925rem;
  padding: 14px;
  border-radius: 14px;
  background: linear-gradient(135deg, var(--gt-green), var(--gt-green-mid));
  color: #fff; border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: all 0.25s;
  box-shadow: 0 4px 18px rgba(26,107,60,0.28);
}
.gt-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(26,107,60,0.36);
}

/* Sidebar card */
.gt-sidebar-card {
  animation-delay: 0.1s;
}
.gt-info-row {
  display: flex; align-items: flex-start; gap: 12px;
  padding: 14px 0;
  border-bottom: 1px solid var(--gt-border);
}
.gt-info-row:last-child { border-bottom: none; }
.gt-info-icon {
  width: 34px; height: 34px;
  border-radius: 10px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  color: var(--gt-green);
  font-size: 0.85rem;
}
.gt-info-label {
  font-family: var(--gt-font-b);
  font-size: 0.72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.06em;
  color: var(--gt-muted); margin-bottom: 2px;
}
.gt-info-val {
  font-family: var(--gt-font-b);
  font-size: 0.875rem; font-weight: 500;
  color: var(--gt-text);
}
.gt-info-val.red { color: #c0392b; font-weight: 600; }

/* Progress bar */
.gt-progress-wrap { margin-top: 20px; }
.gt-progress-label {
  font-family: var(--gt-font-b);
  font-size: 0.72rem; color: var(--gt-muted);
  display: flex; justify-content: space-between;
  margin-bottom: 6px;
}
.gt-progress-track {
  height: 6px; border-radius: 99px;
  background: rgba(26,107,60,0.1);
  overflow: hidden;
}
.gt-progress-fill {
  height: 100%; border-radius: 99px;
  background: linear-gradient(90deg, var(--gt-lime), var(--gt-green));
  transition: width 1s ease;
}
</style>

<div class="gt-page">
  <div class="gt-dot-grid"></div>

  <div class="container position-relative" style="z-index:2;">
    <a href="{{ url()->previous() }}" class="gt-back">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    @php
      use Carbon\Carbon;
      $now      = Carbon::now();
      $deadline = Carbon::parse($tugas->deadline);
      $isLate   = $deadline < $now;
      $diffDays = $now->diffInDays($deadline, false);
      $pengumpulan = $tugas->pengumpulan_tugas->where('siswa_id', Auth::id())->first();

      if ($isLate)          { $deadlineClass = 'danger'; $deadlineText = 'Sudah lewat'; }
      elseif ($diffDays <= 2) { $deadlineClass = 'warn';   $deadlineText = 'Segera!'; }
      else                  { $deadlineClass = 'ok';     $deadlineText = 'Masih ada waktu'; }
    @endphp

    <div class="gt-layout">

      {{-- ── MAIN CARD ─────────────────────── --}}
      <div>
        <div class="gt-card">

          {{-- Hero header --}}
          <div class="gt-hero-header">
            <div class="gt-hpat"></div>
            <div class="gt-hero-icon">📋</div>
            <h1 class="gt-hero-title">{{ $tugas->judul }}</h1>
            <p class="gt-hero-cmd">{{ $tugas->perintah }}</p>
            <div class="gt-hero-chips">
              <span class="gt-chip {{ $deadlineClass }}">
                <i class="bi bi-clock-fill" style="font-size:0.7rem;"></i>
                {{ $deadline->translatedFormat('d M Y, H:i') }}
              </span>
              <span class="gt-chip white">
                <i class="bi bi-info-circle" style="font-size:0.7rem;"></i>
                {{ $deadlineText }}
              </span>
            </div>
          </div>

          {{-- Body --}}
          <div class="gt-body">

            {{-- Deskripsi --}}
            <div class="gt-desc-label">
              <i class="bi bi-text-left"></i> Deskripsi Tugas
            </div>
            <p class="gt-desc-text">{{ $tugas->deskripsi }}</p>

            <div class="gt-divider"></div>

            {{-- ── STATUS: LEWAT DEADLINE & BELUM KUMPUL ── --}}
            @if ($isLate && !$pengumpulan)
              <div class="gt-status-banner late">
                <div class="gt-status-title late">
                  <i class="bi bi-exclamation-octagon-fill"></i>
                  Deadline Terlewat
                </div>
                <p class="gt-status-sub">
                  Batas waktu pengumpulan sudah berakhir pada
                  {{ $deadline->translatedFormat('d F Y, H:i') }}.
                  Tugas ini tidak lagi bisa dikumpulkan.
                </p>
              </div>

            {{-- ── STATUS: SUDAH KUMPUL ── --}}
            @elseif ($pengumpulan)

              @if ($pengumpulan->status === 'dinilai')
                <div class="gt-status-banner graded">
                  <div class="gt-status-title graded">
                    <i class="bi bi-patch-check-fill"></i>
                    Tugas Sudah Dinilai
                  </div>
                  <div class="gt-score-wrap">
                    <div class="gt-score-circle">
                      <span class="gt-score-num">{{ $pengumpulan->nilai }}</span>
                    </div>
                    <div>
                      <div class="gt-score-info-label">Nilai Kamu</div>
                      <div class="gt-score-info-val">
                        @if($pengumpulan->nilai >= 80) Sangat Baik 🎉
                        @elseif($pengumpulan->nilai >= 60) Baik 👍
                        @else Perlu Peningkatan 📚
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

              @else
                <div class="gt-status-banner submitted">
                  <div class="gt-status-title submitted">
                    <i class="bi bi-send-check-fill"></i>
                    Tugas Sudah Dikumpulkan
                  </div>
                  <p class="gt-status-sub">
                    Dikumpulkan {{ $pengumpulan->created_at->diffForHumans() }}. Menunggu penilaian dari guru.
                  </p>
                </div>
              @endif

              {{-- File & catatan --}}
              <div style="margin-top: 20px;">
                @if($pengumpulan->catatan)
                  <div class="gt-desc-label"><i class="bi bi-chat-left-text-fill"></i> Catatanmu</div>
                  <p class="gt-desc-text" style="margin-bottom:12px;">{{ $pengumpulan->catatan }}</p>
                @endif

                <div class="gt-desc-label" style="margin-top:12px;"><i class="bi bi-paperclip"></i> File Dikumpulkan</div>
                <a href="{{ asset('storage/' . $pengumpulan->file) }}"
                   target="_blank" class="gt-file-pill">
                  <span class="gt-file-icon-wrap">
                    <i class="bi bi-file-earmark-fill"></i>
                  </span>
                  <span>{{ basename($pengumpulan->file) }}</span>
                  <i class="bi bi-box-arrow-up-right ms-auto" style="font-size:0.8rem;opacity:0.6;"></i>
                </a>
              </div>

              {{-- Edit & batalkan (hanya jika belum dinilai) --}}
              @if ($pengumpulan->status === 'dikirim')
                <div class="gt-action-row">
                  <a href="{{ route('siswa.tugas.edit', $pengumpulan->id) }}" class="gt-btn gt-btn-edit">
                    <i class="bi bi-pencil-square"></i> Edit Pengumpulan
                  </a>
                  <form method="POST"
                        action="{{ route('siswa.tugas.batalkan', $pengumpulan->id) }}"
                        onsubmit="return confirm('Yakin ingin membatalkan pengumpulan?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="gt-btn gt-btn-cancel">
                      <i class="bi bi-x-circle"></i> Batalkan
                    </button>
                  </form>
                </div>
              @endif

            {{-- ── FORM KUMPUL ── --}}
            @else
              <div class="gt-section-title">
                <i class="bi bi-upload"></i> Kumpulkan Tugas
              </div>

              <form method="POST"
                    action="{{ route('siswa.tugas.kumpulkan', $tugas->id) }}"
                    enctype="multipart/form-data">
                @csrf

                <div class="gt-field">
                  <label class="gt-label">Upload File</label>
                  <div class="gt-drop" id="gt-drop">
                    <input type="file" name="file" id="gt-file" required>
                    <div class="gt-drop-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                    <div class="gt-drop-t">Klik atau seret file ke sini</div>
                    <div class="gt-drop-s">PDF, DOCX, JPG, PNG — maks 10 MB</div>
                    <span id="gt-fn"></span>
                  </div>
                </div>

                <div class="gt-field">
                  <label class="gt-label" for="catatan">Catatan (opsional)</label>
                  <textarea name="catatan" id="catatan" class="gt-textarea"
                            placeholder="Tulis keterangan atau catatan untuk guru..."></textarea>
                </div>

                <button type="submit" class="gt-submit-btn">
                  <i class="bi bi-send-check-fill"></i>
                  Kumpulkan Sekarang
                </button>
              </form>
            @endif

          </div>
        </div>
      </div>

      {{-- ── SIDEBAR ─────────────────────── --}}
      <div>
        <div class="gt-card gt-sidebar-card">
          <div class="gt-body" style="padding: 24px;">

            <div class="gt-section-title" style="margin-bottom:16px;">
              <i class="bi bi-info-circle-fill"></i> Info Tugas
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-calendar3"></i></span>
              <div>
                <div class="gt-info-label">Deadline</div>
                <div class="gt-info-val {{ $isLate ? 'red' : '' }}">
                  {{ $deadline->translatedFormat('d M Y') }}
                  <br>
                  <span style="font-size:0.8rem;">{{ $deadline->format('H:i') }} WIB</span>
                </div>
              </div>
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-hourglass-split"></i></span>
              <div>
                <div class="gt-info-label">Sisa Waktu</div>
                <div class="gt-info-val {{ $isLate ? 'red' : '' }}">
                  @if($isLate)
                    Sudah lewat {{ $deadline->diffForHumans() }}
                  @else
                    {{ $deadline->diffForHumans() }}
                  @endif
                </div>
              </div>
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-clipboard2-check-fill"></i></span>
              <div>
                <div class="gt-info-label">Status</div>
                <div class="gt-info-val">
                  @if ($pengumpulan)
                    @if($pengumpulan->status === 'dinilai')
                      <span style="color:var(--gt-green);">✓ Dinilai</span>
                    @else
                      <span style="color:#1565c0;">↑ Sudah dikumpulkan</span>
                    @endif
                  @elseif($isLate)
                    <span style="color:#c0392b;">✗ Tidak dikumpulkan</span>
                  @else
                    <span style="color:var(--gt-muted);">Belum dikumpulkan</span>
                  @endif
                </div>
              </div>
            </div>

            @if($pengumpulan?->nilai)
              <div class="gt-info-row">
                <span class="gt-info-icon"><i class="bi bi-star-fill"></i></span>
                <div>
                  <div class="gt-info-label">Nilai</div>
                  <div class="gt-info-val" style="color:var(--gt-green);font-size:1.1rem;font-weight:700;">
                    {{ $pengumpulan->nilai }} <span style="font-size:0.75rem;font-weight:400;color:var(--gt-muted);">/ 100</span>
                  </div>
                </div>
              </div>

              {{-- Progress bar nilai --}}
              <div class="gt-progress-wrap">
                <div class="gt-progress-label">
                  <span>Nilai</span><span>{{ $pengumpulan->nilai }}/100</span>
                </div>
                <div class="gt-progress-track">
                  <div class="gt-progress-fill" id="pbar" style="width:0%;"></div>
                </div>
              </div>
            @endif

          </div>
        </div>

        {{-- Tips card --}}
        @if (!$pengumpulan && !$isLate)
          <div class="gt-card" style="margin-top:16px;animation-delay:0.2s;">
            <div class="gt-body" style="padding:22px 24px;">
              <div class="gt-section-title" style="margin-bottom:14px;">
                <i class="bi bi-lightbulb-fill" style="color:#f59e0b;"></i>
                <span style="font-size:0.9rem;">Tips</span>
              </div>
              <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:9px;">
                @foreach(['Pastikan file tidak melebihi 10 MB', 'Cek kembali perintah tugas sebelum submit', 'Simpan salinan file untuk arsip pribadi'] as $tip)
                  <li style="display:flex;align-items:flex-start;gap:8px;font-family:var(--gt-font-b);font-size:0.83rem;color:var(--gt-muted);">
                    <i class="bi bi-check2-circle" style="color:var(--gt-green);font-size:0.85rem;margin-top:2px;flex-shrink:0;"></i>
                    {{ $tip }}
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
      </div>

    </div>
  </div>
</div>

<script>
  const drop = document.getElementById('gt-drop');
  const fi   = document.getElementById('gt-file');
  const fn   = document.getElementById('gt-fn');

  if (fi) {
    fi.addEventListener('change', function() {
      if (this.files[0]) {
        fn.textContent = this.files[0].name;
        fn.style.display = 'inline-block';
      }
    });
    drop?.addEventListener('dragover', e => { e.preventDefault(); drop.classList.add('on'); });
    drop?.addEventListener('dragleave', () => drop.classList.remove('on'));
    drop?.addEventListener('drop', e => {
      e.preventDefault(); drop.classList.remove('on');
      fi.files = e.dataTransfer.files;
      if (fi.files[0]) { fn.textContent = fi.files[0].name; fn.style.display = 'inline-block'; }
    });
  }

  // Animate progress bar
  const pbar = document.getElementById('pbar');
  if (pbar) {
    setTimeout(() => { pbar.style.width = '{{ $pengumpulan?->nilai ?? 0 }}%'; }, 300);
  }
</script>

@endsection