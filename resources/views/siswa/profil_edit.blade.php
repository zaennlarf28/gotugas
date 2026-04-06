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
  --gt-shadow:      0 4px 32px rgba(26,107,60,0.10);
  --gt-font-display: 'Raleway', sans-serif;
  --gt-font-body:    'Ubuntu', sans-serif;
}

.gt-edit-page {
  min-height: calc(100vh - 66px);
  background: var(--gt-cream);
  padding: 48px 16px 80px;
  position: relative;
  overflow: hidden;
}
.gt-edit-page::before {
  content: '';
  position: absolute;
  width: 480px; height: 480px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.13) 0%, transparent 65%);
  top: -140px; right: -100px;
  pointer-events: none;
}
.gt-dot-grid {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.09) 1px, transparent 1px);
  background-size: 28px 28px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 20%, black, transparent);
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
  backdrop-filter: blur(8px);
}
.gt-back-btn:hover {
  color: var(--gt-green);
  border-color: rgba(26,107,60,0.28);
  background: var(--gt-lime-soft);
  transform: translateX(-3px);
}

.gt-edit-wrap {
  max-width: 660px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Card */
.gt-edit-card {
  background: rgba(255,255,255,0.97);
  border-radius: 28px;
  border: 1.5px solid var(--gt-border);
  box-shadow: var(--gt-shadow);
  overflow: hidden;
}

/* Card header */
.gt-edit-card-header {
  background: linear-gradient(135deg, var(--gt-green) 0%, var(--gt-green-mid) 100%);
  padding: 30px 36px;
  position: relative;
  overflow: hidden;
}
.gt-edit-card-header::before {
  content: '';
  position: absolute;
  width: 200px; height: 200px;
  border-radius: 50%;
  background: rgba(255,255,255,0.06);
  top: -80px; right: -40px;
}
.gt-banner-pattern {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
  background-size: 18px 18px;
}
.gt-edit-card-title {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.3rem;
  color: #fff;
  margin: 0 0 4px;
  position: relative;
  z-index: 1;
}
.gt-edit-card-sub {
  font-family: var(--gt-font-body);
  font-size: 0.84rem;
  color: rgba(255,255,255,0.75);
  margin: 0;
  position: relative;
  z-index: 1;
}

/* Avatar upload */
.gt-avatar-edit {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 28px 36px 0;
  margin-bottom: 24px;
}
.gt-avatar-preview {
  position: relative;
  flex-shrink: 0;
}
.gt-avatar-preview img {
  width: 90px; height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid var(--gt-white);
  box-shadow: 0 4px 16px rgba(26,107,60,0.18);
  display: block;
}
.gt-avatar-preview-ring {
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  border: 2px solid rgba(76,222,128,0.4);
}
.gt-avatar-info {
  flex: 1;
}
.gt-avatar-title {
  font-family: var(--gt-font-display);
  font-weight: 700;
  font-size: 0.95rem;
  color: var(--gt-text);
  margin-bottom: 4px;
}
.gt-avatar-hint {
  font-family: var(--gt-font-body);
  font-size: 0.75rem;
  color: var(--gt-muted);
  margin-bottom: 10px;
}
.gt-file-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--gt-font-body);
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--gt-green);
  background: var(--gt-lime-soft);
  border: 1.5px solid rgba(76,222,128,0.35);
  padding: 7px 14px;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.22s ease;
}
.gt-file-label:hover {
  background: rgba(76,222,128,0.22);
  transform: translateY(-1px);
}
.gt-file-input { display: none; }
#gt-file-name {
  font-family: var(--gt-font-body);
  font-size: 0.75rem;
  color: var(--gt-muted);
  margin-top: 6px;
  display: block;
}

/* Form body */
.gt-form-body {
  padding: 8px 36px 36px;
}
@media (max-width: 560px) {
  .gt-edit-card-header { padding: 24px 22px; }
  .gt-form-body { padding: 8px 20px 28px; }
  .gt-avatar-edit { padding: 20px 20px 0; }
}

.gt-divider {
  height: 1px;
  background: var(--gt-border);
  margin: 0 36px 28px;
}
@media (max-width: 560px) { .gt-divider { margin: 0 20px 24px; } }

/* Form fields */
.gt-field-group {
  margin-bottom: 20px;
}
.gt-field-wrap {
  position: relative;
}
.gt-field-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--gt-muted);
  font-size: 1rem;
  pointer-events: none;
  transition: color 0.2s;
  z-index: 1;
}
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
  gap: 6px;
}
.gt-field-label .bi { font-size: 0.75rem; color: var(--gt-green); }

