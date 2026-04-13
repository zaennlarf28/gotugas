<style>
  .gt-footer {
    --gt-green:      #1a6b3c;
    --gt-green-dark: #154f2d;
    --gt-green-mid:  #22883f;
    --gt-lime:       #4cde80;
    --gt-lime-soft:  rgba(76,222,128,0.15);
    --gt-border:     rgba(255,255,255,0.08);
    --gt-muted:      #6b9f7e;
    --gt-text-light: #a8d5b8;
    --gt-font-display: 'Raleway', sans-serif;
    --gt-font-body:    'Ubuntu', sans-serif;
    background: var(--gt-green);
    font-family: var(--gt-font-body);
  }

  /* ── Top grid ── */
  .gt-footer-top {
    max-width: 1200px;
    margin: 0 auto;
    padding: 64px 24px 48px;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.4fr;
    gap: 40px;
  }
  @media (max-width: 860px) {
    .gt-footer-top { grid-template-columns: 1fr 1fr; }
    .gt-footer-brand { grid-column: 1 / -1; }
  }
  @media (max-width: 540px) {
    .gt-footer-top { grid-template-columns: 1fr; }
  }

  /* ── Brand ── */
  .gt-footer-brand-name {
    font-family: var(--gt-font-display);
    font-weight: 800;
    font-size: 1.45rem;
    letter-spacing: -0.5px;
    color: #fff;
    margin: 0 0 4px;
  }
  .gt-footer-brand-dot {
    display: inline-block;
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--gt-lime);
    vertical-align: super;
    margin-left: 2px;
    animation: ft-dot-pulse 2s ease-in-out infinite;
  }
  @keyframes ft-dot-pulse {
    0%,100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.4); opacity: 0.65; }
  }
  .gt-footer-tagline {
    font-size: 0.85rem;
    color: var(--gt-muted);
    line-height: 1.65;
    margin: 0 0 20px;
    max-width: 260px;
  }

  /* ── Contact items ── */
  .gt-footer-contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    color: var(--gt-text-light);
    text-decoration: none;
    margin-bottom: 8px;
    transition: color 0.2s;
  }
  .gt-footer-contact-item:hover { color: #fff; }
  .gt-footer-contact-icon {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: var(--gt-lime-soft);
    border: 1px solid rgba(76,222,128,0.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--gt-lime);
    font-size: 0.75rem;
    transition: background 0.2s;
  }
  .gt-footer-contact-item:hover .gt-footer-contact-icon {
    background: rgba(76,222,128,0.25);
  }

  /* ── Column headings ── */
  .gt-footer-col-title {
    font-family: var(--gt-font-display);
    font-weight: 700;
    font-size: 0.72rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.5);
    margin: 0 0 18px;
  }

  /* ── Link lists ── */
  .gt-footer-links {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .gt-footer-links a {
    font-size: 0.875rem;
    color: var(--gt-text-light);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: color 0.2s, transform 0.2s;
  }
  .gt-footer-links a::before {
    content: '';
    width: 4px; height: 4px;
    border-radius: 50%;
    background: rgba(76,222,128,0.3);
    flex-shrink: 0;
    transition: background 0.2s;
  }
  .gt-footer-links a:hover {
    color: #fff;
    transform: translateX(4px);
  }
  .gt-footer-links a:hover::before {
    background: var(--gt-lime);
  }

  /* ── Social ── */
  .gt-footer-social-sub {
    font-size: 0.83rem;
    color: var(--gt-muted);
    line-height: 1.6;
    margin: 0 0 14px;
  }
  .gt-footer-social-links {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }
  .gt-footer-social-link {
    width: 38px; height: 38px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    color: var(--gt-text-light);
    text-decoration: none;
    font-size: 1rem;
    transition: all 0.22s ease;
  }
  .gt-footer-social-link:hover {
    border-color: var(--gt-lime);
    background: var(--gt-lime-soft);
    color: var(--gt-lime);
    transform: translateY(-2px);
  }

  /* ── Status badge ── */
  .gt-footer-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--gt-lime-soft);
    border: 1px solid rgba(76,222,128,0.22);
    border-radius: 50px;
    padding: 5px 12px;
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--gt-lime);
  }
  .gt-footer-badge-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--gt-lime);
    animation: ft-badge-pulse 2s ease-in-out infinite;
  }
  @keyframes ft-badge-pulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: 0.6; transform: scale(1.3); }
  }

  /* ── Bottom bar ── */
  .gt-footer-bottom-wrap {
    border-top: 1px solid rgba(255,255,255,0.08);
    background: var(--gt-green-dark);
  }
  .gt-footer-bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
  }
  .gt-footer-copy {
    font-size: 0.78rem;
    color: var(--gt-muted);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .gt-footer-copy strong { font-weight: 600; color: var(--gt-text-light); }
  .gt-footer-copy .sep {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
  }
  .gt-footer-rights {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.25);
  }
