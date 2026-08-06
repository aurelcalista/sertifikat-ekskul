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
    <form action="{{ route('admin.certificates.index') }}" method="GET" class="row g-3 mb-4" id="filterForm">
        <div class="col-md-7">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari Kode, Nama Siswa, NIS, atau Nomor Sertifikat..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="col-md-3">
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
                    <th>Kode & No. Sertifikat</th>
                    <th>Nama Siswa</th>
                    <th>Deskripsi / Teks Sertifikat</th>
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
                        <td class="text-secondary fw-medium" style="max-width: 300px; white-space: normal;">{{ Str::limit($cert->prestasi, 90) }}</td>
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
                        <td colspan="6" class="text-center py-5 text-muted">
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
                <div class="preview-certificate-container bg-white position-relative overflow-hidden rounded-4 border shadow-sm p-4 text-center" style="aspect-ratio: 297 / 210; max-width: 720px; width: 100%; margin: 0 auto; display: flex; flex-direction: column; justify-content: space-between;">
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
        <div class="text-center pt-1" style="margin-bottom: 10px;"><img src="{{ asset('logos/logo-rakitai.png') }}" style="max-height: 42px; width: auto; display: inline-block;" alt="Logo Rakit AI"></div>
        <div class="text-center my-1">
            <h2 style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 2.05rem; font-weight: 700; color: #1F2A44; letter-spacing: 6px; margin: 0 0 4px 0; text-transform: uppercase;">SERTIFIKAT</h2>
            <p id="lpJenis" style="font-family: 'Poppins', sans-serif; font-size: 0.72rem; font-weight: 600; color: #F15A3D; letter-spacing: 3px; margin: 3px 0 8px 0; text-transform: uppercase;">SERTIFIKAT KEIKUTSERTAAN</p>
            <div>
                <span id="lpNomorPill" style="border: 1.5px solid #1F2A44; border-radius: 14px; padding: 2px 14px; font-family: 'Poppins', sans-serif; font-size: 0.62rem; font-weight: 600; color: #1F2A44; display: inline-block;">Certificat No: -</span>
            </div>
        </div>
        <div class="text-center my-1">
            <p style="font-family: 'Poppins', sans-serif; font-size: 0.72rem; color: #475569; margin-bottom: 4px; letter-spacing: 0.5px;">Diberikan kepada:</p>
            <h3 id="lpName" style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.75rem; font-weight: 700; color: #1F2A44; margin: 2px 0 0 0; text-transform: uppercase; letter-spacing: 1.5px; letter-spacing: 1px;">NAMA LENGKAP SISWA</h3>
        </div>
        <div class="text-center px-4 my-2" style="margin-top: 12px !important;">
            <p id="lpDesc" class="mb-0 text-secondary" style="font-family: 'Poppins', sans-serif; font-size: 0.78rem; line-height: 1.7; letter-spacing: 0.2px; margin-top: 8px; margin-bottom: 8px;">Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat "Anggota/Peserta Aktif"</p>
        </div>
        <div class="d-flex justify-content-between align-items-end w-100 pt-2" style="margin-top: auto;">
            <div style="width: 30%; text-align: left;"><div id="lpQr" style="width: 58px; height: 58px; border: 1.5px solid #CBD5E1; padding: 3px; border-radius: 8px; background: #FFFFFF; display: inline-block;"></div></div>
            <div style="width: 40%; text-align: center;"><svg viewBox="0 0 100 130" style="width: 68px; height: 88px; display: inline-block; filter: drop-shadow(0px 3px 5px rgba(0,0,0,0.25));">
    <defs>
        <radialGradient id="gRadP_live" cx="40%" cy="35%" r="60%">
            <stop offset="0%" stop-color="#FFF8DC" />
            <stop offset="30%" stop-color="#FFD700" />
            <stop offset="60%" stop-color="#DAA520" />
            <stop offset="100%" stop-color="#8B6508" />
        </radialGradient>
        <radialGradient id="gEdgP_live" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#FFD700" />
            <stop offset="100%" stop-color="#8B4513" />
        </radialGradient>
        <linearGradient id="rLP_live" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#1a3a7a" />
            <stop offset="50%" stop-color="#2563EB" />
            <stop offset="100%" stop-color="#1a3a7a" />
        </linearGradient>
        <linearGradient id="rRP_live" x1="100%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#1a3a7a" />
            <stop offset="50%" stop-color="#2563EB" />
            <stop offset="100%" stop-color="#1a3a7a" />
        </linearGradient>
    </defs>
    <polygon points="42,68 30,130 42,118 50,125" fill="url(#rLP_live)" />
    <polygon points="58,68 70,130 58,118 50,125" fill="url(#rRP_live)" />
    <circle cx="50" cy="50" r="40" fill="url(#gEdgP_live)" stroke="#8B6508" stroke-width="1" stroke-dasharray="7.5 4.5" />
    <circle cx="50" cy="50" r="37" fill="url(#gRadP_live)" />
    <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
    <circle cx="50" cy="50" r="31" fill="url(#gRadP_live)" />
    <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" stroke-dasharray="3 2" />
    <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.35" />
