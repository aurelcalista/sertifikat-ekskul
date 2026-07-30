@extends('layouts.admin')

@section('title', 'Manajemen Template Sertifikat')

@section('content')
<div class="row g-4">
    <!-- Form Upload Template -->
    <div class="col-lg-4">
        <div class="card-custom-admin shadow-sm">
            <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-file-arrow-up me-2 text-danger"></i>Upload Template Baru</h5>
            <p class="text-muted small">Tambahkan background gambar sertifikat berformat JPG/PNG untuk mempercantik sertifikat.</p>
            
            <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label small fw-medium text-secondary">Nama Template</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Contoh: Template Pramuka 2026">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="background_file" class="form-label small fw-medium text-secondary">Berkas Background Gambar</label>
                    <input type="file" name="background_file" id="background_file" class="form-control @error('background_file') is-invalid @enderror" required>
                    <small class="text-muted" style="font-size: 0.75rem;">Gunakan orientasi lanskap (rekomendasi: 1920x1080 piksel). Maks: 2MB</small>
                    @error('background_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-danger w-100 rounded-3 py-2.5">
                    <i class="fa-solid fa-cloud-arrow-up me-2"></i>Simpan Template
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Template Grid -->
    <div class="col-lg-8">
        <div class="card-custom-admin shadow-sm h-100">
            <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-images me-2 text-danger"></i>Daftar Template Sertifikat</h5>
            
            <div class="row g-3">
                @foreach($templates as $tpl)
                    <div class="col-md-6">
                        <div class="card h-100 border rounded-4 overflow-hidden position-relative shadow-xs">
                            <!-- Template Status Tag -->
                            @if($tpl->is_default)
                                <span class="badge bg-success position-absolute m-3 z-1 px-3 py-2 rounded-pill shadow-sm" style="top: 0; left: 0;">
                                    <i class="fa-solid fa-star me-1"></i>Template Default
                                </span>
                            @endif

                            <!-- Background Image Preview -->
                            <div class="bg-light d-flex align-items-center justify-content-center border-bottom text-muted" style="height: 180px; overflow: hidden; position: relative;">
                                @if($tpl->background_path)
                                    @php
                                        $bgBase64 = null;
                                        $path = storage_path('app/public/' . $tpl->background_path);
                                        if (file_exists($path)) {
                                            $bgBase64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
                                        }
                                    @endphp
                                    <img src="{{ $bgBase64 ?? asset('storage/' . $tpl->background_path) }}" alt="{{ $tpl->name }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <!-- Default CSS layout preview -->
                                    <div class="p-3 text-center w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="border: 6px double #E74C3C; background: #FFF;">
                                        <i class="fa-solid fa-certificate text-danger mb-2 fa-2x"></i>
                                        <span class="fw-bold text-dark" style="font-size: 0.8rem;">CSS LAYOUT MINIMALIST</span>
                                        <small class="text-muted" style="font-size: 0.7rem;">Tanpa Background Gambar</small>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark mb-1">{{ $tpl->name }}</h6>
                                <p class="text-muted small mb-3">Dibuat: {{ $tpl->created_at->translatedFormat('d M Y') }}</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    @if(!$tpl->is_default)
                                        <form action="{{ route('admin.templates.default', $tpl->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-3">
                                                <i class="fa-regular fa-star me-1"></i>Set Default
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-3 delete-template-btn" data-id="{{ $tpl->id }}" data-name="{{ $tpl->name }}">
                                            <i class="fa-regular fa-trash-can"></i> Hapus
                                        </button>
                                        <form id="delete-template-form-{{ $tpl->id }}" action="{{ route('admin.templates.destroy', $tpl->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <span class="text-success small"><i class="fa-solid fa-circle-check me-1"></i>Aktif Digunakan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Konfirmasi Hapus Template
        const deleteButtons = document.querySelectorAll('.delete-template-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Hapus Template?',
                    text: `Anda akan menghapus template ${name}. File background akan terhapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#E74C3C',
                    cancelButtonColor: '#64748B',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-template-form-${id}`).submit();
                    }
                });
            });
        });
    });
</script>
@endsection
