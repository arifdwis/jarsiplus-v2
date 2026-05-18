<?php

namespace App\Jobs;

use App\Domain\Integration\Services\JuriService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncJuriScoring implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $permohonanId,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(JuriService $juriService): void
    {
        $scoring = $juriService->getScoring($this->permohonanId);
        
        if (!empty($scoring)) {
            // Process and store scoring data
            // This would typically update PermohonanPenilaian records
        }
    }
}
