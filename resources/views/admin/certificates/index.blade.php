@extends('layouts.admin')

@section('title', 'Data Sertifikat')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Tom Select dark/light integration overrides */
    .ts-wrapper.form-select {
        padding: 0 !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        height: auto !important;
    }
    .ts-wrapper .ts-control {
        border: none !important;
        background: transparent !important;
        color: var(--text-color) !important;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem !important;
        border-radius: 8px !important;
    }
    .ts-wrapper.single .ts-control::after {
        border-color: var(--text-muted) transparent transparent transparent !important;
    }
    .ts-dropdown {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important;
    }
    .ts-dropdown .active {
        background-color: var(--primary-color) !important;
        color: #FFFFFF !important;
    }
    .ts-dropdown .option:hover {
        background-color: rgba(231, 76, 60, 0.1) !important;
        color: var(--primary-color) !important;
    }
</style>
@endsection

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
    <form action="{{ route('admin.certificates.index') }}" method="GET" class="row g-3 mb-4 bg-light p-3 rounded-4" id="filterForm">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Kode, Nama Siswa, NIS, atau No. Sertifikat..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <select name="ekskul" id="ekskulSelect" class="form-select">
                <option value="">-- Semua Ekskul --</option>
                @foreach($ekskul_list as $ekskul)
                    <option value="{{ $ekskul }}" {{ request('ekskul') == $ekskul ? 'selected' : '' }}>{{ $ekskul }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" id="statusSelect" class="form-select">
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
                        <div class="preview-certificate-container p-3 p-md-4 mb-0 position-relative overflow-hidden" id="modalCertFrame" style="aspect-ratio: 297/210; min-height: 380px;">
                            <!-- Elegant Double Border Frame -->
                            <div class="preview-border-outer" id="previewBorderOuter"></div>
                            <div class="preview-border-inner" id="previewBorderInner"></div>
 
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
                                        <img id="modalLogo" src="" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo">
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
                                    <p id="modalJenis" class="text-uppercase fw-bold mb-0" style="font-family: 'Poppins', sans-serif; color: #D4AF37; letter-spacing: 4px; font-size: 0.6rem; margin-top: 2px;">SERTIFIKAT KEIKUTSERTAAN</p>

                                    <!-- Thin gold rule -->
                                    <div style="display:flex; align-items:center; margin: 6px auto; width: 70%;">
                                        <div style="flex:1; height:1px; background: linear-gradient(to right, transparent, #D4AF37);"></div>
                                        <span style="color:#D4AF37; font-size:0.6rem; margin: 0 6px;">◆</span>
                                        <div style="flex:1; height:1px; background: linear-gradient(to left, transparent, #D4AF37);"></div>
                                    </div>

                                    <div style="font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 0.8rem; color: #64748B;">Dengan bangga diberikan kepada:</div>
                                    <h5 class="mb-0" id="modalName" style="font-family: 'Great Vibes', cursive; font-size: 3rem; font-weight: 400; letter-spacing: 1.5px; margin-top: 4px; line-height: 1.1; color: #1a1a2e !important;">Nama Lengkap Siswa</h5>
                                    <div style="width: 60%; height: 1.5px; background: linear-gradient(to right, transparent, #D4AF37, transparent); margin: 6px auto 3px;"></div>
                                    <div class="fw-semibold" id="modalNis" style="font-size: 0.68rem; letter-spacing: 0.8px; font-family: 'Poppins', sans-serif; color: #475569;">NIS. -</div>
                                </div>

                                <!-- Info Badges row -->
                                <div class="d-flex justify-content-center gap-2 w-100" style="margin: 4px 0;">
                                    <div style="background: rgba(212,175,55,0.10); border: 1px solid #D4AF37; border-radius: 20px; padding: 2px 10px; font-size: 0.58rem; color: #92600a; font-weight: 600; letter-spacing: 0.5px; font-family: 'Poppins', sans-serif;">
                                        🎓 Ekskul: <span id="modalEkskul2" style="color:#0F172A;">-</span>
                                    </div>
                                    <div style="background: rgba(15,23,42,0.06); border: 1px solid #CBD5E1; border-radius: 20px; padding: 2px 10px; font-size: 0.58rem; color: #475569; font-weight: 600; letter-spacing: 0.5px; font-family: 'Poppins', sans-serif;">
                                        📅 Periode: <span id="modalPeriode" style="color:#0F172A;">-</span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="text-center px-4 w-100" style="margin: 2px 0 6px;">
                                    <p class="mb-0" id="modalDescription" style="line-height: 1.65; font-size: 0.78rem; color: #334155; font-family: 'Poppins', sans-serif;">
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
                                            <img id="modalQrCode" src="" style="width:50px; height:50px; display:block;" alt="QR Code">
                                        </div>
                                        <div class="text-muted" style="font-size:0.42rem; margin-top:2px; font-family:'Poppins',sans-serif;">Pindai untuk verifikasi</div>
                                    </div>

                                    <!-- Nomor & Tanggal center -->
                                    <div class="text-center" style="font-family:'Poppins',sans-serif;">
                                        <div style="font-size:0.55rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px;">Nomor Sertifikat</div>
                                        <div class="fw-bold" style="font-size:0.72rem; color:#0F172A;" id="modalNomor">-</div>
                                        <div style="font-size:0.5rem; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px; margin-top:4px;">Diterbitkan pada</div>
                                        <div class="fw-bold" style="font-size:0.7rem; color:#0F172A;" id="modalTanggal">-</div>
                                    </div>

                                    <!-- Tanda Tangan Resmi -->
                                    <div class="text-center" style="width:120px; font-family:'Poppins',sans-serif;">
                                        <div style="font-size:0.5rem; color:#64748B; text-transform:uppercase; font-weight:600; letter-spacing:0.5px; margin-bottom:2px;" id="modalJabatan">Pembina OSIS</div>
                                        <div style="height: 38px; position: relative;">
                                            <img id="modalSignature" src="" class="img-fluid" style="max-height:36px; width:auto; mix-blend-mode:multiply; display:block; margin:0 auto;" alt="">
                                        </div>
                                        <div style="border-top: 1.5px solid #0F172A; margin: 0 6px 3px 6px;"></div>
                                        <strong class="d-block" id="modalPembina" style="font-family:'Georgia',serif; font-size:0.62rem; color:#0F172A; line-height:1.3;">Nama Pembina</strong>
                                        <div style="font-size:0.42rem; color:#94A3B8; margin-top:1px;">NIP / NIK</div>
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
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Tom Select search dropdowns
        const tsEkskul = new TomSelect('#ekskulSelect', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });

        const tsStatus = new TomSelect('#statusSelect', {
            create: false
        });

        // Auto filter on change
        tsEkskul.on('change', function() {
            document.getElementById('filterForm').submit();
        });

        tsStatus.on('change', function() {
            document.getElementById('filterForm').submit();
        });

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

                        // Titlecase helper
                        function toTitleCase(str) {
                            return str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
                        }

                        // Populate modal preview fields
                        document.getElementById('modalName').innerText = toTitleCase(cert.nama_siswa);
                        document.getElementById('modalNis').innerText = "NIS. " + cert.nis;
                        document.getElementById('modalEkskul2').innerText = cert.ekskul;
                        
                        const prestasiText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Anggota/Peserta Aktif';
                        document.getElementById('modalJenis').innerText = cert.jenis_sertifikat.toUpperCase();
                        
                        const dateParts = cert.tanggal.split(' ');
                        const yrVal = dateParts[dateParts.length - 1];
                        const yrNum = parseInt(yrVal);
                        if (!isNaN(yrNum)) {
                            document.getElementById('modalPeriode').innerText = `${yrNum}/${yrNum+1}`;
                        } else {
                            const currentYr = new Date().getFullYear();
                            document.getElementById('modalPeriode').innerText = `${currentYr}/${currentYr+1}`;
                        }
                        
                        // Description text formatting
                        document.getElementById('modalDescription').innerHTML = `Dinyatakan telah mengikuti dan aktif berprestasi dalam kegiatan Ekstrakurikuler <strong style="color: #0F172A;">${cert.ekskul}</strong> dengan predikat <span style="background: rgba(212,175,55,0.15); padding: 1px 6px; border-radius: 4px;"><strong style="color: #b5860d;">"${prestasiText}"</strong></span> pada tahun pelajaran <strong style="color:#0F172A;">{{ date('Y') }}/{{ date('Y')+1 }}</strong>.`;

                        document.getElementById('modalTanggal').innerText = cert.tanggal;
                        document.getElementById('modalPembina').innerText = cert.nama_pembina;
                        document.getElementById('modalJabatan').innerText = cert.jabatan_pembina.toUpperCase();
                        document.getElementById('modalNomor').innerText = cert.nomor_sertifikat;

                        // Populate modal details table fields
                        document.getElementById('tblCode').innerText = cert.code;
                        document.getElementById('modalDetailCodeHeader').innerText = cert.code;
                        document.getElementById('tblNomor').innerText = cert.nomor_sertifikat;
                        document.getElementById('tblName').innerText = cert.nama_siswa.toUpperCase();
                        document.getElementById('tblNis').innerText = cert.nis;
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
