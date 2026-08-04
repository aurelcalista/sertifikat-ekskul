@extends('layouts.admin')

@php
    $defaultTemplate = $templates->where('is_default', true)->first() ?: $templates->first();
    $defaultBgUrl = $defaultTemplate && $defaultTemplate->background_path ? asset('storage/' . $defaultTemplate->background_path) : '';
@endphp

@section('title', 'Tambah Sertifikat Baru')

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
@section('content')
<div class="row">
    <!-- Form Section -->
    <div class="col-12 mb-4">
        <div class="card-custom-admin shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Tambah Sertifikat Baru</h4>
                    <p class="text-muted small mb-0">Isi lengkap seluruh form data sertifikat di bawah ini.</p>
                </div>
                <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" id="certForm">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-3">
                    <!-- Hidden validation requirements -->
                    <input type="hidden" name="nis" value="-">
                    <input type="hidden" name="ekskul" value="-">
                    <input type="hidden" name="nama_pembina" value="-">
                    <input type="hidden" name="jabatan_pembina" value="-">

                    <!-- Identitas Penerima -->
                    <div class="col-12">
                        <h5 class="fw-bold text-danger border-bottom pb-2 mb-1"><i class="fa-solid fa-user-graduate me-2"></i>Identitas Penerima</h5>
                    </div>

                    <div class="col-12">
                        <label for="nama_siswa" class="form-label small fw-medium text-secondary">Nama Lengkap Siswa</label>
                        <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" required placeholder="Masukkan nama siswa...">
                        @error('nama_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Detail Sertifikat -->
                    <div class="col-12 mt-2">
                        <h5 class="fw-bold text-danger border-bottom pb-2 mb-1"><i class="fa-solid fa-award me-2"></i>Detail Sertifikat</h5>
                    </div>

                    <div class="col-md-6">
                        <label for="nomor_sertifikat" class="form-label small fw-medium text-secondary">
                            Nomor Sertifikat <span class="badge bg-danger" style="font-size:0.6rem;">Unik</span>
                        </label>
                        <input type="text" name="nomor_sertifikat" id="nomor_sertifikat" class="form-control @error('nomor_sertifikat') is-invalid @enderror" value="{{ old('nomor_sertifikat') }}" required placeholder="124/SMK1/2026">
                        @error('nomor_sertifikat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal" class="form-label small fw-medium text-secondary">Tanggal Terbit</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label small fw-medium text-secondary">Status Sertifikat</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Draft">Draft</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_sertifikat" class="form-label small fw-medium text-secondary">Jenis Sertifikat</label>
                        <input type="text" name="jenis_sertifikat" id="jenis_sertifikat" class="form-control @error('jenis_sertifikat') is-invalid @enderror" value="{{ old('jenis_sertifikat', 'Sertifikat Keikutsertaan') }}" required placeholder="Keikutsertaan, Kejuaraan...">
                        @error('jenis_sertifikat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="logo_sekolah_file" class="form-label small fw-medium text-secondary">Ganti Logo Sekolah <span class="text-muted">(Opsional)</span></label>
                        <input type="file" name="logo_sekolah_file" id="logo_sekolah_file" class="form-control @error('logo_sekolah_file') is-invalid @enderror">
                        <small class="text-muted" style="font-size: 0.75rem;">Format: PNG/JPG/JPEG, Maks: 1MB</small>
                        @error('logo_sekolah_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="prestasi" class="form-label small fw-medium text-secondary">Deskripsi / Teks Sertifikat</label>
                        <textarea name="prestasi" id="prestasi" class="form-control @error('prestasi') is-invalid @enderror" rows="3" required placeholder="Masukkan deskripsi sertifikat...">{{ old('prestasi', 'Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat "Anggota/Peserta Aktif"') }}</textarea>
                        @error('prestasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mt-2 text-end">
                        <button type="button" class="btn btn-outline-danger rounded-3 px-4 py-2 me-2" id="btnPreview">
                            <i class="fa-solid fa-eye me-2"></i>Pratinjau
                        </button>
                        <button type="submit" class="btn btn-danger rounded-3 px-5 py-2">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Sertifikat
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom px-4">
                <h5 class="modal-title fw-bold text-dark" id="previewModalLabel">
                    <i class="fa-solid fa-certificate text-danger me-2"></i>Pratinjau Live Sertifikat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="preview-certificate-container p-3 p-md-4 mb-0 position-relative overflow-hidden" id="certificatePreviewArea" style="aspect-ratio: 297/210; min-height: 380px;">
                    <!-- Template Background Image -->
                    <img id="previewTemplateBg" src="{{ $defaultBgUrl }}" class="position-absolute top-0 start-0 w-100 h-100 {{ $defaultBgUrl ? '' : 'd-none' }}" style="object-fit: cover; z-index: 1;" alt="Background Template">

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
                                <img id="prevLogo" src="{{ $default_logo ?: '' }}" class="img-fluid" style="max-height: 44px; width: auto; mix-blend-mode: multiply;" alt="Logo">
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
                            <p class="mb-0 text-muted" id="prevDescriptionHtml" style="line-height: 1.5; font-size: 0.72rem; font-family: 'Poppins', sans-serif;">
                                Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat <span style="background: rgba(200,155,60,0.15); padding: 1px 6px; border-radius: 4px;"><strong id="prevPrestasi" style="color: #C89B3C;">"Anggota/Peserta Aktif"</strong></span>.
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
                                    <div id="previewQrCode" style="width:44px; height:44px; display:flex; align-items:center; justify-content:center; font-size:0.35rem; color:#888;">QR</div>
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
            <div class="modal-footer bg-light border-top px-4 py-3 justify-content-end">
                <button type="button" class="btn btn-secondary rounded-3 btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements from form
        const inputNama   = document.getElementById('nama_siswa');
        const inputNis    = document.getElementById('nis');
        const inputEkskul = document.getElementById('ekskul');
        const inputJenis  = document.getElementById('jenis_sertifikat');
        const inputNomor  = document.getElementById('nomor_sertifikat');
        const inputPrestasi = document.getElementById('prestasi');
        const inputTanggal  = document.getElementById('tanggal');
        const inputPembina  = document.getElementById('nama_pembina');
        const inputJabatan  = document.getElementById('jabatan_pembina');
        const selectTemplate = document.getElementById('template_id');

        // File inputs
        const fileBackground = document.getElementById('background_file');
        const fileLogo       = document.getElementById('logo_sekolah_file');
        const fileSignature  = document.getElementById('tanda_tangan_file');

        // Elements in preview
        const prevName     = document.getElementById('prevName');
        const prevNis      = document.getElementById('prevNis');
        const prevEkskul   = document.getElementById('prevEkskul');
        const prevEkskul2  = document.getElementById('prevEkskul2');
        const prevJenis    = document.getElementById('prevJenis');
        const prevNomor    = document.getElementById('prevNomor');
        const prevPeriode   = document.getElementById('prevPeriode');
        const prevPrestasi = document.getElementById('prevPrestasi');
        const prevTanggal  = document.getElementById('prevTanggal');
        const prevPembina  = document.getElementById('prevPembina');
        const prevJabatan  = document.getElementById('prevJabatan');
        const previewTemplateBg = document.getElementById('previewTemplateBg');
        const prevLogo     = document.getElementById('prevLogo');
        const prevSignature = document.getElementById('prevSignature');

        // Border accents
        const borders = [
            document.getElementById('previewBorderOuter'),
            document.getElementById('previewBorderInner'),
            document.getElementById('prevCornerTL'),
            document.getElementById('prevCornerTR'),
            document.getElementById('prevCornerBL'),
            document.getElementById('prevCornerBR')
        ];

        // Format Date to Indonesian
        function formatIndonesianDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '-';
            const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        // Sync form values → preview
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
        }
        function updatePreview() {
            const namaVal = inputNama?.value || 'Nama Lengkap Siswa';
            if (prevName) prevName.innerText = toTitleCase(namaVal);
            if (prevNis) prevNis.innerText = 'NIS. ' + (inputNis?.value || '-');
            if (prevEkskul) prevEkskul.innerText = inputEkskul?.value || '-';
            if (prevEkskul2) prevEkskul2.innerText = inputEkskul?.value || '-';
            if (prevJenis) prevJenis.innerText = (inputJenis?.value || 'Sertifikat Keikutsertaan').toUpperCase();
            if (prevNomor) prevNomor.innerText = inputNomor?.value || '-';
            
            if (prevPeriode) {
                if (inputTanggal?.value) {
                    const date = new Date(inputTanggal.value);
                    if (!isNaN(date.getTime())) {
                        const yr = date.getFullYear();
                        prevPeriode.innerText = `${yr}/${yr+1}`;
                    } else {
                        const currentYr = new Date().getFullYear();
                        prevPeriode.innerText = `${currentYr}/${currentYr+1}`;
                    }
                } else {
                    const currentYr = new Date().getFullYear();
                    prevPeriode.innerText = `${currentYr}/${currentYr+1}`;
                }
            }
            
            if (prevPrestasi) prevPrestasi.innerText = inputPrestasi?.value || 'Anggota/Peserta Aktif';
            if (prevTanggal) prevTanggal.innerText = formatIndonesianDate(inputTanggal?.value);
            if (prevPembina) prevPembina.innerText = inputPembina?.value || '{{ $default_pembina }}';
            if (prevJabatan) prevJabatan.innerText = (inputJabatan?.value || '{{ $default_jabatan }}').toUpperCase();

            // Dynamic Font Sizing based on name and description lengths
            if (prevName) {
                const nameLen = prevName.innerText.length;
                const descLen = inputPrestasi?.value ? inputPrestasi.value.length : 0;
                let fs = 3.0; // in rem
                if (descLen > 180) {
                    if (nameLen > 35) {
                        fs = 1.6;
                    } else if (nameLen > 25) {
                        fs = 1.9;
                    } else {
                        fs = 2.2;
                    }
                } else if (descLen > 120) {
                    if (nameLen > 35) {
                        fs = 1.8;
                    } else if (nameLen > 25) {
                        fs = 2.1;
                    } else {
                        fs = 2.4;
                    }
                } else {
                    if (nameLen > 40) {
                        fs = 1.8;
                    } else if (nameLen > 30) {
                        fs = 2.1;
                    } else if (nameLen > 20) {
                        fs = 2.5;
                    }
                }
                prevName.style.fontSize = fs + 'rem';
            }
        }

        const defaultBgUrl = "{{ $defaultBgUrl }}";

        // Background: show default borders or template background
        function updateTemplateBackground() {
            const mockupItems = document.querySelectorAll('.custom-mockup-item');

            if (fileBackground?.files?.[0]) return; // custom file takes priority

            let bgUrl = defaultBgUrl;
            if (selectTemplate) {
                const selectedOption = selectTemplate.options[selectTemplate.selectedIndex];
                if (selectedOption) {
                    bgUrl = selectedOption.getAttribute('data-background');
                }
            }

            if (bgUrl) {
                if (previewTemplateBg) {
                    previewTemplateBg.src = bgUrl;
                    previewTemplateBg.classList.remove('d-none');
                }
                mockupItems.forEach(el => el?.classList.add('d-none'));
            } else {
                if (previewTemplateBg) {
                    previewTemplateBg.classList.add('d-none');
                    previewTemplateBg.src = '';
                }
                mockupItems.forEach(el => el?.classList.remove('d-none'));
            }
        }

        // Set initial images
        if ('{{ $default_logo }}') {
            prevLogo.src = '{{ $default_logo }}';
        }
        if ('{{ $default_signature }}') {
            prevSignature.src = '{{ $default_signature }}';
            prevSignature.style.display = 'inline-block';
        } else {
            prevSignature.style.display = 'none';
        }

        // Attach listeners
        [inputNama, inputNis, inputEkskul, inputJenis, inputNomor, inputPrestasi, inputTanggal, inputPembina, inputJabatan]
            .forEach(el => { if (el) { el.addEventListener('input', updatePreview); el.addEventListener('change', updatePreview); } });

        if (selectTemplate) {
            selectTemplate.addEventListener('change', updateTemplateBackground);
        }

        // File Readers for Live Custom Image Upload Previews
        if (fileBackground) {
            fileBackground.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewTemplateBg.src = e.target.result;
                        previewTemplateBg.classList.remove('d-none');
                        borders.forEach(el => el.classList.add('d-none'));
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    updateTemplateBackground();
                }
            });
        }

        if (fileLogo) {
            fileLogo.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        prevLogo.src = e.target.result;
                        prevLogo.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    prevLogo.src = "{{ $default_logo ?: 'https://via.placeholder.com/100' }}";
                }
            });
        }

        if (fileSignature) {
            fileSignature.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        prevSignature.src = e.target.result;
                        prevSignature.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    if ("{{ $default_signature }}") {
                        prevSignature.src = "{{ $default_signature }}";
                        prevSignature.style.display = 'inline-block';
                    } else {
                        prevSignature.style.display = 'none';
                    }
                }
            });
        }

        // Initial preview population on load
        updatePreview();
        updateTemplateBackground();

        // Initialize preview Modal triggering
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const btnPreview = document.getElementById('btnPreview');

        // QR code generator for preview
        let qrInstance = null;
        function generatePreviewQr() {
            const qrContainer = document.getElementById('previewQrCode');
            if (!qrContainer) return;
            const nomorVal = inputNomor?.value?.trim() || 'PREVIEW-SERTIFIKAT';
            const qrText = `{{ url('/verify') }}?nomor=${encodeURIComponent(nomorVal)}`;
            // Clear previous
            qrContainer.innerHTML = '';
            qrInstance = new QRCode(qrContainer, {
                text: qrText,
                width: 50,
                height: 50,
                colorDark: '#0F172A',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M
            });
        }

        if (btnPreview) {
            btnPreview.addEventListener('click', function() {
                updatePreview();
                updateTemplateBackground();
                generatePreviewQr();
                previewModal.show();
            });
        }
    });
</script>
@endsection
