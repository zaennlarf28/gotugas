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
  --gt-border:     rgba(26,107,60,0.14);
  --gt-font-display: 'Raleway', sans-serif;
  --gt-font-body:    'Ubuntu', sans-serif;
}

/* ── Page wrapper ── */
.gt-join-page {
  min-height: calc(100vh - 66px);
  background: var(--gt-cream);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 48px 16px;
  position: relative;
  overflow: hidden;
}

/* Background decoration */
.gt-join-page::before {
  content: '';
  position: absolute;
  width: 480px; height: 480px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(76,222,128,0.16) 0%, transparent 70%);
  top: -120px; right: -80px;
  pointer-events: none;
}
.gt-join-page::after {
  content: '';
  position: absolute;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,107,60,0.07) 0%, transparent 70%);
  bottom: -100px; left: -60px;
  pointer-events: none;
}

/* Dot grid */
.gt-join-grid {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle, rgba(26,107,60,0.10) 1px, transparent 1px);
  background-size: 28px 28px;
  mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black, transparent);
  pointer-events: none;
}

/* ── Card ── */
.gt-join-wrap {
  width: 100%;
  max-width: 460px;
  position: relative;
  z-index: 2;
  animation: fadeSlideUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes fadeSlideUp {
  from { opacity:0; transform: translateY(28px); }
  to   { opacity:1; transform: translateY(0); }
}

/* Back button */
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
  background: rgba(255,255,255,0.8);
  border: 1.5px solid var(--gt-border);
  margin-bottom: 20px;
  transition: all 0.22s ease;
  backdrop-filter: blur(8px);
}
.gt-back-btn:hover {
  color: var(--gt-green);
  border-color: rgba(26,107,60,0.28);
  background: var(--gt-lime-soft);
  transform: translateX(-3px);
}

/* Card shell */
.gt-join-card {
  background: rgba(255,255,255,0.96);
  border-radius: 28px;
  border: 1.5px solid var(--gt-border);
  box-shadow: 0 8px 40px rgba(26,107,60,0.11), 0 2px 8px rgba(0,0,0,0.04);
  overflow: hidden;
  backdrop-filter: blur(12px);
}

/* Card top strip */
.gt-join-card-top {
  background: linear-gradient(135deg, var(--gt-green) 0%, var(--gt-green-mid) 100%);
  padding: 36px 36px 28px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.gt-join-card-top::before {
  content: '';
  position: absolute;
  width: 220px; height: 220px;
  border-radius: 50%;
  background: rgba(255,255,255,0.06);
  top: -80px; right: -60px;
}
.gt-join-card-top::after {
  content: '';
  position: absolute;
  width: 140px; height: 140px;
  border-radius: 50%;
  background: rgba(255,255,255,0.05);
  bottom: -60px; left: -30px;
}

.gt-join-icon-wrap {
  width: 70px; height: 70px;
  border-radius: 22px;
  background: rgba(255,255,255,0.18);
  backdrop-filter: blur(8px);
  border: 2px solid rgba(255,255,255,0.3);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 16px;
  font-size: 1.8rem;
  position: relative;
  z-index: 1;
  animation: iconBounce 2.5s ease-in-out infinite;
}
@keyframes iconBounce {
  0%,100% { transform: translateY(0) rotate(0deg); }
  50%      { transform: translateY(-5px) rotate(-4deg); }
}

.gt-join-card-title {
  font-family: var(--gt-font-display);
  font-weight: 800;
  font-size: 1.4rem;
  color: #fff;
  margin: 0 0 6px;
  position: relative;
  z-index: 1;
}
.gt-join-card-sub {
  font-family: var(--gt-font-body);
  font-size: 0.85rem;
  color: rgba(255,255,255,0.78);
  margin: 0;
  position: relative;
  z-index: 1;
}

/* Card body */
.gt-join-card-body {
  padding: 32px 36px 36px;
}

/* Alert */
.gt-alert-danger {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  background: #fff5f5;
  border: 1.5px solid rgba(229,57,53,0.18);
  border-radius: 14px;
  padding: 14px 16px;
  font-family: var(--gt-font-body);
  font-size: 0.875rem;
  color: #c0392b;
  margin-bottom: 24px;
  animation: fadeSlideUp 0.35s ease both;
}
.gt-alert-danger .bi { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
.gt-alert-danger .btn-close { margin-left: auto; font-size: 0.7rem; }

/* Form label */
.gt-label {
  font-family: var(--gt-font-body);
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--gt-muted);
  margin-bottom: 8px;
  display: block;
}

/* Input group */
.gt-input-wrap {
  position: relative;
  margin-bottom: 28px;
}
.gt-input-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--gt-muted);
  font-size: 1rem;
  pointer-events: none;
  transition: color 0.2s;
}
.gt-input {
  width: 100%;
  font-family: var(--gt-font-body);
  font-size: 1rem;
  font-weight: 600;
  color: var(--gt-text);
  background: var(--gt-cream);
  border: 2px solid var(--gt-border);
  border-radius: 14px;
  padding: 14px 16px 14px 44px;
  outline: none;
  transition: all 0.22s ease;
  letter-spacing: 0.05em;
}
.gt-input::placeholder {
  font-weight: 400;
  color: #aac5b5;
  letter-spacing: 0;
}
.gt-input:focus {
  border-color: var(--gt-lime);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(76,222,128,0.15);
}
.gt-input:focus + .gt-input-icon,
.gt-input-wrap:focus-within .gt-input-icon {
  color: var(--gt-green);
}

