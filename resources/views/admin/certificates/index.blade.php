@extends('layouts.admin')

@php
    $defaultTemplate = $templates->where('is_default', true)->first() ?: $templates->first();
    $defaultBgUrl = $defaultTemplate && $defaultTemplate->background_path ? asset('storage/' . $defaultTemplate->background_path) : '';
@endphp

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
            <a href="{{ route('admin.certificates.export.pdf') }}" class="btn btn-outline-danger rounded-3 px-3">
                <i class="fa-solid fa-file-pdf me-2"></i>Ekspor PDF List
            </a>
            <button type="button" class="btn btn-danger rounded-3 px-3" data-bs-toggle="collapse" data-bs-target="#createFormCollapse" aria-expanded="false" aria-controls="createFormCollapse">
                <i class="fa-solid fa-circle-plus me-2"></i>Tambah Baru
            </button>
        </div>
    </div>

    <!-- Collapse Create Form Inline -->
    <div class="collapse {{ $errors->any() ? 'show' : '' }} mb-4" id="createFormCollapse">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: var(--card-bg); border: 1px solid var(--border-color) !important;">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-circle-plus text-danger me-2"></i>Tambah Sertifikat Baru
                </h6>
                <button type="button" class="btn-close" data-bs-toggle="collapse" data-bs-target="#createFormCollapse" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" id="createCertForm">
                @csrf
                <!-- Hidden validation requirements -->
                <input type="hidden" name="nis" value="-">
                <input type="hidden" name="ekskul" value="-">
                <input type="hidden" name="nama_pembina" value="-">
                <input type="hidden" name="jabatan_pembina" value="-">

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-3 py-2 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-2">
                    <!-- Baris 1 -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-secondary mb-1">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_siswa" id="nama_siswa" class="form-control form-control-sm" value="{{ old('nama_siswa') }}" required placeholder="Nama penerima...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-secondary mb-1">Nomor Sertifikat <span class="badge bg-danger" style="font-size:0.55rem;">Unik</span></label>
                        <input type="text" name="nomor_sertifikat" id="nomor_sertifikat" class="form-control form-control-sm" value="{{ old('nomor_sertifikat') }}" required placeholder="124/SMK1/2026">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-medium text-secondary mb-1">Tanggal Terbit</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-medium text-secondary mb-1">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm" required>
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>

                    <!-- Baris 2 -->
                    <div class="col-md-4">
                        <label class="form-label small fw-medium text-secondary mb-1">Jenis Sertifikat</label>
                        <input type="text" name="jenis_sertifikat" id="jenis_sertifikat" class="form-control form-control-sm" value="{{ old('jenis_sertifikat', 'Sertifikat Keikutsertaan') }}" required placeholder="Keikutsertaan, Kejuaraan...">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small fw-medium text-secondary mb-1">Deskripsi / Teks Sertifikat</label>
                        <textarea name="prestasi" id="prestasi" class="form-control form-control-sm" rows="1" required placeholder="Deskripsi sertifikat...">{{ old('prestasi', 'Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat "Anggota/Peserta Aktif"') }}</textarea>
                    </div>

                    <!-- Tombol -->
                    <div class="col-12 d-flex justify-content-end gap-2 pt-1 border-top mt-1">
                        <button type="button" class="btn btn-secondary rounded-3 btn-sm px-3" data-bs-toggle="collapse" data-bs-target="#createFormCollapse">Batal</button>
                        <button type="button" class="btn btn-outline-danger rounded-3 btn-sm px-3" id="btnLivePreview">
                            <i class="fa-solid fa-eye me-1"></i>Pratinjau
                        </button>
                        <button type="submit" class="btn btn-danger rounded-3 btn-sm px-4">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Sertifikat
                        </button>
                    </div>
                </div>
            </form>
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
@endsection

@push('modals')
<!-- CSS Styling for Certificate Preview Frame inside Modal -->
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