</style>

<footer id="footer" class="gt-footer">

  <div class="gt-footer-top">

    {{-- Brand & Contact --}}
    <div class="gt-footer-brand">
      <a href="{{ url('/') }}" class="text-decoration-none">
        <h2 class="gt-footer-brand-name">
          GoTugas<span class="gt-footer-brand-dot"></span>
        </h2>
      </a>
      <p class="gt-footer-tagline">
        Platform manajemen tugas sekolah yang mudah, cepat, dan menyenangkan untuk siswa dan guru.
      </p>

      <a href="tel:+6285722830576" class="gt-footer-contact-item">
        <span class="gt-footer-contact-icon"><i class="bi bi-telephone-fill"></i></span>
        +62 857-2283-0576
      </a>
      <a href="mailto:zaennlarf28@gmail.com" class="gt-footer-contact-item">
        <span class="gt-footer-contact-icon"><i class="bi bi-envelope-fill"></i></span>
        zaennlarf28@gmail.com
      </a>
      <div class="gt-footer-contact-item">
        <span class="gt-footer-contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
        Bandung, Cibaduyut
      </div>
    </div>

    {{-- Navigasi --}}
    <div>
      <p class="gt-footer-col-title">Navigasi</p>
      <ul class="gt-footer-links">
        <li><a href="{{ url('/') }}">Beranda</a></li>
        <li><a href="{{ url('join') }}">Masuk Kelas</a></li>
        @auth
          <li><a href="{{ route('profil') }}">Profil Saya</a></li>
        @endauth
      </ul>
    </div>

    {{-- Platform --}}
    <div>
      <p class="gt-footer-col-title">Platform</p>
      <ul class="gt-footer-links">
        <li><a href="#">Tugas</a></li>
        <li><a href="#">Chat Kelas</a></li>
      </ul>
    </div>

    {{-- Sosial --}}
    <div>
      <p class="gt-footer-col-title">Ikuti Kami</p>
      <p class="gt-footer-social-sub">
        Temukan info &amp; update terbaru GoTugas di Instagram kami.
      </p>
      <div class="gt-footer-social-links">
        <a href="https://www.instagram.com/zaenlarfv_/"
           class="gt-footer-social-link"
           target="_blank" rel="noopener"
           title="Instagram @zaenlarfv_">
          <i class="bi bi-instagram"></i>
        </a>
      </div>
      <div class="gt-footer-badge">
        <span class="gt-footer-badge-dot"></span>
        Platform aktif &amp; berkembang
      </div>
    </div>

  </div>

  {{-- Bottom bar --}}
  <div class="gt-footer-bottom-wrap">
    <div class="gt-footer-bottom">
      <p class="gt-footer-copy">
        &copy; {{ date('Y') }}
        <span class="sep"></span>
        Dibuat oleh <strong>Zaenal Arif</strong>
        <span class="sep"></span>
        XII RPL 2
      </p>
      <span class="gt-footer-rights">GoTugas — All rights reserved</span>
    </div>
  </div>

</footer> 