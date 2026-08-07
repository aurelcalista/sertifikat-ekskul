@extends('layouts.admin')

@section('title', 'Cari & Preview Sertifikat')

@section('styles')
<style>
    .preview-certificate-container {
        background-color: #FFFFFF;
        background-image: radial-gradient(rgba(200, 155, 60, 0.03) 1px, transparent 0), radial-gradient(rgba(200, 155, 60, 0.03) 1px, transparent 0);
        background-size: 8px 8px;
        background-position: 0 0, 4px 4px;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        padding: 1.25rem 1.5rem !important;
        border: 1px solid #F3F4F6;
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
<div class="preview-certificate-container bg-white position-relative overflow-hidden rounded-4 border shadow-sm p-4 text-center" style="aspect-ratio: 297 / 210; max-width: 720px; width: 100%; margin: 0 auto; display: flex; flex-direction: column; justify-content: space-between;">
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

    <div class="position-relative w-100 h-100 d-flex flex-column justify-content-between" style="z-index: 5;">
        <div class="text-center pt-1" style="margin-bottom: 10px;">
            <img id="prevLogo" src="{{ asset('logos/logo-rakitai.png') }}" style="max-height: 42px; width: auto; display: inline-block;" alt="Logo Rakit AI">
        </div>
        <div class="text-center my-1">
            <h2 style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 2.05rem; font-weight: 700; color: #1F2A44; letter-spacing: 6px; margin: 0 0 4px 0; text-transform: uppercase;">SERTIFIKAT</h2>
            <p id="prevJenis" style="font-family: 'Poppins', sans-serif; font-size: 0.72rem; font-weight: 600; color: #F15A3D; letter-spacing: 3px; margin: 3px 0 8px 0; text-transform: uppercase;">SERTIFIKAT KEIKUTSERTAAN</p>
            <div>
                <span id="prevPillCode" style="border: 1.5px solid #1F2A44; border-radius: 14px; padding: 2px 14px; font-family: 'Poppins', sans-serif; font-size: 0.62rem; font-weight: 600; color: #1F2A44; display: inline-block;">Certificat No: -</span>
            </div>
        </div>
        <div class="text-center my-1">
            <p style="font-family: 'Poppins', sans-serif; font-size: 0.72rem; color: #475569; margin-bottom: 4px; letter-spacing: 0.5px;">Diberikan kepada:</p>
            <h3 id="prevName" style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.75rem; font-weight: 700; color: #1F2A44; margin: 2px 0 0 0; text-transform: uppercase; letter-spacing: 1px;">NAMA LENGKAP SISWA</h3>
        </div>
        <div class="text-center px-4 my-2" style="margin-top: 12px !important;">
            <p id="prevDescription" class="mb-0 text-secondary" style="font-family: 'Poppins', sans-serif; font-size: 0.78rem; line-height: 1.7; letter-spacing: 0.2px; margin-top: 8px; margin-bottom: 8px;">Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri.</p>
        </div>
        <div class="d-flex justify-content-between align-items-end w-100 pt-2" style="margin-top: auto;">
            <div style="width: 30%; text-align: left;">
                <img id="prevQrCode" src="" style="width: 58px; height: 58px; border: 1.5px solid #CBD5E1; padding: 3px; border-radius: 8px; background: #FFFFFF; display: inline-block;" alt="QR Code">
            </div>
            <div style="width: 40%; text-align: center;">
                <svg viewBox="0 0 100 130" style="width: 68px; height: 88px; display: inline-block; filter: drop-shadow(0px 3px 5px rgba(0,0,0,0.25));">
                    <defs>
                        <radialGradient id="gRadP_adminPrev" cx="40%" cy="35%" r="60%">
                            <stop offset="0%" stop-color="#FFF8DC" />
                            <stop offset="30%" stop-color="#FFD700" />
                            <stop offset="60%" stop-color="#DAA520" />
                            <stop offset="100%" stop-color="#8B6508" />
                        </radialGradient>
                        <radialGradient id="gEdgP_adminPrev" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#FFD700" />
                            <stop offset="100%" stop-color="#8B4513" />
                        </radialGradient>
                        <linearGradient id="rLP_adminPrev" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#1a3a7a" />
                            <stop offset="50%" stop-color="#2563EB" />
                            <stop offset="100%" stop-color="#1a3a7a" />
                        </linearGradient>
                        <linearGradient id="rRP_adminPrev" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#1a3a7a" />
                            <stop offset="50%" stop-color="#2563EB" />
                            <stop offset="100%" stop-color="#1a3a7a" />
                        </linearGradient>
                    </defs>
                    <polygon points="42,68 30,130 42,118 50,125" fill="url(#rLP_adminPrev)" />
                    <polygon points="58,68 70,130 58,118 50,125" fill="url(#rRP_adminPrev)" />
                    <circle cx="50" cy="50" r="40" fill="url(#gEdgP_adminPrev)" stroke="#8B6508" stroke-width="1" stroke-dasharray="7.5 4.5" />
                    <circle cx="50" cy="50" r="37" fill="url(#gRadP_adminPrev)" />
                    <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
                    <circle cx="50" cy="50" r="31" fill="url(#gRadP_adminPrev)" />
                    <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" stroke-dasharray="3 2" />
                    <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.35" />
                </svg>
            </div>
            <div style="width: 30%; text-align: right; padding-right: 5px;">
                <div style="display: inline-block; text-align: right;">
                    <div style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 0.88rem; color: #475569; font-style: italic; margin-bottom: 3px;">Diterbitkan pada tanggal</div>
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                        <span id="prevTanggal" style="font-family: 'Poppins', sans-serif; font-size: 0.85rem; font-weight: 700; color: #0F172A;">-</span>
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                    </div>
                    <div style="height: 1.5px; background: linear-gradient(to right, transparent, #64748B, transparent); margin-top: 4px;"></div>
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
            if (document.getElementById('prevPillCode')) document.getElementById('prevPillCode').innerText = 'Certificat No: ' + (cert.nomor_sertifikat || '-');
            if (document.getElementById('prevNumber')) document.getElementById('prevNumber').innerText = cert.nomor_sertifikat || '-';

            // Dynamic Font Sizing
            const nameLen = namaSiswa.length;
            let fs = '2.5rem';
            if (nameLen > 35) fs = '1.7rem';
            else if (nameLen > 25) fs = '2.0rem';
            else if (nameLen > 18) fs = '2.2rem';
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
                document.getElementById('prevLogo').src = "{{ asset('logos/logo-rakitai.png') }}";
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