<!-- Live Preview Modal (for inline create form) -->
<div class="modal fade" id="livePreviewModal" tabindex="-1" aria-labelledby="livePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom px-4">
                <h5 class="modal-title fw-bold text-dark" id="livePreviewModalLabel">
                    <i class="fa-solid fa-certificate text-danger me-2"></i>Pratinjau Live Sertifikat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="preview-certificate-container p-3 p-md-4 mb-0 position-relative overflow-hidden" id="livePreviewArea" style="aspect-ratio: 297/210; min-height: 380px;">
                    <!-- Template Background Image -->
                    <img id="lpBg" src="{{ $defaultBgUrl ?? '' }}" class="position-absolute top-0 start-0 w-100 h-100 {{ isset($defaultBgUrl) && $defaultBgUrl ? '' : 'd-none' }}" style="object-fit: cover; z-index: 1;" alt="">

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
                    <!-- Corner Patterns -->
                    <div class="custom-mockup-item" style="position: absolute; top: 9px; left: 9px; z-index: 3; pointer-events: none;"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg></div>
                    <div class="custom-mockup-item" style="position: absolute; top: 9px; right: 9px; z-index: 3; transform: rotate(90deg); pointer-events: none;"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg></div>
                    <div class="custom-mockup-item" style="position: absolute; bottom: 9px; right: 9px; z-index: 3; transform: rotate(180deg); pointer-events: none;"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg></div>
                    <div class="custom-mockup-item" style="position: absolute; bottom: 9px; left: 9px; z-index: 3; transform: rotate(270deg); pointer-events: none;"><svg width="20" height="20" viewBox="0 0 24 24"><path d="M 0,24 L 0,0 L 24,0 M 4,24 L 4,4 L 24,4 M 8,8 L 16,8 L 16,16 L 8,16" fill="none" stroke="#C89B3C" stroke-width="1.5" /></svg></div>

                    <!-- Content -->
                    <div class="position-relative h-100 d-flex flex-column" style="z-index: 5; gap: 0; text-align: left;">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center pb-2" style="width: 100%;">
                            <div style="width:48px;"><img id="lpLogo" src="" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo"></div>
                            <div class="text-center flex-grow-1">
                                <p class="mb-0 text-uppercase fw-bold" style="font-size: 0.58rem; letter-spacing: 1px; color: #14213D; font-family:'Poppins',sans-serif;">Lembaga Pendidikan Sertifikasi Ekstrakurikuler</p>
                                <p class="mb-0" style="font-size: 0.48rem; color: #556270; margin-top: 1px; font-family:'Poppins',sans-serif;">Sertifikat Resmi Kegiatan Peserta Didik</p>
                            </div>
                            <div style="width: 44px; text-align: right;"><div class="custom-mockup-item" style="width: 32px; height: 32px; display: inline-block;"><svg viewBox="0 0 100 100" width="100%" height="100%"><circle cx="50" cy="50" r="45" fill="#C89B3C" /><circle cx="50" cy="50" r="39" fill="#FCFAF5" /><circle cx="50" cy="50" r="34" fill="#C89B3C" /><polygon points="50,22 55,39 73,41 59,53 63,70 50,60 37,70 41,53 27,41 45,39" fill="#14213D" /></svg></div></div>
                        </div>
                        <!-- Gold divider -->
                        <div class="text-center w-100 custom-mockup-item" style="margin: 2px 0;"><svg width="60" height="6" viewBox="0 0 80 8" style="display:inline-block;"><line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.75" /><polygon points="40,1 43,4 40,7 37,4" fill="#C89B3C" /><polygon points="48,2 50,4 48,6 46,4" fill="#C89B3C" /><polygon points="32,2 34,4 32,6 30,4" fill="#C89B3C" /><line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.75" /></svg></div>
                        <!-- Title -->
                        <div class="text-center w-100" style="margin-bottom: 2px;">
                            <div class="text-center w-100 custom-mockup-item" style="margin-bottom: 1.5px;"><svg width="30" height="6" viewBox="0 0 80 8" style="display:inline-block;"><line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.5" /><polygon points="40,2 43,4 40,6 37,4" fill="#C89B3C" /><line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.5" /></svg></div>
                            <h4 class="fw-bold mb-0 text-uppercase" style="font-family: 'Cormorant Garamond','Georgia',serif; color: #14213D; font-size: 1.85rem; letter-spacing: 6px; line-height: 1;">Sertifikat</h4>
                            <div class="custom-mockup-item" style="border-top: 0.75px solid #C89B3C; border-bottom: 0.75px solid #C89B3C; padding: 2px 0; margin: 4px auto; width: 45%; text-align: center;">
                                <p id="lpJenis" class="text-uppercase fw-bold mb-0" style="font-family:'Poppins',sans-serif; color: #C89B3C; letter-spacing: 3px; font-size: 0.55rem;">SERTIFIKAT KEIKUTSERTAAN</p>
                            </div>
                            <div class="text-center w-100 custom-mockup-item" style="margin-top: 1.5px;"><svg width="30" height="6" viewBox="0 0 80 8" style="display:inline-block;"><line x1="0" y1="4" x2="32" y2="4" stroke="#C89B3C" stroke-width="0.5" /><polygon points="40,2 43,4 40,6 37,4" fill="#C89B3C" /><line x1="48" y1="4" x2="80" y2="4" stroke="#C89B3C" stroke-width="0.5" /></svg></div>
                        </div>
                        <!-- Recipient -->
                        <div class="text-center w-100" style="position: relative; margin-top: 2px;">
                            <div class="d-flex align-items-center justify-content-center" style="margin-top: 4px;">
                                <span style="font-family:'Cormorant Garamond',serif; font-style: italic; font-size: 0.75rem; color: #556270;">Dengan bangga diberikan kepada:</span>
                            </div>
                            <h5 class="mb-0" id="lpName" style="font-family:'Great Vibes',cursive; font-size: 3rem; font-weight: 400; letter-spacing: 1.5px; margin-top: 2px; line-height: 1.1; color: #14213D;">Nama Lengkap Siswa</h5>
                            <div class="text-center custom-mockup-item" style="margin-top: 1px;"><svg width="30" height="6" viewBox="0 0 40 8" style="display:inline-block;"><line x1="0" y1="4" x2="16" y2="4" stroke="#C89B3C" stroke-width="0.75" /><polygon points="20,1 24,4 20,7 16,4" fill="#C89B3C" /><line x1="24" y1="4" x2="40" y2="4" stroke="#C89B3C" stroke-width="0.75" /></svg></div>
                        </div>
                        <!-- Description -->
                        <div class="text-center px-4 w-100" style="margin: 2px 0 4px;">
                            <p class="mb-0 text-muted" id="lpDesc" style="line-height: 1.5; font-size: 0.72rem; font-family:'Poppins',sans-serif;"></p>
                        </div>
                        <!-- Laurel crest -->
                        <div class="text-center w-100 custom-mockup-item" style="margin-top: 2px; margin-bottom: 2px;"><svg width="180" height="30" viewBox="0 0 240 40" style="display:inline-block; vertical-align:middle;"><path d="M 90,20 Q 50,15 20,25" fill="none" stroke="#C89B3C" stroke-width="1.5" /><path d="M 80,19 C 75,15 70,15 65,17 C 70,20 75,20 80,19 Z" fill="#C89B3C" /><path d="M 65,17 C 60,13 55,13 50,15 C 55,18 60,18 65,17 Z" fill="#C89B3C" /><path d="M 50,15 C 45,11 40,11 35,13 C 40,16 45,16 50,15 Z" fill="#C89B3C" /><path d="M 150,20 Q 190,15 220,25" fill="none" stroke="#C89B3C" stroke-width="1.5" /><path d="M 160,19 C 165,15 170,15 175,17 C 170,20 165,20 160,19 Z" fill="#C89B3C" /><path d="M 175,17 C 180,13 185,13 190,15 C 185,18 180,18 175,17 Z" fill="#C89B3C" /><path d="M 190,15 C 195,11 200,11 205,13 C 200,16 195,16 190,15 Z" fill="#C89B3C" /><circle cx="120" cy="20" r="14" fill="#FCFAF5" stroke="#C89B3C" stroke-width="1.5" /><circle cx="120" cy="20" r="11" fill="none" stroke="#C89B3C" stroke-width="0.5" /><path d="M 119,16 Q 116,18 113,16 L 113,22 Q 116,24 119,22 Z" fill="none" stroke="#14213D" stroke-width="1.2" /><path d="M 121,16 Q 124,18 127,16 L 127,22 Q 124,24 121,22 Z" fill="none" stroke="#14213D" stroke-width="1.2" /><line x1="120" y1="16" x2="120" y2="22" stroke="#14213D" stroke-width="1.2" /></svg></div>
                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center w-100" style="padding-top: 4px; margin-top: auto; border-top: 1px solid rgba(232,213,163,0.4);">
                            <div class="text-start" style="width: 25%;"><div class="border bg-white p-1 d-inline-block" style="border-color: #C89B3C !important; border-radius:4px;"><div id="lpQr" style="width:44px; height:44px;"></div></div><div class="text-muted" style="font-size:0.42rem; margin-top:1px; font-family:'Poppins',sans-serif;">Scan untuk Verifikasi</div></div>
                            <div class="text-center" style="width: 50%;"><svg class="custom-mockup-item" width="100" height="20" viewBox="0 0 120 24" style="display:inline-block;"><path d="M 10,12 C 30,2 40,22 60,12 C 80,2 90,22 110,12" fill="none" stroke="#C89B3C" stroke-width="1" /><circle cx="60" cy="12" r="4" fill="#C89B3C" /></svg></div>
                            <div class="text-end" style="font-family:'Poppins',sans-serif; line-height: 1.1; width: 25%;">
                                <div style="font-size:0.5rem; color:#556270; text-transform:uppercase; letter-spacing:0.5px;">Nomor Sertifikat</div>
                                <div class="fw-bold" style="font-size:0.68rem; color: #14213D;" id="lpNomor">-</div>
                                <div class="custom-mockup-item" style="width: 80px; height: 1px; background-color: #C89B3C; margin: 3px 0 3px auto;"></div>
                                <div style="font-size:0.5rem; color:#556270; text-transform:uppercase; letter-spacing:0.5px;">Diterbitkan pada</div>
                                <div class="fw-bold" style="font-size:0.68rem; color: #14213D;" id="lpTanggal">-</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top px-4 py-2">
                <button type="button" class="btn btn-secondary rounded-3 btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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
                        <div class="preview-certificate-container p-3 p-md-4 mb-0 position-relative overflow-hidden" id="modalCertFrame" style="aspect-ratio: 297/210; min-height: 380px;">
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
                                        <img id="modalLogo" src="" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo">
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
                                        <p id="modalJenis" class="text-uppercase fw-bold mb-0" style="font-family: 'Poppins', sans-serif; color: #C89B3C; letter-spacing: 3px; font-size: 0.55rem;">SERTIFIKAT KEIKUTSERTAAN</p>
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

                                    <h5 class="mb-0" id="modalName" style="font-family: 'Great Vibes', cursive; font-size: 3rem; font-weight: 400; letter-spacing: 1.5px; margin-top: 2px; line-height: 1.1; color: #14213D !important; position: relative; z-index: 2;">Nama Lengkap Siswa</h5>
                                    
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
                                    <p class="mb-0 text-muted" id="modalDescription" style="line-height: 1.5; font-size: 0.72rem; font-family: 'Poppins', sans-serif;">
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
                                            <img id="modalQrCode" src="" style="width:44px; height:44px; display:block;" alt="QR Code">
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
                                        <div class="fw-bold" style="font-size:0.68rem; color: #14213D;" id="modalNomor">-</div>
                                        
                                        <!-- Meta divider line -->
                                        <div class="custom-mockup-item" style="width: 80px; height: 1px; background-color: #C89B3C; margin: 3px 0 3px auto;"></div>

                                        <div style="font-size:0.5rem; color:#556270; text-transform:uppercase; letter-spacing:0.5px;">Diterbitkan pada</div>
                                        <div class="fw-bold" style="font-size:0.68rem; color: #14213D;" id="modalTanggal">-</div>
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


