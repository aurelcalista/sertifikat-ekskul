@extends('layouts.admin')

@php
    $certBgUrl = $certificate->background_path
        ? asset('storage/' . $certificate->background_path)
        : ($certificate->template && $certificate->template->background_path
            ? asset('storage/' . $certificate->template->background_path)
            : '');
@endphp

@section('title', 'Ubah Sertifikat')

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
<div class="card-custom-admin shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Ubah Sertifikat</h4>
            <p class="text-muted small mb-0">Ubah data sertifikat untuk kode unik: <strong class="text-danger">{{ $certificate->code }}</strong></p>
        </div>
        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <form action="{{ route('admin.certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">

            <!-- Hidden validation requirements -->
            <input type="hidden" name="nis" value="{{ $certificate->nis }}">
            <input type="hidden" name="ekskul" value="{{ $certificate->ekskul }}">
            <input type="hidden" name="nama_pembina" value="{{ $certificate->nama_pembina }}">
            <input type="hidden" name="jabatan_pembina" value="{{ $certificate->jabatan_pembina }}">

            <!-- Identitas Penerima -->
            <div class="col-12">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-1"><i class="fa-solid fa-user-graduate me-2"></i>Identitas Penerima</h5>
            </div>

            <div class="col-12">
                <label for="nama_siswa" class="form-label small fw-medium text-secondary">Nama Lengkap Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $certificate->nama_siswa) }}" required placeholder="Masukkan nama siswa...">
                @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Detail Sertifikat -->
            <div class="col-12 mt-2">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-1"><i class="fa-solid fa-award me-2"></i>Detail Sertifikat</h5>
            </div>

            <div class="col-md-6">
                <label for="nomor_sertifikat" class="form-label small fw-medium text-secondary">
                    Nomor Sertifikat <span class="badge bg-danger" style="font-size:0.6rem;">Unik</span>
                </label>
                <input type="text" name="nomor_sertifikat" id="nomor_sertifikat" class="form-control @error('nomor_sertifikat') is-invalid @enderror" value="{{ old('nomor_sertifikat', $certificate->nomor_sertifikat) }}" required placeholder="124/SMK1/2026">
                @error('nomor_sertifikat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-3">
                <label for="tanggal" class="form-label small fw-medium text-secondary">Tanggal Terbit</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $certificate->tanggal->format('Y-m-d')) }}" required>
                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-3">
                <label for="status" class="form-label small fw-medium text-secondary">Status Sertifikat</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Aktif" {{ $certificate->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Draft" {{ $certificate->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="jenis_sertifikat" class="form-label small fw-medium text-secondary">Jenis Sertifikat</label>
                <input type="text" name="jenis_sertifikat" id="jenis_sertifikat" class="form-control @error('jenis_sertifikat') is-invalid @enderror" value="{{ old('jenis_sertifikat', $certificate->jenis_sertifikat) }}" required placeholder="Keikutsertaan, Kejuaraan...">
                @error('jenis_sertifikat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="logo_sekolah_file" class="form-label small fw-medium text-secondary">Ganti Logo Sekolah <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="logo_sekolah_file" id="logo_sekolah_file" class="form-control @error('logo_sekolah_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Format: PNG/JPG/JPEG, Maks: 1MB</small>
                @error('logo_sekolah_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @if($certificate->logo_sekolah)
                    @php
                        $logoBase64 = null;
                        $path = storage_path('app/public/' . $certificate->logo_sekolah);
                        if (file_exists($path)) {
                            $logoBase64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
                        } elseif (file_exists(public_path($certificate->logo_sekolah))) {
                            $path = public_path($certificate->logo_sekolah);
                            $logoBase64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
                        }
                    @endphp
                    <div class="mt-2">
                        <img src="{{ $logoBase64 ?? asset('storage/' . $certificate->logo_sekolah) }}" alt="Logo" class="img-thumbnail" style="max-height: 50px;">
                    </div>
                @endif
            </div>

            <div class="col-12">
                <label for="prestasi" class="form-label small fw-medium text-secondary">Deskripsi / Teks Sertifikat</label>
                <textarea name="prestasi" id="prestasi" class="form-control @error('prestasi') is-invalid @enderror" rows="3" required placeholder="Masukkan deskripsi sertifikat...">{{ old('prestasi', $certificate->prestasi) }}</textarea>
                @error('prestasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 mt-2 text-end">
                <button type="button" class="btn btn-outline-danger rounded-3 px-4 py-2 me-2" id="btnPreview">
                    <i class="fa-solid fa-eye me-2"></i>Pratinjau
                </button>
                <button type="submit" class="btn btn-danger rounded-3 px-5 py-2">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Perbarui Sertifikat
                </button>
            </div>
        </div>
    </form>
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
<div class="preview-certificate-container bg-white position-relative overflow-hidden rounded-4 border shadow-sm p-4 text-center" style="aspect-ratio: 297 / 210; max-width: 660px; width: 100%; margin: 0 auto; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box;">
    <!-- 1. Top-Left Technical Circular Line Pattern -->
    <svg viewBox="0 0 250 250" style="position: absolute; top: 0; left: 0; width: 120px; height: 120px; z-index: 1; pointer-events: none;">
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

    <!-- 2. Top-Right Orange Geometric Angular Splash -->
    <svg viewBox="0 0 350 300" style="position: absolute; top: 0; right: 0; width: 145px; height: 120px; z-index: 1; pointer-events: none;">
        <g fill="#F15A3D">
            <polygon points="120,0 350,0 350,220 280,180 260,250 210,170 170,220 140,110 80,140 100,50" />
            <polygon points="260,190 350,120 350,270 290,260" fill="#D9482B"/>
            <polygon points="180,210 240,290 280,240 220,180" fill="#FF6B4A"/>
        </g>
    </svg>

    <!-- 3. Left Side Diagonal Gray Lines -->
    <svg viewBox="0 0 60 220" style="position: absolute; top: 35%; left: 6px; width: 18px; height: 75px; z-index: 1; pointer-events: none;">
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

    <!-- 4. Right Side Upward Stacked Chevrons -->
    <svg viewBox="0 0 60 200" style="position: absolute; top: 35%; right: 6px; width: 18px; height: 80px; z-index: 1; pointer-events: none;">
        <g fill="none" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round">
            <polyline points="10,35 30,15 50,35" stroke="#F15A3D" />
            <polyline points="10,65 30,45 50,65" stroke="#F15A3D" />
            <polyline points="10,95 30,75 50,95" stroke="#64748B" />
            <polyline points="10,125 30,105 50,125" stroke="#64748B" />
            <polyline points="10,155 30,135 50,155" stroke="#64748B" />
            <polyline points="10,185 30,165 50,185" stroke="#CBD5E1" />
        </g>
    </svg>

    <!-- 5. Bottom Left Corner Diagonal Orange Lines -->
    <svg viewBox="0 0 250 200" style="position: absolute; bottom: 0; left: 0; width: 120px; height: 90px; z-index: 1; pointer-events: none;">
        <g stroke="#F15A3D" stroke-width="2.5" stroke-linecap="round">
            <line x1="0" y1="200" x2="220" y2="20" stroke-width="3.5"/>
            <line x1="0" y1="170" x2="190" y2="10" stroke-width="3"/>
            <line x1="0" y1="140" x2="160" y2="0" stroke-width="2.5"/>
            <line x1="0" y1="110" x2="130" y2="0" stroke-width="2"/>
            <line x1="0" y1="80" x2="90" y2="0" stroke-width="1.5"/>
            <line x1="0" y1="50" x2="50" y2="0" stroke-width="1"/>
        </g>
    </svg>

    <!-- 6. Bottom Right Geometric L-shaped Grain Frame -->
    <svg viewBox="0 0 250 250" style="position: absolute; bottom: 0; right: 0; width: 110px; height: 110px; z-index: 1; pointer-events: none;">
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

    <!-- CONTENT LAYER -->
    <div class="position-relative w-100 h-100 d-flex flex-column justify-content-between" style="z-index: 5;">
        <!-- Header Logo -->
        <div class="text-center pt-1">
            <img src="{{ asset('logos/logo-rakitai.png') }}" style="max-height: 44px; width: auto; display: inline-block;" alt="Logo Rakit AI">
        </div>

        <!-- Title Section -->
        <div class="text-center my-1">
            <h2 style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.95rem; font-weight: 700; color: #1F2A44; letter-spacing: 5px; margin: 0; text-transform: uppercase;">SERTIFIKAT</h2>
            <p id="prevJenis" style="font-family: 'Poppins', sans-serif; font-size: 0.68rem; font-weight: 600; color: #F15A3D; letter-spacing: 3px; margin: 2px 0 4px 0; text-transform: uppercase;">SERTIFIKAT KEIKUTSERTAAN</p>
            <div>
                <span id="prevPillCode" style="border: 1.5px solid #1F2A44; border-radius: 14px; padding: 2px 14px; font-family: 'Poppins', sans-serif; font-size: 0.6rem; font-weight: 600; color: #1F2A44; display: inline-block;">Certificat No: -</span>
            </div>
        </div>

        <!-- Recipient Section -->
        <div class="text-center my-1">
            <p style="font-family: 'Poppins', sans-serif; font-size: 0.68rem; color: #334155; margin-bottom: 2px;">Diberikan kepada:</p>
            <h3 id="prevName" style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 1.65rem; font-weight: 700; color: #1F2A44; margin: 0; text-transform: uppercase; letter-spacing: 1px;">NAMA LENGKAP SISWA</h3>
        </div>

        <!-- Description Box -->
        <div class="text-center px-4 my-2" style="margin-top: 12px !important;">
            <p id="prevPrestasi" class="mb-0 text-secondary" style="font-family: 'Poppins', sans-serif; font-size: 0.68rem; line-height: 1.5;">Atas keikutsertaan, dedikasi, serta pencapaian prestasi luar biasa dalam program pengembangan diri sekolah dengan predikat "Anggota/Peserta Aktif"</p>
        </div>

        <!-- Footer Bar -->
        <div class="d-flex justify-content-between align-items-end w-100 pt-1" style="margin-top: auto;">
            <!-- Left: QR Code -->
            <div style="width: 30%; text-align: left;">
                <div id="previewQrCode" style="width: 54px; height: 54px; border: 1.5px solid #CBD5E1; padding: 3px; border-radius: 8px; background: #FFFFFF; display: inline-block;"></div>
            </div>

            <!-- Center: Plain Gold Medal -->
            <div style="width: 40%; text-align: center;">
                <svg viewBox="0 0 100 130" style="width: 65px; height: 85px; display: inline-block; filter: drop-shadow(0px 3px 5px rgba(0,0,0,0.2));">
    <defs>
        <radialGradient id="gRadP_v3" cx="40%" cy="35%" r="60%">
            <stop offset="0%" stop-color="#FFF8DC" />
            <stop offset="30%" stop-color="#FFD700" />
            <stop offset="60%" stop-color="#DAA520" />
            <stop offset="100%" stop-color="#8B6508" />
        </radialGradient>
        <radialGradient id="gEdgP_v3" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#FFD700" />
            <stop offset="100%" stop-color="#8B4513" />
        </radialGradient>
        <linearGradient id="rLP_v3" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#1a3a7a" />
            <stop offset="50%" stop-color="#2563EB" />
            <stop offset="100%" stop-color="#1a3a7a" />
        </linearGradient>
        <linearGradient id="rRP_v3" x1="100%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stop-color="#1a3a7a" />
            <stop offset="50%" stop-color="#2563EB" />
            <stop offset="100%" stop-color="#1a3a7a" />
        </linearGradient>
    </defs>
    <polygon points="42,68 30,130 42,118 50,125" fill="url(#rLP_v3)" />
    <polygon points="58,68 70,130 58,118 50,125" fill="url(#rRP_v3)" />
    <circle cx="50" cy="50" r="40" fill="url(#gEdgP_v3)" stroke="#8B6508" stroke-width="1" stroke-dasharray="7.5 4.5" />
    <circle cx="50" cy="50" r="37" fill="url(#gRadP_v3)" />
    <circle cx="50" cy="50" r="33" fill="none" stroke="#B8860B" stroke-width="1.5" />
    <circle cx="50" cy="50" r="31" fill="url(#gRadP_v3)" />
    <circle cx="50" cy="50" r="27" fill="none" stroke="#B8860B" stroke-width="0.8" stroke-dasharray="3 2" />
    <ellipse cx="40" cy="38" rx="10" ry="7" fill="#FFF8DC" opacity="0.35" />
</svg>
            </div>

            <!-- Right: Date Only (NO KEPALA SEKOLAH TEXT) -->
            <div style="width: 30%; text-align: right; padding-right: 5px;">
                <div style="display: inline-block; text-align: right;">
                    <div style="font-family: 'Cormorant Garamond', 'Georgia', serif; font-size: 0.82rem; color: #475569; font-style: italic; margin-bottom: 2px;">
                        Diterbitkan pada tanggal
                    </div>
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 4px;">
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                        <span id="prevTanggal" style="font-family: 'Poppins', sans-serif; font-size: 0.8rem; font-weight: 700; color: #0F172A;">-</span>
                        <span style="color: #94A3B8; font-size: 0.45rem;">&#9679; &#9679;</span>
                    </div>
                    <div style="height: 1.5px; background: linear-gradient(to right, transparent, #64748B, transparent); margin-top: 3px;"></div>
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
        const inputNama = document.getElementById('nama_siswa');
        const inputNis = document.getElementById('nis');
        const inputEkskul = document.getElementById('ekskul');
        const inputJenis = document.getElementById('jenis_sertifikat');
        const inputNomor = document.getElementById('nomor_sertifikat');
        const inputPrestasi = document.getElementById('prestasi');
        const inputTanggal = document.getElementById('tanggal');
        const inputPembina = document.getElementById('nama_pembina');
        const inputJabatan = document.getElementById('jabatan_pembina');
        const selectTemplate = document.getElementById('template_id');

        // File inputs
        const fileBackground = document.getElementById('background_file');
        const fileLogo = document.getElementById('logo_sekolah_file');
        const fileSignature = document.getElementById('tanda_tangan_file');

        // Elements in preview mockup
        const prevName = document.getElementById('prevName');
        const prevNis = document.getElementById('prevNis');
        const prevEkskul = document.getElementById('prevEkskul');
        const prevEkskul2 = document.getElementById('prevEkskul2');
        const prevJenis = document.getElementById('prevJenis');
        const prevNomor = document.getElementById('prevNomor');
        const prevPeriode = document.getElementById('prevPeriode');
        const prevPrestasi = document.getElementById('prevPrestasi');
        const prevTanggal = document.getElementById('prevTanggal');
        const prevPembina = document.getElementById('prevPembina');
        const prevJabatan = document.getElementById('prevJabatan');
        const previewTemplateBg = document.getElementById('previewTemplateBg');
        const prevLogo = document.getElementById('prevLogo');
        const prevSignature = document.getElementById('prevSignature');

        // Default assets
        const defaultLogo = "{{ $logoBase64 ?? ($certificate->logo_sekolah ? asset('storage/' . $certificate->logo_sekolah) : '') }}";
        const defaultSignature = "{{ $sigBase64 ?? ($certificate->tanda_tangan ? asset('storage/' . $certificate->tanda_tangan) : '') }}";

        // Border accents
        const borders = [
            document.getElementById('previewBorderOuter'),
            document.getElementById('previewBorderInner'),
            document.getElementById('prevCornerTL'),
            document.getElementById('prevCornerTR'),
            document.getElementById('prevCornerBL'),
            document.getElementById('prevCornerBR')
        ];

        // Format Date to Indonesia Localized Date (d F Y)
        function formatIndonesianDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '-';
            
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            
            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            
            return `${day} ${month} ${year}`;
        }

        // Titlecase helper
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
        }

        // Live preview updates
        function updatePreview() {
            const namaVal = inputNama?.value || 'Nama Lengkap Siswa';
            if (prevName) prevName.innerText = toTitleCase(namaVal);
            if (prevNis) prevNis.innerText = 'NIS. ' + (inputNis?.value || '-');
            if (prevEkskul) prevEkskul.innerText = inputEkskul?.value || '-';
            if (prevEkskul2) prevEkskul2.innerText = inputEkskul?.value || '-';
            if (prevJenis) prevJenis.innerText = (inputJenis?.value || 'Sertifikat Keikutsertaan').toUpperCase();
            const prevPillCode = document.getElementById('prevPillCode'); if (prevPillCode) prevPillCode.innerText = 'Certificat No: ' + (inputNomor?.value || '-');
            
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
            
            if (prevPrestasi) {
                const prestasiHtml = (inputPrestasi?.value || '').replace(/\n/g, '<br>');
                prevPrestasi.innerHTML = prestasiHtml;
            }
            if (prevTanggal) prevTanggal.innerText = formatIndonesianDate(inputTanggal?.value);
            if (prevPembina) prevPembina.innerText = inputPembina?.value || '-';
            if (prevJabatan) prevJabatan.innerText = (inputJabatan?.value || '-').toUpperCase();

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

        // Template background from existing certificate
        const certBgUrl = "{{ $certBgUrl }}";

        // Handle Template Background Change
        function updateTemplateBackground() {
            const mockupItems = document.querySelectorAll('.custom-mockup-item');

            // If custom background file is uploaded, prioritize it
            if (fileBackground && fileBackground.files && fileBackground.files[0]) {
                return;
            }

            let bgUrl = certBgUrl;
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
        if (prevLogo) prevLogo.src = defaultLogo || 'https://via.placeholder.com/100';
        if (prevSignature) {
            if (defaultSignature) {
                prevSignature.src = defaultSignature;
                prevSignature.style.display = 'inline-block';
            } else {
                prevSignature.style.display = 'none';
            }
        }

        // Event listeners for text input changes
        const inputs = [inputNama, inputNis, inputEkskul, inputJenis, inputNomor, inputPrestasi, inputTanggal, inputPembina, inputJabatan];
        inputs.forEach(input => {
            if (input) {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            }
        });


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
                    prevLogo.src = defaultLogo || 'https://via.placeholder.com/100';
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
                    if (defaultSignature) {
                        prevSignature.src = defaultSignature;
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
