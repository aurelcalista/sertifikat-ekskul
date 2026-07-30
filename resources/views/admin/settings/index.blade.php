@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="card-custom-admin shadow-sm mb-4">
    <div class="mb-4 border-bottom pb-3">
        <h4 class="fw-bold mb-1 text-dark">Pengaturan</h4>
        <p class="text-muted small mb-0">Kelola informasi akun administrator dan konfigurasi bawaan sistem sertifikat.</p>
    </div>

    <!-- Bootstrap 5 Navigation Pills (Tabs) -->
    <ul class="nav nav-pills mb-4 gap-2" id="settingsTab" role="tablist" style="background-color: var(--bg-color); padding: 6px; border-radius: 12px; border: 1px solid var(--border-color); display: inline-flex;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 py-2.5 rounded-3 fw-medium d-flex align-items-center gap-2" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                <i class="fa-solid fa-user-gear"></i>Profil Admin
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2.5 rounded-3 fw-medium d-flex align-items-center gap-2" id="system-tab" data-bs-toggle="pill" data-bs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">
                <i class="fa-solid fa-sliders"></i>Pengaturan Sistem
            </button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="settingsTabContent">
        <!-- Tab 1: Profil Admin -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-address-card me-2 text-danger"></i>Informasi Akun Admin</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-medium text-secondary">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required placeholder="Nama lengkap admin...">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-medium text-secondary">Alamat Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required placeholder="email@contoh.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-key me-2 text-danger"></i>Ganti Kata Sandi</h5>
                    <p class="text-muted small mb-3">Kosongkan kolom sandi jika Anda tidak ingin mengubah kata sandi Anda saat ini.</p>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="current_password" class="form-label small fw-medium text-secondary">Kata Sandi Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan kata sandi lama untuk verifikasi...">
                            </div>
                            @error('current_password')
                                <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="new_password" class="form-label small fw-medium text-secondary">Kata Sandi Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Min. 8 karakter...">
                            </div>
                            @error('new_password')
                                <div class="text-danger small mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="new_password_confirmation" class="form-label small fw-medium text-secondary">Konfirmasi Kata Sandi Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-check-double"></i></span>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-danger rounded-3 px-5 py-2.5">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Tab 2: Pengaturan Sistem -->
        <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-12">
                        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-sliders me-2 text-danger"></i>Pengaturan Umum</h5>
                    </div>

                    <div class="col-md-6">
                        <label for="app_name" class="form-label small fw-medium text-secondary">Nama Aplikasi</label>
                        <input type="text" name="app_name" id="app_name" class="form-control @error('app_name') is-invalid @enderror" value="{{ old('app_name', $settings['app_name']) }}" required placeholder="Contoh: Sertifikat Ekskul">
                        @error('app_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="sekolah_default" class="form-label small fw-medium text-secondary">Nama Sekolah Default</label>
                        <input type="text" name="sekolah_default" id="sekolah_default" class="form-control @error('sekolah_default') is-invalid @enderror" value="{{ old('sekolah_default', $settings['sekolah_default']) }}" placeholder="Contoh: SMK Negeri 1 Cirebon">
                        @error('sekolah_default')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-5">
                        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-signature me-2 text-danger"></i>Default Penanggung Jawab / Pembina</h5>
                    </div>

                    <div class="col-md-6">
                        <label for="pembina_default" class="form-label small fw-medium text-secondary">Nama Pembina Default</label>
                        <input type="text" name="pembina_default" id="pembina_default" class="form-control @error('pembina_default') is-invalid @enderror" value="{{ old('pembina_default', $settings['pembina_default']) }}" placeholder="Contoh: Budi Santoso, S.Pd.">
                        @error('pembina_default')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jabatan_pembina_default" class="form-label small fw-medium text-secondary">Jabatan Pembina Default</label>
                        <input type="text" name="jabatan_pembina_default" id="jabatan_pembina_default" class="form-control @error('jabatan_pembina_default') is-invalid @enderror" value="{{ old('jabatan_pembina_default', $settings['jabatan_pembina_default']) }}" placeholder="Contoh: Pembina Pramuka">
                        @error('jabatan_pembina_default')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mt-5">
                        <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-image me-2 text-danger"></i>Berkas Bawaan (Default Assets)</h5>
                    </div>

                    <div class="col-md-6">
                        <label for="logo_file" class="form-label small fw-medium text-secondary">Upload Logo Sekolah Default</label>
                        <input type="file" name="logo_file" id="logo_file" class="form-control @error('logo_file') is-invalid @enderror">
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Logo default yang akan digunakan saat membuat sertifikat baru. Format: PNG/JPG, Maks: 1MB.</small>
                        @error('logo_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($settings['logo_default'])
                            <div class="mt-3 bg-light p-2 rounded-3 border d-inline-block">
                                <img src="{{ asset('storage/' . $settings['logo_default']) }}" alt="Logo Default" style="max-height: 80px; width: auto;" class="img-fluid rounded">
                            </div>
                        @else
                            <div class="mt-2 text-muted small"><i class="fa-solid fa-triangle-exclamation text-warning me-1"></i>Belum ada logo default.</div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="tanda_tangan_file" class="form-label small fw-medium text-secondary">Upload Tanda Tangan Default</label>
                        <input type="file" name="tanda_tangan_file" id="tanda_tangan_file" class="form-control @error('tanda_tangan_file') is-invalid @enderror">
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Tanda tangan default yang akan otomatis terpilih. Gunakan format PNG transparan. Maks: 1MB.</small>
                        @error('tanda_tangan_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($settings['tanda_tangan_default'])
                            <div class="mt-3 bg-light p-2 rounded-3 border d-inline-block">
                                <img src="{{ asset('storage/' . $settings['tanda_tangan_default']) }}" alt="TTD Default" style="max-height: 50px; width: auto;" class="img-fluid bg-white border">
                            </div>
                        @else
                            <div class="mt-2 text-muted small"><i class="fa-solid fa-triangle-exclamation text-warning me-1"></i>Belum ada tanda tangan default.</div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-danger rounded-3 px-5 py-2.5">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Pengaturan Sistem
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Styling nav pills for tabs to match themed red accent */
    .nav-pills .nav-link {
        color: var(--text-muted);
        background: transparent;
        transition: all 0.25s ease;
    }
    .nav-pills .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(231, 76, 60, 0.05);
    }
    .nav-pills .nav-link.active {
        color: #ffffff !important;
        background-color: var(--primary-color) !important;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);
    }
</style>
@endsection

@section('scripts')
<script>
    // Keep active tab upon validation errors
    document.addEventListener("DOMContentLoaded", function () {
        @if($errors->has('name') || $errors->has('email') || $errors->has('current_password') || $errors->has('new_password'))
            const tab = new bootstrap.Tab(document.getElementById('profile-tab'));
            tab.show();
        @elseif($errors->has('app_name') || $errors->has('sekolah_default') || $errors->has('logo_file') || $errors->has('tanda_tangan_file'))
            const tab = new bootstrap.Tab(document.getElementById('system-tab'));
            tab.show();
        @endif
    });
</script>
@endsection
