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

            <!-- Greeting Text (Desktop Only) -->
            <ul class="navbar-nav quick-links d-none d-lg-flex align-items-center ms-3">
                <li class="nav-item">
                    <span class="text-muted small">
                        <i class="ti ti-calendar-event me-1"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </li>
            </ul>

            <div class="d-block d-lg-none py-4">
                <a href="{{ route('guru.dashboard') }}" class="text-nowrap logo-img">
                    <img src="{{asset('/assets/backend/images/logos/logo_gotugas.png')}}" 
                         style="height: 40px; width:auto;" 
                         alt="GoTugas" />
                </a>
            </div>
            
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" 
               href="javascript:void(0)" 
               data-bs-toggle="collapse" 
               data-bs-target="#navbarNav" 
               aria-controls="navbarNav" 
               aria-expanded="false" 
               aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)" 
                       class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center" 
                       type="button" 
                       data-bs-toggle="offcanvas" 
                       data-bs-target="#mobilenavbar" 
                       aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        
                        <!-- Quick Actions (Desktop Only) -->
                        <li class="nav-item d-none d-lg-block me-2">
                            <div class="dropdown">
                                <a class="nav-link nav-icon-hover-bg rounded-circle" 
                                   href="#" 
                                   data-bs-toggle="dropdown" 
                                   aria-expanded="false">
                                    <i class="ti ti-plus"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
                                    <div class="px-3 py-2 border-bottom">
                                        <h6 class="mb-0">Aksi Cepat</h6>
                                    </div>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" 
                                       href="{{ route('guru.kelas.create') }}">
                                        <i class="ti ti-school text-primary"></i>
                                        <span>Buat Kelas Baru</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <div class="px-3 py-1">
                                        <small class="text-muted">Buat Tugas</small>
                                    </div>
                                    @php
                                        $quickKelas = App\Models\Kelas::where('guru_id', Auth::id())
                                                        ->orderBy('created_at', 'desc')
                                                        ->limit(3)
                                                        ->get();
                                    @endphp
                                    @forelse($quickKelas as $k)
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" 
                                           href="{{ route('guru.tugas.create', ['kelas' => $k->id]) }}">
                                            <i class="ti ti-file-plus text-warning"></i>
                                            <span>{{ $k->nama_kelas }}</span>
                                        </a>
                                    @empty
                                        <div class="px-3 py-2 text-muted">
                                            <small>Belum ada kelas</small>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </li>

                        <!-- Notifications -->
                        <li class="nav-item d-none d-lg-block me-2">
                            <a class="nav-link nav-icon-hover-bg rounded-circle position-relative" 
                               href="{{ route('guru.tugas.index') }}">
                                <i class="ti ti-bell"></i>
                                @php
                                    $ungraded = 0;
                                    $allKelas = App\Models\Kelas::where('guru_id', Auth::id())->get();
                                    foreach($allKelas as $kls) {
                                        foreach($kls->tugas as $tgs) {
                                            $ungraded += $tgs->pengumpulan()->whereNull('nilai')->count();
                                        }
                                    }
                                @endphp
                                @if($ungraded > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $ungraded > 9 ? '9+' : $ungraded }}
                                        <span class="visually-hidden">tugas belum dinilai</span>
                                    </span>
                                @endif
                            </a>
                        </li>

                        <!-- Theme Toggle -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                <i class="ti ti-moon moon"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)">
                                <i class="ti ti-sun sun"></i>
                            </a>
                        </li>
                        
                        <!-- Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" 
                               href="javascript:void(0)" 
                               id="drop1" 
                               aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{asset('/assets/backend/images/profile/user-1.jpg')}}" 
                                             class="rounded-circle" 
                                             width="35" 
                                             height="35" 
                                             alt="Profile" />
                                    </div>
                                    <div class="d-none d-lg-block ms-2">
                                        <span class="fw-semibold d-block">{{ Str::limit(Auth::user()->name, 15) }}</span>
                                        <small class="text-muted">Guru</small>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" 
                                 aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">Profile Guru</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="{{asset('/assets/backend/images/profile/user-1.jpg')}}" 
                                             class="rounded-circle" 
                                             width="80" 
                                             height="80" 
                                             alt="Profile" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">{{Auth::user()->name}}</h5>
                                            <span class="mb-1 d-block badge bg-success-subtle text-success">Guru</span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i>
                                                <small>{{Auth::user()->email}}</small>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Quick Stats in Dropdown -->
                                    <div class="py-3 px-7 border-bottom">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-primary fs-4">
                                                        {{ App\Models\Kelas::where('guru_id', Auth::id())->count() }}
                                                    </span>
                                                    <small class="text-muted">Kelas</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    @php
                                                        $totalTugas = 0;
                                                        $allKelas = App\Models\Kelas::where('guru_id', Auth::id())->get();
                                                        foreach($allKelas as $kls) {
                                                            $totalTugas += $kls->tugas->count();
                                                        }
                                                    @endphp
                                                    <span class="fw-bold text-warning fs-4">{{ $totalTugas }}</span>
                                                    <small class="text-muted">Tugas</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="{{ route('logout')}}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                           class="btn btn-outline-primary">
                                            <i class="ti ti-logout me-2"></i>Log Out
                                        </a>
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