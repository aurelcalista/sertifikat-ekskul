@extends('layouts.admin')

@section('title', 'Data Sertifikat')

@section('content')
<div class="card-custom-admin shadow-sm">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Data Sertifikat</h4>
            <p class="text-muted small mb-0">Kelola data sertifikat ekstrakurikuler siswa secara efisien.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.certificates.export.excel') }}" class="btn btn-outline-success rounded-3 px-3">
                <i class="fa-solid fa-file-excel me-2"></i>Ekspor Excel (CSV)
            </a>
            <a href="{{ route('admin.certificates.export.pdf') }}" class="btn btn-outline-danger rounded-3 px-3">
                <i class="fa-solid fa-file-pdf me-2"></i>Ekspor PDF List
            </a>
            <a href="{{ route('admin.certificates.create') }}" class="btn btn-danger rounded-3 px-3">
                <i class="fa-solid fa-circle-plus me-2"></i>Tambah Baru
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('admin.certificates.index') }}" method="GET" class="row g-3 mb-4 bg-light p-3 rounded-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Kode, Nama Siswa, NIS, atau No. Sertifikat..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <select name="ekskul" class="form-select">
                <option value="">-- Semua Ekskul --</option>
                @foreach($ekskul_list as $ekskul)
                    <option value="{{ $ekskul }}" {{ request('ekskul') == $ekskul ? 'selected' : '' }}>{{ $ekskul }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-dark rounded-3"><i class="fa-solid fa-filter me-2"></i>Filter</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-4">
            <thead class="table-light text-secondary small">
                <tr>
                    <th>Kode</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Ekskul</th>
                    <th>Prestasi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificates as $cert)
                    <tr class="small text-dark">
                        <td>
                            <strong class="text-danger">{{ $cert->code }}</strong>
                            <div class="text-muted" style="font-size: 0.75rem;">No. {{ $cert->nomor_sertifikat }}</div>
                        </td>
                        <td class="fw-semibold">{{ $cert->nama_siswa }}</td>
                        <td>{{ $cert->nis }}</td>
                        <td><span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded-pill">{{ $cert->ekskul }}</span></td>
                        <td class="text-orange fw-medium">{{ $cert->prestasi ?? 'Peserta' }}</td>
                        <td>{{ $cert->tanggal->translatedFormat('d M Y') }}</td>
                        <td>
                            @if($cert->status == 'Aktif')
                                <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-pill"><i class="fa-solid fa-circle-check me-1"></i>Aktif</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5 rounded-pill"><i class="fa-solid fa-circle-minus me-1"></i>Draft</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <!-- Verify & Preview Popup -->
                                <button type="button" class="btn btn-sm btn-light border btn-preview" data-code="{{ $cert->code }}" title="Pratinjau & Verifikasi Sertifikat">
                                    <i class="fa-solid fa-eye text-primary"></i>
                                </button>
                                <!-- Download PDF -->
                                @if($cert->status == 'Aktif')
                                    <a href="{{ route('download.pdf', $cert->code) }}" class="btn btn-sm btn-light border" title="Unduh PDF">
                                        <i class="fa-solid fa-download text-success"></i>
                                    </a>
                                @endif
                                <!-- Edit -->
                                <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="btn btn-sm btn-light border" title="Ubah Data">
                                    <i class="fa-solid fa-pen-to-square text-warning"></i>
                                </a>
                                <!-- Delete -->
                                <button type="button" class="btn btn-sm btn-light border delete-btn" data-id="{{ $cert->id }}" data-name="{{ $cert->nama_siswa }}" title="Hapus">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                                <form id="delete-form-{{ $cert->id }}" action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-file-invoice fa-3x mb-3 d-block"></i>
                            <span>Sertifikat tidak ditemukan. Silakan tambahkan data baru atau ganti filter.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $certificates->links() }}
    </div>
</div>

