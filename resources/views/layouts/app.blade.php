<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoTugas - Login</title>

  <link rel="shortcut icon" href="{{ asset('assets/backend/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/css/styles.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>

  <style>
    body {
      background: #f5f5f5ff;
      font-family: 'Segoe UI', sans-serif;
      position: relative;
      overflow: hidden;
      color: #212121;
    }

    #particles-bg {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .card {
      border: 1px solid #e0e0e0;
      border-radius: 1rem;
      background: #ffffff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .form-control {
      border-radius: 0.5rem;
    }

    .btn-login {
      border-radius: 0.5rem;
      background-color: #4CAF50;
      border: none;
      color: #fff;
    }

    .btn-login:hover {
      background-color: #43a047;
    }

    label {
      font-weight: 600;
      color: #424242;
    }

    .form-label {
      color: #616161;
    }

    .alert-success {
      background-color: #e8f5e9;
      color: #388e3c;
      border: none;
    }

    .text-muted small {
      font-size: 0.85rem;
    }

    .logo-image {
      width: 130px;
      height: auto;
      border-radius: 12px;
    }

    .text-success {
      color: #388e3c !important;
    }
  </style>
</head>

<body>
  <!-- Partikel -->
  <div id="particles-bg"></div>

  <div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="col-md-8 col-lg-5 col-xxl-4">
      <div class="card p-4">
        <div class="card-body">

          <!-- Header dengan Logo -->
          <div class="text-center mb-4">
            <img src="{{ asset('storage/ikon-buku.jpg') }}" alt="Ikon Buku" class="logo-image mb-3">
            <h3 class="fw-bold mt-2 text-dark mb-1">GoTugas</h3>
            <small class="text-muted">Silakan login untuk melanjutkan</small>
          </div>

          @if(session('status'))
            <div class="alert alert-success text-center py-2">
              {{ session('status') }}
            </div>
          @endif

          <!-- Form Login -->
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <label for="email">Email</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                     name="email" value="{{ old('email') }}" required autofocus>
              @error('email')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <div class="mb-4">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                     name="password" required>
              @error('password')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-login fw-semibold">Login</button>
            </div>

            <!-- Uncomment kalau mau fitur lupa password -->
            <!--
            <div class="text-center">
              <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary small">
                Lupa password?
              </a>
            </div>
            -->
          </form>

        </div>
      </div>

      <div class="text-center mt-3 text-muted">
        <small>&copy; {{ date('Y') }} GoTugas. Oleh Zaenal Arif.</small>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/backend/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('assets/backend/js/theme/theme.js') }}"></script>

  <script>
    tsParticles.load("particles-bg", {
      fullScreen: false,
      background: { color: "#f5f5f5" },
      particles: {
        number: { value: 40 },
        color: { value: "#81c784" },
        shape: { type: "circle" },
        opacity: { value: 0.4 },
        size: { value: 4 },
        move: { enable: true, speed: 1 },
        links: { enable: true, color: "#c8e6c9", distance: 100, opacity: 0.3 }
      },
      detectRetina: true,
    });
  </script>
</body>
</html>
