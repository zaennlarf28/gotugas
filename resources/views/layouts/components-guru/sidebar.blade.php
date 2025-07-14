<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu p-3">
      <div class="nav flex-column">

        <h6 class="text-light text-uppercase small fw-bold mb-3">Menu Guru</h6>

        <!-- Dashboard -->
        <a class="nav-link d-flex align-items-center py-2 rounded {{ request()->routeIs('guru.dashboard') ? 'bg-success text-white' : 'text-light' }}"
           href="{{ route('guru.dashboard') }}">
          <i class="fas fa-chart-line me-2"></i> Dashboard
        </a>

        <!-- Mata Pelajaran -->
        <a class="nav-link d-flex align-items-center py-2 rounded {{ request()->routeIs('guru.mapel.*') ? 'bg-success text-white' : 'text-light' }}"
           href="{{ route('guru.mapel.index') }}">
          <i class="fas fa-book me-2"></i> Mata Pelajaran
        </a>

        <!-- Kelas Saya -->
        <a class="nav-link d-flex align-items-center py-2 rounded {{ request()->routeIs('guru.kelas.*') ? 'bg-success text-white' : 'text-light' }}"
           href="{{ route('guru.kelas.index') }}">
          <i class="fas fa-chalkboard-teacher me-2"></i> Kelas Saya
        </a>

        <!-- Tugas -->
        <a class="nav-link d-flex align-items-center py-2 rounded {{ request()->routeIs('guru.tugas.*') ? 'bg-success text-white' : 'text-light' }}"
           href="{{ route('guru.tugas.index') }}">
          <i class="fas fa-tasks me-2"></i> Tugas
        </a>
      </div>
    </div>

    <!-- Footer Sidebar -->
    <div class="sb-sidenav-footer bg-dark border-top border-secondary text-center py-3">
      <small class="text-muted">Login sebagai:</small><br>
      <strong class="text-white">{{ Auth::user()->name ?? 'Guest' }}</strong>
    </div>
  </nav>
</div>
