<?php

namespace App\Domain\DataDukung\Observers;

use App\Domain\DataDukung\Models\PermohonanFile;
use App\Domain\Integration\Models\UserActivity;

class PermohonanFileObserver
{
    /**
     * Handle the PermohonanFile "created" event.
     */
    public function created(PermohonanFile $file): void
    {
        UserActivity::create([
            'user_id' => auth()->id(),
            'activity' => 'file_upload',
            'description' => "File '{$file->nama_file}' uploaded untuk permohonan #{$file->id_permohonan}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the PermohonanFile "updated" event.
     */
    public function updated(PermohonanFile $file): void
    {
        //
    }

    /**
     * Handle the PermohonanFile "deleted" event.
     */
    public function deleted(PermohonanFile $file): void
    {
        UserActivity::create([
            'user_id' => auth()->id(),
            'activity' => 'file_delete',
            'description' => "File '{$file->nama_file}' deleted dari permohonan #{$file->id_permohonan}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the PermohonanFile "restored" event.
     */
    public function restored(PermohonanFile $file): void
    {
        //
    }

    /**
     * Handle the PermohonanFile "force deleted" event.
     */
    public function forceDeleted(PermohonanFile $file): void
    {
        //
    }
}
