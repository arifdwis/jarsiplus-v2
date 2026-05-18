<?php

namespace App\Domain\Innovation\Observers;

use App\Domain\Innovation\Models\PermohonanApprove;
use App\Domain\Integration\Models\UserActivity;

class PermohonanApproveObserver
{
    /**
     * Handle the PermohonanApprove "created" event.
     */
    public function created(PermohonanApprove $approve): void
    {
        UserActivity::create([
            'user_id' => auth()->id(),
            'activity' => 'approval_created',
            'description' => "Approval {$approve->status_approve} untuk permohonan #{$approve->id_permohonan}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the PermohonanApprove "updated" event.
     */
    public function updated(PermohonanApprove $approve): void
    {
        if ($approve->isDirty('status_approve')) {
            UserActivity::create([
                'user_id' => auth()->id(),
                'activity' => 'approval_updated',
                'description' => "Approval status berubah menjadi {$approve->status_approve} untuk permohonan #{$approve->id_permohonan}",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    /**
     * Handle the PermohonanApprove "deleted" event.
     */
    public function deleted(PermohonanApprove $approve): void
    {
        //
    }

    /**
     * Handle the PermohonanApprove "restored" event.
     */
    public function restored(PermohonanApprove $approve): void
    {
        //
    }

    /**
     * Handle the PermohonanApprove "force deleted" event.
     */
    public function forceDeleted(PermohonanApprove $approve): void
    {
        //
    }
}
