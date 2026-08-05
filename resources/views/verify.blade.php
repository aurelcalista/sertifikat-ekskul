@extends('layouts.public')

@section('title', 'Verifikasi Sertifikat')

@section('styles')
<style>
    /* Premium Animations */
    .verify-wrapper {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Customization */
    .verify-card {
        border-radius: 24px;
        background: #FFFFFF;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid #F3F4F6;
        overflow: hidden;
        position: relative;
    }
    
    .verify-card.invalid {
        border-color: #F3F4F6;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    .card-glow-bar {
        height: 6px;
        width: 100%;
        background: linear-gradient(90deg, #10B981, #3B82F6);
    }

    .card-glow-bar.invalid {
        background: linear-gradient(90deg, #EF4444, #F59E0B);
    }

    /* Badge & Icon Styles */
    .success-badge-container {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: #E6F4EA;
        color: #137333;
        margin-top: 10px;
        margin-bottom: 18px;
        box-shadow: 0 8px 20px rgba(19, 115, 51, 0.08);
        position: relative;
        animation: pulseRing 2.5s infinite;
    }

    .success-badge-container.invalid {
        background: #FCE8E6;
        color: #C5221F;
        box-shadow: 0 8px 20px rgba(197, 34, 31, 0.08);
        animation: none;
    }

    @keyframes pulseRing {
        0% {
            box-shadow: 0 0 0 0 rgba(19, 115, 51, 0.2);
        }
        70% {
            box-shadow: 0 0 0 12px rgba(19, 115, 51, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(19, 115, 51, 0);
        }
    }

    /* Modern Metadata Layout */
    .metadata-group {
        background: #F8FAFC;
        border-radius: 18px;
        padding: 22px;
        border: 1px solid #F1F5F9;
        margin-bottom: 20px;
    }

    .metadata-group-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #64748B;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .metadata-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #E2E8F0;
    }

    .metadata-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .metadata-item:first-child {
        padding-top: 0;
    }

    .metadata-label {
        font-size: 0.875rem;
        color: #64748B;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .metadata-label i {
        width: 16px;
        text-align: center;
        color: #94A3B8;
    }

    .metadata-value {
        font-size: 0.875rem;
        color: #1E293B;
        font-weight: 600;
        text-align: right;
    }

    .metadata-value.highlight-code {
        color: #E74C3C;
        font-family: 'Courier New', Courier, monospace;
        letter-spacing: 0.5px;
        background: #F8FAFC;
        padding: 3px 10px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
    }

    /* Badge Customizations */
    .ekskul-badge {
        background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        color: white;
        padding: 4px 12px;
        font-size: 0.75rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-block;
        box-shadow: 0 3px 8px rgba(59, 130, 246, 0.2);
    }
    
    .prestasi-badge {
        background: linear-gradient(135deg, #F59E0B, #D97706);
        color: white;
        padding: 4px 12px;
        font-size: 0.75rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-block;
        box-shadow: 0 3px 8px rgba(245, 158, 11, 0.2);
    }

    /* Troubleshooting styles */
    .troubleshoot-box {
        background: #F8FAFC;
        border-radius: 18px;
        padding: 22px;
        border: 1px solid #F1F5F9;
    }

    .troubleshoot-item {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        align-items: flex-start;
    }

    .troubleshoot-item:last-child {
        margin-bottom: 0;
    }

    .troubleshoot-icon {
        color: #EF4444;
        font-size: 1.1rem;
        margin-top: 2px;
    }

    /* Premium Button Styles */
    .btn-gradient-success {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white !important;
        border: none;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-gradient-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.3);
    }
    
    .btn-gradient-success:active {
        transform: translateY(0);
    }

    .btn-outline-custom {
        background: transparent;
        color: #475569 !important;
        border: 1.5px solid #E2E8F0;
        border-radius: 30px;
        padding: 11px 28px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-outline-custom:hover {
        background-color: #F8FAFC;
        color: #0F172A !important;
        border-color: #CBD5E1;
        transform: translateY(-2px);
    }

    @media (max-width: 576px) {
        .metadata-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
        
        .metadata-value {
            text-align: left;
            width: 100%;
        }

        .btn-gradient-success, .btn-outline-custom {
            width: 100%;
            margin-bottom: 12px;
        }

        .btn-outline-custom {
            margin-left: 0 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container my-5 verify-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            @if($isValid)
                <!-- Valid State -->
                <div class="card verify-card shadow-sm">
                    <!-- Top Gradient Glow Bar -->
                    <div class="card-glow-bar"></div>
                    
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="success-badge-container">
                            <i class="fa-solid fa-check fa-3x"></i>
                        </div>
                        
                        <h2 class="fw-bold text-success mb-2" style="font-size: 1.75rem;">Sertifikat Valid & Terdaftar</h2>
                        <p class="text-muted mb-5">Sertifikat dengan kode <span class="fw-bold text-dark">{{ $certificate->code }}</span> telah diverifikasi secara resmi.</p>

                        <!-- Group 1: Informasi Penerima -->
                        <div class="metadata-group text-start">
                            <div class="metadata-group-title">
                                <i class="fa-solid fa-user-graduate"></i> Informasi Penerima
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-user"></i> Nama Lengkap</span>
                                <span class="metadata-value text-uppercase">{{ $certificate->nama_siswa }}</span>
                            </div>
                            
                            @if($certificate->nis && $certificate->nis !== '-')
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-id-card"></i> NIS</span>
                                <span class="metadata-value">{{ $certificate->nis }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Group 2: Detail Sertifikat -->
                        <div class="metadata-group text-start">
                            <div class="metadata-group-title">
                                <i class="fa-solid fa-award"></i> Informasi Sertifikat
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-key"></i> Kode Sertifikat</span>
                                <span class="metadata-value highlight-code">{{ $certificate->code }}</span>
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-hashtag"></i> Nomor Sertifikat</span>
                                <span class="metadata-value">{{ $certificate->nomor_sertifikat }}</span>
                            </div>
                            
                            @if($certificate->ekskul && $certificate->ekskul !== '-')
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-running"></i> Ekstrakurikuler</span>
                                <span class="metadata-value"><span class="ekskul-badge">{{ $certificate->ekskul }}</span></span>
                            </div>
                            @endif
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-ribbon"></i> Kategori / Peran</span>
                                <span class="metadata-value">{{ $certificate->jenis_sertifikat }}</span>
                            </div>
                            
                            <div class="metadata-item align-items-start flex-column">
                                <span class="metadata-label mb-1"><i class="fa-solid fa-trophy"></i> Keterangan / Deskripsi</span>
                                <span class="metadata-value w-100" style="text-align: left; font-weight: normal; line-height: 1.5;">
                                    {!! nl2br(e($certificate->prestasi)) !!}
                                </span>
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-calendar-days"></i> Tanggal Terbit</span>
                                <span class="metadata-value">{{ $certificate->tanggal->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <!-- Group 3: Penandatangan -->
                        <div class="metadata-group text-start">
                            <div class="metadata-group-title">
                                <i class="fa-solid fa-file-signature"></i> Penandatangan
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-user-tie"></i> Nama Pembina</span>
                                <span class="metadata-value">{{ $certificate->nama_pembina }}</span>
                            </div>
                            
                            <div class="metadata-item">
                                <span class="metadata-label"><i class="fa-solid fa-briefcase"></i> Jabatan</span>
                                <span class="metadata-value text-muted">{{ $certificate->jabatan_pembina }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-5 d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('download.pdf', $certificate->code) }}" class="btn-gradient-success">
                                <i class="fa-solid fa-file-pdf"></i> Unduh Sertifikat (PDF)
                            </a>
                            <a href="{{ route('home') }}" class="btn-outline-custom">
                                <i class="fa-solid fa-house"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Invalid State -->
                <div class="card verify-card invalid shadow-sm">
                    <!-- Top Gradient Glow Bar (Red/Orange) -->
                    <div class="card-glow-bar invalid"></div>
                    
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="success-badge-container invalid">
                            <i class="fa-solid fa-triangle-exclamation fa-3x"></i>
                        </div>
                        
                        <h2 class="fw-bold text-danger mb-2" style="font-size: 1.75rem;">Sertifikat Tidak Valid</h2>
                        <p class="text-muted mb-5">Kode sertifikat <span class="fw-bold text-dark">{{ $code }}</span> tidak terdaftar di database kami.</p>
                        
                        <!-- Group: Troubleshooting Tips -->
                        <div class="metadata-group text-start bg-light border-0">
                            <div class="metadata-group-title text-danger mb-4">
                                <i class="fa-solid fa-circle-info"></i> Panduan Pemecahan Masalah
                            </div>
                            
                            <div class="troubleshoot-box">
                                <div class="troubleshoot-item">
                                    <div class="troubleshoot-icon">
                                        <i class="fa-solid fa-keyboard"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Kesalahan Ketik Kode</h6>
                                        <p class="text-muted small mb-0">Format kode sertifikat sangat sensitif (misal: huruf besar/kecil berpengaruh). Silakan periksa kembali tanda hubung dan karakter pada kode.</p>
                                    </div>
                                </div>
                                
                                <div class="troubleshoot-item">
                                    <div class="troubleshoot-icon">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Sertifikat Belum Aktif</h6>
                                        <p class="text-muted small mb-0">Ada kemungkinan data sertifikat Anda sedang diproses atau belum diaktifkan oleh admin pembina ekstrakurikuler.</p>
                                    </div>
                                </div>
                                
                                <div class="troubleshoot-item">
                                    <div class="troubleshoot-icon">
                                        <i class="fa-solid fa-ban"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">Ditarik dari Sistem</h6>
                                        <p class="text-muted small mb-0">Jika sertifikat sudah pernah valid namun sekarang tidak, data kemungkinan ditarik kembali karena adanya kesalahan administratif.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-5 d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('download.view') }}" class="btn-gradient-success" style="background: linear-gradient(135deg, #EF4444, #DC2626); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.2);">
                                <i class="fa-solid fa-magnifying-glass"></i> Coba Cari Ulang
                            </a>
                            <a href="{{ route('home') }}" class="btn-outline-custom">
                                <i class="fa-solid fa-house"></i> Ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
