@extends('layouts.public')

@section('title', 'Verifikasi Sertifikat')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            @if($isValid)
                <!-- Valid State -->
                <div class="card card-custom p-4 p-md-5 border border-success border-2 shadow-sm text-center position-relative">
                    <div class="position-absolute top-0 start-0 end-0 bg-success" style="height: 10px;"></div>
                    
                    <div class="text-success my-3">
                        <i class="fa-solid fa-circle-check fa-4x"></i>
                    </div>
                    
                    <h2 class="fw-bold text-success mb-2">Sertifikat Valid & Terdaftar</h2>
                    <p class="text-muted">Sertifikat dengan kode <strong class="text-dark">{{ $certificate->code }}</strong> telah divalidasi oleh sistem sekolah.</p>

                    <!-- Details Table -->
                    <div class="table-responsive text-start my-4">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Kode Sertifikat</th>
                                    <td><strong class="text-danger">{{ $certificate->code }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nomor Sertifikat</th>
                                    <td>{{ $certificate->nomor_sertifikat }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Siswa</th>
                                    <td><strong>{{ strtoupper($certificate->nama_siswa) }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">NIS</th>
                                    <td>{{ $certificate->nis }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Sekolah</th>
                                    <td>{{ $certificate->sekolah }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kelas</th>
                                    <td>{{ $certificate->kelas }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ekstrakurikuler</th>
                                    <td><span class="badge bg-secondary">{{ $certificate->ekskul }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis Sertifikat</th>
                                    <td>{{ $certificate->jenis_sertifikat }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Prestasi</th>
                                    <td><span class="text-orange fw-semibold">{{ $certificate->prestasi ?? 'Peserta Aktif' }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Terbit</th>
                                    <td>{{ $certificate->tanggal->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Pembina</th>
                                    <td>{{ $certificate->nama_pembina }} ({{ $certificate->jabatan_pembina }})</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('download.pdf', $certificate->code) }}" class="btn btn-success rounded-pill px-4 py-2">
                            <i class="fa-solid fa-file-pdf me-2"></i>Download Sertifikat (PDF)
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 ms-2">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @else
                <!-- Invalid State -->
                <div class="card card-custom p-4 p-md-5 border border-danger border-2 shadow-sm text-center position-relative">
                    <div class="position-absolute top-0 start-0 end-0 bg-danger" style="height: 10px;"></div>
                    
                    <div class="text-danger my-3">
                        <i class="fa-solid fa-triangle-exclamation fa-4x"></i>
                    </div>
                    
                    <h2 class="fw-bold text-danger mb-2">Sertifikat Tidak Valid</h2>
                    <p class="text-muted">Kode sertifikat <strong class="text-dark">{{ $code }}</strong> tidak terdaftar dalam database kami atau statusnya dinonaktifkan.</p>
                    
                    <div class="alert alert-danger my-4 py-3 text-start small">
                        <h6 class="fw-bold"><i class="fa-solid fa-circle-info me-2"></i>Penyebab Kemungkinan:</h6>
                        <ul class="mb-0 ps-3">
                            <li>Salah mengetikkan kode sertifikat (kode bersifat sensitif).</li>
                            <li>Sertifikat belum dipublikasikan oleh administrator/pembina.</li>
                            <li>Sertifikat telah dihapus dari sistem.</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('download.view') }}" class="btn btn-custom-primary rounded-pill px-4 py-2">
                            Coba Cari Ulang
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 ms-2">
                            Ke Beranda
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
