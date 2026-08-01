@extends('layouts.admin')

@section('title', 'Ubah Sertifikat')

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

        <div class="row g-4">
            <!-- Data Siswa Section -->
            <div class="col-12">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-user-graduate me-2"></i>1. Identitas Siswa</h5>
            </div>
            
            <div class="col-md-8">
                <label for="nama_siswa" class="form-label small fw-medium text-secondary">Nama Lengkap Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $certificate->nama_siswa) }}" required placeholder="Masukkan nama siswa...">
                @error('nama_siswa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="nis" class="form-label small fw-medium text-secondary">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $certificate->nis) }}" required placeholder="2026xxxxxx">
                @error('nis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Detail Sertifikat Section -->
            <div class="col-12 mt-5">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-award me-2"></i>2. Detail Sertifikat & Kegiatan</h5>
            </div>

            <div class="col-md-4">
                <label for="ekskul" class="form-label small fw-medium text-secondary">Ekstrakurikuler</label>
                <input type="text" name="ekskul" id="ekskul" class="form-control @error('ekskul') is-invalid @enderror" value="{{ old('ekskul', $certificate->ekskul) }}" required placeholder="Pramuka, Futsal, Paskibra, dll">
                @error('ekskul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="jenis_sertifikat" class="form-label small fw-medium text-secondary">Jenis Sertifikat</label>
                <input type="text" name="jenis_sertifikat" id="jenis_sertifikat" class="form-control @error('jenis_sertifikat') is-invalid @enderror" value="{{ old('jenis_sertifikat', $certificate->jenis_sertifikat) }}" required placeholder="Sertifikat Kejuaraan, Penghargaan, dll">
                @error('jenis_sertifikat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="nomor_sertifikat" class="form-label small fw-medium text-secondary">Nomor Sertifikat</label>
                <input type="text" name="nomor_sertifikat" id="nomor_sertifikat" class="form-control @error('nomor_sertifikat') is-invalid @enderror" value="{{ old('nomor_sertifikat', $certificate->nomor_sertifikat) }}" required placeholder="124/SMK1/EKS/2026">
                @error('nomor_sertifikat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label for="prestasi" class="form-label small fw-medium text-secondary">Pencapaian / Prestasi <span class="text-muted">(Opsional)</span></label>
                <input type="text" name="prestasi" id="prestasi" class="form-control @error('prestasi') is-invalid @enderror" value="{{ old('prestasi', $certificate->prestasi) }}" placeholder="Juara 1 Lomba Tingkat Kota, Anggota Aktif, dll">
                @error('prestasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="tanggal" class="form-label small fw-medium text-secondary">Tanggal Terbit Sertifikat</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $certificate->tanggal->format('Y-m-d')) }}" required>
                @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Penanggung Jawab Section -->
            <div class="col-12 mt-5">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-signature me-2"></i>3. Pembina / Penanggung Jawab</h5>
            </div>

            <div class="col-md-6">
                <label for="nama_pembina" class="form-label small fw-medium text-secondary">Nama Pembina</label>
                <input type="text" name="nama_pembina" id="nama_pembina" class="form-control @error('nama_pembina') is-invalid @enderror" value="{{ old('nama_pembina', $certificate->nama_pembina) }}" required placeholder="Masukkan nama pembina...">
                @error('nama_pembina')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="jabatan_pembina" class="form-label small fw-medium text-secondary">Jabatan Pembina</label>
                <input type="text" name="jabatan_pembina" id="jabatan_pembina" class="form-control @error('jabatan_pembina') is-invalid @enderror" value="{{ old('jabatan_pembina', $certificate->jabatan_pembina) }}" required placeholder="Pembina Futsal, Koordinator Ekskul, dll">
                @error('jabatan_pembina')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Desain & Upload Section -->
            <div class="col-12 mt-5">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-image me-2"></i>4. Pengaturan Template & Berkas</h5>
            </div>

            <div class="col-md-4">
                <label for="template_id" class="form-label small fw-medium text-secondary">Template Background Default</label>
                <select name="template_id" id="template_id" class="form-select @error('template_id') is-invalid @enderror" required>
                    @foreach($templates as $tpl)
                        <option value="{{ $tpl->id }}" data-background="{{ $tpl->background_path ? asset('storage/' . $tpl->background_path) : '' }}" {{ $certificate->template_id == $tpl->id ? 'selected' : '' }}>{{ $tpl->name }} {{ $tpl->is_default ? '(Default)' : '' }}</option>
                    @endforeach
                </select>
                @error('template_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="status" class="form-label small fw-medium text-secondary">Status Publikasi</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Aktif" {{ $certificate->status == 'Aktif' ? 'selected' : '' }}>Aktif (Dapat diunduh siswa)</option>
                    <option value="Draft" {{ $certificate->status == 'Draft' ? 'selected' : '' }}>Draft (Disembunyikan dari siswa)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="background_file" class="form-label small fw-medium text-secondary">Ganti Custom Background <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="background_file" id="background_file" class="form-control @error('background_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Akan menimpa template. Format: JPG/PNG, Maks: 2MB</small>
                @error('background_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($certificate->background_path)
                    <div class="mt-2">
                        <span class="badge bg-info-subtle text-info">Ada Background Kustom</span>
                        <a href="{{ asset('storage/' . $certificate->background_path) }}" target="_blank" class="small text-decoration-none ms-2">Lihat</a>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label for="logo_sekolah_file" class="form-label small fw-medium text-secondary">Ganti Logo Sekolah <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="logo_sekolah_file" id="logo_sekolah_file" class="form-control @error('logo_sekolah_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Format: PNG/JPG/JPEG, Maks: 1MB</small>
                @error('logo_sekolah_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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

            <div class="col-md-6">
                <label for="tanda_tangan_file" class="form-label small fw-medium text-secondary">Ganti Tanda Tangan Pembina <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="tanda_tangan_file" id="tanda_tangan_file" class="form-control @error('tanda_tangan_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Format: PNG transparan, Maks: 1MB</small>
                @error('tanda_tangan_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($certificate->tanda_tangan)
                    @php
                        $sigBase64 = null;
                        $path = storage_path('app/public/' . $certificate->tanda_tangan);
                        if (file_exists($path)) {
                            $sigBase64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
                        }
                    @endphp
                    <div class="mt-2">
                        <img src="{{ $sigBase64 ?? asset('storage/' . $certificate->tanda_tangan) }}" alt="Ttd" class="img-thumbnail" style="max-height: 50px; background-color: #eee;">
                    </div>
                @endif
            </div>

            <div class="col-12 mt-4 text-end">
                <button type="button" class="btn btn-outline-danger rounded-3 px-4 py-2.5 me-2" id="btnPreview">
                    <i class="fa-solid fa-eye me-2"></i>Pratinjau
                </button>
                <button type="submit" class="btn btn-danger rounded-3 px-5 py-2.5">
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
                <div class="preview-certificate-container p-3 p-md-4 mb-0 position-relative overflow-hidden" id="certificatePreviewArea" style="aspect-ratio: 297/210; min-height: 380px;">
                    <!-- Elegant double border -->
                    <div class="preview-border-outer" id="previewBorderOuter"></div>
                    <div class="preview-border-inner" id="previewBorderInner"></div>
                    
                    <div class="preview-corner-accent-tl" id="prevCornerTL"></div>
                    <div class="preview-corner-accent-tr" id="prevCornerTR"></div>
                    <div class="preview-corner-accent-bl" id="prevCornerBL"></div>
                    <div class="preview-corner-accent-br" id="prevCornerBR"></div>
                    
                    <!-- Template Background Image -->
                    <img id="previewTemplateBg" src="" class="position-absolute top-0 start-0 w-100 h-100 d-none" style="object-fit: cover; z-index: 1;" alt="Background Template">

                    <!-- Content -->
                    <div class="position-relative h-100 d-flex flex-column" style="z-index: 5; gap: 0;">

                        <!-- Header: Logo + Subtitle + Seal -->
                        <div class="d-flex justify-content-between align-items-center pb-2" style="border-bottom: 1px solid #e8d5a3;">
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
                        <div class="text-center" style="margin: 6px 0 2px;">
                            <span style="color: #D4AF37; font-size: 0.65rem; letter-spacing: 6px;">✦ ✦ ✦</span>
                        </div>

                        <!-- Title + Recipient -->
                        <div class="text-center" style="margin-bottom: 4px;">
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
                        <div class="d-flex justify-content-center gap-2" style="margin: 4px 0;">
                            <div style="background: rgba(212,175,55,0.10); border: 1px solid #D4AF37; border-radius: 20px; padding: 2px 10px; font-size: 0.58rem; color: #92600a; font-weight: 600; letter-spacing: 0.5px; font-family: 'Poppins', sans-serif;">
                                🎓 Ekskul: <span id="prevEkskul2" style="color:#0F172A;">-</span>
                            </div>
                            <div style="background: rgba(15,23,42,0.06); border: 1px solid #CBD5E1; border-radius: 20px; padding: 2px 10px; font-size: 0.58rem; color: #475569; font-weight: 600; letter-spacing: 0.5px; font-family: 'Poppins', sans-serif;">
                                📅 Periode: <span id="prevPeriode" style="color:#0F172A;">{{ date('Y') }}/{{ date('Y')+1 }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="text-center px-4" style="margin: 2px 0 6px;">
                            <p class="mb-0" style="line-height: 1.65; font-size: 0.78rem; color: #334155; font-family: 'Poppins', sans-serif;">
                                Dinyatakan telah mengikuti dan aktif berprestasi dalam kegiatan Ekstrakurikuler
                                <strong id="prevEkskul" style="color: #0F172A;"> - </strong>
                                dengan predikat
                                <span style="background: rgba(212,175,55,0.15); padding: 1px 6px; border-radius: 4px;"><strong id="prevPrestasi" style="color: #b5860d;">"Anggota/Peserta Aktif"</strong></span>
                                pada tahun pelajaran <strong style="color:#0F172A;">{{ date('Y') }}/{{ date('Y')+1 }}</strong>.
                            </p>
                        </div>

                        <!-- Decorative bottom ornament -->
                        <div class="text-center" style="margin: 2px 0;">
                            <span style="color: #D4AF37; font-size: 0.5rem; letter-spacing: 8px;">— ✦ —</span>
                        </div>

                        <!-- Footer: QR | Nomor+Tanggal | Tanda Tangan -->
                        <div class="d-flex justify-content-between align-items-end" style="border-top: 1px solid #e8d5a3; padding-top: 6px; margin-top: auto;">

                            <!-- QR Code (auto-generated) -->
                            <div class="text-start" style="width:68px;">
                                <div class="border bg-white p-1 d-inline-block" style="border-color: #D4AF37 !important; border-radius:4px;">
                                    <div id="previewQrCode" style="width:50px; height:50px; display:flex; align-items:center; justify-content:center;"></div>
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
            if (prevPembina) prevPembina.innerText = inputPembina?.value || '-';
            if (prevJabatan) prevJabatan.innerText = (inputJabatan?.value || '-').toUpperCase();

            if (prevName) {
                // Auto-scale font: 3rem for ≤10 chars, scales down smoothly, min 1.4rem for very long names
                const nameLen = prevName.innerText.length;
                const maxSize = 3.0;   // rem at shortest name
                const minSize = 1.4;   // rem at longest (clamped)
                const scaleStart = 10; // chars before scaling kicks in
                const scaleEnd   = 45; // chars where min size is reached
                let fs = maxSize;
                if (nameLen > scaleStart) {
                    const ratio = Math.min((nameLen - scaleStart) / (scaleEnd - scaleStart), 1);
                    fs = maxSize - ratio * (maxSize - minSize);
                }
                prevName.style.fontSize = fs.toFixed(2) + 'rem';
            }
        }

        // Handle Template Background Change
        function updateTemplateBackground() {
            // If custom background file is uploaded, prioritize it
            if (fileBackground && fileBackground.files && fileBackground.files[0]) {
                return;
            }

            if (!selectTemplate) return;
            const selectedOption = selectTemplate.options[selectTemplate.selectedIndex];
            if (!selectedOption) return;
            const bgUrl = selectedOption.getAttribute('data-background');

            if (bgUrl) {
                if (previewTemplateBg) {
                    previewTemplateBg.src = bgUrl;
                    previewTemplateBg.classList.remove('d-none');
                }
                borders.forEach(el => el?.classList.add('d-none'));
            } else {
                if (previewTemplateBg) {
                    previewTemplateBg.classList.add('d-none');
                    previewTemplateBg.src = '';
                }
                borders.forEach(el => el?.classList.remove('d-none'));
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