<!-- CSS Styling for Certificate Preview Frame inside Modal -->
<style>
    .preview-certificate-container {
        background-color: #FCFBF7;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 1.5rem 2rem !important;
        border: 1px solid rgba(0,0,0,0.08);
    }
    
    .preview-border-outer {
        position: absolute;
        top: 6px;
        left: 6px;
        right: 6px;
        bottom: 6px;
        border: 1.5px solid #D4AF37;
        z-index: 5;
        pointer-events: none;
    }
    
    .preview-border-inner {
        position: absolute;
        top: 9px;
        left: 9px;
        right: 9px;
        bottom: 9px;
        border: 0.8px solid #0F172A;
        z-index: 5;
        pointer-events: none;
    }
    
    .preview-corner-accent-tl {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 12px;
        height: 12px;
        border-top: 2px solid #D4AF37;
        border-left: 2px solid #D4AF37;
        z-index: 6;
    }
    
    .preview-corner-accent-tr {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 12px;
        height: 12px;
        border-top: 2px solid #D4AF37;
        border-right: 2px solid #D4AF37;
        z-index: 6;
    }
    
    .preview-corner-accent-bl {
        position: absolute;
        bottom: 12px;
        left: 12px;
        width: 12px;
        height: 12px;
        border-bottom: 2px solid #D4AF37;
        border-left: 2px solid #D4AF37;
        z-index: 6;
    }
    
    .preview-corner-accent-br {
        position: absolute;
        bottom: 12px;
        right: 12px;
        width: 12px;
        height: 12px;
        border-bottom: 2px solid #D4AF37;
        border-right: 2px solid #D4AF37;
        z-index: 6;
    }

    .preview-gold-seal-badge {
        width: 40px;
        height: 40px;
        background: radial-gradient(circle, #f39c12, #D4AF37);
        border-radius: 50%;
        position: relative;
        display: inline-block;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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

    #modalTab .nav-link {
        color: var(--text-muted);
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }
    #modalTab .nav-link.active {
        background-color: var(--primary-color) !important;
        color: #FFFFFF !important;
        border-color: var(--primary-color) !important;
    }
