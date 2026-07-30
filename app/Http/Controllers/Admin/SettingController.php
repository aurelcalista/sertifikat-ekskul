<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan form pengaturan sistem.
     */
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        $settings = [
            'app_name' => Setting::get('app_name', 'Sertifikat Ekskul'),
            'sekolah_default' => Setting::get('sekolah_default', ''),
            'pembina_default' => Setting::get('pembina_default', ''),
            'jabatan_pembina_default' => Setting::get('jabatan_pembina_default', ''),
            'logo_default' => Setting::get('logo_default', null),
            'tanda_tangan_default' => Setting::get('tanda_tangan_default', null),
        ];

        return view('admin.settings.index', compact('settings', 'admin'));
    }

    /**
     * Perbarui data pengaturan sistem beserta file logo/tanda tangan default.
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'sekolah_default' => 'nullable|string|max:255',
            'pembina_default' => 'nullable|string|max:255',
            'jabatan_pembina_default' => 'nullable|string|max:255',
            'logo_file' => 'nullable|image|mimes:png,jpg,jpeg|max:1048',
            'tanda_tangan_file' => 'nullable|image|mimes:png|max:1048',
        ]);

        Setting::set('app_name', $request->app_name);
        Setting::set('sekolah_default', $request->sekolah_default);
        Setting::set('pembina_default', $request->pembina_default);
        Setting::set('jabatan_pembina_default', $request->jabatan_pembina_default);

        // Upload Logo Default
        if ($request->hasFile('logo_file')) {
            $oldLogo = Setting::get('logo_default');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('logo_file')->store('logos', 'public');
            Setting::set('logo_default', $logoPath);
        }

        // Upload TTD Default
        if ($request->hasFile('tanda_tangan_file')) {
            $oldTtd = Setting::get('tanda_tangan_default');
            if ($oldTtd) {
                Storage::disk('public')->delete($oldTtd);
            }
            $ttdPath = $request->file('tanda_tangan_file')->store('signatures', 'public');
            Setting::set('tanda_tangan_default', $ttdPath);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
