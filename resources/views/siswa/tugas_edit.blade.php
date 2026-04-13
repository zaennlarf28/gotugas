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
  position: relative; overflow: hidden;
}
.gt-page::before {
  content: '';
  position: absolute;
  width: 480px; height: 480px; border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.12) 0%, transparent 65%);
  top: -120px; right: -80px; pointer-events: none;
}
.gt-dot-grid {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.08) 1px, transparent 1px);
  background-size: 28px 28px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black, transparent);
  pointer-events: none;
}

/* Back */
.gt-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: var(--gt-font-b);
  font-size: 0.82rem; font-weight: 600;
  color: var(--gt-muted); text-decoration: none;
  padding: 7px 16px; border-radius: 50px;
  background: rgba(255,255,255,0.85);
  border: 1.5px solid var(--gt-border);
  margin-bottom: 28px;
  transition: all 0.22s ease; backdrop-filter: blur(8px);
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
  grid-template-columns: 1fr 320px;
  gap: 24px; align-items: start;
}
@media (max-width: 860px) {
  .gt-layout { grid-template-columns: 1fr; }
}

/* Card */
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

/* Card header — AMBER untuk edit (beda dari green detail) */
.gt-edit-header {
  background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
  padding: 28px 36px;
  position: relative; overflow: hidden;
}
.gt-edit-header::before {
  content: '';
  position: absolute;
  width: 200px; height: 200px; border-radius: 50%;
  background: rgba(255,255,255,0.06);
  top: -60px; right: -40px;
}
.gt-hpat {
  position: absolute; inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
  background-size: 18px 18px;
}
.gt-header-icon {
  width: 50px; height: 50px;
  border-radius: 15px;
  background: rgba(255,255,255,0.18);
  border: 2px solid rgba(255,255,255,0.28);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.35rem; margin-bottom: 14px;
  position: relative; z-index: 1;
}
.gt-header-title {
  font-family: var(--gt-font-d);
  font-weight: 800; font-size: 1.25rem;
  color: #fff; margin: 0 0 4px;
  position: relative; z-index: 1;
}
.gt-header-sub {
  font-family: var(--gt-font-b);
  font-size: 0.84rem; color: rgba(255,255,255,0.75);
  margin: 0; position: relative; z-index: 1;
}

/* Body */
.gt-body { padding: 32px 36px; }
@media (max-width: 600px) {
  .gt-edit-header { padding: 22px 20px; }
  .gt-body { padding: 22px 20px; }
}

.gt-divider { height: 1px; background: var(--gt-border); margin: 24px 0; }

/* Tugas info strip (referensi dari detail) */
.gt-tugas-strip {
  display: flex; align-items: flex-start; gap: 14px;
  background: var(--gt-cream);
  border: 1.5px solid var(--gt-border);
  border-radius: 16px;
  padding: 16px 18px;
  margin-bottom: 28px;
}
.gt-tugas-strip-icon {
  width: 44px; height: 44px;
  border-radius: 13px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; font-size: 1.1rem; color: var(--gt-green);
}
.gt-tugas-strip-title {
  font-family: var(--gt-font-d);
  font-weight: 700; font-size: 0.95rem;
  color: var(--gt-text); margin-bottom: 3px;
}
.gt-tugas-strip-meta {
  font-family: var(--gt-font-b);
  font-size: 0.78rem; color: var(--gt-muted);
  display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
}
.gt-tugas-strip-meta .bi { font-size: 0.72rem; }

/* Form fields */
.gt-field { margin-bottom: 22px; }
.gt-label {
  font-family: var(--gt-font-b);
  font-size: 0.72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.07em;
  color: var(--gt-muted); margin-bottom: 8px;
  display: block;
}

