@extends('layouts.admin')

@section('title', 'Data Sertifikat')

@section('content')
<div class="card-custom-admin shadow-sm">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Data Sertifikat</h4>
            <p class="text-muted small mb-0">Kelola data sertifikat ekstrakurikuler siswa secara efisien.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.certificates.export.excel') }}" class="btn btn-outline-success rounded-3 px-3">
                <i class="fa-solid fa-file-excel me-2"></i>Ekspor Excel (CSV)
            </a>
            <a href="{{ route('admin.certificates.export.pdf') }}" class="btn btn-outline-danger rounded-3 px-3">
                <i class="fa-solid fa-file-pdf me-2"></i>Ekspor PDF List
            </a>
            <a href="{{ route('admin.certificates.create') }}" class="btn btn-danger rounded-3 px-3">
                <i class="fa-solid fa-circle-plus me-2"></i>Tambah Baru
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('admin.certificates.index') }}" method="GET" class="row g-3 mb-4 bg-light p-3 rounded-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari Kode, Nama Siswa, NIS, atau No. Sertifikat..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-3">
            <select name="ekskul" class="form-select">
                <option value="">-- Semua Ekskul --</option>
                @foreach($ekskul_list as $ekskul)
                    <option value="{{ $ekskul }}" {{ request('ekskul') == $ekskul ? 'selected' : '' }}>{{ $ekskul }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status" class="form-select">
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
                                <!-- Verify / View Public -->
                                <a href="{{ route('verify', $cert->code) }}" target="_blank" class="btn btn-sm btn-light border" title="Lihat Halaman Verifikasi">
                                    <i class="fa-solid fa-eye text-primary"></i>
                                </a>
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

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
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
    });
</script>
@endsection