</svg></div>
            <div style="width: 30%; text-align: right; padding-right: 5px;">
                <div style="display: inline-block; text-align: right;">
                    <div style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 0.88rem; color: #475569; font-style: italic; margin-bottom: 3px;">Diterbitkan pada tanggal</div>
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                        <span id="lpTanggal" style="font-family: 'Poppins', sans-serif; font-size: 0.85rem; font-weight: 700; color: #0F172A;">-</span>
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                    </div>
                    <div style="height: 1.5px; background: linear-gradient(to right, transparent, #64748B, transparent); margin-top: 4px;"></div>
                </div>
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
                <div class="text-center mb-3">
                    <span id="modalStatus" class="badge px-3 py-2 rounded-pill fw-semibold mb-2"></span>
                </div>
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
                <div class="tab-content" id="modalTabContent">
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
                                        <td class="fw-bold text-secondary bg-light">Jenis Sertifikat</td>
                                        <td id="tblJenis"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Prestasi / Pencapaian</td>
                                        <td id="tblPrestasi"></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-secondary bg-light">Tanggal Terbit</td>
                                        <td id="tblTanggal"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="preview-pane" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">
                        <div class="preview-certificate-container bg-white position-relative overflow-hidden rounded-4 border shadow-sm p-4 text-center" style="aspect-ratio: 297 / 210; max-width: 720px; width: 100%; margin: 0 auto; display: flex; flex-direction: column; justify-content: space-between;">
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
        <div class="text-center pt-1" style="margin-bottom: 10px;"><img src="{{ asset('logos/logo-rakitai.png') }}" style="max-height: 42px; width: auto; display: inline-block;" alt="Logo Rakit AI"></div>
        <div class="text-center my-1">
            <h2 style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 2.05rem; font-weight: 700; color: #1F2A44; letter-spacing: 6px; margin: 0 0 4px 0; text-transform: uppercase;">SERTIFIKAT</h2>
            <p id="modalJenis" style="font-family: 'Poppins', sans-serif; font-size: 0.72rem; font-weight: 600; color: #F15A3D; letter-spacing: 3px; margin: 3px 0 8px 0; text-transform: uppercase;">SERTIFIKAT KEIKUTSERTAAN</p>
            <div>
                <span id="modalPillCode" style="border: 1.5px solid #1F2A44; border-radius: 14px; padding: 2px 14px; font-family: 'Poppins', sans-serif; font-size: 0.62rem; font-weight: 600; color: #1F2A44; display: inline-block;">Certificat No: -</span>
            </div>
        </div>
        <div class="text-center my-1">
            <p style="font-family: 'Poppins', sans-serif; font-size: 0.72rem; color: #475569; margin-bottom: 4px; letter-spacing: 0.5px;">Diberikan kepada:</p>
            <h3 id="modalName" style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.75rem; font-weight: 700; color: #1F2A44; margin: 2px 0 0 0; text-transform: uppercase; letter-spacing: 1.5px; letter-spacing: 1px;">NAMA LENGKAP SISWA</h3>
        </div>
        <div class="text-center px-4 my-2" style="margin-top: 12px !important;">
            <p id="modalDescription" class="mb-0 text-secondary" style="font-family: 'Poppins', sans-serif; font-size: 0.78rem; line-height: 1.7; letter-spacing: 0.2px; margin-top: 8px; margin-bottom: 8px;">Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat "Anggota/Peserta Aktif"</p>
        </div>
        <div class="d-flex justify-content-between align-items-end w-100 pt-2" style="margin-top: auto;">
            <div style="width: 30%; text-align: left;"><img id="modalQrCode" src="" style="width: 58px; height: 58px; border: 1.5px solid #CBD5E1; padding: 3px; border-radius: 8px; background: #FFFFFF; display: inline-block;" alt="QR Code"></div>
            <div style="width: 40%; text-align: center;"><svg viewBox="0 0 100 130" style="width: 68px; height: 88px; display: inline-block; filter: drop-shadow(0px 3px 5px rgba(0,0,0,0.25));">
    <defs>
        <radialGradient id="gRadP_prev" cx="40%" cy="35%" r="60%">
            <stop offset="0%" stop-color="#FFF8DC" />
            <stop offset="30%" stop-color="#FFD700" />
            <stop offset="60%" stop-color="#DAA520" />
            <stop offset="100%" stop-color="#8B6508" />
        </radialGradient>
        <radialGradient id="gEdgP_prev" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#FFD700" />
            <stop offset="100%" stop-color="#8B4513" />
        </radialGradient>
        <linearGradient id="rLP_prev" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#1a3a7a" />
            <stop offset="50%" stop-color="#2563EB" />
            <stop offset="100%" stop-color="#1a3a7a" />
        </linearGradient>
        <linearGradient id="rRP_prev" x1="100%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#1a3a7a" />
            <stop offset="50%" stop-color="#2563EB" />
            <stop offset="100%" stop-color="#1a3a7a" />
        </linearGradient>
    </defs>
    <polygon points="42,68 30,130 42,118 50,125" fill="url(#rLP_prev)" />
    <polygon points="58,68 70,130 58,118 50,125" fill="url(#rRP_prev)" />
    <circle cx="50" cy="50" r="40" fill="url(#gEdgP_prev)" stroke="#8B6508" stroke-width="1" stroke-dasharray="7.5 4.5" />
    <circle cx="50" cy="50" r="37" fill="url(#gRadP_prev)" />
    <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
    <circle cx="50" cy="50" r="31" fill="url(#gRadP_prev)" />
    <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" stroke-dasharray="3 2" />
    <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.35" />
