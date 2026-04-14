<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GoTugas - Login</title>

  <link rel="shortcut icon" href="{{ asset('assets/backend/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/backend/css/styles.css') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #f5f7fa;
      font-family: 'Inter', 'Segoe UI', sans-serif;
      position: relative;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Background Decorative Circles */
    body::before,
    body::after {
      content: '';
      position: fixed;
      border-radius: 50%;
      z-index: 0;
    }

    body::before {
      width: 400px;
      height: 400px;
      background: linear-gradient(135deg, rgba(15, 157, 88, 0.08) 0%, rgba(11, 128, 67, 0.05) 100%);
      top: -100px;
      right: -100px;
      border: 1px solid rgba(15, 157, 88, 0.1);
    }

    body::after {
      width: 300px;
      height: 300px;
      background: linear-gradient(135deg, rgba(15, 157, 88, 0.06) 0%, rgba(11, 128, 67, 0.03) 100%);
      bottom: -80px;
      left: -80px;
      border: 1px solid rgba(15, 157, 88, 0.08);
    }

    /* Additional decorative dots */
    .bg-decoration {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: 0;
      pointer-events: none;
    }

    .dot {
      position: absolute;
      width: 6px;
      height: 6px;
      background: rgba(15, 157, 88, 0.15);
      border-radius: 50%;
    }

    .dot:nth-child(1) { top: 10%; right: 15%; }
    .dot:nth-child(2) { top: 20%; right: 25%; }
    .dot:nth-child(3) { top: 15%; right: 35%; }
    .dot:nth-child(4) { top: 25%; right: 20%; }
    .dot:nth-child(5) { top: 30%; right: 30%; }
    .dot:nth-child(6) { top: 12%; right: 40%; }
    .dot:nth-child(7) { bottom: 15%; left: 20%; }
    .dot:nth-child(8) { bottom: 25%; left: 15%; }
    .dot:nth-child(9) { bottom: 20%; left: 30%; }
    .dot:nth-child(10) { bottom: 30%; left: 25%; }
    .dot:nth-child(11) { bottom: 18%; left: 35%; }
    .dot:nth-child(12) { bottom: 28%; left: 18%; }

    .login-container {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .card {
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      background: #ffffff;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      width: 100%;
      max-width: 480px;
    }

    .card-body {
      padding: 3rem 2.5rem;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 2rem;
    }

    .logo-wrapper {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      margin-bottom: 1.5rem;
    }

    .logo-image {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      object-fit: cover;
    }

    .brand-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: #0f9d58;
      margin: 0;
    }

    .welcome-text {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1f2937;
      margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
      color: #6b7280;
      font-size: 0.95rem;
      font-weight: 400;
      line-height: 1.5;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
      border-radius: 8px;
      padding: 12px 16px;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .form-group {
      margin-bottom: 1.25rem;
    }

    .form-label-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .form-label {
      color: #374151;
      font-weight: 600;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .forgot-link {
      color: #0f9d58;
      text-decoration: none;
      font-size: 0.875rem;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .forgot-link:hover {
      color: #0b8043;
      text-decoration: underline;
    }

    .form-control {
      border: 1px solid #d1d5db;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      transition: all 0.2s ease;
      background: #ffffff;
      width: 100%;
    }

    .form-control::placeholder {
      color: #9ca3af;
    }

    .form-control:focus {
      border-color: #0f9d58;
      box-shadow: 0 0 0 3px rgba(15, 157, 88, 0.1);
      outline: none;
      background: #ffffff;
    }

    .form-control.is-invalid {
      border-color: #ef4444;
    }

    .form-control.is-invalid:focus {
      box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .text-danger {
      color: #ef4444;
      font-size: 0.8rem;
      margin-top: 0.375rem;
      display: block;
    }

    .btn-login {
      width: 100%;
      border-radius: 8px;
      background: #0f9d58;
      border: none;
      color: #fff;
      padding: 0.875rem 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      transition: all 0.2s ease;
      cursor: pointer;
      margin-top: 0.5rem;
    }

    .btn-login:hover {
      background: #0b8043;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(15, 157, 88, 0.25);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .btn-login:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    .divider {
      text-align: center;
      margin: 1.5rem 0;
      position: relative;
    }

    .divider-text {
      background: #ffffff;
      padding: 0 1rem;
      color: #6b7280;
      font-size: 0.875rem;
      position: relative;
      z-index: 1;
    }

    .divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: #e5e7eb;
      z-index: 0;
    }

    .register-link {
      text-align: center;
      color: #6b7280;
      font-size: 0.9rem;
    }

    .register-link a {
      color: #0f9d58;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.2s ease;
    }

    .register-link a:hover {
      color: #0b8043;
      text-decoration: underline;
    }

    .footer-text {
      text-align: center;
      margin-top: 2rem;
      color: #6b7280;
      font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 576px) {
      .card-body {
        padding: 2rem 1.5rem;
      }

      .welcome-text {
        font-size: 1.25rem;
      }

      .brand-title {
        font-size: 1.5rem;
      }

      .logo-image {
        width: 45px;
        height: 45px;
      }

      body::before {
        width: 300px;
        height: 300px;
      }

      body::after {
        width: 200px;
        height: 200px;
      }
    }
  </style>
</head>

<body>
  <!-- Background Decorative Dots -->
  <div class="bg-decoration">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>

  <div class="login-container">
    <div style="width: 100%; max-width: 480px;">
      <div class="card">
        <div class="card-body">

          <!-- Logo & Brand -->
          <div class="logo-container">
            <div class="logo-wrapper">
              <img src="{{ asset('assets/frontend/img/ikon-buku.jpg') }}" alt="GoTugas Logo" class="logo-image">
              <h1 class="brand-title">GoTugas</h1>
            </div>
            <h2 class="welcome-text">Selamat Datang! 👋</h2>
            <p class="welcome-subtitle">Silakan masuk ke akun Anda untuk memulai</p>
          </div>

          <!-- Success Alert -->
          @if(session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif

          <!-- Login Form -->
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
              <div class="form-label-wrapper">
                <label for="email" class="form-label">Email atau Username</label>
              </div>
              <input 
                id="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror"
                name="email" 
                value="{{ old('email') }}" 
                placeholder="Masukkan email atau username Anda"
                required 
                autofocus
              >
              @error('email')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
              <div class="form-label-wrapper">
                <label for="password" class="form-label">Password</label>
                <!-- Uncomment jika perlu lupa password -->
                <!--
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                -->
              </div>
              <input 
                id="password" 
                type="password" 
                class="form-control @error('password') is-invalid @enderror"
                name="password" 
                placeholder="••••••••"
                required
              >
              @error('password')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
              Masuk
            </button>

            <!-- Register Link (Optional) -->
            <!--
            <div class="divider">
              <span class="divider-text">Atau</span>
            </div>
            <div class="register-link">
              Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
            -->
          </form>

        </div>
      </div>

      <!-- Footer -->
      <div class="footer-text">
        &copy; {{ date('Y') }} GoTugas. Dibuat oleh Zaenal Arif
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/backend/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('assets/backend/js/theme/theme.js') }}"></script>
</body>
</html>