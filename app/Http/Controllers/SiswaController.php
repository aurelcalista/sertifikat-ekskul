<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\DownloadHistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaController extends Controller
{
    /**
     * Tampilkan landing page utama.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Tampilkan halaman cari & unduh sertifikat.
     */
    public function downloadView()
    {
        return view('download');
    }

    /**
     * Pencarian sertifikat menggunakan AJAX untuk interaktivitas modern.
     */
    public function search(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $certificate = Certificate::with('template')
            ->where('code', trim($request->code))
            ->where('status', 'Aktif')
            ->first();

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Kode sertifikat tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        // Convert logo to Base64 with white background removed to bypass symlink and background issues
        $logo_base64 = null;
        if ($certificate->logo_sekolah) {
            $logo_path = storage_path('app/public/' . $certificate->logo_sekolah);
            if (file_exists($logo_path)) {
                $logo_base64 = Certificate::removeWhiteBackground($logo_path);
            } elseif (file_exists(public_path($certificate->logo_sekolah))) {
                $logo_path = public_path($certificate->logo_sekolah);
                $logo_base64 = Certificate::removeWhiteBackground($logo_path);
            }
        }

        // Convert signature to Base64 with white background removed to bypass symlink and background issues
        $signature_base64 = null;
        if ($certificate->tanda_tangan) {
            $sig_path = storage_path('app/public/' . $certificate->tanda_tangan);
            if (file_exists($sig_path)) {
                $signature_base64 = Certificate::removeWhiteBackground($sig_path);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'code' => $certificate->code,
                'nomor_sertifikat' => $certificate->nomor_sertifikat,
                'nama_siswa' => $certificate->nama_siswa,
                'nis' => $certificate->nis,
                'ekskul' => $certificate->ekskul,
                'jenis_sertifikat' => $certificate->jenis_sertifikat,
                'prestasi' => $certificate->prestasi ?? '-',
                'tanggal' => $certificate->tanggal->translatedFormat('d F Y'),
                'nama_pembina' => $certificate->nama_pembina,
                'jabatan_pembina' => $certificate->jabatan_pembina,
                'logo_base64' => $logo_base64,
                'signature_base64' => $signature_base64,
                'verify_url' => route('verify', $certificate->code),
                'pdf_url' => route('download.pdf', $certificate->code),
            ]
        ]);
    }

    /**
     * Unduh sertifikat format PDF dan catat riwayat download.
     */
    public function downloadPdf($code)
    {
        $certificate = Certificate::where('code', $code)
            ->where('status', 'Aktif')
            ->firstOrFail();

        // Catat riwayat download
        DownloadHistory::create([
            'certificate_id' => $certificate->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Muat template PDF sertifikat dengan orientasi Lanskap A4
        $pdf = Pdf::loadView('certificates.pdf', compact('certificate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("Sertifikat-{$certificate->nama_siswa}-{$certificate->code}.pdf");
    }

    /**
     * Halaman verifikasi publik (QR Code target).
     */
    public function verify($code)
    {
        $certificate = Certificate::where('code', $code)
            ->where('status', 'Aktif')
            ->first();

        $isValid = !empty($certificate);

        return view('verify', compact('certificate', 'isValid', 'code'));
    }
}
