<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <title>@yield('title', 'Admin Dashboard') | Sertifikat Ekskul</title>
    
    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary-color: #E74C3C;
            --accent-color: #FF6B35;
            --bg-color: #F8F9FA;
            --card-bg: #FFFFFF;
            --text-color: #2C3E50;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --sidebar-width: 260px;
        }

        [data-theme="dark"] {
            --primary-color: #FF6B35;
            --accent-color: #E74C3C;
            --bg-color: #0F172A;
            --card-bg: #1E293B;
            --text-color: #F1F5F9;
            --text-muted: #94A3B8;
            --border-color: #334155;
        }

        /* Dark Theme Global Element & Utility Class Overrides */
        [data-theme="dark"] .text-dark {
            color: var(--text-color) !important;
        }
        [data-theme="dark"] .text-muted {
            color: var(--text-muted) !important;
        }
        [data-theme="dark"] .text-secondary {
            color: var(--text-muted) !important;
        }
        [data-theme="dark"] .bg-light {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: var(--text-color) !important;
        }
        [data-theme="dark"] .table-light, [data-theme="dark"] thead.table-light, [data-theme="dark"] .table-light th {
            --bs-table-bg: rgba(255, 255, 255, 0.06) !important;
            --bs-table-color: var(--text-color) !important;
            background-color: rgba(255, 255, 255, 0.06) !important;
            color: var(--text-color) !important;
        }
        [data-theme="dark"] .table {
            --bs-table-bg: var(--card-bg) !important;
            --bs-table-striped-bg: rgba(255, 255, 255, 0.02) !important;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.04) !important;
            --bs-table-border-color: var(--border-color) !important;
            --bs-table-color: var(--text-color) !important;
            color: var(--text-color) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .table td, [data-theme="dark"] .table th {
            color: var(--text-color) !important;
            background-color: var(--card-bg) !important;
        }
        [data-theme="dark"] .page-link {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--primary-color) !important;
        }
        [data-theme="dark"] .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        [data-theme="dark"] .page-item.disabled .page-link {
            background-color: var(--bg-color) !important;
            border-color: var(--border-color) !important;
            color: var(--text-muted) !important;
        }
        [data-theme="dark"] .card-custom-admin, [data-theme="dark"] .card {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-color) !important;
        }
        [data-theme="dark"] .form-control, [data-theme="dark"] .form-select {
            background-color: var(--bg-color) !important;
            color: var(--text-color) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.6;
        }
        [data-theme="dark"] .form-control:focus, [data-theme="dark"] .form-select:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.25) !important;
        }
        [data-theme="dark"] .modal-content {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-color) !important;
        }
        [data-theme="dark"] .modal-header, [data-theme="dark"] .modal-footer {
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(1) brightness(2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Sidebar Style */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 24px;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        /* Custom Modern Scrollbar for Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
            opacity: 0.8;
        }

        .hover-opacity:hover {
            opacity: 0.85;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 35px;
            text-decoration: none;
            color: var(--text-color);
        }

        .sidebar-brand span {
            color: var(--primary-color);
        }

        .menu-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 12px;
            font-weight: 600;
        }

        .nav-menu {
            list-style: none;
            padding-left: 0;
            margin-bottom: 30px;
        }

        .nav-menu-item {
            margin-bottom: 6px;
        }

        .nav-menu-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-menu-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 10px;
        }

        .nav-menu-link:hover, .nav-menu-link.active {
            color: white;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);
        }

        /* Bootstrap Pagination Styling to Match Theme */
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #FFFFFF !important;
        }
        .pagination .page-link {
            color: var(--primary-color) !important;
            border-color: var(--border-color);
            transition: all 0.2s ease;
        }
        .pagination .page-link:hover {
            background-color: rgba(231, 76, 60, 0.1) !important;
            border-color: var(--primary-color);
            color: var(--primary-color) !important;
        }
        .pagination .page-item.disabled .page-link {
            color: var(--text-muted) !important;
            background-color: transparent;
            border-color: var(--border-color);
        }
        [data-theme="dark"] .pagination .page-link {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        [data-theme="dark"] .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #ffffff !important;
        }

        /* Main Content Style */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 24px 35px;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 16px 24px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .card-stat {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            font-weight: bold;
        }

        .theme-toggle-btn {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .theme-toggle-btn:hover {
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
                padding: 16px;
            }
        }
        .sidebar-toggle-btn {
            display: block !important;
        }

        /* Sidebar Collapsed Styles (Desktop >= 992px) */
        @media (min-width: 992px) {
            .sidebar.collapsed {
                width: 75px;
                padding: 24px 10px;
            }
            .sidebar.collapsed .sidebar-brand div {
                display: none !important;
            }
            .sidebar.collapsed .sidebar-brand {
                justify-content: center;
                margin-bottom: 25px;
            }
            .sidebar.collapsed .menu-title {
                display: none !important;
            }
            .sidebar.collapsed .nav-menu-link span {
                display: none !important;
            }
            .sidebar.collapsed .nav-menu-link {
                justify-content: center;
                padding: 12px 0;
            }
            .sidebar.collapsed .nav-menu-link i {
                margin-right: 0;
                font-size: 1.25rem;
            }
            .sidebar.collapsed .btn-outline-danger span {
                display: none !important;
            }
            .sidebar.collapsed .btn-outline-danger {
                justify-content: center;
                padding: 12px 0 !important;
            }
            .sidebar.collapsed .btn-outline-danger i {
                margin-right: 0 !important;
                font-size: 1.1rem;
            }
            
            /* Adjust main content offset when collapsed */
            .sidebar.collapsed ~ .main-wrapper {
                margin-left: 75px;
            }
        }

        .card-custom-admin {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s ease;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <script>
            if (window.innerWidth >= 992 && localStorage.getItem('sidebar-collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        </script>

        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand d-flex align-items-center gap-2 mb-4 py-2 text-decoration-none">
            <!-- Logo Emblem -->
            <img src="{{ asset('logos/logo-rakitai.png') }}" alt="Logo" width="34" height="34" style="object-fit: contain; flex-shrink: 0;">
            <!-- Brand text -->
            <div class="d-flex align-items-center">
                <span class="fw-bold text-dark" style="font-size: 1.1rem; letter-spacing: -0.5px; line-height: 1;">Sertifikat</span>
                <span class="fw-bold px-1 text-muted" style="font-size: 1.1rem; line-height: 1;">|</span>
                <span class="fw-bold text-danger" style="font-size: 1.1rem; letter-spacing: -0.5px; line-height: 1;">Ekskul</span>
            </div>
        </a>

        <div class="menu-title">Menu Utama</div>
        <ul class="nav-menu">
            <li class="nav-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-menu-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="{{ route('admin.certificates.index') }}" class="nav-menu-link {{ Request::routeIs('admin.certificates.index') || Request::routeIs('admin.certificates.edit') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice"></i><span>Data Sertifikat</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="{{ route('admin.certificates.create') }}" class="nav-menu-link {{ Request::routeIs('admin.certificates.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-plus"></i><span>Tambah Sertifikat</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="{{ route('admin.certificates.preview') }}" class="nav-menu-link {{ Request::routeIs('admin.certificates.preview') ? 'active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass-chart"></i><span>Portal Cari & Preview</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="{{ route('admin.templates.index') }}" class="nav-menu-link {{ Request::routeIs('admin.templates.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-wand-magic-sparkles"></i><span>Template Sertifikat</span>
                </a>
            </li>

            <li class="nav-menu-item">
                <a href="{{ route('admin.download-histories') }}" class="nav-menu-link {{ Request::routeIs('admin.download-histories') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i><span>Riwayat Download</span>
                </a>
            </li>
            <li class="nav-menu-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-menu-link {{ Request::routeIs('admin.settings.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-gears"></i><span>Pengaturan</span>
                </a>
            </li>
        </ul>

        <div class="mt-auto">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 border-0 rounded-3 text-start px-3 py-2">
                    <i class="fa-solid fa-right-from-bracket me-2"></i><span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light sidebar-toggle-btn border" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="d-none d-sm-block">
                    <h5 class="fw-semibold mb-0">Portal Administrasi</h5>
                    <small class="text-muted">{{ date('d F Y') }}</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-4">
                <!-- Theme Toggle -->
                <button class="theme-toggle-btn" onclick="toggleTheme()" title="Ganti Tema">
                    <i class="fa-solid fa-moon" id="theme-icon"></i>
                </button>
                
                <!-- Admin Profile Info (Clickable Link to Profile Settings) -->
                <a href="{{ route('admin.profile.edit') }}" class="d-flex align-items-center gap-2 text-decoration-none text-dark hover-opacity" title="Kelola Profil">
                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                        {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                    </div>
                    <div class="d-none d-md-block text-start">
                        <span class="fw-semibold d-block small" style="color: var(--text-color);">{{ Auth::guard('admin')->user()->name }}</span>
                        <span class="text-muted small d-block" style="font-size: 0.75rem;">Administrator</span>
                    </div>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <section class="content-body flex-1">
            @yield('content')
        </section>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Sidebar Toggle for Mobile & Desktop Collapse
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth >= 992) {
                sidebar.classList.toggle('collapsed');
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebar-collapsed', isCollapsed ? 'true' : 'false');
            } else {
                sidebar.classList.toggle('active');
            }
        }

        // Dark Mode Logic
        const themeToggle = document.querySelector('.theme-toggle-btn');
        const themeIcon = document.getElementById('theme-icon');
        
        // Cek local storage theme
        if (localStorage.getItem('admin-theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            themeIcon.className = 'fa-solid fa-sun';
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            themeIcon.className = 'fa-solid fa-moon';
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            let newTheme = 'light';
            if (currentTheme === 'light') {
                newTheme = 'dark';
                themeIcon.className = 'fa-solid fa-sun';
            } else {
                themeIcon.className = 'fa-solid fa-moon';
            }
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('admin-theme', newTheme);
        }

        // Global Alert Success/Error
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
