<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return redirect()->route('admin.settings.index');
    }

    /**
     * Perbarui data profil admin (Nama, Email, Foto Profil & Password).
     */
    public function update(Request $request)
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'avatar_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Upload Foto Profil jika ada
        if ($request->hasFile('avatar_file')) {
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $avatarPath = $request->file('avatar_file')->store('avatars', 'public');
            $admin->avatar = $avatarPath;
        }

        // Perbarui Nama dan Email
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Perbarui Password jika diisi
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
            }
            $admin->password = Hash::make($request->new_password);
        }

        $admin->save();

        return redirect()->route('admin.settings.index')->with('success', 'Profil admin berhasil diperbarui.');
    }

    /**
     * Tambah Akun Admin Baru.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'avatar_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar_file')) {
            $avatarPath = $request->file('avatar_file')->store('avatars', 'public');
        }

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Akun Admin Baru berhasil ditambahkan.');
    }

    /**
     * Hapus Akun Admin.
     */
    public function destroyAdmin($id)
    {
        $currentAdmin = auth()->guard('admin')->user();
        if ($currentAdmin->id == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin = Admin::findOrFail($id);
        if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $admin->delete();

        return redirect()->route('admin.settings.index')->with('success', 'Akun Admin berhasil dihapus.');
    }
}