.gt-field-input {
  width: 100%;
  font-family: var(--gt-font-body);
  font-size: 0.925rem;
  font-weight: 500;
  color: var(--gt-text);
  background: var(--gt-cream);
  border: 2px solid var(--gt-border);
  border-radius: 14px;
  padding: 13px 16px 13px 44px;
  outline: none;
  transition: all 0.22s ease;
}
.gt-field-input::placeholder { color: #aac5b5; font-weight: 400; }
.gt-field-input:focus {
  border-color: var(--gt-lime);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(76,222,128,0.13);
}
.gt-field-wrap:focus-within .gt-field-icon { color: var(--gt-green); }

/* Error messages */
.gt-field-error {
  font-family: var(--gt-font-body);
  font-size: 0.78rem;
  color: #c0392b;
  margin-top: 6px;
  display: flex;
  align-items: center;
  gap: 4px;
}

/* Actions */
.gt-form-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 28px;
  padding-top: 24px;
  border-top: 1px solid var(--gt-border);
  flex-wrap: wrap;
}
.gt-save-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--gt-font-display);
  font-weight: 700;
  font-size: 0.9rem;
  padding: 12px 28px;
  border-radius: 14px;
  background: linear-gradient(135deg, var(--gt-green) 0%, var(--gt-green-mid) 100%);
  color: #fff;
  border: none;
  cursor: pointer;
  transition: all 0.25s ease;
  box-shadow: 0 4px 16px rgba(26,107,60,0.28);
}
.gt-save-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(26,107,60,0.36);
}
.gt-cancel-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: var(--gt-font-body);
  font-weight: 600;
  font-size: 0.875rem;
  padding: 11px 22px;
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

<div class="gt-edit-page">
  <div class="gt-dot-grid"></div>

  <div class="container position-relative" style="z-index:2;">
    <a href="{{ route('profil') }}" class="gt-back-btn">
      <i class="bi bi-arrow-left"></i> Kembali ke Profil
    </a>

    <div class="gt-edit-wrap">
      <div class="gt-edit-card">

        {{-- Header --}}
        <div class="gt-edit-card-header">
          <div class="gt-banner-pattern"></div>
          <h2 class="gt-edit-card-title">Edit Profil</h2>
          <p class="gt-edit-card-sub">Perbarui informasi akun dan foto profilmu</p>
        </div>

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- Avatar upload --}}
          <div class="gt-avatar-edit">
            <div class="gt-avatar-preview">
              <img src="{{ $user->foto_profil_url }}" alt="Foto Profil" id="gt-avatar-img">
              <span class="gt-avatar-preview-ring"></span>
            </div>
            <div class="gt-avatar-info">
              <div class="gt-avatar-title">Foto Profil</div>
              <div class="gt-avatar-hint">JPG, PNG atau GIF. Maks 2MB.</div>
              <label class="gt-file-label" for="foto_profil">
                <i class="bi bi-camera-fill"></i>
                Ganti Foto
              </label>
              <input type="file" name="foto_profil" id="foto_profil" class="gt-file-input" accept="image/*">
              <span id="gt-file-name">Belum ada file dipilih</span>
            </div>
          </div>

          <div class="gt-divider"></div>

          <div class="gt-form-body">

            {{-- Nama --}}
            <div class="gt-field-group">
              <label class="gt-field-label" for="name">
                <i class="bi bi-person-fill"></i> Nama Lengkap
              </label>
              <div class="gt-field-wrap">
                <i class="bi bi-person gt-field-icon"></i>
                <input type="text" name="name" id="name"
                       class="gt-field-input"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Nama lengkapmu"
                       required>
              </div>
              @error('name')
                <p class="gt-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
              @enderror
            </div>

            {{-- Alamat --}}
            <div class="gt-field-group">
              <label class="gt-field-label" for="alamat">
                <i class="bi bi-house-door-fill"></i> Alamat
              </label>
              <div class="gt-field-wrap">
                <i class="bi bi-geo-alt gt-field-icon"></i>
                <input type="text" name="alamat" id="alamat"
                       class="gt-field-input"
                       value="{{ old('alamat', $user->alamat) }}"
                       placeholder="Alamat tempat tinggal">
              </div>
              @error('alamat')
                <p class="gt-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
              @enderror
            </div>

            {{-- No Telepon --}}
            <div class="gt-field-group">
              <label class="gt-field-label" for="no_telepon">
                <i class="bi bi-telephone-fill"></i> No Telepon
              </label>
              <div class="gt-field-wrap">
                <i class="bi bi-phone gt-field-icon"></i>
                <input type="text" name="no_telepon" id="no_telepon"
                       class="gt-field-input"
                       value="{{ old('no_telepon', $user->no_telepon) }}"
                       placeholder="08xx-xxxx-xxxx">
              </div>
              @error('no_telepon')
                <p class="gt-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</p>
              @enderror
            </div>

            {{-- Actions --}}
            <div class="gt-form-actions">
              <a href="{{ route('profil') }}" class="gt-cancel-btn">
                Batal
              </a>
              <button type="submit" class="gt-save-btn">
                <i class="bi bi-check2-circle"></i>
                Simpan Perubahan
              </button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Preview avatar on file select
  const fileInput = document.getElementById('foto_profil');
  const avatarImg = document.getElementById('gt-avatar-img');
  const fileName  = document.getElementById('gt-file-name');

  fileInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      fileName.textContent = file.name;
      const reader = new FileReader();
      reader.onload = e => { avatarImg.src = e.target.result; };
      reader.readAsDataURL(file);
    }
  });
</script>

@endsection