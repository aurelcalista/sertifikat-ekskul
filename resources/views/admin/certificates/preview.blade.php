@extends('layouts.admin')

@section('title', 'Cari & Preview Sertifikat')

@section('styles')
<style>
    /* Styling to match the PDF certificate view */
    .preview-certificate-container {
        background-color: #FCFBF7;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        padding: 2.2rem 2.8rem !important; /* Compact padding to reduce scrolling */
    }
    
    #prevSignature {
        height: 90px !important;
        width: 180px !important;
        object-fit: contain;
        display: block;
        margin: 0 auto;
        mix-blend-mode: multiply; /* Removes white background */
        transform: scale(1.3); /* Scale up to compensate for margins */
        transform-origin: center;
    }
    
    .preview-border-outer {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 2px solid #D4AF37;
        z-index: 5;
        pointer-events: none;
    }
    
    .preview-border-inner {
        position: absolute;
        top: 14px;
        left: 14px;
        right: 14px;
        bottom: 14px;
        border: 1px solid #0F172A;
        z-index: 5;
        pointer-events: none;
    }
    
    .preview-corner-accent-tl {
        position: absolute;
        top: 18px;
        left: 18px;
        width: 16px;
        height: 16px;
        border-top: 2.5px solid #D4AF37;
        border-left: 2.5px solid #D4AF37;
        z-index: 6;
    }
    
    .preview-corner-accent-tr {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 16px;
        height: 16px;
        border-top: 2.5px solid #D4AF37;
        border-right: 2.5px solid #D4AF37;
        z-index: 6;
    }
    
    .preview-corner-accent-bl {
        position: absolute;
        bottom: 18px;
        left: 18px;
        width: 16px;
        height: 16px;
        border-bottom: 2.5px solid #D4AF37;
        border-left: 2.5px solid #D4AF37;
        z-index: 6;
    }
    
    .preview-corner-accent-br {
        position: absolute;
        bottom: 18px;
        right: 18px;
        width: 16px;
        height: 16px;
        border-bottom: 2.5px solid #D4AF37;
        border-right: 2.5px solid #D4AF37;
        z-index: 6;
    }

    .preview-gold-seal-badge {
        width: 50px;
        height: 50px;
        background: radial-gradient(circle, #f39c12, #D4AF37);
        border-radius: 50%;
        position: relative;
        display: inline-block;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        border: 1.5px dashed #FFFFFF;
    }

    .preview-gold-seal-inner {
        position: absolute;
        top: 3px;
        left: 3px;
        right: 3px;
        bottom: 3px;
        border: 0.8px solid rgba(255,255,255,0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-gold-seal-inner span {
        color: #FFFFFF;
        font-size: 14px;
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

        <!-- Preview Card (Hidden by default) -->
        <div id="previewCard" class="card card-custom-admin p-4 shadow-sm d-none" style="position: relative; overflow: hidden;">
            <div class="text-center mb-4 mt-2">
                <span id="prevStatus" class="badge px-3 py-2 rounded-pill fw-semibold mb-2">
                    <!-- Populated dynamically -->
                </span>
                <h3 class="fw-bold text-dark mb-1">Pratinjau Dokumen</h3>
                <p class="text-muted small mb-0">Berikut pratinjau sertifikat yang tersimpan di dalam sistem database.</p>
            </div>

            <!-- Certificate Mockup Frame (Canva style) -->
            <div class="preview-certificate-container p-3 p-md-4 mb-3 position-relative overflow-hidden">
                <!-- Elegant Double Border Frame -->
                <div class="preview-border-outer"></div>
                <div class="preview-border-inner"></div>

                <!-- Small Elegant Corner Brackets -->
                <div class="preview-corner-accent-tl"></div>
                <div class="preview-corner-accent-tr"></div>
                <div class="preview-corner-accent-bl"></div>
                <div class="preview-corner-accent-br"></div>

                <!-- Header -->
                <div class="row align-items-center mb-3 position-relative" style="z-index: 5; text-align: left;">
                    <div class="col-md-2 text-center text-md-start mb-2 mb-md-0">
                        <!-- School Logo (Placeholder or dynamic) -->
                        <img id="prevLogo" src="https://via.placeholder.com/100" class="img-fluid" style="max-height: 60px; width: auto;" alt="Logo Sekolah">
                    </div>
                    <div class="col-md-8 text-center">
                        <h4 class="fw-bold mb-0 text-uppercase" id="prevSchool" style="font-family: 'Georgia', serif; color: #0F172A; letter-spacing: 2px; font-size: 1.15rem; line-height: 1.2;">SMK NEGERI 1 CIREBON</h4>
                        <p class="text-muted small mb-0 text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px; font-weight: 600; margin-top: 3px;">Hasil Penilaian Kegiatan Ekstrakurikuler Mandiri</p>
                    </div>
                    <div class="col-md-2 text-center text-md-end d-none d-md-block">
                        <!-- Gold Seal Badge -->
                        <div class="preview-gold-seal-badge">
                            <div class="preview-gold-seal-inner">
                                <span style="font-size: 14px;">★</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center my-3 position-relative" style="z-index: 5;">
                    <!-- Georgia Serif Fonts -->
                    <h3 class="fw-bold mb-0 text-uppercase" style="font-family: 'Georgia', serif; color: #0F172A; font-size: 2rem; letter-spacing: 3px; line-height: 1.1;">Sertifikat</h3>
                    <p id="prevJenis" class="text-uppercase fw-bold mb-2 text-secondary" style="font-family: 'Georgia', serif; color: #D4AF37 !important; letter-spacing: 4px; font-size: 0.8rem; margin-top: 2px;">KEJUARAAN</p>
                    
                    <div class="recipient-label text-muted" style="font-family: 'Georgia', serif; font-style: italic; font-size: 0.85rem; margin-top: 6px;">Diberikan Kepada:</div>
                    <div class="my-0">
                        <h2 class="fw-bold text-dark m-0" id="prevName" style="font-family: 'Georgia', serif; font-size: 2rem; letter-spacing: 1px;">AUREL CALISTA</h2>
                    </div>
                    <div class="preview-gold-divider" style="width: 55%; max-width: 400px; height: 1.5px; background-color: #D4AF37; margin: 4px auto;"></div>
                    <div class="fw-bold text-secondary small mt-1" id="prevNisAndKelas" style="letter-spacing: 0.5px; font-size: 0.8rem;">NIS. 2026102391 &nbsp;|&nbsp; KELAS: XII RPL 1</div>
                </div>

                <div class="my-3 text-center position-relative" style="z-index: 5;">
                    <p class="text-secondary mb-0" style="line-height: 1.6; max-width: 85%; margin: 0 auto; font-size: 0.9rem;">
                        Telah menyelesaikan dan berpartisipasi aktif dalam kegiatan ekstrakurikuler 
                        <strong id="prevEkskul" style="color: #0F172A;">Pramuka</strong> dengan pencapaian prestasi luar biasa sebagai 
                        "<strong id="prevPrestasi" style="color: #D4AF37;">Juara 1 Lomba Tingkat Kota</strong>" pada tahun pelajaran {{ date('Y') }}.
                    </p>
                </div>

                <div class="row align-items-end mt-4 position-relative" style="z-index: 5; text-align: left;">
                    <!-- QR Code -->
                    <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                        <img id="prevQrCode" src="" class="img-fluid border bg-white p-1 rounded shadow-sm" style="width: 75px; height: 75px; border-color: #D4AF37 !important;" alt="QR Code Verifikasi">
                        <span class="d-block text-muted small mt-1" style="font-size: 0.6rem; letter-spacing: 0.3px; font-weight: 500;">Pindai untuk validasi sertifikat</span>
                    </div>
                    
                    <!-- Certificate Details -->
                    <div class="col-md-4 text-center mb-3 mb-md-0 small">
                        <div class="fw-bold text-dark small" style="font-size: 0.8rem;">No: <span id="prevNomor">001/EKS/2026</span></div>
                        <div class="mt-1 small" style="font-size: 0.8rem;">Kode Verifikasi: <strong id="prevCode" style="color: #E74C3C; font-size: 0.85rem;">SK-2026-XXXX</strong></div>
                        <div class="mt-2 text-muted text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.5px;">Diterbitkan pada tanggal:</div>
                        <div class="fw-bold text-dark mt-0" id="prevTanggal" style="font-size: 0.78rem;">30 Juli 2026</div>
                    </div>

                    <!-- Signature -->
                    <div class="col-md-4 text-center">
                        <span class="text-muted d-block small mb-1" id="prevJabatan" style="font-size: 0.7rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 4px;">Pembina Pramuka</span>
                        <div class="my-1" style="height: 90px;">
                            <img id="prevSignature" src="https://via.placeholder.com/150x50" class="img-fluid" alt="Tanda Tangan">
                        </div>
                        <strong class="d-block text-dark" id="prevPembina" style="font-family: 'Georgia', serif; font-size: 0.88rem;">Budi Santoso, S.Pd.</strong>
                    </div>
                </div>
            </div>

            <!-- Download / Action Buttons -->
            <div class="text-center mt-3 d-flex justify-content-center gap-2">
                <a id="btnDownloadPdf" href="" class="btn btn-success rounded-3 px-4 py-2">
                    <i class="fa-solid fa-file-pdf me-2"></i>Unduh PDF
                </a>
                <a id="btnEditCert" href="" class="btn btn-warning rounded-3 px-4 py-2 text-dark">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Ubah Data
                </a>
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
    
    // Reset preview
    document.getElementById('previewCard').classList.add('d-none');

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

            // Populate preview fields
            document.getElementById('prevName').innerText = cert.nama_siswa.toUpperCase();
            document.getElementById('prevNisAndKelas').innerHTML = "NIS. " + cert.nis + " &nbsp;|&nbsp; KELAS: " + cert.kelas.toUpperCase();
            document.getElementById('prevSchool').innerText = cert.sekolah.toUpperCase();
            document.getElementById('prevEkskul').innerText = cert.ekskul;
            document.getElementById('prevJenis').innerText = cert.jenis_sertifikat.toUpperCase();
            document.getElementById('prevPrestasi').innerText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Anggota/Peserta Aktif';
            document.getElementById('prevTanggal').innerText = cert.tanggal;
            document.getElementById('prevPembina').innerText = cert.nama_pembina;
            document.getElementById('prevJabatan').innerText = cert.jabatan_pembina;
            document.getElementById('prevCode').innerText = cert.code;
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
            
            // Set edit certificate link (assuming standard resource route structure)
            // Wait, we need the certificate ID to build the edit URL!
            // Let's pass the ID in the search response or get the edit URL from server.
            // But we can check what cert.pdf_url ends with or add an 'edit_url' field in Controller search response!
            // Actually, we don't have cert.id in the response yet, so let's make sure the controller returns it!
            // Let's see: we can construct the edit URL dynamically if we know the ID or we can just fetch it from the database!
            // Let's add 'edit_url' field in SiswaController/CertificateController. In the CertificateController preview search, we can return the edit_url!
            // Yes! In CertificateController, I returned the edit url:
            // Let's check my CertificateController search output:
            // It did not have edit_url yet. Let's add it! Or we can use route builder or edit_url directly.
            // Let's add 'edit_url' => route('admin.certificates.edit', $certificate->id) in CertificateController@search.
            // For now, in JS:
            if (cert.edit_url) {
                document.getElementById('btnEditCert').href = cert.edit_url;
                document.getElementById('btnEditCert').style.display = 'inline-block';
            } else {
                document.getElementById('btnEditCert').style.display = 'none';
            }

            // Show preview
            document.getElementById('previewCard').classList.remove('d-none');
            
            // Smooth scroll to preview
            document.getElementById('previewCard').scrollIntoView({ behavior: 'smooth', block: 'center' });
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
