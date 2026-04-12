<aside class="left-sidebar with-vertical">
    <div>
        {{-- Brand Logo --}}
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('guru.dashboard') }}" class="text-nowrap logo-img">
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

        {{-- Sidebar Navigation --}}
        <nav class="sidebar-nav scroll-sidebar mt-2" data-simplebar>
            <ul id="sidebarnav">

                {{-- Dashboard --}}
                <li class="sidebar-item {{ request()->routeIs('guru.dashboard*') ? 'selected' : '' }}">
                    <a class="sidebar-link" href="{{ route('guru.dashboard') }}">
                        <span><i class="ti ti-home"></i></span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu Utama</span>
                </li>

                {{-- Kelas --}}
                @php $totalKelas = App\Models\Kelas::where('guru_id', Auth::id())->count(); @endphp
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

                {{-- Tugas --}}
                @php
                    $totalTugas = \App\Models\Tugas::whereHas('kelas', fn($q) => $q->where('guru_id', Auth::id()))->count();
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

        {{-- ✅ Profile section dengan foto dinamis --}}
        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="position-relative" style="flex-shrink:0;">
                    {{-- ✅ Foto profil dinamis --}}
                    <img src="{{ Auth::user()->foto_profil_url }}"
                         class="rounded-circle"
                         width="40" height="40"
                         style="object-fit:cover;border:2px solid #dee2e6;"
                         alt="{{ Auth::user()->name }}" />
                    {{-- Online dot --}}
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"
                          style="width:10px;height:10px;"></span>
                </div>

                <div class="john-title overflow-hidden">
                    <h6 class="mb-0 fs-4 fw-semibold text-truncate" style="max-width:100px;">
                        {{ Auth::user()->name }}
                    </h6>
                    <span class="fs-2 badge bg-success-subtle text-success">Guru</span>
                </div>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                   class="border-0 bg-transparent text-primary ms-auto"
                   title="Logout">
                    <i class="ti ti-power fs-6"></i>
                </a>

                <form action="{{ route('logout') }}" method="POST"
                      id="logout-form-sidebar" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </div>
</aside>