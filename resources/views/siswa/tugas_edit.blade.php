@extends('layouts.frontend')

@section('content')

<style>
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
  --gt-font-display: 'Raleway', sans-serif;
  --gt-font-body:    'Ubuntu', sans-serif;
}

.gt-submit-page {
  min-height: calc(100vh - 66px);
  background: var(--gt-cream);
  padding: 48px 16px 80px;
  position: relative;
  overflow: hidden;
}
.gt-submit-page::before {
  content: '';
  position: absolute;
  width: 440px; height: 440px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.12) 0%, transparent 65%);
  top: -120px; right: -80px;
  pointer-events: none;
}
.gt-dot-grid {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.09) 1px, transparent 1px);
  background-size: 28px 28px;
  mask-image: radial-gradient(ellipse 70% 70% at 50% 20%, black, transparent);
  pointer-events: none;
}

.gt-back-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--gt-font-body);
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--gt-muted);
  text-decoration: none;
  padding: 7px 14px;
  border-radius: 50px;
  background: rgba(255,255,255,0.85);
  border: 1.5px solid var(--gt-border);
  margin-bottom: 28px;
  transition: all 0.22s ease;
}
.gt-back-btn:hover {
  color: var(--gt-green);
  border-color: rgba(26,107,60,0.28);
  background: var(--gt-lime-soft);
  transform: translateX(-3px);
}

.gt-wrap {
  max-width: 620px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes fadeUp {
  from { opacity:0; transform: translateY(28px); }
  to   { opacity:1; transform: translateY(0); }
}

.gt-card {
  background: rgba(255,255,255,0.97);
  border-radius: 28px;
  border: 1.5px solid var(--gt-border);
  box-shadow: 0 4px 32px rgba(26,107,60,0.10);
  overflow: hidden;
}

.gt-card-header {
  background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%);
  padding: 28px 34px;
  position: relative;
  overflow: hidden;
}
.gt-card-header::before {
  content: '';
  position: absolute;
  width: 180px; height: 180px;
  border-radius: 50%;
  background: rgba(255,255,255,0.06);
  top: -70px; right: -40px;
}
.gt-hpattern {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
  background-size: 18px 18px;
}
.gt-card-header-icon {
  width: 52px; height: 52px;
  border-radius: 16px;
  background: rgba(255,255,255,0.18);
  backdrop-filter: blur(8px);
  border: 2px solid rgba(255,255,255,0.25);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem;
  margin-bottom: 14px;
  position: relative;
  z-index: 1;
}
.gt-card-header-title {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.25rem;
  color: #fff;
  margin: 0 0 4px;
  position: relative;
  z-index: 1;
}
.gt-card-header-sub {
  font-family: var(--gt-font-body);
  font-size: 0.83rem;
  color: rgba(255,255,255,0.72);
  margin: 0;
  position: relative;
  z-index: 1;
}

.gt-card-body {
  padding: 32px 34px 36px;
}
@media (max-width: 560px) {
  .gt-card-header { padding: 22px 20px; }
  .gt-card-body   { padding: 22px 20px 28px; }
}

/* Current file info */
.gt-current-file {
  display: flex;
  align-items: center;
  gap: 12px;
  background: #edf5ff;
  border: 1.5px solid rgba(21,101,192,0.18);
  border-radius: 14px;
  padding: 14px 16px;
  margin-bottom: 24px;
}
.gt-file-icon {
  width: 40px; height: 40px;
  border-radius: 11px;
  background: rgba(21,101,192,0.12);
  display: flex; align-items: center; justify-content: center;
  color: #1565c0;
  font-size: 1.1rem;
  flex-shrink: 0;
}
.gt-current-file-label {
  font-family: var(--gt-font-body);
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  color: #1565c0;
  margin-bottom: 2px;
}
.gt-current-file-name {
  font-family: var(--gt-font-body);
  font-size: 0.875rem;
  color: #12291d;
  font-weight: 500;
}

/* Field group */
.gt-field-group { margin-bottom: 22px; }
.gt-field-label {
  font-family: var(--gt-font-body);
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  color: var(--gt-muted);
  margin-bottom: 7px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.gt-field-label .bi { font-size: 0.75rem; color: var(--gt-green); }

/* Upload dropzone */
.gt-dropzone {
  position: relative;
  border: 2px dashed rgba(26,107,60,0.22);
  border-radius: 16px;
  background: var(--gt-cream);
  padding: 28px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.22s ease;
}
.gt-dropzone:hover, .gt-dropzone.dragover {
  border-color: var(--gt-lime);
  background: rgba(212,247,226,0.35);
}
.gt-dropzone input[type="file"] {
  position: absolute;
  inset: 0;
  opacity: 0;
  cursor: pointer;
  width: 100%;
  height: 100%;
}
.gt-dropzone-icon {
  width: 52px; height: 52px;
  border-radius: 16px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 12px;
  font-size: 1.4rem;
  color: var(--gt-green);
}
.gt-dropzone-title {
  font-family: var(--gt-font-body);
  font-weight: 700;
  font-size: 0.9rem;
  color: var(--gt-text);
  margin-bottom: 4px;
}
.gt-dropzone-hint {
  font-family: var(--gt-font-body);
  font-size: 0.77rem;
  color: var(--gt-muted);
}
#gt-drop-name {
  display: inline-block;
  margin-top: 10px;
  font-family: var(--gt-font-body);
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--gt-green);
  background: var(--gt-lime-soft);
  padding: 4px 12px;
  border-radius: 50px;
}

