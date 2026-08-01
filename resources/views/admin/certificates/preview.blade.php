@extends('layouts.admin')

@section('title', 'Cari & Preview Sertifikat')

@section('styles')
<style>
    .preview-certificate-container {
        background-color: #FCFBF7;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        padding: 1.25rem 1.5rem !important;
        border: 1px solid rgba(0,0,0,0.08);
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
                        
                        <!-- Certificate Mockup Frame (Canva style) -->
                        <div class="preview-certificate-container p-3 p-md-4 mb-3 position-relative overflow-hidden" style="aspect-ratio: 297/210; min-height: 380px;">
                            <!-- Elegant Double Border Frame -->
                            <div class="preview-border-outer"></div>
                            <div class="preview-border-inner"></div>

                            <!-- Small Elegant Corner Brackets -->
                            <div class="preview-corner-accent-tl"></div>
                            <div class="preview-corner-accent-tr"></div>
                            <div class="preview-corner-accent-bl"></div>
                            <div class="preview-corner-accent-br"></div>

                            <!-- Content -->
                            <div class="position-relative h-100 d-flex flex-column" style="z-index: 5; gap: 0; text-align: left;">

                                <!-- Header: Logo + Subtitle + Seal -->
                                <div class="d-flex justify-content-between align-items-center pb-2" style="border-bottom: 1px solid #e8d5a3; width: 100%;">
                                    <div style="width:48px;">
                                        <img id="prevLogo" src="" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo">
                                    </div>
                                    <div class="text-center flex-grow-1">
                                        <p class="mb-0 text-uppercase fw-bold" style="font-size: 0.58rem; letter-spacing: 1px; color: #334155;">Lembaga Pendidikan Sertifikasi Ekstrakurikuler</p>
                                        <p class="mb-0" style="font-size: 0.48rem; letter-spacing: 0.5px; color: #94A3B8; margin-top: 1px;">Sertifikat Resmi Kegiatan Peserta Didik</p>
                                    </div>
                                    <div style="width:44px;">
                                        <div class="preview-gold-seal-badge" style="width: 44px; height: 44px; border-width: 1.5px;">
                                            <div class="preview-gold-seal-inner" style="top: 2px; left: 2px; right: 2px; bottom: 2px;">
                                                <span style="font-size: 14px;">★</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decorative top ornament -->
                                <div class="text-center w-100" style="margin: 6px 0 2px;">
                                    <span style="color: #D4AF37; font-size: 0.65rem; letter-spacing: 6px;">✦ ✦ ✦</span>
                                </div>

                                <!-- Title + Recipient -->
                                <div class="text-center w-100" style="margin-bottom: 4px;">
                                    <h4 class="fw-bold mb-0 text-uppercase" style="font-family: 'Cormorant Garamond', 'Georgia', serif; color: #0F172A; font-size: 2rem; letter-spacing: 5px; line-height: 1;">Sertifikat</h4>
                                    <p id="prevJenis" class="text-uppercase fw-bold mb-0" style="font-family: 'Poppins', sans-serif; color: #D4AF37; letter-spacing: 4px; font-size: 0.6rem; margin-top: 2px;">SERTIFIKAT KEIKUTSERTAAN</p>

                                    <!-- Thin gold rule -->
                                    <div style="display:flex; align-items:center; margin: 6px auto; width: 70%;">
                                        <div style="flex:1; height:1px; background: linear-gradient(to right, transparent, #D4AF37);"></div>
                                        <span style="color:#D4AF37; font-size:0.6rem; margin: 0 6px;">◆</span>
                                        <div style="flex:1; height:1px; background: linear-gradient(to left, transparent, #D4AF37);"></div>
                                    </div>

                                    <div style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 0.8rem; color: #64748B;">Dengan bangga diberikan kepada:</div>
                                    <h5 class="mb-0" id="prevName" style="font-family: 'Great Vibes', cursive; font-size: 3rem; font-weight: 400; letter-spacing: 1.5px; margin-top: 4px; line-height: 1.1; color: #1a1a2e !important;">Nama Lengkap Siswa</h5>
                                    <div style="width: 60%; height: 1.5px; background: linear-gradient(to right, transparent, #D4AF37, transparent); margin: 6px auto 3px;"></div>
                                    <div class="fw-semibold" id="prevNis" style="font-size: 0.68rem; letter-spacing: 0.8px; font-family: 'Poppins', sans-serif; color: #475569;">NIS. -</div>
                                </div>

                                <!-- Info Badges row -->
                                <div class="d-flex justify-content-center gap-2 w-100" style="margin: 4px 0;">
                                    <div style="background: rgba(212,175,55,0.10); border: 1px solid #D4AF37; border-radius: 20px; padding: 2px 10px; font-size: 0.58rem; color: #92600a; font-weight: 600; letter-spacing: 0.5px; font-family: 'Poppins', sans-serif;">
                                        🎓 Ekskul: <span id="prevEkskul2" style="color:#0F172A;">-</span>
                                    </div>
                                    <div style="background: rgba(15,23,42,0.06); border: 1px solid #CBD5E1; border-radius: 20px; padding: 2px 10px; font-size: 0.58rem; color: #475569; font-weight: 600; letter-spacing: 0.5px; font-family: 'Poppins', sans-serif;">
                                        📅 Periode: <span id="prevPeriode" style="color:#0F172A;">-</span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="text-center px-4 w-100" style="margin: 2px 0 6px;">
                                    <p class="mb-0" id="prevDescription" style="line-height: 1.65; font-size: 0.78rem; color: #334155; font-family: 'Poppins', sans-serif;">
                                    </p>
                                </div>

                                <!-- Decorative bottom ornament -->
                                <div class="text-center w-100" style="margin: 2px 0;">
                                    <span style="color: #D4AF37; font-size: 0.5rem; letter-spacing: 8px;">— ✦ —</span>
                                </div>

                                <!-- Footer: QR | Nomor+Tanggal | Tanda Tangan -->
                                <div class="d-flex justify-content-between align-items-end w-100" style="border-top: 1px solid #e8d5a3; padding-top: 6px; margin-top: auto;">

                                    <!-- QR Code -->
                                    <div class="text-start" style="width:68px;">
                                        <div class="border bg-white p-1 d-inline-block" style="border-color: #D4AF37 !important; border-radius:4px;">
                                            <img id="prevQrCode" src="" style="width:50px; height:50px; display:block;" alt="QR Code">
                                        </div>
                                        <div class="text-muted" style="font-size:0.42rem; margin-top:2px; font-family:'Poppins',sans-serif;">Pindai untuk verifikasi</div>
                                    </div>

                                    <!-- Nomor & Tanggal center -->
                                    <div class="text-center" style="font-family:'Poppins',sans-serif;">
                                        <div style="font-size:0.55rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px;">Nomor Sertifikat</div>
                                        <div class="fw-bold" style="font-size:0.72rem; color:#0F172A;" id="prevNomor">-</div>
                                        <div style="font-size:0.5rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px; margin-top:4px;">Diterbitkan pada</div>
                                        <div class="fw-bold" style="font-size:0.7rem; color:#0F172A;" id="prevTanggal">-</div>
                                    </div>

                                    <!-- Tanda Tangan Resmi -->
                                    <div class="text-center" style="width:120px; font-family:'Poppins',sans-serif;">
                                        <div style="font-size:0.5rem; color:#64748B; text-transform:uppercase; font-weight:600; letter-spacing:0.5px; margin-bottom:2px;" id="prevJabatan">Pembina OSIS</div>
                                        <div style="height: 38px; position: relative;">
                                            <img id="prevSignature" src="" class="img-fluid" style="max-height:36px; width:auto; mix-blend-mode:multiply; display:block; margin:0 auto;" alt="">
                                        </div>
                                        <div style="border-top: 1.5px solid #0F172A; margin: 0 6px 3px 6px;"></div>
                                        <strong class="d-block" id="prevPembina" style="font-family:'Georgia',serif; font-size:0.62rem; color:#0F172A; line-height:1.3;">Nama Pembina</strong>
                                        <div style="font-size:0.42rem; color:#94A3B8; margin-top:1px;">NIP / NIK</div>
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
            document.getElementById('prevName').innerText = toTitleCase(cert.nama_siswa);
            document.getElementById('prevNis').innerText = "NIS. " + cert.nis;
            document.getElementById('prevEkskul2').innerText = cert.ekskul;
            
            const prestasiText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Anggota/Peserta Aktif';
            document.getElementById('prevJenis').innerText = cert.jenis_sertifikat.toUpperCase();
            
            const dateParts = cert.tanggal.split(' ');
            const yrVal = dateParts[dateParts.length - 1];
            const yrNum = parseInt(yrVal);
            if (!isNaN(yrNum)) {
                document.getElementById('prevPeriode').innerText = `${yrNum}/${yrNum+1}`;
            } else {
                const currentYr = new Date().getFullYear();
                document.getElementById('prevPeriode').innerText = `${currentYr}/${currentYr+1}`;
            }
            
            document.getElementById('prevDescription').innerHTML = `Dinyatakan telah mengikuti dan aktif berprestasi dalam kegiatan Ekstrakurikuler <strong style="color: #0F172A;">${cert.ekskul}</strong> dengan predikat <span style="background: rgba(212,175,55,0.15); padding: 1px 6px; border-radius: 4px;"><strong style="color: #b5860d;">"${prestasiText}"</strong></span> pada tahun pelajaran <strong style="color:#0F172A;">{{ date('Y') }}/{{ date('Y')+1 }}</strong>.`;

            document.getElementById('prevTanggal').innerText = cert.tanggal;
            document.getElementById('prevPembina').innerText = cert.nama_pembina;
            document.getElementById('prevJabatan').innerText = cert.jabatan_pembina.toUpperCase();
            document.getElementById('prevNomor').innerText = cert.nomor_sertifikat;

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

            if (cert.signature_base64) {
                document.getElementById('prevSignature').src = cert.signature_base64;
                document.getElementById('prevSignature').style.display = 'inline-block';
            } else {
                document.getElementById('prevSignature').style.display = 'none';
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
