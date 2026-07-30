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
                <div class="card card-custom p-4 text-center position-relative z-1 shadow hero-cert-card" style="max-width: 500px; margin: 0 auto; border: 8px double #E74C3C; border-radius: 12px; background: #fff;">
                    <!-- Inner Border Line -->
                    <div style="position: absolute; top: 4px; left: 4px; right: 4px; bottom: 4px; border: 1px solid #FF6B35; border-radius: 6px; pointer-events: none;"></div>
                    
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="fa-solid fa-graduation-cap text-danger" style="font-size: 1.5rem;"></i>
                        <span class="text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 1px;">Sertifikat Resmi</span>
                        <i class="fa-solid fa-medal text-warning" style="font-size: 1.5rem;"></i>
                    </div>

                    <!-- Certificate Title -->
                    <h5 class="fw-bold mb-1 text-uppercase text-danger" style="font-size: 1rem; letter-spacing: 1.5px; font-family: 'Georgia', serif;">Sertifikat Penghargaan</h5>
                    <div class="mx-auto bg-warning mb-3" style="width: 60px; height: 2px;"></div>
                    
                    <span class="text-muted d-block small mb-2" style="font-size: 0.75rem; font-style: italic;">Diberikan Kepada:</span>
                    
                    <!-- Placeholder Name (Default) -->
                    <h4 class="fw-bold my-1 text-dark" style="font-family: 'Georgia', serif; font-size: 1.35rem; border-bottom: 1.5px dashed #FF6B35; display: inline-block; padding-bottom: 2px; letter-spacing: 0.5px;">[ Nama Lengkap Siswa ]</h4>
                    
                    <!-- Certificate Body -->
                    <p class="text-muted mx-auto my-3" style="font-size: 0.75rem; line-height: 1.6; max-width: 90%;">
                        Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri kegiatan ekstrakurikuler sekolah.
                    </p>

                    <!-- Footer Details -->
                    <div class="row align-items-end mt-4 pt-2 border-top border-light">
                        <div class="col-4 text-start">
                            <span class="text-muted d-block" style="font-size: 0.65rem;">Kode Verifikasi:</span>
                            <strong class="text-danger" style="font-size: 0.7rem;">SK-2026-XXXXXX</strong>
                        </div>
                        <div class="col-4 text-center">
                            <!-- Styled Gold Seal -->
                            <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; border: 2px dashed #d4af37;">
                                <i class="fa-solid fa-star fs-6"></i>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div style="border-bottom: 1px solid #ccc; width: 80px; margin-left: auto; height: 20px;"></div>
                            <span class="text-muted d-block mt-1" style="font-size: 0.6rem;">Pembina Ekstrakurikuler</span>
                        </div>
                    </div>
                </div>

                <!-- Another card overlapping -->
                <div class="card card-custom p-3 text-start position-absolute shadow border border-light hero-verify-card" style="max-width: 240px; right: -20px; bottom: -30px; z-index: 2; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success-subtle text-success p-2 rounded-circle">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">Terverifikasi</h6>
                            <span class="text-muted" style="font-size: 0.7rem;">Sertifikat Terdaftar</span>
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
