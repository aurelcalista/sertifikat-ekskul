@extends('layouts.admin')

@section('title', 'Cari & Preview Sertifikat')

@section('styles')
<style>
    .preview-certificate-container {
        background-color: #FCFAF5;
        background-image: radial-gradient(rgba(200, 155, 60, 0.03) 1px, transparent 0), radial-gradient(rgba(200, 155, 60, 0.03) 1px, transparent 0);
        background-size: 8px 8px;
        background-position: 0 0, 4px 4px;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 12px 40px rgba(20, 33, 61, 0.08);
        padding: 1.25rem 1.5rem !important;
        border: 1px solid rgba(200, 155, 60, 0.2);
    }
    @media (max-width: 991.98px) {
        .preview-certificate-container {
            zoom: 0.85;
        }
    }
    @media (max-width: 767.98px) {
        .preview-certificate-container {
            zoom: 0.65;
        }
    }
    @media (max-width: 575.98px) {
        .preview-certificate-container {
            zoom: 0.45;
        }
    }
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
    .preview-gold-seal-inner span {
        color: #FFFFFF;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <!-- Compact Sleek Search Card -->
        <div class="card card-custom-admin shadow-sm p-3 mb-4">
            <form id="searchForm" class="row g-2 align-items-center mb-0">
                <div class="col-md-3 col-12">
                    <h5 class="fw-bold mb-0 text-dark text-nowrap">
                        <i class="fa-solid fa-magnifying-glass-chart text-danger me-2"></i>Pratinjau Sertifikat
                    </h5>
                </div>
                <div class="col-md-6 col-12">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 border-danger-subtle text-muted"><i class="fa-solid fa-key"></i></span>
                        <input type="text" class="form-control border-start-0 border-danger-subtle rounded-end-3" id="certCode" placeholder="Masukkan Kode Sertifikat (e.g. SK-2026-Y0M31K)" required style="height: 46px;">
                    </div>
                </div>
                <div class="col-md-3 col-12 d-grid">
                    <button type="submit" class="btn btn-danger rounded-3 fw-semibold text-white" style="height: 46px;">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Cari Sertifikat
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-light border-bottom px-4">
                        <h5 class="modal-title fw-bold text-dark" id="previewModalLabel">
                            <i class="fa-solid fa-certificate text-danger me-2"></i>Pratinjau Sertifikat
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 bg-light">
                        <div class="text-center mb-3">
                            <span id="prevStatus" class="badge px-3 py-2 rounded-pill fw-semibold mb-2"></span>
                        </div>
                        
                        <div class="preview-certificate-container p-3 p-md-4 mb-3 position-relative overflow-hidden" id="certificatePreviewArea" style="aspect-ratio: 297/210; min-height: 380px;">
                            <!-- Template Background Image -->
                            <img id="previewTemplateBg" src="" class="position-absolute top-0 start-0 w-100 h-100 d-none" style="object-fit: cover; z-index: 1;" alt="Background Template">

                            <!-- Navy Swoop Top-Right -->
                            <svg class="custom-mockup-item" viewBox="0 0 400 300" style="position: absolute; top: 0; right: 0; width: 37%; height: auto; z-index: 1; pointer-events: none;">
                                <path d="M 180,0 C 270,10 350,90 400,180 L 400,0 Z" fill="#14213D" />
                                <path d="M 180,0 C 270,10 350,90 400,180" fill="none" stroke="#C89B3C" stroke-width="4" />
                                <path d="M 160,0 C 250,10 330,90 380,180" fill="none" stroke="#C89B3C" stroke-width="1.5" />
                            </svg>

                            <!-- Navy Swoop Bottom-Left -->
                            <svg class="custom-mockup-item" viewBox="0 0 400 300" style="position: absolute; bottom: 0; left: 0; width: 37%; height: auto; z-index: 1; pointer-events: none;">
                                <path d="M 0,120 C 50,210 130,290 220,300 L 0,300 Z" fill="#14213D" />
                                <path d="M 0,120 C 50,210 130,290 220,300" fill="none" stroke="#C89B3C" stroke-width="4" />
                                <path d="M 0,100 C 60,190 140,280 240,300" fill="none" stroke="#C89B3C" stroke-width="1.5" />
                            </svg>

                            <!-- Double Gold Borders -->
                            <div class="custom-mockup-item" style="position: absolute; top: 6px; left: 6px; right: 6px; bottom: 6px; border: 2px solid #C89B3C; z-index: 2; pointer-events: none;"></div>
                            <div class="custom-mockup-item" style="position: absolute; top: 9px; left: 9px; right: 9px; bottom: 9px; border: 0.75px solid #C89B3C; z-index: 2; pointer-events: none;"></div>

                            <!-- Geometric Corner Patterns -->
                            <div class="custom-mockup-item" style="position: absolute; top: 9px; left: 9px; z-index: 3; pointer-events: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg>
                            </div>
                            <div class="custom-mockup-item" style="position: absolute; top: 9px; right: 9px; z-index: 3; transform: rotate(90deg); pointer-events: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg>
                            </div>
                            <div class="custom-mockup-item" style="position: absolute; bottom: 9px; right: 9px; z-index: 3; transform: rotate(180deg); pointer-events: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg>
                            </div>
                            <div class="custom-mockup-item" style="position: absolute; bottom: 9px; left: 9px; z-index: 3; transform: rotate(270deg); pointer-events: none;">
                                <svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg>
                            </div>

                            <!-- Content -->
                            <div class="position-relative h-100 d-flex flex-column" style="z-index: 5; gap: 0; text-align: left;">

                                <!-- Header: Logo + Subtitle + Seal -->
                                <div class="d-flex justify-content-between align-items-center pb-2" style="width: 100%;">
                                    <div style="width:48px;">
                                        <img id="prevLogo" src="" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo">
                                    </div>
                                    <div class="text-center flex-grow-1">
                                        <p class="mb-0 text-uppercase fw-bold" style="font-size: 0.58rem; letter-spacing: 1px; color: #14213D; font-family:'Poppins', sans-serif;">Lembaga Pendidikan Sertifikasi Ekstrakurikuler</p>
                                        <p class="mb-0" style="font-size: 0.48rem; letter-spacing: 0.5px; color: #556270; margin-top: 1px; font-family:'Poppins', sans-serif;">Sertifikat Resmi Kegiatan Peserta Didik</p>
                                    </div>
                                    <div style="width: 44px; text-align: right;">
                                        <div class="custom-mockup-item" style="width: 32px; height: 32px; display: inline-block;">
                                            <svg viewBox="0 0 100 100" width="100%" height="100%">
                                                <circle cx="50" cy="50" r="45" fill="#C89B3C" />
                                                <circle cx="50" cy="50" r="39" fill="#FCFAF5" />
                                                <circle cx="50" cy="50" r="34" fill="#C89B3C" />
                                                <polygon points="50,22 55,39 73,41 59,53 63,70 50,60 37,70 41,53 27,41 45,39" fill="#14213D" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decorative horizontal gold divider under the header -->
                                <div class="text-center w-100 custom-mockup-item" style="margin: 2px 0;">
                                    <svg width="60" height="6" viewBox="0 0 80 8" style="display: inline-block;">
                                        <line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                                        <polygon points="40,1 43,4 40,7 37,4" fill="#C89B3C" />
                                        <polygon points="48,2 50,4 48,6 46,4" fill="#C89B3C" />
                                        <polygon points="32,2 34,4 32,6 30,4" fill="#C89B3C" />
                                        <line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                                    </svg>
                                </div>

                                <!-- Title Section with ornaments above and below -->
                                <div class="text-center w-100" style="margin-bottom: 2px; position: relative;">
                                    <!-- Decorative gold ornament above title -->
                                    <div class="text-center w-100 custom-mockup-item" style="margin-bottom: 1.5px;">
                                        <svg width="30" height="6" viewBox="0 0 80 8" style="display: inline-block;">
                                            <line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                                            <polygon points="40,2 43,4 40,6 37,4" fill="#C89B3C" />
                                            <line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                                        </svg>
                                    </div>
                                    <h4 class="fw-bold mb-0 text-uppercase" style="font-family: 'Cormorant Garamond', 'Georgia', serif; color: #14213D; font-size: 1.85rem; letter-spacing: 6px; line-height: 1;">Sertifikat</h4>
                                    
                                    <div class="custom-mockup-item" style="border-top: 0.75px solid #C89B3C; border-bottom: 0.75px solid #C89B3C; padding: 2px 0; margin: 4px auto; width: 45%; text-align: center;">
                                        <p id="prevJenis" class="text-uppercase fw-bold mb-0" style="font-family: 'Poppins', sans-serif; color: #C89B3C; letter-spacing: 3px; font-size: 0.55rem;">SERTIFIKAT KEIKUTSERTAAN</p>
                                    </div>
                                    <!-- Decorative gold ornament below title -->
                                    <div class="text-center w-100 custom-mockup-item" style="margin-top: 1.5px;">
                                        <svg width="30" height="6" viewBox="0 0 80 8" style="display: inline-block;">
                                            <line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                                            <polygon points="40,2 43,4 40,6 37,4" fill="#C89B3C" />
                                            <line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.5" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Recipient Section -->
                                <div class="text-center w-100" style="position: relative; margin-top: 2px;">
                                    <!-- Subtle laurel wreath watermark behind the recipient name -->
                                    <div class="custom-mockup-item" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 140px; height: 90px; z-index: 1; opacity: 0.08; pointer-events: none;">
                                        <svg viewBox="0 0 200 130" width="100%" height="100%">
                                            <path d="M 90,110 C 50,100 20,70 20,40 C 20,20 40,10 60,5" fill="none" stroke="#C89B3C" stroke-width="2" />
                                            <path d="M 23,60 C 13,55 5,55 -2,60 C 3,63 13,63 23,60 Z" fill="#C89B3C" />
                                            <path d="M 21,45 C 11,40 3,40 -4,45 C 1,48 11,48 21,45 Z" fill="#C89B3C" />
                                            <path d="M 25,30 C 15,25 7,25 0,30 C 5,33 15,33 25,30 Z" fill="#C89B3C" />
                                            <path d="M 110,110 C 150,100 180,70 180,40 C 180,20 160,10 140,5" fill="none" stroke="#C89B3C" stroke-width="2" />
                                            <path d="M 177,60 C 187,55 195,55 202,60 C 197,63 187,63 177,60 Z" fill="#C89B3C" />
                                            <path d="M 179,45 C 189,40 197,40 204,45 C 199,48 189,48 179,45 Z" fill="#C89B3C" />
                                            <path d="M 175,30 C 185,25 193,25 200,30 C 195,33 185,33 175,30 Z" fill="#C89B3C" />
                                        </svg>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center" style="margin-top: 4px; position: relative; z-index: 2;">
                                        <svg class="custom-mockup-item" width="18" height="10" viewBox="0 0 24 12" style="display: inline-block; margin-right: 6px;">
                                            <path d="M 24,6 Q 12,0 0,6 Q 12,12 24,6 M 18,6 Q 12,3 6,6" fill="none" stroke="#C89B3C" stroke-width="1.2" />
                                        </svg>
                                        <span style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 0.75rem; color: #556270;">Dengan bangga diberikan kepada:</span>
                                        <svg class="custom-mockup-item" width="18" height="10" viewBox="0 0 24 12" style="display: inline-block; margin-left: 6px; transform: scaleX(-1);">
                                            <path d="M 24,6 Q 12,0 0,6 Q 12,12 24,6 M 18,6 Q 12,3 6,6" fill="none" stroke="#C89B3C" stroke-width="1.2" />
                                        </svg>
                                    </div>

                                    <h5 class="mb-0" id="prevName" style="font-family: 'Great Vibes', cursive; font-size: 3rem; font-weight: 400; letter-spacing: 1.5px; margin-top: 2px; line-height: 1.1; color: #14213D !important; position: relative; z-index: 2;">Nama Lengkap Siswa</h5>
                                    
                                    <!-- Thin gold divider below the recipient name -->
                                    <div class="text-center custom-mockup-item" style="margin-top: 1px;">
                                        <svg width="30" height="6" viewBox="0 0 40 8" style="display: inline-block;">
                                            <line x1="0" y1="4" x2="16" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                                            <polygon points="20,1 24,4 20,7 16,4" fill="#C89B3C" />
                                            <line x1="24" y1="4" x2="40" y2="4" stroke="#C89B3C" stroke-width="0.75" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="text-center px-4 w-100" style="margin: 2px 0 4px;">
                                    <p class="mb-0 text-muted" id="prevDescription" style="line-height: 1.5; font-size: 0.72rem; font-family: 'Poppins', sans-serif;">
                                    </p>
                                </div>

                                <!-- Symmetrical Olive Branch + Book Badge at Bottom-Center -->
                                <div class="text-center w-100 custom-mockup-item" style="margin-top: 2px; margin-bottom: 2px;">
                                    <svg width="180" height="30" viewBox="0 0 240 40" style="display: inline-block; vertical-align: middle;">
                                        <path d="M 90,20 Q 50,15 20,25" fill="none" stroke="#C89B3C" stroke-width="1.5" />
                                        <path d="M 80,19 C 75,15 70,15 65,17 C 70,20 75,20 80,19 Z" fill="#C89B3C" />
                                        <path d="M 65,17 C 60,13 55,13 50,15 C 55,18 60,18 65,17 Z" fill="#C89B3C" />
                                        <path d="M 50,15 C 45,11 40,11 35,13 C 40,16 45,16 50,15 Z" fill="#C89B3C" />
                                        <path d="M 75,18 C 72,12 67,10 62,12 C 66,16 70,17 75,18 Z" fill="#C89B3C" />
                                        <path d="M 60,16 C 57,10 52,8 47,10 C 51,14 55,15 60,16 Z" fill="#C89B3C" />
                                        <path d="M 150,20 Q 190,15 220,25" fill="none" stroke="#C89B3C" stroke-width="1.5" />
                                        <path d="M 160,19 C 165,15 170,15 175,17 C 170,20 165,20 160,19 Z" fill="#C89B3C" />
                                        <path d="M 175,17 C 180,13 185,13 190,15 C 185,18 180,18 175,17 Z" fill="#C89B3C" />
                                        <path d="M 190,15 C 195,11 200,11 205,13 C 200,16 195,16 190,15 Z" fill="#C89B3C" />
                                        <path d="M 165,18 C 168,12 173,10 178,12 C 174,16 170,17 165,18 Z" fill="#C89B3C" />
                                        <path d="M 180,16 C 183,10 188,8 193,12 C 189,14 185,15 180,16 Z" fill="#C89B3C" />
                                        <circle cx="120" cy="20" r="14" fill="#FCFAF5" stroke="#C89B3C" stroke-width="1.5" />
                                        <circle cx="120" cy="20" r="11" fill="none" stroke="#C89B3C" stroke-width="0.5" />
                                        <path d="M 119,16 Q 116,18 113,16 L 113,22 Q 116,24 119,22 Z" fill="none" stroke="#14213D" stroke-width="1.2" />
                                        <path d="M 121,16 Q 124,18 127,16 L 127,22 Q 124,24 121,22 Z" fill="none" stroke="#14213D" stroke-width="1.2" />
                                        <line x1="120" y1="16" x2="120" y2="22" stroke="#14213D" stroke-width="1.2" />
                                    </svg>
                                </div>

                                <!-- Footer: QR | Ornament | Nomor+Tanggal -->
                                <div class="d-flex justify-content-between align-items-center w-100" style="padding-top: 4px; margin-top: auto; border-top: 1px solid rgba(232, 213, 163, 0.4);">

                                    <!-- Left: QR Code -->
                                    <div class="text-start" style="width: 25%;">
                                        <div class="border bg-white p-1 d-inline-block" style="border-color: #C89B3C !important; border-radius:4px;">
                                            <img id="prevQrCode" src="" style="width:44px; height:44px; display:block;" alt="QR Code">
                                        </div>
                                        <div class="text-muted" style="font-size:0.42rem; margin-top:1px; font-family:'Poppins',sans-serif;">Scan untuk Verifikasi</div>
                                    </div>

                                    <!-- Center: Horizontal Gold Ornament only (NO signature) -->
                                    <div class="text-center" style="width: 50%;">
                                        <svg class="custom-mockup-item" width="100" height="20" viewBox="0 0 120 24" style="display: inline-block;">
                                            <path d="M 10,12 C 30,2 40,22 60,12 C 80,2 90,22 110,12" fill="none" stroke="#C89B3C" stroke-width="1" />
                                            <circle cx="60" cy="12" r="4" fill="#C89B3C" />
                                            <polygon points="60,2 64,8 60,10 56,8" fill="#C89B3C" />
                                            <polygon points="60,22 64,16 60,14 56,16" fill="#C89B3C" />
                                        </svg>
                                    </div>

                                    <!-- Right: Nomor & Tanggal -->
                                    <div class="text-end" style="font-family:'Poppins',sans-serif; line-height: 1.1; width: 25%;">
                                        <div style="font-size:0.5rem; color:#556270; text-transform:uppercase; letter-spacing:0.5px;">Nomor Sertifikat</div>
                                        <div class="fw-bold" style="font-size:0.68rem; color: #14213D;" id="prevNomor">-</div>
                                        
                                        <!-- Meta divider line -->
                                        <div class="custom-mockup-item" style="width: 80px; height: 1px; background-color: #C89B3C; margin: 3px 0 3px auto;"></div>

                                        <div style="font-size:0.5rem; color:#556270; text-transform:uppercase; letter-spacing:0.5px;">Diterbitkan pada</div>
                                        <div class="fw-bold" style="font-size:0.68rem; color: #14213D;" id="prevTanggal">-</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top px-4 py-3 justify-content-between">
                        <div>
                            <a id="btnEditCert" href="" class="btn btn-warning rounded-3 text-dark btn-sm fw-semibold me-1">
                                <i class="fa-solid fa-pen-to-square me-1"></i>Ubah Data
                            </a>
                            <a id="btnDownloadPdf" href="" class="btn btn-success rounded-3 btn-sm fw-semibold">
                                <i class="fa-solid fa-file-pdf me-1"></i>Unduh PDF
                            </a>
                        </div>
                        <button type="button" class="btn btn-secondary rounded-3 btn-sm" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
// Define loaders for admin panel (since they are not defined in admin layout)
function showLoader() {
    const btn = document.querySelector('#searchForm button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mencari...';
    }
}

function hideLoader() {
    const btn = document.querySelector('#searchForm button[type="submit"]');
    if (btn) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-magnifying-glass me-2"></i>Cari Sertifikat';
    }
}

