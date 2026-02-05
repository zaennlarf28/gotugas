<aside class="left-sidebar with-vertical" >
    <div>
        <!-- Brand Logo -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('guru.dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/backend/images/logos/logo_gotugas.png') }}"
                     class="dark-logo"
                     alt="Logo-Dark"
                     style="height: 64px; width:auto;">

                <img src="{{ asset('assets/backend/images/logos/logo_gotugas.png') }}"
                     class="light-logo"
                     alt="Logo-light"
                     style="height: 64px; width:auto;">
            </a>

            <a href="javascript:void(0)"
               class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav scroll-sidebar mt-2" data-simplebar>
            <ul id="sidebarnav">

                <!-- Dashboard -->
                <li class="sidebar-item {{ request()->routeIs('guru.dashboard*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.dashboard') }}">
                        <span><i class="ti ti-home"></i></span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu Utama</span>
                </li>

                <!-- Kelas Saya -->
                @php
                    $totalKelas = App\Models\Kelas::where('guru_id', Auth::id())->count();
                @endphp
                <li class="sidebar-item {{ request()->routeIs('guru.kelas.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.kelas.index') }}">
                        <span><i class="ti ti-chalkboard"></i></span>
                        <span class="hide-menu">Kelas Saya</span>

                        @if($totalKelas > 0)
                            <span class="badge bg-primary-subtle text-primary rounded-pill ms-auto">
                                {{ $totalKelas }}
                            </span>
                        @endif
                    </a>
                </li>

                <!-- Tugas -->
                @php
                    $totalTugas = \App\Models\Tugas::whereHas('kelas', function ($q) {
                        $q->where('guru_id', Auth::id());
                    })->count();
                @endphp
                <li class="sidebar-item {{ request()->routeIs('guru.tugas.*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.tugas.index') }}">
                        <span><i class="ti ti-clipboard-list"></i></span>
                        <span class="hide-menu">Tugas</span>

                        @if($totalTugas > 0)
                            <span class="badge bg-warning-subtle text-warning rounded-pill ms-auto">
                                {{ $totalTugas }}
                            </span>
                        @endif
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Profile Section -->
        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img position-relative">
                    <img src="{{ asset('assets/backend/images/profile/user-1.jpg') }}"
                         class="rounded-circle"
                         width="40"
                         height="40" />
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle"></span>
                </div>

                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">
                        {{ Str::limit(Auth::user()->name, 12) }}
                    </h6>
                    <span class="fs-2 badge bg-success-subtle text-success">Guru</span>
                </div>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="border-0 bg-transparent text-primary ms-auto"
                   title="Logout">
                    <i class="ti ti-power fs-6"></i>
                </a>

                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</aside>
