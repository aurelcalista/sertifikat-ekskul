@extends('layouts.admin')

@section('title', 'Profil Administrator')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom-admin shadow-sm">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-user-gear fa-lg"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Profil Administrator</h4>
                    <p class="text-muted small mb-0">Perbarui informasi profil dan kata sandi akun Anda.</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf

                <!-- Basic Profile Section -->
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-address-card me-2 text-danger"></i>Informasi Akun</h5>
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

                <!-- Change Password Section -->
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

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4 py-2">Batal</a>
                    <button type="submit" class="btn btn-danger rounded-3 px-4 py-2">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
