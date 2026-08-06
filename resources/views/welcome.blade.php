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
                <div class="card card-custom p-4 text-center position-relative z-1 hero-cert-card" style="max-width: 500px; margin: 0 auto; background-color: #FFFFFF; border: 1px solid #F3F4F6; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border-radius: 8px; aspect-ratio: 297/210; overflow: hidden; display: flex; flex-direction: column;">
                    <!-- Elegant Double Border Frame -->
                    <div class="preview-border-outer"></div>
                    <div class="preview-border-inner"></div>

                    <!-- Small Elegant Corner Brackets -->
                    <div class="preview-corner-accent-tl"></div>
                    <div class="preview-corner-accent-tr"></div>
                    <div class="preview-corner-accent-bl"></div>
                    <div class="preview-corner-accent-br"></div>
                    
                    <!-- Content -->
                    <div class="position-relative h-100 d-flex flex-column" style="z-index: 5; text-align: left;">
                        <!-- Header: Logo + Subtitle + Seal -->
                        <div class="d-flex justify-content-between align-items-center pb-2 mb-2" style="border-bottom: 1px solid #e8d5a3; width: 100%;">
                            <div style="width:48px;">
                                <img src="{{ asset('logos/logo-rakitai.png') }}" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo">
                            </div>
                            <div class="text-center flex-grow-1">
                                <p class="mb-0 text-uppercase fw-bold" style="font-size: 0.58rem; letter-spacing: 1px; color: #334155;">Lembaga Pendidikan Sertifikasi Ekstrakurikuler</p>
                                <p class="mb-0" style="font-size: 0.48rem; letter-spacing: 0.5px; color: #94A3B8; margin-top: 1px;">Sertifikat Resmi Kegiatan Peserta Didik</p>
                            </div>
                            <div style="width:44px;">
                                <div class="preview-gold-seal-badge" style="width: 44px; height: 44px; border-width: 1.5px;">
                                    <div class="preview-gold-seal-inner" style="top: 2px; left: 2px; right: 2px; bottom: 2px;">
                                        <span style="font-size: 14px; color: #FFFFFF;">★</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative top ornament -->
                        <div class="text-center w-100 mb-1" style="margin-top: 2px;">
                            <span style="color: #D4AF37; font-size: 0.65rem; letter-spacing: 6px;">✦ ✦ ✦</span>
                        </div>

                        <!-- Title + Recipient -->
                        <div class="text-center w-100" style="margin-bottom: 2px;">
                            <h4 class="fw-bold mb-0 text-uppercase" style="font-family: 'Cormorant Garamond', 'Georgia', serif; color: #0F172A; font-size: 2rem; letter-spacing: 5px; line-height: 1;">Sertifikat</h4>
                            <p class="text-uppercase fw-bold mb-0" style="font-family: 'Poppins', sans-serif; color: #D4AF37; letter-spacing: 4px; font-size: 0.55rem; margin-top: 2px;">Sertifikat Penghargaan</p>

                            <!-- Thin gold rule -->
                            <div style="display:flex; align-items:center; margin: 4px auto; width: 70%;">
                                <div style="flex:1; height:1px; background: linear-gradient(to right, transparent, #D4AF37);"></div>
                                <span style="color:#D4AF37; font-size:0.6rem; margin: 0 4px;">◆</span>
                                <div style="flex:1; height:1px; background: linear-gradient(to left, transparent, #D4AF37);"></div>
                            </div>

                            <div style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 0.75rem; color: #64748B;">Dengan bangga diberikan kepada:</div>
                            <h5 class="mb-0" style="font-family: 'Great Vibes', cursive; font-size: 2.8rem; font-weight: 400; letter-spacing: 1.5px; margin-top: 2px; line-height: 1.1; color: #1a1a2e !important;">Nama Lengkap Siswa</h5>
                            <div style="width: 60%; height: 1.5px; background: linear-gradient(to right, transparent, #D4AF37, transparent); margin: 4px auto 2px;"></div>
                        </div>

                        <!-- Description -->
                        <div class="text-center px-4 w-100" style="margin: 2px 0 4px;">
                            <p class="mb-0" style="line-height: 1.5; font-size: 0.72rem; color: #334155; font-family: 'Poppins', sans-serif;">
                                Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri.
                            </p>
                        </div>

                        <!-- Footer: QR | Nomor+Tanggal -->
                        <div class="d-flex justify-content-between align-items-end w-100" style="border-top: 1px solid #e8d5a3; padding-top: 6px; margin-top: auto;">
                            <!-- QR Code -->
                            <div class="text-start" style="width:68px;">
                                <div class="border bg-white p-1 d-inline-block" style="border-color: #D4AF37 !important; border-radius:4px;">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://sertifikat-ekskul.com/verify/SK-2026-XXXXXX" style="width:44px; height:44px; display:block;" alt="QR Code">
                                </div>
                                <div class="text-muted" style="font-size:0.4rem; margin-top:1px; font-family:'Poppins',sans-serif; line-height:1;">Pindai verifikasi</div>
                            </div>

                            <!-- Nomor & Tanggal -->
                            <div class="text-end" style="font-family:'Poppins',sans-serif; line-height: 1.1;">
                                <div style="font-size:0.5rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px;">Nomor Sertifikat</div>
                                <div class="fw-bold" style="font-size:0.68rem; color:#0F172A;">SK-2026-XXXXXX</div>
                                <div style="font-size:0.45rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px; margin-top:2px;">Diterbitkan pada</div>
                                <div class="fw-bold" style="font-size:0.65rem; color:#0F172A;">30 Juli 2026</div>
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
