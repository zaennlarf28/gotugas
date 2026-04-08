<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>GoTugas — Platform Tugas Sekolah</title>
  <meta name="description" content="GoTugas - Platform manajemen tugas sekolah yang mudah digunakan">
  <meta name="keywords" content="gotugas, tugas sekolah, manajemen kelas">

  <!-- Favicons -->
  <link href="{{ asset('assets/frontend/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/frontend/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800;900&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('assets/frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('assets/frontend/css/main.css') }}" rel="stylesheet">

  <style>
    /* ── Global resets for GoTugas theme ── */
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Ubuntu', sans-serif;
      background: #f6fbf8;
      margin: 0;
    }

    /* ── Smooth page transitions ── */
    .main {
      animation: pageIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    @keyframes pageIn {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Scroll to top button ── */
    .gt-scroll-top {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: #1a6b3c;
      color: #fff;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      box-shadow: 0 4px 16px rgba(26,107,60,0.35);
      opacity: 0;
      transform: translateY(16px);
      transition: all 0.3s ease;
      z-index: 9999;
      text-decoration: none;
    }
    .gt-scroll-top.show {
      opacity: 1;
      transform: translateY(0);
    }
    .gt-scroll-top:hover {
      background: #22883f;
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(26,107,60,0.4);
    }

    /* ── Toast notifications ── */
    .gt-toast-container {
      position: fixed;
      top: 80px;
      right: 20px;
      z-index: 99999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .gt-toast {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px 18px;
      border-radius: 14px;
      font-family: 'Ubuntu', sans-serif;
      font-size: 0.875rem;
      font-weight: 500;
      box-shadow: 0 8px 28px rgba(0,0,0,0.12);
      animation: toastIn 0.4s cubic-bezier(0.22,1,0.36,1) both;
      min-width: 280px;
      max-width: 360px;
    }
    @keyframes toastIn {
      from { opacity:0; transform: translateX(20px); }
      to   { opacity:1; transform: translateX(0); }
    }
    .gt-toast.success {
      background: #d4f7e2;
      color: #1a6b3c;
      border: 1.5px solid rgba(76,222,128,0.4);
    }
    .gt-toast.error {
      background: #fff0f0;
      color: #c0392b;
      border: 1.5px solid rgba(192,57,43,0.2);
    }
    .gt-toast .bi { font-size: 1rem; flex-shrink: 0; }
    .gt-toast .gt-toast-close {
      margin-left: auto;
      background: none;
      border: none;
      cursor: pointer;
      color: inherit;
      opacity: 0.6;
      font-size: 0.9rem;
      padding: 0;
      line-height: 1;
    }
    .gt-toast .gt-toast-close:hover { opacity: 1; }

    /* ── Global scrollbar styling ── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb {
      background: rgba(26,107,60,0.25);
      border-radius: 99px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(26,107,60,0.45);
    }

    /* ── Focus ring ── */
    :focus-visible {
      outline: 2.5px solid #4cde80;
      outline-offset: 3px;
    }
  </style>

  @stack('styles')
</head>

<body class="index-page">

  {{-- Preloader --}}
  <div id="gt-preloader"
       style="position:fixed;inset:0;z-index:999999;background:#f6fbf8;display:flex;align-items:center;justify-content:center;transition:opacity 0.5s ease;">
    <div style="text-align:center;">
      <div style="width:48px;height:48px;border:3px solid rgba(26,107,60,0.15);border-top-color:#1a6b3c;border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 12px;"></div>
      <div style="font-family:'Raleway',sans-serif;font-weight:800;font-size:1.1rem;background:linear-gradient(135deg,#1a6b3c,#4cde80);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">GoTugas</div>
    </div>
    <style>@keyframes spin{to{transform:rotate(360deg)}}</style>
  </div>

  {{-- Header --}}
  @include('layouts.components-frontend.navbar')

  {{-- Toast notifications --}}
  <div class="gt-toast-container" id="gt-toasts">
    @if(session('success'))
      <div class="gt-toast success" id="toast-success">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
        <button class="gt-toast-close" onclick="this.closest('.gt-toast').remove()">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    @endif
    @if(session('error'))
      <div class="gt-toast error" id="toast-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <span>{{ session('error') }}</span>
        <button class="gt-toast-close" onclick="this.closest('.gt-toast').remove()">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    @endif
  </div>

  {{-- Main content --}}
  <main class="main">
    @yield('content')
  </main>

  {{-- Scroll to top --}}
  <a href="#" class="gt-scroll-top" id="gt-scroll-top" title="Kembali ke atas">
    <i class="bi bi-arrow-up"></i>
  </a>

  {{-- Footer --}}
  @include('layouts.components-frontend.footer')

  <!-- Vendor JS -->
  <script src="{{ asset('assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/frontend/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/frontend/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/frontend/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/frontend/js/main.js') }}"></script>

  <script>
    // Preloader
    window.addEventListener('load', () => {
      const pre = document.getElementById('gt-preloader');
      if (pre) {
        pre.style.opacity = '0';
        setTimeout(() => pre.remove(), 500);
      }
    });

    // AOS init
    AOS.init({ duration: 600, easing: 'ease-out-cubic', once: true, offset: 40 });

    // Scroll top
    const scrollBtn = document.getElementById('gt-scroll-top');
    window.addEventListener('scroll', () => {
      scrollBtn.classList.toggle('show', window.scrollY > 300);
    });
    scrollBtn.addEventListener('click', e => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Auto-dismiss toasts after 4s
    document.querySelectorAll('.gt-toast').forEach(toast => {
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(20px)';
        toast.style.transition = 'all 0.35s ease';
        setTimeout(() => toast.remove(), 350);
      }, 4000);
    });
  </script>

  @stack('scripts')
</body>

</html>