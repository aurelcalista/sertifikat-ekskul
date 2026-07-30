@extends('layouts.admin')

@section('title', 'Tambah Sertifikat Baru')

@section('content')
<div class="card-custom-admin shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Tambah Sertifikat Baru</h4>
            <p class="text-muted small mb-0">Isi lengkap seluruh form data sertifikat di bawah ini.</p>
        </div>
        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <!-- Data Siswa Section -->
            <div class="col-12">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-user-graduate me-2"></i>1. Identitas Siswa</h5>
            </div>
            
            <div class="col-md-6">
                <label for="nama_siswa" class="form-label small fw-medium text-secondary">Nama Lengkap Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" required placeholder="Masukkan nama siswa...">
                @error('nama_siswa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="nis" class="form-label small fw-medium text-secondary">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required placeholder="2026xxxxxx">
                @error('nis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="kelas" class="form-label small fw-medium text-secondary">Kelas</label>
                <input type="text" name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}" required placeholder="X RPL 1, XII TKJ 2, dll">
                @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="sekolah" class="form-label small fw-medium text-secondary">Nama Sekolah</label>
                <input type="text" name="sekolah" id="sekolah" class="form-control @error('sekolah') is-invalid @enderror" value="{{ old('sekolah', $default_sekolah) }}" required placeholder="SMK Negeri 1 Cirebon">
                @error('sekolah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Detail Sertifikat Section -->
            <div class="col-12 mt-5">
                <h5 class="fw-bold text-danger border-bottom pb-2 mb-3"><i class="fa-solid fa-award me-2"></i>2. Detail Sertifikat & Kegiatan</h5>
            </div>

            <div class="col-md-4">
                <label for="ekskul" class="form-label small fw-medium text-secondary">Ekstrakurikuler</label>
                <input type="text" name="ekskul" id="ekskul" class="form-control @error('ekskul') is-invalid @enderror" value="{{ old('ekskul') }}" required placeholder="Pramuka, Futsal, Paskibra, dll">
                @error('ekskul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="jenis_sertifikat" class="form-label small fw-medium text-secondary">Jenis Sertifikat</label>
                <input type="text" name="jenis_sertifikat" id="jenis_sertifikat" class="form-control @error('jenis_sertifikat') is-invalid @enderror" value="{{ old('jenis_sertifikat', 'Sertifikat Keikutsertaan') }}" required placeholder="Sertifikat Kejuaraan, Penghargaan, dll">
                @error('jenis_sertifikat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="nomor_sertifikat" class="form-label small fw-medium text-secondary">Nomor Sertifikat</label>
                <input type="text" name="nomor_sertifikat" id="nomor_sertifikat" class="form-control @error('nomor_sertifikat') is-invalid @enderror" value="{{ old('nomor_sertifikat') }}" required placeholder="124/SMK1/EKS/2026">
                @error('nomor_sertifikat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label for="prestasi" class="form-label small fw-medium text-secondary">Pencapaian / Prestasi <span class="text-muted">(Opsional)</span></label>
                <input type="text" name="prestasi" id="prestasi" class="form-control @error('prestasi') is-invalid @enderror" value="{{ old('prestasi') }}" placeholder="Juara 1 Lomba Tingkat Kota, Anggota Aktif, dll">
                @error('prestasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="tanggal" class="form-label small fw-medium text-secondary">Tanggal Terbit Sertifikat</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
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
                <input type="text" name="nama_pembina" id="nama_pembina" class="form-control @error('nama_pembina') is-invalid @enderror" value="{{ old('nama_pembina', $default_pembina) }}" required placeholder="Masukkan nama pembina...">
                @error('nama_pembina')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="jabatan_pembina" class="form-label small fw-medium text-secondary">Jabatan Pembina</label>
                <input type="text" name="jabatan_pembina" id="jabatan_pembina" class="form-control @error('jabatan_pembina') is-invalid @enderror" value="{{ old('jabatan_pembina', $default_jabatan) }}" required placeholder="Pembina Futsal, Koordinator Ekskul, dll">
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
                        <option value="{{ $tpl->id }}" {{ $tpl->is_default ? 'selected' : '' }}>{{ $tpl->name }} {{ $tpl->is_default ? '(Default)' : '' }}</option>
                    @endforeach
                </select>
                @error('template_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="status" class="form-label small fw-medium text-secondary">Status Publikasi</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Aktif" selected>Aktif (Dapat diunduh siswa)</option>
                    <option value="Draft">Draft (Disembunyikan dari siswa)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="background_file" class="form-label small fw-medium text-secondary">Override Custom Background <span class="text-muted">(Opsional)</span></label>
                <input type="file" name="background_file" id="background_file" class="form-control @error('background_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Akan menimpa template default. Format: JPG/PNG, Maks: 2MB</small>
                @error('background_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="logo_sekolah_file" class="form-label small fw-medium text-secondary">Override Logo Sekolah <span class="text-muted">(Kosongkan jika ingin memakai logo default)</span></label>
                <input type="file" name="logo_sekolah_file" id="logo_sekolah_file" class="form-control @error('logo_sekolah_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Format: PNG/JPG/JPEG, Maks: 1MB</small>
                @error('logo_sekolah_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="tanda_tangan_file" class="form-label small fw-medium text-secondary">Override Tanda Tangan Pembina <span class="text-muted">(Kosongkan jika ingin memakai ttd default)</span></label>
                <input type="file" name="tanda_tangan_file" id="tanda_tangan_file" class="form-control @error('tanda_tangan_file') is-invalid @enderror">
                <small class="text-muted" style="font-size: 0.75rem;">Format: PNG transparan, Maks: 1MB</small>
                @error('tanda_tangan_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-danger rounded-3 px-5 py-2.5">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Sertifikat
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