</style>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom px-4">
                <h5 class="modal-title fw-bold text-dark" id="previewModalLabel">
                    <i class="fa-solid fa-certificate text-danger me-2"></i>Keaslian & Pratinjau Sertifikat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <!-- Status Badge -->
                <div class="text-center mb-3">
                    <span id="modalStatus" class="badge px-3 py-2 rounded-pill fw-semibold mb-2"></span>
                </div>

                <!-- Navigation Tabs / Pills -->
                <ul class="nav nav-pills nav-fill mb-3 bg-white p-1 rounded-3 border" id="modalTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold btn-sm py-2" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-pane" type="button" role="tab" aria-controls="detail-pane" aria-selected="true">
                            <i class="fa-solid fa-list-check me-1.5"></i>Keaslian Sertifikat
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold btn-sm py-2" id="preview-tab" data-bs-toggle="tab" data-bs-target="#preview-pane" type="button" role="tab" aria-controls="preview-pane" aria-selected="false">
                            <i class="fa-solid fa-file-invoice me-1.5"></i>Pratinjau Sertifikat
                        </button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="modalTabContent">
                    <!-- Tab 1: Keaslian / Verifikasi Details -->
                    <div class="tab-pane fade show active" id="detail-pane" role="tabpanel" aria-labelledby="detail-tab" tabindex="0">
                        <div class="card border border-success-subtle bg-white p-3 rounded-4 mb-3 text-center">
                            <div class="text-success mb-2">
                                <i class="fa-solid fa-circle-check fa-3x"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-1">Sertifikat Valid & Terdaftar</h5>
                            <p class="text-muted small mb-0">Sertifikat dengan kode <strong id="modalDetailCodeHeader" class="text-dark"></strong> telah divalidasi oleh sistem.</p>
                        </div>
                        
                        <div class="table-responsive rounded-4 border bg-white shadow-xs">
                            <table class="table table-striped table-hover align-middle mb-0 small">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light" style="width: 35%;">Kode Sertifikat</td>
                                        <td class="fw-bold text-danger" id="tblCode"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Nomor Sertifikat</td>
                                        <td id="tblNomor"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Nama Siswa</td>
                                        <td class="fw-bold text-dark" id="tblName"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">NIS</td>
                                        <td id="tblNis"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Sekolah</td>
                                        <td id="tblSchool"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Kelas</td>
                                        <td id="tblKelas"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Ekstrakurikuler</td>
                                        <td><span class="badge bg-secondary-subtle text-secondary" id="tblEkskul"></span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Jenis Sertifikat</td>
                                        <td id="tblJenis"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Prestasi / Pencapaian</td>
                                        <td class="text-orange fw-medium" id="tblPrestasi"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Tanggal Terbit</td>
                                        <td id="tblTanggal"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Pembina / TTD</td>
                                        <td id="tblPembina"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2: Pratinjau Sertifikat Mockup -->
                    <div class="tab-pane fade" id="preview-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                        <!-- Mockup Container -->
                        <div class="preview-certificate-container p-3 p-md-4 mb-0 position-relative overflow-hidden" id="modalCertFrame">
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
                                    <img id="modalLogo" src="" class="img-fluid" style="max-height: 50px; width: auto;" alt="Logo Sekolah">
                                </div>
                                <div class="col-md-8 text-center">
                                    <h4 class="fw-bold mb-0 text-uppercase" id="modalSchool" style="font-family: 'Georgia', serif; color: #0F172A; letter-spacing: 1.5px; font-size: 1rem; line-height: 1.2;"></h4>
                                    <p class="text-muted small mb-0 text-uppercase" style="font-size: 0.55rem; letter-spacing: 0.5px; font-weight: 600; margin-top: 2px;">Hasil Penilaian Kegiatan Ekstrakurikuler Mandiri</p>
                                </div>
                                <div class="col-md-2 text-center text-md-end d-none d-md-block">
                                    <!-- Gold Seal Badge -->
                                    <div class="preview-gold-seal-badge">
                                        <div class="preview-gold-seal-inner">
                                            <span style="font-size: 10px;">★</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center my-3 position-relative" style="z-index: 5;">
                                <h3 class="fw-bold mb-0 text-uppercase" style="font-family: 'Georgia', serif; color: #0F172A; font-size: 1.6rem; letter-spacing: 2px; line-height: 1.1;">Sertifikat</h3>
                                <p id="modalJenis" class="text-uppercase fw-bold mb-2 text-secondary" style="font-family: 'Georgia', serif; color: #D4AF37 !important; letter-spacing: 3px; font-size: 0.75rem; margin-top: 2px;"></p>
                                
                                <div class="recipient-label text-muted" style="font-family: 'Georgia', serif; font-style: italic; font-size: 0.75rem; margin-top: 4px;">Diberikan Kepada:</div>
                                <div class="my-0">
                                    <h2 class="fw-bold text-dark m-0" id="modalName" style="font-family: 'Georgia', serif; font-size: 1.6rem; letter-spacing: 1px;"></h2>
                                </div>
                                <div class="preview-gold-divider" style="width: 50%; max-width: 300px; height: 1px; background-color: #D4AF37; margin: 3px auto;"></div>
                                <div class="fw-bold text-secondary small mt-1" id="modalNisAndKelas" style="letter-spacing: 0.5px; font-size: 0.75rem;"></div>
                            </div>

                            <div class="my-3 text-center position-relative" style="z-index: 5;">
                                <p class="text-secondary mb-0" id="modalDescription" style="line-height: 1.5; max-width: 85%; margin: 0 auto; font-size: 0.82rem;">
                                </p>
                            </div>

                            <div class="row align-items-end mt-3 position-relative" style="z-index: 5; text-align: left;">
                                <!-- QR Code -->
                                <div class="col-md-4 text-center text-md-start mb-2 mb-md-0">
                                    <img id="modalQrCode" src="" class="img-fluid border bg-white p-1 rounded shadow-sm" style="width: 65px; height: 65px; border-color: #D4AF37 !important;" alt="QR Code Verifikasi">
                                    <span class="d-block text-muted small mt-1" style="font-size: 0.55rem; letter-spacing: 0.2px; font-weight: 500;">Pindai untuk validasi</span>
                                </div>
                                
                                <!-- Certificate Details -->
                                <div class="col-md-4 text-center mb-2 mb-md-0 small" style="font-size: 0.7rem;">
                                    <div class="fw-bold text-dark">No: <span id="modalNomor"></span></div>
                                    <div class="mt-1">Kode: <strong id="modalCode" style="color: #E74C3C;"></strong></div>
                                    <div class="fw-bold text-dark mt-2" id="modalTanggal"></div>
                                </div>

                                <!-- Signature -->
                                <div class="col-md-4 text-center">
                                    <span class="text-muted d-block small mb-1" id="modalJabatan" style="font-size: 0.65rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 2px;"></span>
                                    <div class="my-1" style="height: 70px;">
                                        <img id="modalSignature" src="" class="img-fluid" alt="Tanda Tangan" style="height: 70px !important; width: 140px !important; object-fit: contain; display: block; margin: 0 auto; mix-blend-mode: multiply; transform: scale(1.2); transform-origin: center;">
                                    </div>
                                    <strong class="d-block text-dark" id="modalPembina" style="font-family: 'Georgia', serif; font-size: 0.8rem;"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top px-4 py-3 justify-content-between">
                <div>
                    <a id="modalEditBtn" href="" class="btn btn-warning rounded-3 text-dark btn-sm fw-semibold me-1">
                        <i class="fa-solid fa-pen-to-square me-1"></i>Edit Data
                    </a>
                    <a id="modalDownloadBtn" href="" class="btn btn-success rounded-3 btn-sm fw-semibold">
                        <i class="fa-solid fa-file-pdf me-1"></i>Unduh PDF
                    </a>
                </div>
                <button type="button" class="btn btn-secondary rounded-3 btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Konfirmasi Hapus Data
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Hapus Sertifikat?',
                    text: `Anda akan menghapus sertifikat atas nama ${name}. Tindakan ini tidak dapat dibatalkan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#E74C3C',
                    cancelButtonColor: '#64748B',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });

        // Pratinjau Modal Sertifikat
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const previewButtons = document.querySelectorAll('.btn-preview');

        previewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const code = this.getAttribute('data-code');

                Swal.fire({
                    title: 'Memuat Data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch("{{ route('admin.certificates.preview.search') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(res => {
                    if (!res.ok) throw res;
                    return res.json();
                })
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        const cert = data.data;

                        // Populate modal preview fields
                        document.getElementById('modalName').innerText = cert.nama_siswa.toUpperCase();
                        document.getElementById('modalNisAndKelas').innerHTML = "NIS. " + cert.nis + " &nbsp;|&nbsp; KELAS: " + cert.kelas.toUpperCase();
                        document.getElementById('modalSchool').innerText = cert.sekolah.toUpperCase();
                        document.getElementById('modalJenis').innerText = cert.jenis_sertifikat.toUpperCase();
                        
                        // Description text formatting
                        const prestasiText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Anggota/Peserta Aktif';
                        document.getElementById('modalDescription').innerHTML = `Telah menyelesaikan dan berpartisipasi aktif dalam kegiatan ekstrakurikuler <strong style="color: #0f172a;">${cert.ekskul}</strong> dengan pencapaian prestasi luar biasa sebagai "<strong style="color: #D4AF37;">${prestasiText}</strong>" pada tahun pelajaran {{ date('Y') }}.`;

                        document.getElementById('modalTanggal').innerText = cert.tanggal;
                        document.getElementById('modalPembina').innerText = cert.nama_pembina;
                        document.getElementById('modalJabatan').innerText = cert.jabatan_pembina;
                        document.getElementById('modalCode').innerText = cert.code;
                        document.getElementById('modalNomor').innerText = cert.nomor_sertifikat;

                        // Populate modal details table fields
                        document.getElementById('tblCode').innerText = cert.code;
                        document.getElementById('modalDetailCodeHeader').innerText = cert.code;
                        document.getElementById('tblNomor').innerText = cert.nomor_sertifikat;
                        document.getElementById('tblName').innerText = cert.nama_siswa.toUpperCase();
                        document.getElementById('tblNis').innerText = cert.nis;
                        document.getElementById('tblSchool').innerText = cert.sekolah;
                        document.getElementById('tblKelas').innerText = cert.kelas;
                        document.getElementById('tblEkskul').innerText = cert.ekskul;
                        document.getElementById('tblJenis').innerText = cert.jenis_sertifikat;
                        document.getElementById('tblPrestasi').innerText = prestasiText;
                        document.getElementById('tblTanggal').innerText = cert.tanggal;
                        document.getElementById('tblPembina').innerText = cert.nama_pembina + ' (' + cert.jabatan_pembina + ')';

                        // Status Badge
                        const statusBadge = document.getElementById('modalStatus');
                        if (cert.status === 'Aktif') {
                            statusBadge.className = "badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold mb-2";
                            statusBadge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i>Sertifikat Aktif';
                        } else {
                            statusBadge.className = "badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-semibold mb-2";
                            statusBadge.innerHTML = '<i class="fa-solid fa-circle-minus me-1"></i>Sertifikat Draft';
                        }

                        // Logo
                        if (cert.logo_base64) {
                            document.getElementById('modalLogo').src = cert.logo_base64;
                            document.getElementById('modalLogo').style.display = 'inline-block';
                        } else {
                            document.getElementById('modalLogo').src = "https://via.placeholder.com/100?text=Logo";
                        }

                        // Signature
                        if (cert.signature_base64) {
                            document.getElementById('modalSignature').src = cert.signature_base64;
                            document.getElementById('modalSignature').style.display = 'block';
                        } else {
                            document.getElementById('modalSignature').style.display = 'none';
                        }

                        // QR Code
                        document.getElementById('modalQrCode').src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(cert.verify_url)}`;

                        // Action links
                        document.getElementById('modalDownloadBtn').href = cert.pdf_url;
                        document.getElementById('modalEditBtn').href = cert.edit_url;

                        // Reset to first tab (detail-tab) before showing
                        const firstTab = document.querySelector('#modalTab button[id="detail-tab"]');
                        const tabTrigger = new bootstrap.Tab(firstTab);
                        tabTrigger.show();

                        // Show modal
                        previewModal.show();
                    }
                })
                .catch(err => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat data sertifikat.',
                        confirmButtonColor: '#E74C3C'
                    });
                });
            });
        });
    });
</script>
@endsection