</svg></div>
            <div style="width: 30%; text-align: right; padding-right: 5px;">
                <div style="display: inline-block; text-align: right;">
                    <div style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 0.88rem; color: #475569; font-style: italic; margin-bottom: 3px;">Diterbitkan pada tanggal</div>
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                        <span id="modalTanggal" style="font-family: 'Poppins', sans-serif; font-size: 0.85rem; font-weight: 700; color: #0F172A;">-</span>
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                    </div>
                    <div style="height: 1.5px; background: linear-gradient(to right, transparent, #64748B, transparent); margin-top: 4px;"></div>
                </div>
            </div>
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
        const elStatus = document.getElementById('statusSelect');
        if (elStatus) {
            const tsStatus = new TomSelect('#statusSelect', {
                create: false
            });
            tsStatus.on('change', function() {
                document.getElementById('filterForm').submit();
            });
        }

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
                            return (str || '').replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
                        }

                        // Populate modal preview fields safely
                        const namaSiswa = toTitleCase(cert.nama_siswa);
                        const elName = document.getElementById('modalName');
                        if (elName) elName.innerText = namaSiswa;
                        
                        const prestasiText = cert.prestasi && cert.prestasi !== '-' ? cert.prestasi : 'Anggota/Peserta Aktif';
                        const elJenis = document.getElementById('modalJenis');
                        if (elJenis) elJenis.innerText = (cert.jenis_sertifikat || '').toUpperCase();
                        
                        // Format description with highlighted double quotes and newlines
                        let prestasiHtml = cert.prestasi ? cert.prestasi.replace(/\n/g, '<br>') : '';
                        prestasiHtml = prestasiHtml.replace(/"(.*?)"/g, '<span style="color:#C89B3C; font-weight:bold;">"$1"</span>');
                        prestasiHtml = prestasiHtml.replace(/&quot;(.*?)&quot;/g, '<span style="color:#C89B3C; font-weight:bold;">"$1"</span>');
                        const elDesc = document.getElementById('modalDescription');
                        if (elDesc) elDesc.innerHTML = prestasiHtml;

                        const elTgl = document.getElementById('modalTanggal');
                        if (elTgl) elTgl.innerText = cert.tanggal || '-';

                        const elPill = document.getElementById('modalPillCode');
                        if (elPill) elPill.innerText = 'Certificat No: ' + (cert.nomor_sertifikat || '-');

                        // Dynamic Font Sizing based on name and description lengths
                        if (elName) {
                            const nameLen = namaSiswa.length;
                            const descLen = cert.prestasi ? cert.prestasi.length : 0;
                            let fs = '2.4rem';
                            if (descLen > 180) {
                                fs = nameLen > 35 ? '1.5rem' : nameLen > 25 ? '1.8rem' : '2.0rem';
                            } else if (descLen > 120) {
                                fs = nameLen > 35 ? '1.7rem' : nameLen > 25 ? '2.0rem' : '2.2rem';
                            } else {
                                if (nameLen > 40) fs = '1.7rem';
                                else if (nameLen > 30) fs = '2.0rem';
                                else if (nameLen > 20) fs = '2.3rem';
                            }
                            elName.style.fontSize = fs;
                        }

                        // Populate modal details table fields safely
                        const elTblCode = document.getElementById('tblCode'); if (elTblCode) elTblCode.innerText = cert.code || '-';
                        const elModalHeaderCode = document.getElementById('modalDetailCodeHeader'); if (elModalHeaderCode) elModalHeaderCode.innerText = cert.code || '-';
                        const elTblNomor = document.getElementById('tblNomor'); if (elTblNomor) elTblNomor.innerText = cert.nomor_sertifikat || '-';
                        const elTblName = document.getElementById('tblName'); if (elTblName) elTblName.innerText = (cert.nama_siswa || '').toUpperCase();
                        const elTblNis = document.getElementById('tblNis'); if (elTblNis) elTblNis.innerText = cert.nis || '-';
                        const elTblEkskul = document.getElementById('tblEkskul'); if (elTblEkskul) elTblEkskul.innerText = cert.ekskul || '-';
                        const elTblJenis = document.getElementById('tblJenis'); if (elTblJenis) elTblJenis.innerText = cert.jenis_sertifikat || '-';
                        const elTblPrestasi = document.getElementById('tblPrestasi'); if (elTblPrestasi) elTblPrestasi.innerText = prestasiText;
                        const elTblTanggal = document.getElementById('tblTanggal'); if (elTblTanggal) elTblTanggal.innerText = cert.tanggal || '-';
                        const elTblPembina = document.getElementById('tblPembina'); if (elTblPembina) elTblPembina.innerText = (cert.nama_pembina || '') + ' (' + (cert.jabatan_pembina || '') + ')';

                        // Status Badge
                        const statusBadge = document.getElementById('modalStatus');
                        if (statusBadge) {
                            if (cert.status === 'Aktif') {
                                statusBadge.className = "badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold mb-2";
                                statusBadge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i>Sertifikat Aktif';
                            } else {
                                statusBadge.className = "badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-semibold mb-2";
                                statusBadge.innerHTML = '<i class="fa-solid fa-circle-minus me-1"></i>Sertifikat Draft';
                            }
                        }

                        // Logo
                        const modalLogo = document.getElementById('modalLogo');
                        if (modalLogo) {
                            if (cert.logo_base64) {
                                modalLogo.src = cert.logo_base64;
                                modalLogo.style.display = 'inline-block';
                            } else {
                                modalLogo.src = "{{ asset('logos/logo-rakitai.png') }}";
                            }
                        }

                        // QR Code
                        const modalQrCode = document.getElementById('modalQrCode');
                        if (modalQrCode) {
                            modalQrCode.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(cert.verify_url)}`;
                        }

                        // Action links
                        const dlBtn = document.getElementById('modalDownloadBtn'); if (dlBtn) dlBtn.href = cert.pdf_url || '#';
                        const editBtn = document.getElementById('modalEditBtn'); if (editBtn) editBtn.href = cert.edit_url || '#';

                        // Reset to first tab (detail-tab) before showing
                        const firstTab = document.querySelector('#modalTab button[id="detail-tab"]');
                        if (firstTab) {
                            const tabTrigger = new bootstrap.Tab(firstTab);
                            tabTrigger.show();
                        }

                        // Show modal
                        if (previewModal) previewModal.show();
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

                const lpNomorPill = document.getElementById('lpNomorPill'); if (lpNomorPill) lpNomorPill.innerText = 'Certificat No: ' + (nomor || '-');
                if (lpTanggal) lpTanggal.innerText = lpFormatDate(tanggal);

                // Load default logo
                const defaultLogo = "{{ isset($default_logo) && $default_logo ? $default_logo : '' }}";
                const lpLogo = document.getElementById('lpLogo');
                if (lpLogo) {
                    lpLogo.src = defaultLogo || '{{ asset('logos/logo-rakitai.png') }}';
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
