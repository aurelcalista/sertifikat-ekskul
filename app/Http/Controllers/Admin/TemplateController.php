<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Tampilkan semua daftar template background sertifikat.
     */
    public function index()
    {
        $templates = Template::all();
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Simpan template baru (upload gambar background / pilih layout vector).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'layout' => 'nullable|string|max:100',
            'background_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $background_path = null;
        if ($request->hasFile('background_file')) {
            $background_path = $request->file('background_file')->store('templates', 'public');
        }

        Template::create([
            'name' => $request->name,
            'layout' => $request->input('layout', 'classic_gold'),
            'background_path' => $background_path,
            'is_default' => false,
        ]);

        return redirect()->route('admin.templates.index')->with('success', 'Template baru berhasil ditambahkan.');
    }

    /**
     * Atur template default untuk pembuatan sertifikat.
     */
    public function setDefault($id)
    {
        $template = Template::findOrFail($id);

        // Set semua template lain menjadi false
        Template::where('is_default', true)->update(['is_default' => false]);

        // Set template yang dipilih menjadi true
        $template->update(['is_default' => true]);

        // Update sertifikat tanpa background kustom ke template default baru
        \App\Models\Certificate::whereNull('background_path')->update(['template_id' => $template->id]);

        return redirect()->route('admin.templates.index')->with('success', "Template '{$template->name}' sekarang menjadi template default dan diterapkan pada sertifikat.");
    }

    /**
     * Hapus template beserta berkas gambarnya.
     */
    public function destroy($id)
    {
        $template = Template::findOrFail($id);

        if ($template->is_default) {
            return redirect()->route('admin.templates.index')->with('error', 'Template default tidak dapat dihapus. Silakan set template lain sebagai default terlebih dahulu.');
        }

        // Hapus file gambarnya
        if ($template->background_path) {
            Storage::disk('public')->delete($template->background_path);
        }

        $template->delete();

        return redirect()->route('admin.templates.index')->with('success', 'Template berhasil dihapus.');
    }
}
