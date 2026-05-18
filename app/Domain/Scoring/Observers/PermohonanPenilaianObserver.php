<?php

namespace App\Domain\Scoring\Observers;

use App\Domain\Scoring\Models\PermohonanPenilaian;

class PermohonanPenilaianObserver
{
    /**
     * Handle the PermohonanPenilaian "created" event.
     */
    public function created(PermohonanPenilaian $penilaian): void
    {
        // Log penilaian creation if needed
    }

    /**
     * Handle the PermohonanPenilaian "updated" event.
     */
    public function updated(PermohonanPenilaian $penilaian): void
    {
        // Log penilaian update if needed
    }

    /**
     * Handle the PermohonanPenilaian "deleted" event.
     */
    public function deleted(PermohonanPenilaian $penilaian): void
    {
        //
    }

    /**
     * Handle the PermohonanPenilaian "restored" event.
     */
    public function restored(PermohonanPenilaian $penilaian): void
    {
        //
    }

    /**
     * Handle the PermohonanPenilaian "force deleted" event.
     */
    public function forceDeleted(PermohonanPenilaian $penilaian): void
    {
        //
    }
}