/* Current file */
.gt-current-file {
  display: flex; align-items: center; gap: 12px;
  background: #fff8e1;
  border: 1.5px solid rgba(180,83,9,0.18);
  border-radius: 14px;
  padding: 14px 16px;
  margin-bottom: 12px;
}
.gt-cf-icon {
  width: 38px; height: 38px; border-radius: 11px;
  background: rgba(180,83,9,0.1);
  display: flex; align-items: center; justify-content: center;
  color: #b45309; font-size: 1rem; flex-shrink: 0;
}
.gt-cf-label {
  font-family: var(--gt-font-b);
  font-size: 0.7rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.06em;
  color: #b45309; margin-bottom: 2px;
}
.gt-cf-name {
  font-family: var(--gt-font-b);
  font-size: 0.85rem; color: var(--gt-text); font-weight: 500;
}
.gt-cf-view {
  margin-left: auto;
  font-family: var(--gt-font-b);
  font-size: 0.78rem; font-weight: 600;
  color: #b45309;
  background: rgba(180,83,9,0.1);
  border: 1.5px solid rgba(180,83,9,0.2);
  padding: 5px 14px; border-radius: 50px;
  text-decoration: none; transition: all 0.2s;
}
.gt-cf-view:hover { background: rgba(180,83,9,0.18); color: #b45309; }

/* Dropzone */
.gt-drop {
  position: relative;
  border: 2px dashed rgba(26,107,60,0.22);
  border-radius: 16px;
  background: var(--gt-cream);
  padding: 26px 20px;
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
  width: 46px; height: 46px; border-radius: 14px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 10px;
  font-size: 1.2rem; color: var(--gt-green);
}
.gt-drop-t { font-family: var(--gt-font-b); font-weight: 700; font-size: 0.875rem; color: var(--gt-text); margin-bottom: 3px; }
.gt-drop-s { font-family: var(--gt-font-b); font-size: 0.75rem; color: var(--gt-muted); }
#gt-fn {
  display: none; margin-top: 8px;
  font-family: var(--gt-font-b); font-size: 0.75rem; font-weight: 600;
  color: var(--gt-green); background: var(--gt-lime-soft);
  padding: 3px 12px; border-radius: 50px;
}

