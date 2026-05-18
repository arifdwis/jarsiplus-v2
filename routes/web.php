<?php

use App\Http\Controllers\ComingSoonController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public routes (no auth required)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'welcome'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/inovasi', [PublicController::class, 'inovasiIndex'])->name('inovasi.index');
Route::get('/inovasi/{slug}', [PublicController::class, 'inovasiShow'])->name('inovasi.show');
Route::get('/laman/{slug}', [PublicController::class, 'laman'])->name('laman.show');

/*
|--------------------------------------------------------------------------
| Auth (SSO) — login/logout aliases
|--------------------------------------------------------------------------
*/
Route::redirect('/login', '/oauth/sso/authorize')->name('login');
Route::get('/logout', fn () => redirect()->route('sso.logout'))->name('logout');

/*
|--------------------------------------------------------------------------
| Protected routes (authenticated SSO session)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', ['user' => auth()->user()]);
    })->name('dashboard');

    Route::get('/profil', fn () => app(ComingSoonController::class)('Profil Saya', 'Edit profil pemohon, NIP, jabatan, unit kerja, foto', 'pi pi-user'))->name('profil');
    Route::get('/notifikasi', fn () => app(ComingSoonController::class)('Notifikasi', 'Inbox notifikasi sistem', 'pi pi-bell'))->name('notifikasi');

    /*
    |----------------------------------------------------------------------
    | /jarsiplus/* — Innovator portal (matches DB menu URIs)
    |----------------------------------------------------------------------
    */
    Route::prefix('jarsiplus')->name('jarsiplus.')->group(function () {
        Route::middleware('submission.window')->group(function () {
            Route::resource('permohonan', PermohonanController::class);
            Route::post('permohonan/{permohonan}/submit', [PermohonanController::class, 'submit'])->name('permohonan.submit');
            Route::post('permohonan/{permohonan}/upload', [FileUploadController::class, 'upload'])->name('file.upload');
            Route::delete('file/{file}', [FileUploadController::class, 'destroy'])->name('file.destroy');
        });

        Route::get('pemohon', fn () => app(ComingSoonController::class)('Pemohon', 'Daftar pemohon ASN/instansi', 'pi pi-users'))->name('pemohon');
        Route::get('logpermohonan', fn () => app(ComingSoonController::class)('Log Permohonan', 'Audit trail seluruh permohonan', 'pi pi-history'))->name('logpermohonan');
        Route::get('laman', fn () => app(ComingSoonController::class)('Laman CMS', 'Halaman CMS', 'pi pi-file'))->name('laman');
        Route::get('arsip', fn () => app(ComingSoonController::class)('Arsip', 'Arsip permohonan tahun-tahun lalu', 'pi pi-inbox'))->name('arsip');
    });

    /*
    |----------------------------------------------------------------------
    | /jarsiplus/file/{id} — file download (no submission window)
    |----------------------------------------------------------------------
    */
    Route::get('jarsiplus/download/{file}', [FileUploadController::class, 'download'])->name('jarsiplus.file.download');

    /*
    |----------------------------------------------------------------------
    | /master/* — Master data
    |----------------------------------------------------------------------
    */
    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/', fn () => app(ComingSoonController::class)('Master Data', 'Kelola seluruh master data sistem', 'pi pi-folder'))->name('index');
        Route::get('kategori', fn () => app(ComingSoonController::class)('Kategori Urusan', 'CRUD kategori urusan pemerintahan', 'pi pi-list'))->name('kategori');
        Route::get('indikator', fn () => app(ComingSoonController::class)('Indikator Penilaian', 'CRUD indikator + parameter', 'pi pi-list'))->name('indikator');
    });

    /*
    |----------------------------------------------------------------------
    | /wilayah/* — Region master
    |----------------------------------------------------------------------
    */
    Route::prefix('wilayah')->name('wilayah.')->group(function () {
        Route::get('/', fn () => app(ComingSoonController::class)('Wilayah', 'Kelola data wilayah', 'pi pi-map'))->name('index');
        Route::get('provinsi', fn () => app(ComingSoonController::class)('Provinsi', 'CRUD provinsi', 'pi pi-building'))->name('provinsi');
        Route::get('kota', fn () => app(ComingSoonController::class)('Kota / Kabupaten', 'CRUD kota & kabupaten', 'pi pi-building'))->name('kota');
    });

    /*
    |----------------------------------------------------------------------
    | /support/* — CMS
    |----------------------------------------------------------------------
    */
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', fn () => app(ComingSoonController::class)('Support', 'Konten dukungan publik', 'pi pi-megaphone'))->name('index');
        Route::get('faq', fn () => app(ComingSoonController::class)('FAQ', 'CRUD FAQ', 'pi pi-question-circle'))->name('faq');
        Route::get('slider', fn () => app(ComingSoonController::class)('Slider', 'CRUD slider home', 'pi pi-images'))->name('slider');
    });

    /*
    |----------------------------------------------------------------------
    | /settings/* — System settings (Superadmin)
    |----------------------------------------------------------------------
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn () => app(ComingSoonController::class)('Pengaturan Sistem', 'Settings, roles, permissions, menu', 'pi pi-cog'))->name('index');
        Route::get('users', fn () => app(ComingSoonController::class)('Users', 'Manage users', 'pi pi-users'))->name('users');
        Route::get('roles', fn () => app(ComingSoonController::class)('Roles', 'Manage roles', 'pi pi-id-card'))->name('roles');
        Route::get('permission', fn () => app(ComingSoonController::class)('Permissions', 'Manage permissions', 'pi pi-shield'))->name('permission');
        Route::get('menu', fn () => app(ComingSoonController::class)('Menu', 'Manage navigation menu', 'pi pi-sitemap'))->name('menu');
        Route::get('log-activity', fn () => app(ComingSoonController::class)('Log Activity', 'Audit log aktivitas', 'pi pi-history'))->name('log-activity');
    });

    /*
    |----------------------------------------------------------------------
    | Backward-compat: /permohonan/* alias to /jarsiplus/permohonan/*
    |----------------------------------------------------------------------
    */
    Route::redirect('/permohonan', '/jarsiplus/permohonan');
});
