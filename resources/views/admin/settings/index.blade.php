@extends('layouts.admin')

@section('title', 'Pengaturan & Kelola Admin')

@section('content')
<div class="card-custom-admin shadow-sm mb-4">
    <div class="mb-4 border-bottom pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Pengaturan & Profil Admin</h4>
            <p class="text-muted small mb-0">Kelola profil akun, tambah administrator baru, dan konfigurasi bawaan sistem sertifikat.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4 py-3 small d-flex align-items-center gap-2" style="background-color: #E8F5E9; color: #2E7D32;">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 mb-4 py-3 small d-flex align-items-center gap-2" style="background-color: #FFEBEE; color: #C62828;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Navigation Pills (Tabs) -->
    <ul class="nav nav-pills mb-4 gap-2" id="settingsTab" role="tablist" style="background-color: var(--bg-color); padding: 6px; border-radius: 12px; border: 1px solid var(--border-color); display: inline-flex;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 py-2.5 rounded-3 fw-medium d-flex align-items-center gap-2" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                <i class="fa-solid fa-user-gear"></i>Profil Saya
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-4 py-2.5 rounded-3 fw-medium d-flex align-items-center gap-2" id="manage-admins-tab" data-bs-toggle="pill" data-bs-target="#manage-admins" type="button" role="tab" aria-controls="manage-admins" aria-selected="false">
                <i class="fa-solid fa-users-gear"></i>Kelola User Admin
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
        
        <!-- Tab 1: Profil Saya -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Foto Profil Admin Section -->
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-image me-2 text-danger"></i>Foto Profil Admin</h5>
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        <div>
                            @if($admin->avatar)
                                <img src="{{ asset('storage/' . $admin->avatar) }}" alt="Foto Profil" class="rounded-circle border shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
                            @else
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2 shadow-sm" style="width: 90px; height: 90px;">
                                    {{ substr($admin->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1" style="max-width: 400px;">
                            <label for="avatar_file" class="form-label small fw-medium text-secondary">Upload Foto Profil Baru</label>
                            <input type="file" name="avatar_file" id="avatar_file" class="form-control @error('avatar_file') is-invalid @enderror" accept="image/*">
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Format: PNG, JPG, JPEG, WEBP. Maksimal 2MB.</small>
                            @error('avatar_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <!-- Informasi Akun Admin -->
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

                <!-- Ganti Kata Sandi -->
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

        <!-- Tab 2: Kelola User Admin -->
        <div class="tab-pane fade" id="manage-admins" role="tabpanel" aria-labelledby="manage-admins-tab">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-user-plus me-2 text-danger"></i>Daftar Administrator</h5>
                    <p class="text-muted small mb-0">Kelola daftar pengguna yang dapat mengakses dashboard manajemen sertifikat.</p>
                </div>
                <button type="button" class="btn btn-danger rounded-3 px-4 py-2 small fw-medium" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                    <i class="fa-solid fa-plus me-2"></i>Tambah Admin Baru
                </button>
            </div>

            <!-- Admin Table -->
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">Foto</th>
                            <th>Nama Admin</th>
                            <th>Email</th>
                            <th>Tanggal Dibuat</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allAdmins as $itemAdmin)
                            <tr>
                                <td>
                                    @if($itemAdmin->avatar)
                                        <img src="{{ asset('storage/' . $itemAdmin->avatar) }}" alt="Avatar" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold small" style="width: 40px; height: 40px;">
                                            {{ substr($itemAdmin->name, 0, 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $itemAdmin->name }}</span>
                                    @if($itemAdmin->id === $admin->id)
                                        <span class="badge bg-danger-subtle text-danger ms-2" style="font-size: 0.7rem;">Akun Anda</span>
                                    @endif
                                </td>
                                <td class="text-secondary small">{{ $itemAdmin->email }}</td>
                                <td class="text-muted small">{{ $itemAdmin->created_at ? $itemAdmin->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td class="text-center">
                                    @if($itemAdmin->id !== $admin->id)
                                        <form action="{{ route('admin.profile.destroy-admin', $itemAdmin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-2" title="Hapus Admin">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small" style="font-style: italic;">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada akun admin lain.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 3: Pengaturan Sistem -->
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

<!-- Modal Tambah Admin Baru -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="addAdminModalLabel"><i class="fa-solid fa-user-plus me-2 text-danger"></i>Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.profile.store-admin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="admin_name" class="form-label small fw-medium text-secondary">Nama Lengkap</label>
                        <input type="text" name="name" id="admin_name" class="form-control" required placeholder="Nama admin baru...">
                    </div>
                    <div class="mb-3">
                        <label for="admin_email" class="form-label small fw-medium text-secondary">Email</label>
                        <input type="email" name="email" id="admin_email" class="form-control" required placeholder="adminbaru@contoh.com">
                    </div>
                    <div class="mb-3">
                        <label for="admin_avatar" class="form-label small fw-medium text-secondary">Foto Profil (Opsional)</label>
                        <input type="file" name="avatar_file" id="admin_avatar" class="form-control" accept="image/*">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="admin_password" class="form-label small fw-medium text-secondary">Kata Sandi</label>
                            <input type="password" name="password" id="admin_password" class="form-control" required placeholder="Min. 8 karakter">
                        </div>
                        <div class="col-md-6">
                            <label for="admin_password_confirmation" class="form-label small fw-medium text-secondary">Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation" id="admin_password_confirmation" class="form-control" required placeholder="Ulangi sandi">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-3 px-4"><i class="fa-solid fa-user-check me-1"></i>Simpan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
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
    document.addEventListener("DOMContentLoaded", function () {
        @if($errors->has('name') || $errors->has('email') || $errors->has('avatar_file') || $errors->has('current_password') || $errors->has('new_password'))
            const tab = new bootstrap.Tab(document.getElementById('profile-tab'));
            tab.show();
        @elseif($errors->has('app_name') || $errors->has('sekolah_default') || $errors->has('logo_file') || $errors->has('tanda_tangan_file'))
            const tab = new bootstrap.Tab(document.getElementById('system-tab'));
            tab.show();
        @endif
    });
</script>
@endsection
