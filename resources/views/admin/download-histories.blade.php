@extends('layouts.admin')

@section('title', 'Riwayat Download Sertifikat')

@section('content')
<div class="card-custom-admin shadow-sm">
    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-dark">Riwayat Download</h4>
        <p class="text-muted small mb-0">Catatan riwayat unduhan sertifikat ekskul oleh siswa.</p>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-4">
            <thead class="table-light text-secondary small">
                <tr>
                    <th>Waktu Unduh</th>
                    <th>Kode Sertifikat</th>
                    <th>Nama Siswa</th>
                    <th>Ekskul</th>
                    <th>IP Address</th>
                    <th>Browser / Device</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $log)
                    <tr class="small text-dark">
                        <td>
                            <div>{{ $log->created_at->translatedFormat('d M Y') }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i>{{ $log->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <strong class="text-danger">{{ $log->certificate->code }}</strong>
                        </td>
                        <td class="fw-semibold">{{ $log->certificate->nama_siswa }}</td>
                        <td><span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded-pill">{{ $log->certificate->ekskul }}</span></td>
                        <td><code>{{ $log->ip_address ?? '-' }}</code></td>
                        <td class="text-muted" style="font-size: 0.8rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $log->user_agent }}">
                            {{ $log->user_agent ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-clock-rotate-left fa-3x mb-3 d-block"></i>
                            <span>Belum ada riwayat unduhan sertifikat yang tercatat.</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $histories->links() }}
    </div>
</div>
@endsection
