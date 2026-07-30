<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Middleware\AuthenticateAdmin;
use Illuminate\Support\Facades\Route;

// Public Siswa Routes
Route::get('/', [SiswaController::class, 'index'])->name('home');
Route::get('/download', [SiswaController::class, 'downloadView'])->name('download.view');
Route::post('/download/search', [SiswaController::class, 'search'])->name('download.search');
Route::get('/download/{code}/pdf', [SiswaController::class, 'downloadPdf'])->name('download.pdf');
Route::get('/verify/{code}', [SiswaController::class, 'verify'])->name('verify');

// Admin Guest Routes
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

// Admin Auth Routes
Route::middleware(AuthenticateAdmin::class)->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/download-histories', [DashboardController::class, 'downloadHistories'])->name('download-histories');

    // Certificates CRUD
    Route::get('/certificates/export/excel', [CertificateController::class, 'exportExcel'])->name('certificates.export.excel');
    Route::get('/certificates/export/pdf', [CertificateController::class, 'exportPdf'])->name('certificates.export.pdf');
    Route::get('/certificates/preview', [CertificateController::class, 'preview'])->name('certificates.preview');
    Route::post('/certificates/preview/search', [CertificateController::class, 'search'])->name('certificates.preview.search');
    Route::resource('/certificates', CertificateController::class);

    // Templates CRUD
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::delete('/templates/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy');
    Route::post('/templates/{id}/default', [TemplateController::class, 'setDefault'])->name('templates.default');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
