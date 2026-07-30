<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Setting;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    /**
     * Tampilkan data sertifikat dengan fitur pencarian, filter, dan pagination.
     */
    public function index(Request $request)
    {
        $query = Certificate::with('template');

        // Pencarian berdasarkan kode, nama, atau NIS
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nomor_sertifikat', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan ekskul
        if ($request->filled('ekskul')) {
            $query->where('ekskul', $request->input('ekskul'));
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $certificates = $query->latest()->paginate(10)->withQueryString();
        
        // Ambil opsi ekskul unik untuk dropdown filter
        $ekskul_list = Certificate::distinct()->pluck('ekskul')->filter()->toArray();

        return view('admin.certificates.index', compact('certificates', 'ekskul_list'));
    }

    /**
     * Tampilkan form tambah sertifikat dengan nilai default dari settings.
     */
    public function create()
    {
        $templates = Template::all();
        
        // Nilai default dari settings untuk mempercepat pengisian
        $default_sekolah = Setting::get('sekolah_default', '');
        $default_pembina = Setting::get('pembina_default', '');
        $default_jabatan = Setting::get('jabatan_pembina_default', '');

        return view('admin.certificates.create', compact('templates', 'default_sekolah', 'default_pembina', 'default_jabatan'));
    }

    /**
     * Simpan sertifikat baru beserta upload berkas logo, ttd, background.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:50',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'ekskul' => 'required|string|max:100',
            'jenis_sertifikat' => 'required|string|max:100',
            'nomor_sertifikat' => 'required|string|max:100',
            'prestasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'nama_pembina' => 'required|string|max:255',
            'jabatan_pembina' => 'required|string|max:255',
            'template_id' => 'required|exists:templates,id',
            'status' => 'required|in:Aktif,Draft',
            'background_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'logo_sekolah_file' => 'nullable|image|mimes:png,jpg,jpeg|max:1048',
            'tanda_tangan_file' => 'nullable|image|mimes:png|max:1048',
        ]);

        $data = $validated;

        // Upload custom background
        if ($request->hasFile('background_file')) {
            $data['background_path'] = $request->file('background_file')->store('backgrounds', 'public');
        }

        // Upload logo sekolah (gunakan default setting jika kosong)
        if ($request->hasFile('logo_sekolah_file')) {
            $data['logo_sekolah'] = $request->file('logo_sekolah_file')->store('logos', 'public');
        } else {
            $data['logo_sekolah'] = Setting::get('logo_default');
        }

        // Upload tanda tangan (gunakan default setting jika kosong)
        if ($request->hasFile('tanda_tangan_file')) {
            $data['tanda_tangan'] = $request->file('tanda_tangan_file')->store('signatures', 'public');
        } else {
            $data['tanda_tangan'] = Setting::get('tanda_tangan_default');
        }

        Certificate::create($data);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil dibuat.');
    }

    /**
     * Tampilkan detail/form edit sertifikat.
     */
    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        $templates = Template::all();
        return view('admin.certificates.edit', compact('certificate', 'templates'));
    }

    /**
     * Perbarui data sertifikat beserta berkas upload.
     */
    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|max:50',
            'sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'ekskul' => 'required|string|max:100',
            'jenis_sertifikat' => 'required|string|max:100',
            'nomor_sertifikat' => 'required|string|max:100',
            'prestasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'nama_pembina' => 'required|string|max:255',
            'jabatan_pembina' => 'required|string|max:255',
            'template_id' => 'required|exists:templates,id',
            'status' => 'required|in:Aktif,Draft',
            'background_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'logo_sekolah_file' => 'nullable|image|mimes:png,jpg,jpeg|max:1048',
            'tanda_tangan_file' => 'nullable|image|mimes:png|max:1048',
        ]);

        $data = $validated;

        // Upload custom background baru
        if ($request->hasFile('background_file')) {
            if ($certificate->background_path) {
                Storage::disk('public')->delete($certificate->background_path);
            }
            $data['background_path'] = $request->file('background_file')->store('backgrounds', 'public');
        }

        // Upload logo sekolah baru
        if ($request->hasFile('logo_sekolah_file')) {
            if ($certificate->logo_sekolah && $certificate->logo_sekolah !== Setting::get('logo_default')) {
                Storage::disk('public')->delete($certificate->logo_sekolah);
            }
            $data['logo_sekolah'] = $request->file('logo_sekolah_file')->store('logos', 'public');
        }

        // Upload tanda tangan baru
        if ($request->hasFile('tanda_tangan_file')) {
            if ($certificate->tanda_tangan && $certificate->tanda_tangan !== Setting::get('tanda_tangan_default')) {
                Storage::disk('public')->delete($certificate->tanda_tangan);
            }
            $data['tanda_tangan'] = $request->file('tanda_tangan_file')->store('signatures', 'public');
        }

        $certificate->update($data);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    /**
     * Hapus data sertifikat beserta berkasnya.
     */
    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Hapus file kustom jika ada
        if ($certificate->background_path) {
            Storage::disk('public')->delete($certificate->background_path);
        }
        if ($certificate->logo_sekolah && $certificate->logo_sekolah !== Setting::get('logo_default')) {
            Storage::disk('public')->delete($certificate->logo_sekolah);
        }
        if ($certificate->tanda_tangan && $certificate->tanda_tangan !== Setting::get('tanda_tangan_default')) {
            Storage::disk('public')->delete($certificate->tanda_tangan);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    /**
     * Ekspor data sertifikat ke file CSV (dapat dibuka langsung di Excel).
     */
    public function exportExcel()
    {
        $certificates = Certificate::all();
        $filename = 'sertifikat-export-' . date('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($certificates) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM untuk excel agar encoding UTF-8 terbaca dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header kolom
            fputcsv($file, [
                'Kode Sertifikat', 'Nomor Sertifikat', 'Nama Siswa', 'NIS', 'Sekolah',
                'Kelas', 'Ekskul', 'Jenis Sertifikat', 'Prestasi', 'Tanggal',
                'Nama Pembina', 'Jabatan Pembina', 'Status'
            ], ';');

            foreach ($certificates as $cert) {
                fputcsv($file, [
                    $cert->code,
                    $cert->nomor_sertifikat,
                    $cert->nama_siswa,
                    $cert->nis,
                    $cert->sekolah,
                    $cert->kelas,
                    $cert->ekskul,
                    $cert->jenis_sertifikat,
                    $cert->prestasi ?? '-',
                    $cert->tanggal->format('Y-m-d'),
                    $cert->nama_pembina,
                    $cert->jabatan_pembina,
                    $cert->status
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor rekap data sertifikat ke format PDF.
     */
    public function exportPdf()
    {
        $certificates = Certificate::latest()->get();
        $pdf = Pdf::loadView('admin.certificates.export_pdf_list', compact('certificates'));
        
        return $pdf->download('rekap-sertifikat-' . date('Ymd-His') . '.pdf');
    }

    /**
     * Tampilkan halaman pratinjau sertifikat khusus admin.
     */
    public function preview()
    {
        return view('admin.certificates.preview');
    }

    /**
     * AJAX search untuk pratinjau sertifikat admin (bisa mencari yang Draft juga).
     */
    public function search(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $certificate = Certificate::with('template')
            ->where('code', trim($request->code))
            ->first();

        if (!$certificate) {
            return response()->json([
                'success' => false,
                'message' => 'Kode sertifikat tidak ditemukan.',
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
                'sekolah' => $certificate->sekolah,
                'kelas' => $certificate->kelas,
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
                'edit_url' => route('admin.certificates.edit', $certificate->id),
                'status' => $certificate->status,
            ]
        ]);
    }
}
