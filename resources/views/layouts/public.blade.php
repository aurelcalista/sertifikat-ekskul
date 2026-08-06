<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sertifikat Ekskul') | Sistem Sertifikat</title>
    
    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script href="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAFAFA;
            color: #2C3E50;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Unique Floating Glassmorphism Island Navbar */
        .navbar-custom {
            position: sticky;
            top: 15px;
            z-index: 1050;
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(231, 76, 60, 0.1);
            border-radius: 50px;
            margin: 15px 10px 10px 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.01) !important;
            padding: 8px 20px !important;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .navbar-custom .container {
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 100%;
        }

        @media (max-width: 400px) {
            .navbar-custom {
                padding: 6px 12px !important;
            }
            .navbar-brand {
                gap: 4px !important;
            }
            .navbar-brand span {
                font-size: 0.95rem !important;
            }
            .navbar-brand img {
                width: 26px;
                height: 26px;
            }
        }

        @media (min-width: 1200px) {
            .navbar-custom {
                margin: 20px auto 10px auto;
                max-width: 1260px;
            }
        }

        @media (min-width: 1400px) {
            .navbar-custom {
                max-width: 1360px;
            }
        }

        .navbar-custom .nav-link {
            color: #4A5568;
            font-weight: 500;
            font-size: 0.925rem;
            padding: 8px 18px !important;
            border-radius: 30px;
            transition: all 0.25s ease;
        }
        
        .navbar-custom .nav-link:hover {
            color: #E74C3C !important;
            background-color: rgba(231, 76, 60, 0.06);
        }

        .navbar-custom .nav-link.active {
            color: white !important;
            background: #E74C3C;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .navbar-custom .navbar-toggler {
            border: none;
            padding: 4px 8px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
        }
        
        .navbar-custom .navbar-toggler:focus {
            box-shadow: none;
            background-color: rgba(231, 76, 60, 0.05);
        }
        
        @media (max-width: 991.98px) {
            .navbar-custom .navbar-collapse {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 15px;
                margin-top: 10px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.05);
                border: 1px solid rgba(231, 76, 60, 0.08);
            }
            .navbar-custom .nav-item {
                width: 100%;
                text-align: center;
                margin: 4px 0;
            }
            .navbar-custom .nav-item.me-3 {
                margin-right: 0 !important;
            }
        }

        .text-orange {
            color: #FF6B35;
        }

        .text-red {
            color: #E74C3C;
        }

        .btn-custom-primary {
            background-color: #E74C3C;
            color: white;
            border-radius: 30px;
            padding: 8px 24px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom-primary:hover {
            background-color: #d63031;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        }

        .btn-custom-outline {
            background: transparent;
            color: #2C3E50;
            border: 2px solid #E74C3C;
            border-radius: 30px;
            padding: 8px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom-outline:hover {
            background-color: #E74C3C;
            color: white;
            transform: translateY(-2px);
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            background: white;
            transition: all 0.3s ease;
        }

        .footer {
            margin-top: auto;
            background-color: #FFFFFF;
            border-top: 1px solid #ECEFF1;
        }

        /* Loading Spinner */
        .spinner-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255,255,255,0.85);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .spinner-wrapper.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Spinner Loading -->
    <div id="loader" class="spinner-wrapper">
        <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <!-- Logo Emblem -->
                <img src="{{ asset('logos/logo-rakitai.png') }}" alt="Logo" style="height: 26px; width: auto; object-fit: contain; flex-shrink: 0;">
                <!-- Small Sertifikat Label -->
                <span class="text-uppercase fw-semibold" style="font-size: 0.65rem; color: #E74C3C; letter-spacing: 0.5px; background-color: #FEE2E2; padding: 2px 6px; border-radius: 6px; white-space: nowrap;">Sertifikat</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link fw-medium {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ Request::routeIs('download.view') ? 'active' : '' }}" href="{{ route('download.view') }}">Cari Sertifikat</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-1 pb-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} <span class="text-red fw-semibold">Sertifikat.Ekskul</span>. Hak Cipta Dilindungi Undang-Undang.</p>
            <small class="text-muted">Dikembangkan dengan penuh dedikasi untuk memudahkan siswa mengunduh sertifikat.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Helper Loading
        function showLoader() {
            document.getElementById('loader').classList.add('show');
        }
        function hideLoader() {
            document.getElementById('loader').classList.remove('show');
        }

        // Global Alert if any redirect message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: '{{ session('error') }}',
                confirmButtonColor: '#E74C3C'
            });
        @endif
    </script>
    @yield('scripts')
</body>
</html>