document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const code = document.getElementById('certCode').value.trim();
    if (!code) return;

    showLoader();

    // Fetch CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('admin.certificates.preview.search', [], false) }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
            "Bypass-Tunnel-Reminder": "true"
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => {
        if (!response.ok) {
            throw response;
        }
        return response.json();
    })
    .then(data => {
        hideLoader();
        if (data.success) {
            const cert = data.data;

            // Titlecase helper
            function toTitleCase(str) {
                return str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
            }

            // Populate preview fields
            const namaSiswa = toTitleCase(cert.nama_siswa);
            document.getElementById('prevName').innerText = namaSiswa;
            document.getElementById('prevJenis').innerText = cert.jenis_sertifikat.toUpperCase();
            
            // Format description with highlighted double quotes and newlines
            let prestasiHtml = cert.prestasi ? cert.prestasi.replace(/\n/g, '<br>') : '';
            prestasiHtml = prestasiHtml.replace(/"(.*?)"/g, '<span style="color:#C89B3C; font-weight:bold;">"$1"</span>');
            prestasiHtml = prestasiHtml.replace(/&quot;(.*?)&quot;/g, '<span style="color:#C89B3C; font-weight:bold;">"$1"</span>');
            document.getElementById('prevDescription').innerHTML = prestasiHtml;

            document.getElementById('prevTanggal').innerText = cert.tanggal;
            document.getElementById('prevNomor').innerText = cert.nomor_sertifikat;

            // Dynamic Font Sizing based on name and description lengths
            const nameLen = namaSiswa.length;
            const descLen = cert.prestasi ? cert.prestasi.length : 0;
            let fs = '3rem';
            if (descLen > 180) {
                if (nameLen > 35) {
                    fs = '1.6rem';
                } else if (nameLen > 25) {
                    fs = '1.9rem';
                } else {
                    fs = '2.2rem';
                }
            } else if (descLen > 120) {
                if (nameLen > 35) {
                    fs = '1.8rem';
                } else if (nameLen > 25) {
                    fs = '2.1rem';
                } else {
                    fs = '2.4rem';
                }
            } else {
                if (nameLen > 40) {
                    fs = '1.8rem';
                } else if (nameLen > 30) {
                    fs = '2.1rem';
                } else if (nameLen > 20) {
                    fs = '2.5rem';
                }
            }
            document.getElementById('prevName').style.fontSize = fs;

            // Populate status badge
            const statusBadge = document.getElementById('prevStatus');
            if (cert.status === 'Aktif') {
                statusBadge.className = "badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold mb-2";
                statusBadge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i>Sertifikat Aktif';
            } else {
                statusBadge.className = "badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-semibold mb-2";
                statusBadge.innerHTML = '<i class="fa-solid fa-circle-minus me-1"></i>Sertifikat Draft';
            }

            // Handle images (logos & signatures) using Base64
            if (cert.logo_base64) {
                document.getElementById('prevLogo').src = cert.logo_base64;
                document.getElementById('prevLogo').style.display = 'inline-block';
            } else {
                document.getElementById('prevLogo').src = "https://via.placeholder.com/100?text=Logo";
            }

            // QR Code dynamic rendering via QRServer CDN
            document.getElementById('prevQrCode').src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(cert.verify_url)}`;

            // Set download PDF action url
            document.getElementById('btnDownloadPdf').href = cert.pdf_url;
            
            if (cert.edit_url) {
                document.getElementById('btnEditCert').href = cert.edit_url;
                document.getElementById('btnEditCert').style.display = 'inline-block';
            } else {
                document.getElementById('btnEditCert').style.display = 'none';
            }

            // Show preview modal
            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            previewModal.show();
        }
    })
    .catch(err => {
        hideLoader();
        if (err.json) {
            err.json().then(errorData => {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ditemukan',
                    text: errorData.message || 'Kode sertifikat tidak terdaftar.',
                    confirmButtonColor: '#E74C3C'
                });
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan sistem, silakan coba lagi.',
                confirmButtonColor: '#E74C3C'
            });
        }
    });
});
</script>
@endsection
