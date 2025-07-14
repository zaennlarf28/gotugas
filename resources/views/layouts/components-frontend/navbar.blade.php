<header id="header" class="header d-flex align-items-center sticky-top shadow-sm">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
      <h1 class="sitename">GoTugas</h1>
    </a>

    <nav id="navmenu" class="navmenu me-3">
      <ul>
        <li><a href="{{ url('/') }}" class="active">Beranda</a></li>
        <li><a href="{{url('join')}}">Masuk Kelas</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    {{-- Login/Register/User --}}
    @if (Route::has('login'))
    <div class="d-flex align-items-center gap-3">
      @auth
      <div class="dropdown">
        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ Auth::user()->foto_profil_url }}"
     alt="Avatar" class="rounded-circle me-2" width="30" height="30">
          <span class="fw-semibold">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="{{ route('profil') }}">Profil Saya</a></li>
          
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger">Logout</button>
            </form>
          </li>
        </ul>
      </div>
      @else
      <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm">Log in</a>
      @endauth
    </div>
    @endif

  </div>
</header>
