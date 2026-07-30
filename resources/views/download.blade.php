@extends('layouts.public')

@section('title', 'Cari dan Unduh Sertifikat')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Search Card -->
            <div class="card card-custom p-4 p-md-5 border border-light shadow-sm">
                <div class="text-center mb-4">
                    <div class="text-red mb-3">
                        <i class="fa-solid fa-award fa-3x"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Download Sertifikat</h3>
                    <p class="text-muted">Masukkan kode sertifikat unik Anda yang diberikan oleh pembina atau admin.</p>
                </div>
                
                <!-- Search Form -->
                <form id="searchForm" class="mb-2">
                    <div class="row g-2 justify-content-center">
                        <div class="col-md-8 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-pill border-2 border-danger-subtle px-4" id="certCode" placeholder="SK-2026-XXXXXX" required style="height: 60px;">
                                <label for="certCode" class="ps-4">Kode Sertifikat (e.g. SK-2026-8HJ27X)</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 d-grid">
                            <button type="submit" class="btn btn-custom-primary rounded-pill py-3 px-4 fs-6">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>Cari Sertifikat
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted small mt-2">
                    <i class="fa-solid fa-info-circle me-1"></i>Format kode bersifat sensitif (gunakan huruf besar).
                </div>
            </div>

            <!-- Preview Card (Hidden by default) -->
            <div id="previewCard" class="card card-custom mt-5 p-4 p-md-5 border border-success-subtle shadow-sm d-none" style="position: relative; overflow: hidden;">
                <!-- Decorative Top Border -->
                <div class="position-absolute top-0 start-0 end-0 bg-success" style="height: 8px;"></div>
                
                <div class="text-center mb-5 mt-3">
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold mb-3">
                        <i class="fa-solid fa-circle-check me-1"></i>Sertifikat Terdaftar & Valid
                    </span>
                    <h3 class="fw-bold text-dark">Pratinjau Sertifikat</h3>
                    <p class="text-muted small">Silakan periksa detail informasi di bawah ini sebelum mengunduh.</p>
                </div>

                <!-- Certificate Mockup Frame (Canva style) -->
                <div class="p-4 p-md-5 mb-4 position-relative overflow-hidden" style="background-color: #FCFBF7; border: 4px double #D4AF37; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); text-align: center;">
                    <!-- Canva Corner Decorations (using absolute elements inside container) -->
                    <div style="position: absolute; top: 0; left: 0; width: 80px; height: 80px; background-color: #0F172A; clip-path: polygon(0 0, 100% 0, 0 100%); z-index: 2;"></div>
                    <div style="position: absolute; top: 0; left: 0; width: 85px; height: 85px; background-color: #D4AF37; clip-path: polygon(0 0, 100% 0, 0 100%); z-index: 1;"></div>
                    
                    <div style="position: absolute; bottom: 0; right: 0; width: 80px; height: 80px; background-color: #0F172A; clip-path: polygon(100% 0, 100% 100%, 0 100%); z-index: 2;"></div>
                    <div style="position: absolute; bottom: 0; right: 0; width: 85px; height: 85px; background-color: #D4AF37; clip-path: polygon(100% 0, 100% 100%, 0 100%); z-index: 1;"></div>

                    <!-- Inner gold border -->
                    <div style="position: absolute; top: 8px; left: 8px; right: 8px; bottom: 8px; border: 1px solid #D4AF37; border-radius: 8px; pointer-events: none;"></div>

                    <!-- Header -->
                    <div class="row align-items-center mb-4 position-relative" style="z-index: 5; text-align: left;">
                        <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                            <!-- School Logo (Placeholder or dynamic) -->
                            <img id="prevLogo" src="https://via.placeholder.com/100" class="img-fluid rounded border bg-white p-1" style="max-height: 70px; width: auto;" alt="Logo Sekolah">
                        </div>
                        <div class="col-md-8 text-center">
                            <h4 class="fw-bold mb-0 text-uppercase" id="prevSchool" style="font-family: 'Georgia', serif; color: #0F172A; letter-spacing: 1.5px; font-size: 1.25rem;">SMK NEGERI 1 CIREBON</h4>
                            <p class="text-muted small mb-0 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; font-weight: 600;">Sertifikat Hasil Kegiatan Ekstrakurikuler</p>
                        </div>
                        <div class="col-md-2 text-center text-md-end d-none d-md-block">
                            <!-- Gold Medal -->
                            <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; border: 2px dashed #fff; background: radial-gradient(circle, #f39c12, #D4AF37);">
                                <span style="font-size: 1.25rem;">★</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center my-4 position-relative" style="z-index: 5;">
                        <!-- Georgia Serif Fonts -->
                        <h3 class="fw-bold mb-1 text-uppercase" style="font-family: 'Georgia', serif; color: #0F172A; font-size: 1.9rem; letter-spacing: 3px; margin: 0;">Sertifikat</h3>
                        <span id="prevJenis" class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fs-7 fw-bold mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem; background-color: #FFEAA7 !important; border: 1px solid #D4AF37;">Kejuaraan</span>
                        
                        <div class="recipient-label text-muted" style="font-family: 'Georgia', serif; font-style: italic; font-size: 0.85rem; margin-top: 10px;">Diberikan Kepada:</div>
                        <h2 class="fw-bold text-dark my-1" id="prevName" style="font-family: 'Georgia', serif; font-size: 2.2rem; border-bottom: 2px solid #D4AF37; display: inline-block; padding-bottom: 3px;">AUREL CALISTA</h2>
                        <div class="fw-bold text-muted small mt-1" id="prevNis">NIS. 2026102391</div>
                    </div>

                    <div class="my-4 text-center position-relative" style="z-index: 5;">
                        <p class="fs-6 text-secondary" style="line-height: 1.8; max-width: 82%; margin: 0 auto; font-size: 0.95rem;">
                            Telah berhasil menyelesaikan dan berpartisipasi aktif pada kegiatan ekstrakurikuler 
                            <strong id="prevEkskul" style="color: #0F172A;">Pramuka</strong> dengan predikat prestasi/pencapaian 
                            <strong id="prevPrestasi" style="color: #D4AF37;">Juara 1 Lomba Tingkat Kota</strong>.
                        </p>
                    </div>

                    <div class="row align-items-end mt-5 position-relative" style="z-index: 5; text-align: left;">
                        <!-- QR Code -->
                        <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                            <img id="prevQrCode" src="" class="img-fluid border bg-white p-1 rounded shadow-sm" style="width: 90px; height: 90px; border-color: #D4AF37 !important;" alt="QR Code Verifikasi">
                            <span class="d-block text-muted small mt-1" style="font-size: 0.65rem;">Pindai untuk Verifikasi</span>
                        </div>
                        
                        <!-- Certificate Details -->
                        <div class="col-md-4 text-center mb-4 mb-md-0 small">
                            <div class="text-muted">Kode: <strong id="prevCode" style="color: #E74C3C;">SK-2026-XXXX</strong></div>
                            <div class="text-muted">Nomor: <span id="prevNomor" class="text-dark">001/EKS/2026</span></div>
                            <div class="text-muted">Tanggal: <span id="prevTanggal" class="text-dark">30 Juli 2026</span></div>
                        </div>

                        <!-- Signature -->
                        <div class="col-md-4 text-center text-md-end">
                            <span class="text-muted d-block small mb-1" id="prevJabatan" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 8px;">Pembina Pramuka</span>
                            <div class="my-2" style="height: 50px;">
                                <img id="prevSignature" src="https://via.placeholder.com/150x50" class="img-fluid" style="max-height: 50px; width: auto;" alt="Tanda Tangan">
                            </div>
                            <strong class="d-block text-dark" id="prevPembina" style="font-family: 'Georgia', serif; font-size: 0.95rem;">Budi Santoso, S.Pd.</strong>
                        </div>
                    </div>
                </div>

                <!-- Download Actions -->
                <div class="text-center mt-4">
                    <a id="btnDownloadPdf" href="" class="btn btn-lg btn-success rounded-pill px-5 py-3 shadow">
                        <i class="fa-solid fa-file-pdf me-2"></i>Download PDF Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const code = document.getElementById('certCode').value.trim();
    if (!code) return;

    showLoader();
    
    // Reset preview
    document.getElementById('previewCard').classList.add('d-none');

    // Fetch CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('download.search') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token
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
            document.getElementById('prevNis').innerText = "NIS. " + cert.nis;
            document.getElementById('prevSchool').innerText = cert.sekolah.toUpperCase();
            document.getElementById('prevEkskul').innerText = cert.ekskul;
            document.getElementById('prevJenis').innerText = cert.jenis_sertifikat;
            document.getElementById('prevPrestasi').innerText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Peserta Aktif';
            document.getElementById('prevTanggal').innerText = cert.tanggal;
            document.getElementById('prevPembina').innerText = cert.nama_pembina;
            document.getElementById('prevJabatan').innerText = cert.jabatan_pembina;
            document.getElementById('prevCode').innerText = cert.code;
            document.getElementById('prevNomor').innerText = cert.nomor_sertifikat;

            // Handle images (logos & signatures)
            if (cert.logo_sekolah) {
                document.getElementById('prevLogo').src = "{{ asset('storage') }}/" + cert.logo_sekolah;
                document.getElementById('prevLogo').style.display = 'inline-block';
            } else {
                document.getElementById('prevLogo').src = "https://via.placeholder.com/100?text=Logo";
            }

            if (cert.tanda_tangan) {
                document.getElementById('prevSignature').src = "{{ asset('storage') }}/" + cert.tanda_tangan;
                document.getElementById('prevSignature').style.display = 'inline-block';
            } else {
                document.getElementById('prevSignature').style.display = 'none';
            }

            // QR Code dynamic rendering via QRServer CDN based on validation link
            document.getElementById('prevQrCode').src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(cert.verify_url)}`;

            // Set download PDF action url
            document.getElementById('btnDownloadPdf').href = cert.pdf_url;

            // Show preview
            document.getElementById('previewCard').classList.remove('d-none');
            
            // Smooth scroll to preview
            document.getElementById('previewCard').scrollIntoView({ behavior: 'smooth' });
        }
    })
    .catch(err => {
        hideLoader();
        if (err.json) {
            err.json().then(errorData => {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ditemukan',
                    text: errorData.message || 'Kode sertifikat tidak terdaftar atau tidak aktif.',
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
