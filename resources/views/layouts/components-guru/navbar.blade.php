<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <!-- Brand -->
  <a class="navbar-brand ps-3 fw-semibold" href="#">
    <i class="fas fa-chalkboard-teacher me-2"></i>Dashboard Guru
  </a>

  <!-- Sidebar Toggle -->
  <button class="btn btn-link btn-sm me-4" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Spacer -->
  <div class="ms-auto"></div>

  <!-- User Dropdown -->
  <ul class="navbar-nav ms-auto me-3 me-lg-4">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
         data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user fa-fw"></i>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
        <li><hr class="dropdown-divider" /></li>
        <li>
          <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
            @csrf
            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin logout?')">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
          </form>
        </li>
      </ul>
    </li>
  </ul>
</nav>
