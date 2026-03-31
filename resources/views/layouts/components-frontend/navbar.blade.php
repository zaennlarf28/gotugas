<style>
  /* ===== GoTugas Navbar ===== */
  :root {
    --gt-primary: #1a6b3c;
    --gt-primary-light: #22883f;
    --gt-accent: #4cde80;
    --gt-surface: rgba(255,255,255,0.92);
    --gt-border: rgba(26,107,60,0.12);
    --gt-shadow: 0 4px 24px rgba(26,107,60,0.10);
    --gt-text: #1a2e22;
    --gt-muted: #6b8a77;
    --gt-radius: 14px;
    --gt-font-display: 'Raleway', sans-serif;
    --gt-font-body: 'Ubuntu', sans-serif;
  }

  #header.header {
    background: var(--gt-surface);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1.5px solid var(--gt-border);
    box-shadow: var(--gt-shadow);
    padding: 0;
    height: 66px;
    transition: all 0.3s ease;
  }

  /* Logo */
  #header .logo .sitename {
    font-family: var(--gt-font-display);
    font-weight: 800;
    font-size: 1.45rem;
    letter-spacing: -0.5px;
    background: linear-gradient(135deg, var(--gt-primary) 30%, var(--gt-accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
    transition: opacity 0.2s;
  }
  #header .logo:hover .sitename { opacity: 0.82; }
  #header .logo .logo-dot {
    display: inline-block;
    width: 7px; height: 7px;
    background: var(--gt-accent);
    border-radius: 50%;
    margin-left: 2px;
    vertical-align: super;
    animation: pulse-dot 2s ease-in-out infinite;
  }
  @keyframes pulse-dot {
    0%,100% { transform: scale(1); opacity:1; }
    50% { transform: scale(1.4); opacity:0.7; }
  }

  /* Nav links */
  #header .navmenu ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 4px;
  }
  #header .navmenu ul li a {
    font-family: var(--gt-font-body);
    font-weight: 500;
    font-size: 0.9rem;
    color: var(--gt-muted);
    text-decoration: none;
    padding: 7px 16px;
    border-radius: 50px;
    position: relative;
    transition: all 0.22s ease;
    letter-spacing: 0.01em;
  }
  #header .navmenu ul li a:hover,
  #header .navmenu ul li a.active {
    color: var(--gt-primary);
    background: rgba(26,107,60,0.08);
  }
  #header .navmenu ul li a.active::after {
    content: '';
    display: block;
    width: 4px; height: 4px;
    border-radius: 50%;
    background: var(--gt-accent);
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
  }

  /* Chat icon */
  .gt-chat-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(26,107,60,0.07);
    color: var(--gt-primary);
    transition: all 0.22s ease;
    text-decoration: none !important;
  }
  .gt-chat-btn:hover {
    background: rgba(26,107,60,0.15);
    transform: scale(1.07);
    color: var(--gt-primary);
  }
  .gt-chat-btn .bi { font-size: 1.1rem; }
  .gt-chat-btn .gt-badge {
    position: absolute;
    top: -2px; right: -2px;
    background: #e53935;
    color: #fff;
    font-size: 0.6rem;
    font-weight: 700;
    min-width: 17px; height: 17px;
    border-radius: 50px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 4px;
    border: 2px solid #fff;
    line-height: 1;
  }

  /* Dropdown menus */
  .gt-dropdown-menu {
    border: 1.5px solid var(--gt-border) !important;
    border-radius: var(--gt-radius) !important;
    box-shadow: 0 8px 32px rgba(26,107,60,0.13) !important;
    padding: 8px !important;
    min-width: 240px !important;
    background: rgba(255,255,255,0.97) !important;
    backdrop-filter: blur(12px);
    margin-top: 10px !important;
    animation: dropDown 0.18s ease;
  }
  @keyframes dropDown {
    from { opacity:0; transform: translateY(-6px); }
    to   { opacity:1; transform: translateY(0); }
  }
  .gt-dropdown-menu .dropdown-header {
    font-family: var(--gt-font-display);
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--gt-muted);
    padding: 4px 10px 6px;
  }
  .gt-dropdown-menu .dropdown-item {
    border-radius: 9px;
    padding: 9px 12px;
    font-size: 0.875rem;
    color: var(--gt-text);
    font-family: var(--gt-font-body);
    transition: background 0.15s;
  }
  .gt-dropdown-menu .dropdown-item:hover {
    background: rgba(26,107,60,0.08);
    color: var(--gt-primary);
  }
  .gt-dropdown-menu .dropdown-divider {
    border-color: var(--gt-border);
    margin: 6px 0;
  }
  .gt-dropdown-menu .dropdown-item.text-danger:hover {
    background: rgba(229,57,53,0.08);
    color: #e53935 !important;
  }

  /* User avatar button */
  .gt-user-btn {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 5px 12px 5px 5px;
    border-radius: 50px;
    background: rgba(26,107,60,0.06);
    border: 1.5px solid var(--gt-border);
    text-decoration: none !important;
    color: var(--gt-text) !important;
    transition: all 0.22s ease;
  }
  .gt-user-btn:hover {
    background: rgba(26,107,60,0.11);
    border-color: rgba(26,107,60,0.22);
  }
  .gt-user-btn img {
    border: 2px solid var(--gt-accent);
    object-fit: cover;
  }
  .gt-user-btn .gt-user-name {
    font-family: var(--gt-font-body);
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--gt-text);
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .gt-user-btn .bi-chevron-down {
    font-size: 0.7rem;
    color: var(--gt-muted);
    transition: transform 0.2s;
  }
  .gt-user-btn[aria-expanded="true"] .bi-chevron-down {
    transform: rotate(180deg);
  }

  /* Login button */
  .gt-login-btn {
    font-family: var(--gt-font-body);
    font-weight: 600;
    font-size: 0.875rem;
    padding: 8px 20px;
    border-radius: 50px;
    border: 2px solid var(--gt-primary);
    color: var(--gt-primary);
    background: transparent;
    transition: all 0.22s ease;
    text-decoration: none;
    letter-spacing: 0.01em;
  }
  .gt-login-btn:hover {
    background: var(--gt-primary);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(26,107,60,0.28);
  }

  /* Kelas badge in chat dropdown */
  .gt-kelas-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: rgba(76,222,128,0.15);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .gt-kelas-icon .bi { color: var(--gt-primary); font-size: 0.95rem; }
  .gt-dm-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: rgba(66,133,244,0.12);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .gt-dm-icon .bi { color: #4285f4; font-size: 0.95rem; }

  /* Mobile toggle */
  .mobile-nav-toggle {
    color: var(--gt-primary);
    font-size: 1.3rem;
  }

  @media (max-width: 1199px) {
    #header .navmenu { display: none; }
  }
</style>

<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center" style="height:66px;">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto text-decoration-none">
      <h1 class="sitename mb-0">GoTugas<span class="logo-dot"></span></h1>
    </a>

    {{-- Nav --}}
    <nav id="navmenu" class="navmenu me-3">
      <ul>
        <li><a href="{{ url('/') }}" class="active">Beranda</a></li>
        <li><a href="{{ url('join') }}">Masuk Kelas</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    {{-- Auth section --}}
    @if (Route::has('login'))
    <div class="d-flex align-items-center gap-2">
      @auth

        {{-- Chat dropdown (siswa only) --}}
        @if(Auth::user()->role === 'siswa')
          @php
            $unreadDm = \App\Models\Message::where('receiver_id', Auth::id())
                ->whereNull('read_at')->whereNull('kelas_id')->count();
            $kelasSayaIds = Auth::user()->kelas()->pluck('kelas.id');
            $unreadKelas = \App\Models\Message::whereIn('kelas_id', $kelasSayaIds)
                ->where('sender_id', '!=', Auth::id())
                ->whereNull('receiver_id')->whereNull('read_at')->count();
            $totalUnread = $unreadDm + $unreadKelas;
          @endphp

          <div class="dropdown">
            <a href="#" class="gt-chat-btn" data-bs-toggle="dropdown" aria-expanded="false" title="Pesan">
              <i class="bi bi-chat-dots-fill"></i>
              @if($totalUnread > 0)
                <span class="gt-badge">{{ $totalUnread > 9 ? '9+' : $totalUnread }}</span>
              @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end gt-dropdown-menu">
              <li><h6 class="dropdown-header">Kotak Masuk</h6></li>

              @if($unreadDm > 0)
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                    <span class="gt-dm-icon"><i class="bi bi-envelope-fill"></i></span>
                    <div>
                      <div class="fw-semibold" style="font-size:0.85rem;">Pesan Langsung</div>
                      <small class="text-muted">{{ $unreadDm }} pesan belum dibaca</small>
                    </div>
                  </a>
                </li>
              @endif

              @foreach(Auth::user()->kelas()->with('mapel')->get() as $k)
                @php
                  $unreadK = \App\Models\Message::where('kelas_id', $k->id)
                      ->where('sender_id', '!=', Auth::id())
                      ->whereNull('receiver_id')->whereNull('read_at')->count();
                @endphp
                @if($unreadK > 0)
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2"
                       href="{{ route('siswa.chat.kelas', $k->id) }}">
                      <span class="gt-kelas-icon"><i class="bi bi-chat-left-fill"></i></span>
                      <div>
                        <div class="fw-semibold" style="font-size:0.85rem;">{{ $k->nama_kelas }}</div>
                        <small class="text-muted">{{ $unreadK }} pesan baru</small>
                      </div>
                    </a>
                  </li>
                @endif
              @endforeach

              @if($totalUnread == 0)
                <li>
                  <div class="text-center py-3">
                    <i class="bi bi-check2-all" style="font-size:1.4rem;color:var(--gt-accent);"></i>
                    <p class="text-muted small mb-0 mt-1">Semua pesan sudah dibaca</p>
                  </div>
                </li>
              @endif

              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item text-center fw-semibold"
                   style="font-size:0.825rem;color:var(--gt-primary);"
                   href="{{ route('siswa.chat.dm', Auth::id()) }}">
                  Lihat semua pesan →
                </a>
              </li>
            </ul>
          </div>
        @endif

        {{-- User dropdown --}}
        <div class="dropdown">
          <a class="gt-user-btn dropdown-toggle" href="#" id="userDropdown"
             data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ Auth::user()->foto_profil_url }}"
                 alt="Avatar" class="rounded-circle" width="30" height="30">
            <span class="gt-user-name">{{ Auth::user()->name }}</span>
            <i class="bi bi-chevron-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end gt-dropdown-menu" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profil') }}">
                <i class="bi bi-person-circle" style="color:var(--gt-primary);"></i>
                Profil Saya
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                  <i class="bi bi-box-arrow-right"></i>
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>

      @else
        <a href="{{ route('login') }}" class="gt-login-btn">Masuk</a>
      @endauth
    </div>
    @endif

  </div>
</header>