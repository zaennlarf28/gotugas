<header class="topbar">
    <div class="with-vertical">
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav quick-links d-none d-lg-flex align-items-center ms-3">
                <li class="nav-item">
                    <span class="text-muted small">
                        <i class="ti ti-calendar-event me-1"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </li>
            </ul>

            <div class="d-block d-lg-none py-4">
                <a href="./main/index.html" class="text-nowrap logo-img">
                    <img src="{{ asset('/assets/backend/images/logos/logo_gotugas.png') }}"
                         style="height:40px;width:auto;" alt="GoTugas" />
                </a>
            </div>

            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0"
               href="javascript:void(0)"
               data-bs-toggle="collapse" data-bs-target="#navbarNav"
               aria-controls="navbarNav" aria-expanded="false"
               aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)"
                       class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center"
                       type="button" data-bs-toggle="offcanvas"
                       data-bs-target="#mobilenavbar">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>

                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                        {{-- Dark/Light mode --}}
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                <i class="ti ti-moon moon"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)">
                                <i class="ti ti-sun sun"></i>
                            </a>
                        </li>

                        {{-- Profile Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)"
                               id="dropAdmin" aria-expanded="false">
                                <div class="d-flex align-items-center gap-2">
                                    {{-- ✅ Foto profil dinamis --}}
                                    <img src="{{ Auth::user()->foto_profil_url }}"
                                         class="rounded-circle"
                                         width="35" height="35"
                                         style="object-fit:cover;border:2px solid #e9ecef;"
                                         alt="{{ Auth::user()->name }}" />
                                    <div class="d-none d-lg-block">
                                        <span class="fw-semibold d-block" style="font-size:0.85rem;">
                                            {{ Str::limit(Auth::user()->name, 15) }}
                                        </span>
                                        <small class="text-muted">Admin</small>
                                    </div>
                                </div>
                            </a>

                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="dropAdmin">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">Profil Admin</h5>
                                    </div>

                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        {{-- ✅ Foto profil dinamis di dropdown --}}
                                        <img src="{{ Auth::user()->foto_profil_url }}"
                                             class="rounded-circle"
                                             width="80" height="80"
                                             style="object-fit:cover;border:3px solid #e9ecef;"
                                             alt="{{ Auth::user()->name }}" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                            <span class="mb-1 d-block badge bg-danger-subtle text-danger">
                                                Admin
                                            </span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i>
                                                <small>{{ Auth::user()->email }}</small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form-admin-nav').submit();"
                                           class="btn btn-outline-primary">
                                            <i class="ti ti-logout me-2"></i>Log Out
                                        </a>
                                        <form action="{{ route('logout') }}" method="POST"
                                              id="logout-form-admin-nav" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>