/* Textarea */
.gt-textarea {
  width: 100%;
  font-family: var(--gt-font-b); font-size: 0.9rem; color: var(--gt-text);
  background: var(--gt-cream);
  border: 2px solid var(--gt-border);
  border-radius: 14px; padding: 14px 16px;
  resize: vertical; outline: none;
  transition: all 0.22s; min-height: 110px;
}
.gt-textarea::placeholder { color: #aac5b5; }
.gt-textarea:focus { border-color: var(--gt-lime); background: #fff; box-shadow: 0 0 0 4px rgba(76,222,128,0.12); }

/* Actions */
.gt-actions {
  display: flex; align-items: center; justify-content: flex-end;
  gap: 10px; margin-top: 28px; padding-top: 22px;
  border-top: 1px solid var(--gt-border); flex-wrap: wrap;
}
.gt-save-btn {
  display: inline-flex; align-items: center; gap: 8px;
  font-family: var(--gt-font-d); font-weight: 700; font-size: 0.9rem;
  padding: 12px 28px; border-radius: 14px;
  background: linear-gradient(135deg, #b45309, #d97706);
  color: #fff; border: none; cursor: pointer;
  transition: all 0.25s;
  box-shadow: 0 4px 16px rgba(180,83,9,0.28);
}
.gt-save-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(180,83,9,0.36);
}
.gt-cancel-btn {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: var(--gt-font-b); font-weight: 600; font-size: 0.875rem;
  padding: 11px 22px; border-radius: 14px;
  background: transparent; color: var(--gt-muted);
  border: 1.5px solid var(--gt-border); text-decoration: none;
  transition: all 0.22s;
}
.gt-cancel-btn:hover {
  color: var(--gt-text);
  border-color: rgba(26,107,60,0.22);
  background: var(--gt-cream);
}

/* Sidebar */
.gt-sidebar { animation-delay: 0.1s; }
.gt-section-title {
  font-family: var(--gt-font-d); font-weight: 700; font-size: 0.95rem;
  color: var(--gt-text); margin: 0 0 18px;
  display: flex; align-items: center; gap: 8px;
}

/* Info rows */
.gt-info-row {
  display: flex; align-items: flex-start; gap: 12px;
  padding: 12px 0; border-bottom: 1px solid var(--gt-border);
}
.gt-info-row:last-child { border-bottom: none; }
.gt-info-icon {
  width: 32px; height: 32px; border-radius: 9px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; color: var(--gt-green); font-size: 0.8rem;
}
.gt-info-label {
  font-family: var(--gt-font-b);
  font-size: 0.68rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.06em;
  color: var(--gt-muted); margin-bottom: 2px;
}
.gt-info-val {
  font-family: var(--gt-font-b);
  font-size: 0.85rem; font-weight: 500; color: var(--gt-text);
}

/* Warning box */
.gt-warn-box {
  background: #fff8e1;
  border: 1.5px solid rgba(180,83,9,0.18);
  border-radius: 16px; padding: 18px 20px;
  margin-top: 16px;
}
.gt-warn-title {
  font-family: var(--gt-font-d);
  font-weight: 700; font-size: 0.85rem;
  color: #b45309; margin-bottom: 10px;
  display: flex; align-items: center; gap: 6px;
}
.gt-warn-list {
  list-style: none; padding: 0; margin: 0;
  display: flex; flex-direction: column; gap: 7px;
}
.gt-warn-list li {
  display: flex; align-items: flex-start; gap: 7px;
  font-family: var(--gt-font-b);
  font-size: 0.8rem; color: var(--gt-muted);
}
.gt-warn-list li .bi { color: #b45309; font-size: 0.75rem; margin-top: 2px; flex-shrink: 0; }
</style>

<div class="gt-page">
  <div class="gt-dot-grid"></div>

  <div class="container position-relative" style="z-index:2;">
    <a href="{{ route('siswa.tugas.show', $pengumpulan->tugas_id) }}" class="gt-back">
      <i class="bi bi-arrow-left"></i> Kembali ke Detail Tugas
    </a>

    @php
      $tugas    = $pengumpulan->tugas;
      $deadline = \Carbon\Carbon::parse($tugas->deadline);
    @endphp

    <div class="gt-layout">

      {{-- ── MAIN ─────────────────────── --}}
      <div>
        <div class="gt-card">

          {{-- Header amber --}}
          <div class="gt-edit-header">
            <div class="gt-hpat"></div>
            <div class="gt-header-icon">✏️</div>
            <h1 class="gt-header-title">Edit Pengumpulan</h1>
            <p class="gt-header-sub">Perbarui file atau catatan sebelum deadline berakhir</p>
          </div>

          <div class="gt-body">

            {{-- Referensi tugas --}}
            <div class="gt-tugas-strip">
              <span class="gt-tugas-strip-icon"><i class="bi bi-clipboard2-fill"></i></span>
              <div>
                <div class="gt-tugas-strip-title">{{ $tugas->judul }}</div>
                <div class="gt-tugas-strip-meta">
                  <i class="bi bi-clock-fill"></i>
                  Deadline: {{ $deadline->translatedFormat('d M Y, H:i') }}
                  &nbsp;·&nbsp;
                  <i class="bi bi-hourglass-split"></i>
                  {{ $deadline->diffForHumans() }}
                </div>
              </div>
            </div>

            {{-- File saat ini --}}
            @if($pengumpulan->file)
              <div class="gt-field">
                <label class="gt-label"><i class="bi bi-file-earmark-fill" style="color:var(--gt-green);font-size:0.72rem;"></i> &nbsp;File Saat Ini</label>
                <div class="gt-current-file">
                  <span class="gt-cf-icon"><i class="bi bi-file-earmark-fill"></i></span>
                  <div>
                    <div class="gt-cf-label">File Terkumpul</div>
                    <div class="gt-cf-name">{{ basename($pengumpulan->file) }}</div>
                  </div>
                  <a href="{{ asset('storage/' . $pengumpulan->file) }}"
                     target="_blank" class="gt-cf-view">
                    <i class="bi bi-eye me-1"></i>Lihat
                  </a>
                </div>
              </div>
            @endif

            <form method="POST"
                  action="{{ route('siswa.tugas.update', $pengumpulan->id) }}"
                  enctype="multipart/form-data">
              @csrf

              {{-- Upload baru --}}
              <div class="gt-field">
                <label class="gt-label">Ganti File <span style="font-weight:400;text-transform:none;letter-spacing:0;">(opsional)</span></label>
                <div class="gt-drop" id="gt-drop">
                  <input type="file" name="file" id="gt-file">
                  <div class="gt-drop-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                  <div class="gt-drop-t">Klik atau seret file baru ke sini</div>
                  <div class="gt-drop-s">Kosongkan jika tidak ingin mengganti file</div>
                  <span id="gt-fn"></span>
                </div>
              </div>

              {{-- Catatan --}}
              <div class="gt-field">
                <label class="gt-label" for="catatan">Catatan / Deskripsi</label>
                <textarea name="catatan" id="catatan"
                          class="gt-textarea"
                          placeholder="Tulis catatan tambahan untuk gurumu...">{{ $pengumpulan->catatan }}</textarea>
              </div>

              <div class="gt-divider" style="margin-bottom:0;"></div>

              <div class="gt-actions">
                <a href="{{ route('siswa.tugas.show', $pengumpulan->tugas_id) }}" class="gt-cancel-btn">
                  Batal
                </a>
                <button type="submit" class="gt-save-btn">
                  <i class="bi bi-check2-circle"></i>
                  Simpan Perubahan
                </button>
              </div>

            </form>

          </div>
        </div>
      </div>

      {{-- ── SIDEBAR ─────────────────────── --}}
      <div>
        <div class="gt-card gt-sidebar">
          <div class="gt-body" style="padding:24px;">
            <div class="gt-section-title">
              <i class="bi bi-info-circle-fill" style="color:var(--gt-green);"></i> Info Pengumpulan
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-calendar3"></i></span>
              <div>
                <div class="gt-info-label">Deadline</div>
                <div class="gt-info-val">{{ $deadline->translatedFormat('d M Y, H:i') }}</div>
              </div>
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-clock-history"></i></span>
              <div>
                <div class="gt-info-label">Dikumpulkan</div>
                <div class="gt-info-val">{{ $pengumpulan->created_at->translatedFormat('d M Y, H:i') }}</div>
              </div>
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-arrow-repeat"></i></span>
              <div>
                <div class="gt-info-label">Terakhir Diubah</div>
                <div class="gt-info-val">{{ $pengumpulan->updated_at->diffForHumans() }}</div>
              </div>
            </div>

            <div class="gt-info-row">
              <span class="gt-info-icon"><i class="bi bi-tag-fill"></i></span>
              <div>
                <div class="gt-info-label">Status</div>
                <div class="gt-info-val" style="color:#1565c0;font-weight:600;">
                  {{ ucfirst($pengumpulan->status) }}
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Warning --}}
        <div class="gt-warn-box">
          <div class="gt-warn-title">
            <i class="bi bi-exclamation-triangle-fill"></i> Perhatian
          </div>
          <ul class="gt-warn-list">
            <li><i class="bi bi-dot"></i> Edit hanya bisa dilakukan sebelum deadline</li>
            <li><i class="bi bi-dot"></i> File lama akan diganti jika kamu upload file baru</li>
            <li><i class="bi bi-dot"></i> Simpan salinan file untuk arsipmu sendiri</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  const drop = document.getElementById('gt-drop');
  const fi   = document.getElementById('gt-file');
  const fn   = document.getElementById('gt-fn');

  fi.addEventListener('change', function() {
    if (this.files[0]) {
      fn.textContent = this.files[0].name;
      fn.style.display = 'inline-block';
    }
  });
  drop.addEventListener('dragover', e => { e.preventDefault(); drop.classList.add('on'); });
  drop.addEventListener('dragleave', () => drop.classList.remove('on'));
  drop.addEventListener('drop', e => {
    e.preventDefault(); drop.classList.remove('on');
    fi.files = e.dataTransfer.files;
    if (fi.files[0]) { fn.textContent = fi.files[0].name; fn.style.display = 'inline-block'; }
  });
</script>

@endsection