@endpush

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
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

                fetch("{{ route('admin.certificates.preview.search', [], false) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Bypass-Tunnel-Reminder": "true"
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
                        const namaSiswa = toTitleCase(cert.nama_siswa);
                        document.getElementById('modalName').innerText = namaSiswa;
                        
                        const prestasiText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Anggota/Peserta Aktif';
                        document.getElementById('modalJenis').innerText = cert.jenis_sertifikat.toUpperCase();
                        
                        // Format description with highlighted double quotes and newlines
                        let prestasiHtml = cert.prestasi ? cert.prestasi.replace(/\n/g, '<br>') : '';
                        prestasiHtml = prestasiHtml.replace(/"(.*?)"/g, '<span style="color:#C89B3C; font-weight:bold;">"$1"</span>');
                        prestasiHtml = prestasiHtml.replace(/&quot;(.*?)&quot;/g, '<span style="color:#C89B3C; font-weight:bold;">"$1"</span>');
                        document.getElementById('modalDescription').innerHTML = prestasiHtml;

                        document.getElementById('modalTanggal').innerText = cert.tanggal;
                        document.getElementById('modalNomor').innerText = cert.nomor_sertifikat;

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
                        document.getElementById('modalName').style.fontSize = fs;

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

        // Auto-expand create certificate form inline if validation errors exist
        @if ($errors->any())
            const createFormCollapseEl = document.getElementById('createFormCollapse');
            if (createFormCollapseEl) {
                const bsCollapse = new bootstrap.Collapse(createFormCollapseEl, { show: true });
                bsCollapse.show();
            }
        @endif

        // ─── Live Preview untuk Form Tambah Baru ───────────────────────────
        const btnLivePreview = document.getElementById('btnLivePreview');
        if (btnLivePreview) {
            const liveModal = new bootstrap.Modal(document.getElementById('livePreviewModal'));

            // Helper: title case
            function lpTitleCase(str) {
                return str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
            }

            // Helper: format tanggal ke Bahasa Indonesia
            function lpFormatDate(val) {
                if (!val) return '-';
                const d = new Date(val);
                if (isNaN(d.getTime())) return '-';
                const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
            }

            // QR instance
            let lpQrInstance = null;

            btnLivePreview.addEventListener('click', function () {
                // Ambil nilai dari form
                const nama   = document.getElementById('nama_siswa')?.value?.trim() || 'Nama Lengkap Siswa';
                const nomor  = document.getElementById('nomor_sertifikat')?.value?.trim() || '-';
                const tanggal = document.getElementById('tanggal')?.value || '';
                const jenis  = document.getElementById('jenis_sertifikat')?.value?.trim() || 'Sertifikat Keikutsertaan';
                const prestasi = document.getElementById('prestasi')?.value?.trim() || '';

                // Isi konten preview
                const lpName = document.getElementById('lpName');
                const lpJenis = document.getElementById('lpJenis');
                const lpDesc = document.getElementById('lpDesc');
                const lpNomor = document.getElementById('lpNomor');
                const lpTanggal = document.getElementById('lpTanggal');

                if (lpName) {
                    const namaDisplay = lpTitleCase(nama);
                    lpName.innerText = namaDisplay;

                    // Dynamic font sizing
                    const nameLen = namaDisplay.length;
                    const descLen = prestasi.length;
                    let fs = '3rem';
                    if (descLen > 180) {
                        fs = nameLen > 35 ? '1.6rem' : nameLen > 25 ? '1.9rem' : '2.2rem';
                    } else if (descLen > 120) {
                        fs = nameLen > 35 ? '1.8rem' : nameLen > 25 ? '2.1rem' : '2.4rem';
                    } else {
                        if (nameLen > 40) fs = '1.8rem';
                        else if (nameLen > 30) fs = '2.1rem';
                        else if (nameLen > 20) fs = '2.5rem';
                    }
                    lpName.style.fontSize = fs;
                }

                if (lpJenis) lpJenis.innerText = jenis.toUpperCase();

                if (lpDesc) {
                    let html = prestasi.replace(/\n/g, '<br>');
                    html = html.replace(/"(.*?)"/g, '<span style="color:#C89B3C;font-weight:bold;">"$1"</span>');
                    html = html.replace(/&quot;(.*?)&quot;/g, '<span style="color:#C89B3C;font-weight:bold;">"$1"</span>');
                    lpDesc.innerHTML = html;
                }

                if (lpNomor) lpNomor.innerText = nomor;
                if (lpTanggal) lpTanggal.innerText = lpFormatDate(tanggal);

                // Load default logo
                const defaultLogo = "{{ isset($default_logo) && $default_logo ? $default_logo : '' }}";
                const lpLogo = document.getElementById('lpLogo');
                if (lpLogo) {
                    lpLogo.src = defaultLogo || 'https://via.placeholder.com/100?text=Logo';
                }

                // QR Code
                const lpQrContainer = document.getElementById('lpQr');
                if (lpQrContainer) {
                    lpQrContainer.innerHTML = '';
                    const qrText = `{{ url('/verify') }}?nomor=${encodeURIComponent(nomor)}`;
                    lpQrInstance = new QRCode(lpQrContainer, {
                        text: qrText,
                        width: 44,
                        height: 44,
                        colorDark: '#0F172A',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.M
                    });
                }

                liveModal.show();
            });
        }
    });
</script>
@endsection
