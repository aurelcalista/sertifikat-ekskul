<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin | Sertifikat Ekskul</title>
    
    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFFFFF;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            overflow-x: hidden;
        }

        .login-container {
            width: 100%;
            min-height: 100vh;
            display: flex;
        }

        /* Left Side: Brand Info & Illustration */
        .login-left {
            flex: 1.2;
            background-color: #FFFFFF;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid #ECEFF1;
        }

        /* Right Side: Login Card */
        .login-right {
            flex: 1;
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-text-large {
            font-size: 1.5rem;
            font-weight: 700;
            color: #E74C3C;
            letter-spacing: -0.5px;
        }

        .brand-text-divider {
            font-size: 1.5rem;
            font-weight: 700;
            color: #CFD8DC;
        }

        .brand-text-dark {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2C3E50;
            letter-spacing: -0.5px;
        }

        .brand-sub {
            font-size: 0.8rem;
            color: #78909C;
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }

        .welcome-section {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .welcome-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #2C3E50;
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .welcome-title span {
            color: #FF6B35;
        }

        .welcome-desc {
            font-size: 0.95rem;
            color: #78909C;
            line-height: 1.6;
            max-width: 480px;
        }

        /* Card form */
        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 10px;
        }

        .card-header-custom {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-box {
            background-color: #E74C3C;
            border-radius: 12px;
            padding: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            width: 42px;
            height: 42px;
        }

        .card-title-custom {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 6px;
        }

        .card-sub-custom {
            font-size: 0.85rem;
            color: #78909C;
        }

        /* Form Inputs matching screenshot */
        .form-label-custom {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 8px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control-custom {
            width: 100%;
            height: 55px;
            border-radius: 14px;
            border: 1.5px solid transparent;
            background-color: #EAF2FA; /* Soft blue-gray input bg */
            padding-left: 50px;
            padding-right: 20px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #2C3E50;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            outline: none;
            background-color: #FFFFFF;
            border-color: #FF6B35;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
        }

        .form-control-custom.is-invalid {
            border-color: #E74C3C;
            background-color: #FFEBEE;
        }

        .input-group-custom i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #90A4AE;
            font-size: 1.1rem;
        }

        /* Remember Me & Forgot Password */
        .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1.5px solid #CFD8DC;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #E74C3C;
            border-color: #E74C3C;
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #78909C;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #E74C3C;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #FF6B35;
        }

        /* Button */
        .btn-submit-custom {
            background-color: #E74C3C;
            color: #FFFFFF;
            border-radius: 14px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.2);
        }

        .btn-submit-custom:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(231, 76, 60, 0.3);
        }

        .back-link {
            color: #78909C;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 25px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #E74C3C;
        }

        .copyright-text {
            color: #90A4AE;
            font-size: 0.8rem;
        }

        /* New premium illustration styles & animations */
        .login-illustration-svg {
            max-width: 440px;
            height: auto;
        }

        .icon-shadow {
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.06));
        }

        /* Floating main certificate */
        .main-cert-container {
            animation: floatCert 5s ease-in-out infinite;
        }

        @keyframes floatCert {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }
        
        .cert-shadow-rect {
            animation: shadowPulse 5s ease-in-out infinite;
            transform-origin: center;
        }
        
        @keyframes shadowPulse {
            0%, 100% {
                opacity: 0.4;
                transform: scale(1) translateY(0);
            }
            50% {
                opacity: 0.2;
                transform: scale(0.95) translateY(8px);
            }
        }

        /* Cap float */
        .cap-float {
            animation: floatCap 4s ease-in-out infinite alternate;
        }

        @keyframes floatCap {
            0% {
                transform: translate(90px, 110px) translateY(0);
            }
            100% {
                transform: translate(90px, 110px) translateY(-10px);
            }
        }

        /* Medal float */
        .medal-float {
            animation: floatMedal 4.5s ease-in-out infinite alternate 0.5s;
        }

        @keyframes floatMedal {
            0% {
                transform: translate(360px, 140px) translateY(0) rotate(0deg);
            }
            100% {
                transform: translate(360px, 140px) translateY(-8px) rotate(3deg);
            }
        }

        /* Shield float */
        .shield-float {
            animation: floatShield 3.8s ease-in-out infinite alternate 0.2s;
        }

        @keyframes floatShield {
            0% {
                transform: translate(225px, 255px) translateY(0) scale(1);
            }
            100% {
                transform: translate(225px, 255px) translateY(-5px) scale(1.03);
            }
        }

        /* Sparkles fade in/out */
        .sparkle {
            animation: sparklePulse 3s ease-in-out infinite;
            transform-origin: center;
        }
        .sparkle.delay-1 { animation-delay: 0.2s; }
        .sparkle.delay-2 { animation-delay: 0.8s; }
        .sparkle.delay-3 { animation-delay: 1.4s; }
        .sparkle.delay-4 { animation-delay: 2s; }

        @keyframes sparklePulse {
            0%, 100% {
                opacity: 0.2;
                transform: scale(0.8);
            }
            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .login-left {
                display: none;
            }
            .login-right {
                flex: 1;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Left Column -->
        <div class="login-left">
            <!-- Brand -->
            <div>
                <a href="{{ route('home') }}" class="brand-header">
                    <img src="{{ asset('logos/logo-rakitai.png') }}" alt="Logo" style="height: 28px; width: auto; object-fit: contain;">
                    <div>
                        <span class="brand-sub" style="font-size: 0.7rem; color: #E74C3C; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; background-color: #FEE2E2; padding: 2px 6px; border-radius: 6px;">Sertifikat</span>
                    </div>
                </a>
            </div>

            <!-- Welcome Text & Illustration -->
            <div class="welcome-section">
                <!-- Decorative Red Line -->
                <div class="bg-danger mb-3" style="width: 40px; height: 4px; border-radius: 2px;"></div>
                
                <h1 class="welcome-title">
                    Selamat datang di <br>
                    <span>Sistem Manajemen Sertifikat</span>
                </h1>
                <p class="welcome-desc">
                    Platform pengelolaan sertifikat digital untuk mendokumentasikan pencapaian, kejuaraan, dan partisipasi siswa dalam berbagai program ekstrakurikuler sekolah secara kredibel dan terintegrasi.
                </p>

                <!-- Certificate Animated SVG Illustration -->
                <div class="mt-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 360" width="100%" height="auto" class="login-illustration-svg">
                        <defs>
                            <!-- Gradients -->
                            <radialGradient id="bgGlow" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#FFEAA7" stop-opacity="0.3"/>
                                <stop offset="100%" stop-color="#FFFFFF" stop-opacity="0"/>
                            </radialGradient>
                            
                            <linearGradient id="certBorder" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#E74C3C"/>
                                <stop offset="50%" stop-color="#FF6B35"/>
                                <stop offset="100%" stop-color="#F1C40F"/>
                            </linearGradient>

                            <linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F1C40F"/>
                                <stop offset="100%" stop-color="#F39C12"/>
                            </linearGradient>
                            
                            <linearGradient id="shieldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3498DB"/>
                                <stop offset="100%" stop-color="#2980B9"/>
                            </linearGradient>
                        </defs>

                        <!-- Background glow -->
                        <circle cx="250" cy="180" r="150" fill="url(#bgGlow)" />
                        
                        <!-- Floor Shadow -->
                        <ellipse cx="250" cy="310" rx="140" ry="8" fill="#E2E8F0" />
                        
                        <!-- Animated Background Sparkles -->
                        <g class="sparkle-group">
                            <!-- Star 1 -->
                            <path class="sparkle delay-1" d="M120,90 L123,97 L130,100 L123,103 L120,110 L117,103 L110,100 L117,97 Z" fill="#F1C40F" />
                            <!-- Star 2 -->
                            <path class="sparkle delay-2" d="M380,110 L382,115 L387,117 L382,119 L380,124 L378,119 L373,117 L378,115 Z" fill="#FF6B35" />
                            <!-- Star 3 -->
                            <path class="sparkle delay-3" d="M160,250 L161.5,254 L165.5,255 L161.5,256 L160,260 L158.5,256 L154.5,255 L158.5,254 Z" fill="#2ECC71" />
                            <!-- Star 4 -->
                            <path class="sparkle delay-4" d="M340,240 L342,245 L347,247 L342,249 L340,254 L338,249 L333,247 L338,245 Z" fill="#3498DB" />
                        </g>

                        <!-- Floating Graduation Cap (Left) -->
                        <g class="floating-item cap-float" transform="translate(90, 110)">
                            <circle cx="20" cy="20" r="24" fill="#FFFFFF" class="icon-shadow"/>
                            <circle cx="20" cy="20" r="24" fill="#FFEBEE"/>
                            <path d="M20,10 L34,16 L20,22 L6,16 Z" fill="#E74C3C" />
                            <path d="M12,18.5 L12,24 C12,26 28,26 28,24 L28,18.5" fill="#C0392B" />
                            <path d="M31,17.5 L31,25" stroke="#F1C40F" stroke-width="2" stroke-linecap="round" fill="none"/>
                            <circle cx="31" cy="25" r="2" fill="#F39C12"/>
                        </g>

                        <!-- Floating Medal/Ribbon (Right) -->
                        <g class="floating-item medal-float" transform="translate(360, 140)">
                            <circle cx="20" cy="20" r="24" fill="#FFFFFF" class="icon-shadow"/>
                            <circle cx="20" cy="20" r="24" fill="#E8F5E9"/>
                            <!-- Ribbon -->
                            <path d="M14,20 L11,32 L20,28 L29,32 L26,20 Z" fill="#FF6B35" />
                            <!-- Medal circle -->
                            <circle cx="20" cy="18" r="10" fill="url(#goldGrad)" />
                            <path d="M20,12 L22,16 L26,16 L23,19 L24,23 L20,21 L16,23 L17,19 L14,16 L18,16 Z" fill="#FFFFFF" />
                        </g>

                        <!-- Central Certificate Document (Main element) -->
                        <g class="main-cert-container">
                            <!-- Shadow under certificate -->
                            <rect x="155" y="115" width="190" height="150" rx="12" fill="#CBD5E1" opacity="0.4" class="cert-shadow-rect"/>
                            
                            <!-- Document Body -->
                            <rect x="150" y="110" width="190" height="150" rx="12" fill="#FFFFFF" stroke="url(#certBorder)" stroke-width="4" />
                            
                            <!-- Inner border lines -->
                            <rect x="157" y="117" width="176" height="136" rx="8" fill="none" stroke="#FFEAA7" stroke-width="1.5" />
                            
                            <!-- Certificate Header lines -->
                            <rect x="195" y="132" width="100" height="5" rx="2.5" fill="#E74C3C" />
                            <rect x="225" y="143" width="40" height="2" rx="1" fill="#78909C" />
                            
                            <!-- Name Placeholder lines -->
                            <rect x="175" y="165" width="140" height="8" rx="4" fill="#F1C40F" />
                            
                            <!-- Detail Paragraph lines -->
                            <rect x="185" y="188" width="120" height="4" rx="2" fill="#90A4AE" />
                            <rect x="170" y="198" width="150" height="4" rx="2" fill="#CFD8DC" />
                            <rect x="195" y="208" width="100" height="4" rx="2" fill="#CFD8DC" />
                            
                            <!-- Medal seal stamp on document -->
                            <circle cx="250" cy="235" r="12" fill="url(#goldGrad)" />
                            <polygon points="250,229 253,233 257,233 254,236 255,240 250,238 245,240 246,236 243,233 247,233" fill="#FFFFFF" />
                        </g>

                        <!-- Floating Security Shield / Lock (Bottom Center Overlay) -->
                        <g class="floating-item shield-float" transform="translate(225, 255)">
                            <circle cx="25" cy="25" r="28" fill="#FFFFFF" class="icon-shadow"/>
                            <circle cx="25" cy="25" r="26" fill="#E3F2FD"/>
                            <!-- Shield Shape -->
                            <path d="M25,12 C28,12 36,10 36,10 C36,10 37,22 34,29 C30,37 25,40 25,40 C25,40 20,37 16,29 C13,22 14,10 14,10 C14,10 22,12 25,12 Z" fill="url(#shieldGrad)" />
                            <!-- Lock shape -->
                            <rect x="21" y="23" width="8" height="7" rx="1.5" fill="#FFFFFF" />
                            <path d="M22,23 L22,20 C22,18.5 23,17.5 25,17.5 C27,17.5 28,18.5 28,20 L28,23" stroke="#FFFFFF" stroke-width="2" fill="none" />
                        </g>
                    </svg>
                </div>
            </div>

            <!-- Footer -->
            <div>
                <p class="copyright-text mb-0">&copy; {{ date('Y') }} Sertifikat Ekskul. Hak Cipta Dilindungi.</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="login-right">
            <div class="login-card">
                
                <!-- Card Header -->
                <div class="card-header-custom text-center">
                    <!-- School Logo -->
                    <div class="mb-2">
                        <img src="{{ asset('logos/logo-rakitai.png') }}" alt="Logo" style="height: 40px; width: auto; object-fit: contain;">
                    </div>
                    <div class="mb-2">
                        <span class="text-uppercase fw-semibold" style="font-size: 0.7rem; color: #E74C3C; letter-spacing: 0.5px; background-color: #FEE2E2; padding: 2px 8px; border-radius: 6px; display: inline-block;">Sertifikat</span>
                    </div>
                    <p class="card-sub-custom">Masuk untuk melanjutkan ke dashboard manajemen</p>
                </div>

                <!-- Alert Messages inside Card -->
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-4 py-3 small d-flex align-items-center gap-2" style="background-color: #E8F5E9; color: #2E7D32;">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 mb-4 py-3 small d-flex align-items-center gap-2" style="background-color: #FFEBEE; color: #C62828;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    
                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label-custom">Email</label>
                        <div class="input-group-custom">
                            <i class="fa-regular fa-envelope"></i>
                            <input id="email" class="form-control-custom @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="arcaess1129@gmail.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1" style="font-size: 0.8rem;"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label-custom">Kata Sandi</label>
                        <div class="input-group-custom">
                            <i class="fa-solid fa-lock"></i>
                            <input id="password" class="form-control-custom @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="••••••••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1" style="font-size: 0.8rem;"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">Ingat saya</label>
                        </div>
                        <a href="#" class="forgot-link" onclick="Swal.fire({title: 'Lupa Kata Sandi?', text: 'Silakan hubungi administrator IT sekolah untuk melakukan reset password.', icon: 'info', confirmButtonColor: '#E74C3C'}); return false;">Lupa kata sandi?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit-custom shadow-sm">
                        <i class="fa-solid fa-right-to-bracket"></i>Masuk
                    </button>

                    <!-- Back Link -->
                    <div class="text-center">
                        <a href="{{ route('home') }}" class="back-link">
                            <i class="fa-solid fa-arrow-left"></i>Kembali ke Beranda
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
