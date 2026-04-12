<aside class="left-sidebar with-vertical">
    <div>
        {{-- Brand Logo --}}
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('backend.dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/backend/images/logos/logo_gotugas.png') }}"
                     class="dark-logo" alt="Logo-Dark"
                     style="height: 64px; width:auto;">
                <img src="{{ asset('assets/backend/images/logos/logo_gotugas.png') }}"
                     class="light-logo" alt="Logo-light"
                     style="height: 64px; width:auto;">
            </a>
            <a href="javascript:void(0)"
               class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav scroll-sidebar mt-2" data-simplebar>
            <ul id="sidebarnav">

                <li class="sidebar-item {{ request()->routeIs('backend.dashboard*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.dashboard') }}" aria-expanded="false">
                        <span><i class="ti ti-home"></i></span>
                        <span class="hide-menu">Home</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <span class="hide-menu">Akademik</span>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.mapel.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.mapel.index') }}" aria-expanded="false">
                        <span><i class="ti ti-book"></i></span>
                        <span class="hide-menu">Mapel</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.classes.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.classes.index') }}" aria-expanded="false">
                        <span><i class="ti ti-school"></i></span>
                        <span class="hide-menu">Class</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <span class="hide-menu">Akun</span>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.guru.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.guru.index') }}" aria-expanded="false">
                        <span><i class="ti ti-user"></i></span>
                        <span class="hide-menu">Guru</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('backend.siswa.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('backend.siswa.index') }}" aria-expanded="false">
                        <span><i class="ti ti-user"></i></span>
                        <span class="hide-menu">Siswa</span>
                    </a>
                </li>

            </ul>
        </nav>

        {{-- ✅ Profile section dengan foto dinamis --}}
        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div style="flex-shrink:0;">
                    {{-- ✅ Foto profil dinamis --}}
                    <img src="{{ Auth::user()->foto_profil_url }}"
                         class="rounded-circle"
                         width="40" height="40"
                         style="object-fit:cover;border:2px solid #dee2e6;"
                         alt="{{ Auth::user()->name }}" />
                </div>

                <div class="john-title overflow-hidden">
                    <h6 class="mb-0 fs-4 fw-semibold text-truncate" style="max-width:100px;">
                        {{ Auth::user()->name }}
                    </h6>
                    <span class="fs-2 badge bg-danger-subtle text-danger">Admin</span>
                </div>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-admin-sidebar').submit();"
                   class="border-0 bg-transparent text-primary ms-auto"
                   title="Logout">
                    <i class="ti ti-power fs-6"></i>
                </a>

                <form action="{{ route('logout') }}" method="POST"
                      id="logout-form-admin-sidebar" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </div>
</aside>