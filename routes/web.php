<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PermohonanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('sso.authorize'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Login/logout aliases pointing to SSO routes
Route::redirect('/login', '/oauth/sso/authorize')->name('login');
Route::get('/logout', fn () => redirect()->route('sso.logout'))->name('logout');

// Protected routes
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'user' => auth()->user(),
        ]);
    })->name('dashboard');

    // Permohonan routes
    Route::middleware('submission.window')->group(function () {
        Route::resource('permohonan', PermohonanController::class);
        Route::post('permohonan/{permohonan}/submit', [PermohonanController::class, 'submit'])
            ->name('permohonan.submit');

        // File upload routes
        Route::post('permohonan/{permohonan}/upload', [FileUploadController::class, 'upload'])
            ->name('file.upload');
        Route::delete('file/{file}', [FileUploadController::class, 'destroy'])
            ->name('file.destroy');
    });

    // File download (no submission window check)
    Route::get('download/{file}', [FileUploadController::class, 'download'])
        ->name('file.download');
});