/* Textarea */
.gt-textarea {
  width: 100%;
  font-family: var(--gt-font-body);
  font-size: 0.9rem;
  color: var(--gt-text);
  background: var(--gt-cream);
  border: 2px solid var(--gt-border);
  border-radius: 14px;
  padding: 14px 16px;
  resize: vertical;
  outline: none;
  transition: all 0.22s ease;
  min-height: 120px;
}
.gt-textarea::placeholder { color: #aac5b5; }
.gt-textarea:focus {
  border-color: var(--gt-lime);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(76,222,128,0.13);
}

/* Actions */
.gt-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 28px;
  padding-top: 22px;
  border-top: 1px solid var(--gt-border);
}
.gt-save-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--gt-font-display);
  font-weight: 700;
  font-size: 0.9rem;
  padding: 12px 26px;
  border-radius: 14px;
  background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%);
  color: #fff;
  border: none;
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 4px 16px rgba(21,101,192,0.28);
}
.gt-save-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(21,101,192,0.36);
}
.gt-cancel-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.875rem;
  padding: 11px 20px;
  border-radius: 14px;
  background: transparent;
  color: var(--gt-muted);
  border: 2px solid var(--gt-border);
  text-decoration: none;
  transition: all 0.22s ease;
}
.gt-cancel-btn:hover {
  color: var(--gt-text);
  border-color: rgba(26,107,60,0.22);
  background: var(--gt-cream);
}
</style>

<div class="gt-submit-page">
  <div class="gt-dot-grid"></div>

  <div class="container position-relative" style="z-index:2;">
    <a href="{{ url()->previous() }}" class="gt-back-btn">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="gt-wrap">
      <div class="gt-card">

        {{-- Header --}}
        <div class="gt-card-header">
          <div class="gt-hpattern"></div>
          <div class="gt-card-header-icon">✏️</div>
          <h2 class="gt-card-header-title">Edit Pengumpulan</h2>
          <p class="gt-card-header-sub">Perbarui file atau catatan tugasmu sebelum deadline</p>
        </div>

        <div class="gt-card-body">

          {{-- Current file indicator --}}
          @if($pengumpulan->file)
            <div class="gt-current-file">
              <span class="gt-file-icon"><i class="bi bi-file-earmark-fill"></i></span>
              <div>
                <div class="gt-current-file-label">File Saat Ini</div>
                <div class="gt-current-file-name">{{ basename($pengumpulan->file) }}</div>
              </div>
              <a href="{{ asset('storage/' . $pengumpulan->file) }}"
                 target="_blank"
                 class="ms-auto btn btn-sm rounded-pill"
                 style="font-size:0.78rem;padding:5px 12px;background:#1565c0;color:#fff;font-family:var(--gt-font-body);font-weight:600;text-decoration:none;">
                <i class="bi bi-eye me-1"></i> Lihat
              </a>
            </div>
          @endif

          <form method="POST" action="{{ route('siswa.tugas.update', $pengumpulan->id) }}"
                enctype="multipart/form-data">
            @csrf

            {{-- File upload --}}
            <div class="gt-field-group">
              <label class="gt-field-label">
                <i class="bi bi-paperclip"></i> Ganti File <span style="font-weight:400;text-transform:none;letter-spacing:0;">(opsional)</span>
              </label>
              <div class="gt-dropzone" id="gt-dropzone">
                <input type="file" name="file" id="gt-file">
                <div class="gt-dropzone-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                <div class="gt-dropzone-title">Klik atau seret file ke sini</div>
                <div class="gt-dropzone-hint">PDF, DOCX, JPG, PNG, dll. Maks 10MB</div>
                <span id="gt-drop-name" style="display:none;"></span>
              </div>
            </div>

            {{-- Catatan --}}
            <div class="gt-field-group">
              <label class="gt-field-label" for="catatan">
                <i class="bi bi-chat-left-text-fill"></i> Catatan / Deskripsi
              </label>
              <textarea name="catatan" id="catatan"
                        class="gt-textarea"
                        placeholder="Tulis catatan tambahan untuk gurumu...">{{ $pengumpulan->catatan }}</textarea>
            </div>

            <div class="gt-actions">
              <a href="{{ url()->previous() }}" class="gt-cancel-btn">Batal</a>
              <button type="submit" class="gt-save-btn">
                <i class="bi bi-check2-circle"></i>
                Simpan Perubahan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const dropzone = document.getElementById('gt-dropzone');
  const fileInput = document.getElementById('gt-file');
  const dropName  = document.getElementById('gt-drop-name');

  fileInput.addEventListener('change', function () {
    if (this.files[0]) {
      dropName.textContent = this.files[0].name;
      dropName.style.display = 'inline-block';
    }
  });
  dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('dragover'); });
  dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
  dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    fileInput.files = e.dataTransfer.files;
    if (fileInput.files[0]) {
      dropName.textContent = fileInput.files[0].name;
      dropName.style.display = 'inline-block';
    }
  });
</script>

@endsection