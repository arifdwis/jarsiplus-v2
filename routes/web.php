<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

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
| Protected routes (requires SSO authenticated session)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('Dashboard', [
            'user' => auth()->user(),
        ]);
    })->name('dashboard');

    // Permohonan (innovator portal)
    Route::middleware('submission.window')->group(function () {
        Route::resource('permohonan', PermohonanController::class);
        Route::post('permohonan/{permohonan}/submit', [PermohonanController::class, 'submit'])
            ->name('permohonan.submit');

        Route::post('permohonan/{permohonan}/upload', [FileUploadController::class, 'upload'])
            ->name('file.upload');
        Route::delete('file/{file}', [FileUploadController::class, 'destroy'])
            ->name('file.destroy');
    });

    Route::get('download/{file}', [FileUploadController::class, 'download'])
        ->name('file.download');
});