/* Hint below input */
.gt-input-hint {
  font-family: var(--gt-font-body);
  font-size: 0.76rem;
  color: var(--gt-muted);
  margin-top: 7px;
  display: flex;
  align-items: center;
  gap: 5px;
}

/* Submit button */
.gt-submit-btn {
  width: 100%;
  font-family: var(--gt-font-display);
  font-weight: 700;
  font-size: 0.95rem;
  letter-spacing: 0.02em;
  padding: 15px 24px;
  border-radius: 14px;
  background: linear-gradient(135deg, var(--gt-green) 0%, var(--gt-green-mid) 100%);
  color: #fff;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.25s ease;
  box-shadow: 0 4px 18px rgba(26,107,60,0.28);
  position: relative;
  overflow: hidden;
}
.gt-submit-btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 100%);
  opacity: 0;
  transition: opacity 0.25s;
}
.gt-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 26px rgba(26,107,60,0.35);
}
.gt-submit-btn:hover::before { opacity: 1; }
.gt-submit-btn:active { transform: translateY(0); }
.gt-submit-btn .bi { font-size: 1rem; }

/* Divider */
.gt-divider {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 24px 0 0;
  font-family: var(--gt-font-body);
  font-size: 0.76rem;
  color: var(--gt-muted);
}
.gt-divider::before,
.gt-divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--gt-border);
}

/* How it works strip */
.gt-steps {
  display: flex;
  gap: 0;
  margin-top: 20px;
}
.gt-step {
  flex: 1;
  text-align: center;
  padding: 12px 8px;
  position: relative;
}
.gt-step:not(:last-child)::after {
  content: '';
  position: absolute;
  right: 0; top: 50%;
  transform: translateY(-50%);
  width: 1px; height: 40%;
  background: var(--gt-border);
}
.gt-step-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  background: var(--gt-lime-soft);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 7px;
  font-size: 0.9rem;
  color: var(--gt-green);
}
.gt-step-text {
  font-family: var(--gt-font-body);
  font-size: 0.7rem;
  color: var(--gt-muted);
  line-height: 1.35;
  font-weight: 500;
}

@media (max-width: 480px) {
  .gt-join-card-top { padding: 28px 24px 22px; }
  .gt-join-card-body { padding: 24px 22px 28px; }
  .gt-steps { gap: 0; }
}
</style>

<div class="gt-join-page">
  <div class="gt-join-grid"></div>

  <div class="gt-join-wrap">

    {{-- Back --}}
    <a href="{{ url('/') }}" class="gt-back-btn">
      <i class="bi bi-arrow-left"></i>
      Kembali ke Beranda
    </a>

    <div class="gt-join-card">

      {{-- Top banner --}}
      <div class="gt-join-card-top">
        <div class="gt-join-icon-wrap">🎓</div>
        <h2 class="gt-join-card-title">Gabung ke Kelas</h2>
        <p class="gt-join-card-sub">Masukkan kode unik yang diberikan oleh gurumu</p>
      </div>

      {{-- Body --}}
      <div class="gt-join-card-body">

        {{-- Error alert --}}
        @if(session('error'))
          <div class="gt-alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('siswa.kelas.join.proses') }}">
          @csrf

          <label for="kode_kelas" class="gt-label">Kode Kelas</label>
          <div class="gt-input-wrap">
            <input
              type="text"
              name="kode_kelas"
              id="kode_kelas"
              class="gt-input"
              placeholder="cth: ABC123"
              autocomplete="off"
              autocapitalize="characters"
              spellcheck="false"
              required
            >
            <i class="bi bi-key-fill gt-input-icon"></i>
          </div>
          <p class="gt-input-hint" style="margin-top:-18px; margin-bottom:24px;">
            <i class="bi bi-info-circle"></i>
            Kode kelas bisa didapatkan dari gurumu secara langsung.
          </p>

          <button type="submit" class="gt-submit-btn">
            <i class="bi bi-box-arrow-in-right"></i>
            Gabung Sekarang
          </button>
        </form>

        {{-- How it works --}}
        <div class="gt-divider">Cara bergabung</div>
        <div class="gt-steps">
          <div class="gt-step">
            <div class="gt-step-icon"><i class="bi bi-chat-dots"></i></div>
            <div class="gt-step-text">Minta kode dari gurumu</div>
          </div>
          <div class="gt-step">
            <div class="gt-step-icon"><i class="bi bi-keyboard"></i></div>
            <div class="gt-step-text">Masukkan kode di atas</div>
          </div>
          <div class="gt-step">
            <div class="gt-step-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="gt-step-text">Langsung masuk kelas!</div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

@endsection