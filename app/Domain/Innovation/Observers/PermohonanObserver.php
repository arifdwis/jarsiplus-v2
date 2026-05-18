<?php

namespace App\Domain\Innovation\Observers;

use App\Domain\Innovation\Models\Permohonan;
use App\Domain\Innovation\Models\PermohonanHistori;

class PermohonanObserver
{
    /**
     * Handle the Permohonan "created" event.
     */
    public function created(Permohonan $permohonan): void
    {
        PermohonanHistori::create([
            'id_permohonan' => $permohonan->id,
            'status_lama' => null,
            'status_baru' => $permohonan->status ?? 'draft',
            'keterangan' => 'Permohonan dibuat',
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Handle the Permohonan "updated" event.
     */
    public function updated(Permohonan $permohonan): void
    {
        if ($permohonan->isDirty('status')) {
            PermohonanHistori::create([
                'id_permohonan' => $permohonan->id,
                'status_lama' => $permohonan->getOriginal('status'),
                'status_baru' => $permohonan->status,
                'keterangan' => "Status berubah dari {$permohonan->getOriginal('status')} menjadi {$permohonan->status}",
                'user_id' => auth()->id(),
            ]);
        }
    }

    /**
     * Handle the Permohonan "deleted" event.
     */
    public function deleted(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "restored" event.
     */
    public function restored(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "force deleted" event.
     */
    public function forceDeleted(Permohonan $permohonan): void
    {
        //
    }
}
