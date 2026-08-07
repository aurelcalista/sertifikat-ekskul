@extends('layouts.public')

@section('title', 'Sistem Download Sertifikat Ekstrakurikuler')

@section('styles')
<style>
    /* Hero animations */
    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hero illustration entrance and container animations */
    .hero-illustration-wrapper {
        opacity: 0;
        transform: scale(0.95);
        animation: heroIllustrationEntrance 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards;
    }

    @keyframes heroIllustrationEntrance {
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Certificate mockup card float */
    .hero-cert-card {
        transform: rotate(-2deg);
        animation: floatCard 6s ease-in-out infinite 1.3s;
        transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1) !important;
    }

    .hero-cert-card:hover {
        animation-play-state: paused;
        transform: scale(1.03) rotate(0deg) !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
    }

    @keyframes floatCard {
        0% {
            transform: translateY(0px) rotate(-2deg);
        }
        50% {
            transform: translateY(-12px) rotate(-1deg);
        }
        100% {
            transform: translateY(0px) rotate(-2deg);
        }
    }

    /* Floating badge info entry and float */
    .hero-verify-card {
        transform: rotate(5deg);
        animation: floatVerify 6s ease-in-out infinite 1.6s;
        transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1) !important;
    }
    
    .hero-verify-card:hover {
        animation-play-state: paused;
        transform: scale(1.05) rotate(3deg) translate(-5px, -5px) !important;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    @keyframes floatVerify {
        0% {
            transform: translateY(0px) rotate(5deg);
        }
        50% {
            transform: translateY(8px) rotate(6deg);
        }
        100% {
            transform: translateY(0px) rotate(5deg);
        }
    }

    /* Scroll animations for cards and sections */
    .scroll-animate {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
    }
    
    .scroll-animate.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Card styling adjustments for hover */
    .card-custom {
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    }
    
    .card-custom:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
    }
    
    /* Background glows animate too */
    .bg-glow-danger {
        animation: pulseGlow 8s ease-in-out infinite alternate;
    }
    
    .bg-glow-warning {
        animation: pulseGlow 10s ease-in-out infinite alternate-reverse;
    }
    
    @keyframes pulseGlow {
        0% {
            opacity: 0.08;
            transform: translateY(0px) scale(1);
        }
        100% {
            opacity: 0.15;
            transform: translateY(-20px) scale(1.1);
        }
    }

    /* Certificate Template Elements */
    .preview-border-outer {
        position: absolute;
        top: 6px;
        left: 6px;
        right: 6px;
        bottom: 6px;
        border: 1.5px solid #D4AF37;
        z-index: 2;
        pointer-events: none;
    }
    .preview-border-inner {
        position: absolute;
        top: 9px;
        left: 9px;
        right: 9px;
        bottom: 9px;
        border: 0.5px solid #0F172A;
        z-index: 2;
        pointer-events: none;
    }
    .preview-corner-accent-tl {
        position: absolute;
        top: 11px;
        left: 11px;
        width: 10px;
        height: 10px;
        border-top: 1.8px solid #D4AF37;
        border-left: 1.8px solid #D4AF37;
        z-index: 3;
    }
    .preview-corner-accent-tr {
        position: absolute;
        top: 11px;
        right: 11px;
        width: 10px;
        height: 10px;
        border-top: 1.8px solid #D4AF37;
        border-right: 1.8px solid #D4AF37;
        z-index: 3;
    }
    .preview-corner-accent-bl {
        position: absolute;
        bottom: 11px;
        left: 11px;
        width: 10px;
        height: 10px;
        border-bottom: 1.8px solid #D4AF37;
        border-left: 1.8px solid #D4AF37;
        z-index: 3;
    }
    .preview-corner-accent-br {
        position: absolute;
        bottom: 11px;
        right: 11px;
        width: 10px;
        height: 10px;
        border-bottom: 1.8px solid #D4AF37;
        border-right: 1.8px solid #D4AF37;
        z-index: 3;
    }
    .preview-gold-seal-badge {
        background: radial-gradient(circle, #f39c12, #D4AF37);
        border-radius: 50%;
        position: relative;
        display: inline-block;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px dashed #FFFFFF;
    }
    .preview-gold-seal-inner {
        position: absolute;
        top: 2px;
        left: 2px;
        right: 2px;
        bottom: 2px;
        border: 0.5px solid rgba(255,255,255,0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="container mt-2 mb-5">
    <div class="row align-items-center pt-2 pb-5">
        <!-- Hero Text -->
        <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
            <span class="badge bg-danger-subtle text-danger mb-3 px-3 py-2 rounded-pill fw-semibold animate-fade-in-up delay-100">
                <i class="fa-solid fa-award me-2"></i>Sistem Resmi Sekolah
            </span>
            <h1 class="display-4 fw-bold lh-sm mb-3 animate-fade-in-up delay-200">
                Sistem Download <br>
                <span class="text-red">Sertifikat</span> <span class="text-orange">Ekstrakurikuler</span>
            </h1>
            <p class="lead text-muted mb-4 fs-5 animate-fade-in-up delay-300">
                Cara termudah untuk mencari, memverifikasi, dan mengunduh sertifikat atas pencapaian dan keikutsertaan Anda dalam berbagai program ekstrakurikuler.
            </p>
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 animate-fade-in-up delay-400">
                <a href="{{ route('download.view') }}" class="btn btn-lg btn-custom-primary px-4 py-3 fs-6">
                    <i class="fa-solid fa-circle-down me-2"></i>Unduh Sertifikat Sekarang
                </a>
                <a href="#cara-kerja" class="btn btn-lg btn-custom-outline px-4 py-3 fs-6">
                    Pelajari Selengkapnya
                </a>
            </div>
        </div>
        
        <!-- Hero Illustration -->
        <div class="col-lg-6 text-center">
            <div class="position-relative d-inline-block hero-illustration-wrapper">
                <!-- Decorative background shapes -->
                <div class="position-absolute translate-middle-y start-0 top-50 bg-danger opacity-10 rounded-circle bg-glow-danger" style="width: 250px; height: 250px; filter: blur(50px);"></div>
                <div class="position-absolute translate-middle-y end-0 top-0 bg-warning opacity-10 rounded-circle bg-glow-warning" style="width: 200px; height: 200px; filter: blur(40px);"></div>
                
                <!-- Certificate mockup preview -->
                <div class="card card-custom text-center position-relative z-1 hero-cert-card" style="max-width: 520px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #F3F4F6; box-shadow: 0 12px 40px rgba(20, 33, 61, 0.08); border-radius: 8px; aspect-ratio: 297/210; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; padding: 1.1rem 1.3rem !important;">
                    <!-- SVG Background Elements -->
                    <svg viewBox="0 0 250 250" style="position: absolute; top: 0; left: 0; width: 130px; height: 130px; z-index: 1; pointer-events: none;">
                        <g fill="none" stroke="#64748B" stroke-width="1.2" opacity="0.65">
                            <circle cx="0" cy="0" r="230" stroke-width="0.7"/>
                            <circle cx="0" cy="0" r="210" stroke-dasharray="4,4"/>
                            <circle cx="0" cy="0" r="190" stroke-width="1.2"/>
                            <circle cx="0" cy="0" r="170"/>
                            <circle cx="0" cy="0" r="150" stroke-dasharray="3,3"/>
                            <circle cx="0" cy="0" r="130" stroke-width="1.5"/>
                            <circle cx="0" cy="0" r="100"/>
                            <circle cx="0" cy="0" r="70" stroke-width="0.8"/>
                            <line x1="0" y1="0" x2="230" y2="0" stroke-width="1.2"/>
                            <line x1="0" y1="0" x2="212" y2="88"/>
                            <line x1="0" y1="0" x2="162" y2="162" stroke-width="1.2"/>
                            <line x1="0" y1="0" x2="88" y2="212"/>
                            <line x1="0" y1="0" x2="0" y2="230" stroke-width="1.2"/>
                            <circle cx="212" cy="88" r="3" fill="#64748B"/>
                            <circle cx="162" cy="162" r="3" fill="#64748B"/>
                            <circle cx="88" cy="212" r="3" fill="#64748B"/>
                        </g>
                    </svg>
                    <svg viewBox="0 0 350 300" style="position: absolute; top: 0; right: 0; width: 160px; height: 135px; z-index: 1; pointer-events: none;">
                        <g fill="#F15A3D">
                            <polygon points="120,0 350,0 350,220 280,180 260,250 210,170 170,220 140,110 80,140 100,50" />
                            <polygon points="260,190 350,120 350,270 290,260" fill="#D9482B"/>
                            <polygon points="180,210 240,290 280,240 220,180" fill="#FF6B4A"/>
                        </g>
                    </svg>
                    <svg viewBox="0 0 60 220" style="position: absolute; top: 35%; left: 8px; width: 20px; height: 80px; z-index: 1; pointer-events: none;">
                        <g stroke="#94A3B8" stroke-width="2.5" stroke-linecap="round">
                            <line x1="5" y1="20" x2="55" y2="45" />
                            <line x1="5" y1="40" x2="55" y2="65" />
                            <line x1="5" y1="60" x2="55" y2="85" />
                            <line x1="5" y1="80" x2="55" y2="105" />
                            <line x1="5" y1="100" x2="55" y2="125" />
                            <line x1="5" y1="120" x2="55" y2="145" />
                            <line x1="5" y1="140" x2="55" y2="165" />
                            <line x1="5" y1="160" x2="55" y2="185" />
                            <line x1="5" y1="180" x2="55" y2="205" />
                        </g>
                    </svg>
                    <svg viewBox="0 0 60 200" style="position: absolute; top: 35%; right: 8px; width: 20px; height: 85px; z-index: 1; pointer-events: none;">
                        <g fill="none" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round">
                            <polyline points="10,35 30,15 50,35" stroke="#F15A3D" />
                            <polyline points="10,65 30,45 50,65" stroke="#F15A3D" />
                            <polyline points="10,95 30,75 50,95" stroke="#64748B" />
                            <polyline points="10,125 30,105 50,125" stroke="#64748B" />
                            <polyline points="10,155 30,135 50,155" stroke="#64748B" />
                            <polyline points="10,185 30,165 50,185" stroke="#CBD5E1" />
                        </g>
                    </svg>
                    <svg viewBox="0 0 250 200" style="position: absolute; bottom: 0; left: 0; width: 130px; height: 100px; z-index: 1; pointer-events: none;">
                        <g stroke="#F15A3D" stroke-width="2.5" stroke-linecap="round">
                            <line x1="0" y1="200" x2="220" y2="20" stroke-width="3.5"/>
                            <line x1="0" y1="170" x2="190" y2="10" stroke-width="3"/>
                            <line x1="0" y1="140" x2="160" y2="0" stroke-width="2.5"/>
                            <line x1="0" y1="110" x2="130" y2="0" stroke-width="2"/>
                            <line x1="0" y1="80" x2="90" y2="0" stroke-width="1.5"/>
                            <line x1="0" y1="50" x2="50" y2="0" stroke-width="1"/>
                        </g>
                    </svg>
                    <svg viewBox="0 0 250 250" style="position: absolute; bottom: 0; right: 0; width: 120px; height: 120px; z-index: 1; pointer-events: none;">
                        <g fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M 40,240 L 240,240 L 240,40 M 70,240 L 240,240 L 240,70" stroke="#1E293B" stroke-width="2" />
                            <path d="M 10,240 L 240,240 L 240,10" stroke="#F15A3D" stroke-width="2" />
                            <path d="M 50,225 L 225,225 L 225,50" stroke="#F15A3D" stroke-width="1.5" />
                            <path d="M 80,210 L 160,210 L 160,180 L 180,180 L 180,160 L 210,160 L 210,80" stroke="#F15A3D" stroke-width="1.8" />
                            <g stroke="#F15A3D" stroke-width="1.5">
                                <line x1="160" y1="195" x2="85" y2="195" stroke-width="2"/>
                                <path d="M 115,195 Q 105,185 95,195 Q 105,205 115,195 Z" fill="#F15A3D" opacity="0.85"/>
                                <path d="M 130,195 Q 120,185 110,195 Q 120,205 130,195 Z" fill="#F15A3D" opacity="0.85"/>
                                <path d="M 145,195 Q 135,185 125,195 Q 135,205 145,195 Z" fill="#F15A3D" opacity="0.85"/>
                            </g>
                            <g stroke="#F15A3D" stroke-width="1.5">
                                <line x1="195" y1="160" x2="195" y2="85" stroke-width="2"/>
                                <path d="M 195,115 Q 185,105 195,95 Q 205,105 195,115 Z" fill="#F15A3D" opacity="0.85"/>
                                <path d="M 195,130 Q 185,120 195,110 Q 205,120 195,130 Z" fill="#F15A3D" opacity="0.85"/>
                                <path d="M 195,145 Q 185,135 195,125 Q 205,135 195,145 Z" fill="#F15A3D" opacity="0.85"/>
                            </g>
                        </g>
                    </svg>

                    <!-- Content Layer -->
                    <div class="position-relative w-100 h-100 d-flex flex-column justify-content-between" style="z-index: 5;">
                        <!-- Logo -->
                        <div class="text-center" style="margin-bottom: 2px;">
                            <img src="{{ asset('logos/logo-rakitai.png') }}" style="max-height: 36px; width: auto; display: inline-block;" alt="Logo Rakit AI">
                        </div>

                        <!-- Header Titles & Pill -->
                        <div class="text-center my-0">
                            <h2 style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.65rem; font-weight: 700; color: #1F2A44; letter-spacing: 5px; margin: 0 0 1px 0; text-transform: uppercase;">SERTIFIKAT</h2>
                            <p style="font-family: 'Poppins', sans-serif; font-size: 0.6rem; font-weight: 600; color: #F15A3D; letter-spacing: 2.5px; margin: 1px 0 4px 0; text-transform: uppercase;">KEIKUTSERTAAN</p>
                            <div>
                                <span style="border: 1.2px solid #1F2A44; border-radius: 12px; padding: 1px 12px; font-family: 'Poppins', sans-serif; font-size: 0.52rem; font-weight: 600; color: #1F2A44; display: inline-block;">Certificat No: 124/SMK1/EKS/2026</span>
                            </div>
                        </div>

                        <!-- Recipient Section -->
                        <div class="text-center my-0">
                            <p style="font-family: 'Poppins', sans-serif; font-size: 0.6rem; color: #475569; margin-bottom: 1px; letter-spacing: 0.5px;">Diberikan kepada:</p>
                            <h3 style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.45rem; font-weight: 700; color: #1F2A44; margin: 1px 0 0 0; text-transform: uppercase; letter-spacing: 1px;">Nama Lengkap Siswa</h3>
                        </div>

                        <!-- Description text -->
                        <div class="text-center px-2 px-md-3 my-0" style="margin-top: 3px !important; margin-bottom: 3px !important;">
                            <p class="mb-0 text-secondary" style="font-family: 'Poppins', sans-serif; font-size: 0.65rem; line-height: 1.45; letter-spacing: 0.1px;">
                                Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat <span style="color: #F15A3D; font-weight: 700;">"Anggota/Peserta Aktif"</span>
                            </p>
                        </div>

                        <!-- Footer Layer: QR Code | Gold Medal Ribbon | Tanggal -->
                        <div class="d-flex justify-content-between align-items-end w-100 pt-1" style="margin-top: auto;">
                            <!-- QR Code -->
                            <div style="width: 30%; text-align: left;">
                                <div style="width: 48px; height: 48px; border: 1.2px solid #CBD5E1; padding: 2px; border-radius: 6px; background: #FFFFFF; display: inline-block;">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://sertifikat-ekskul.com/verify/SK-2026-XXXXXX" style="width: 100%; height: 100%; display: block;" alt="QR Code">
                                </div>
                            </div>

                            <!-- Center Gold Medal Ribbon SVG -->
                            <div style="width: 40%; text-align: center;">
                                <svg viewBox="0 0 100 130" style="width: 52px; height: 66px; display: inline-block; filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.2));">
                                    <defs>
                                        <radialGradient id="gRadP_home" cx="40%" cy="35%" r="60%">
                                            <stop offset="0%" stop-color="#FFF8DC" />
                                            <stop offset="30%" stop-color="#FFD700" />
                                            <stop offset="60%" stop-color="#DAA520" />
                                            <stop offset="100%" stop-color="#8B6508" />
                                        </radialGradient>
                                        <radialGradient id="gEdgP_home" cx="50%" cy="50%" r="50%">
                                            <stop offset="0%" stop-color="#FFD700" />
                                            <stop offset="100%" stop-color="#8B4513" />
                                        </radialGradient>
                                        <linearGradient id="rLP_home" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#1a3a7a" />
                                            <stop offset="50%" stop-color="#2563EB" />
                                            <stop offset="100%" stop-color="#1a3a7a" />
                                        </linearGradient>
                                        <linearGradient id="rRP_home" x1="100%" y1="0%" x2="0%" y2="100%">
                                            <stop offset="0%" stop-color="#1a3a7a" />
                                            <stop offset="50%" stop-color="#2563EB" />
                                            <stop offset="100%" stop-color="#1a3a7a" />
                                        </linearGradient>
                                    </defs>
                                    <polygon points="42,68 30,130 42,118 50,125" fill="url(#rLP_home)" />
                                    <polygon points="58,68 70,130 58,118 50,125" fill="url(#rRP_home)" />
                                    <circle cx="50" cy="50" r="40" fill="url(#gEdgP_home)" stroke="#8B6508" stroke-width="1" stroke-dasharray="7.5 4.5" />
                                    <circle cx="50" cy="50" r="37" fill="url(#gRadP_home)" />
                                    <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
                                    <circle cx="50" cy="50" r="31" fill="url(#gRadP_home)" />
                                    <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" stroke-dasharray="3 2" />
                                    <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.35" />
                                </svg>
                            </div>

                            <!-- Right Date -->
                            <div style="width: 30%; text-align: right; padding-right: 2px;">
                                <div style="display: inline-block; text-align: right;">
                                    <div style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 0.72rem; color: #475569; font-style: italic; margin-bottom: 1px;">Diterbitkan pada tanggal</div>
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 3px;">
                                        <span style="color: #94A3B8; font-size: 0.4rem;">&#9679; &#9679;</span>
                                        <span style="font-family: 'Poppins', sans-serif; font-size: 0.7rem; font-weight: 700; color: #0F172A;">05 August 2026</span>
                                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                                    </div>
                                    <div style="height: 1.5px; background: linear-gradient(to right, transparent, #64748B, transparent); margin-top: 2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cara Kerja Section -->
<div id="cara-kerja" class="bg-light py-5">
    <div class="container my-4">
        <div class="text-center mb-5 scroll-animate">
            <h2 class="fw-bold">Cara Mendapatkan Sertifikat</h2>
            <p class="text-muted">Proses yang sangat sederhana tanpa perlu login atau mendaftar akun</p>
        </div>
        <div class="row g-4 justify-content-center">
            <!-- Step 1 -->
            <div class="col-md-4 text-center scroll-animate" style="transition-delay: 0.1s;">
                <div class="card card-custom p-4 h-100 border border-light shadow-sm">
                    <div class="bg-danger-subtle text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-key fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">1. Dapatkan Kode</h5>
                    <p class="text-muted">Dapatkan kode sertifikat unik (contoh: SK-2026-XXXXXX) yang dibagikan oleh admin atau pembina ekskul Anda.</p>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="col-md-4 text-center scroll-animate" style="transition-delay: 0.3s;">
                <div class="card card-custom p-4 h-100 border border-light shadow-sm">
                    <div class="bg-warning-subtle text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-magnifying-glass fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">2. Cari Kode</h5>
                    <p class="text-muted">Masukkan kode unik tersebut ke halaman pencarian untuk memuat detail sertifikat Anda secara instan.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-4 text-center scroll-animate" style="transition-delay: 0.5s;">
                <div class="card card-custom p-4 h-100 border border-light shadow-sm">
                    <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-file-pdf fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">3. Unduh PDF</h5>
                    <p class="text-muted">Periksa kesesuaian data Anda pada preview, lalu klik tombol download untuk menyimpan sertifikat PDF berkualitas tinggi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // Once animated, stop observing
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-animate').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection
