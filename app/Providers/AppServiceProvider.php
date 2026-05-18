<?php

namespace App\Providers;

use App\Domain\DataDukung\Models\PermohonanFile;
use App\Domain\DataDukung\Observers\PermohonanFileObserver;
use App\Domain\Innovation\Models\Permohonan;
use App\Domain\Innovation\Models\PermohonanApprove;
use App\Domain\Innovation\Observers\PermohonanApproveObserver;
use App\Domain\Innovation\Observers\PermohonanObserver;
use App\Domain\Scoring\Models\PermohonanPenilaian;
use App\Domain\Scoring\Observers\PermohonanPenilaianObserver;
use App\Policies\PermohonanFilePolicy;
use App\Policies\PermohonanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        Permohonan::observe(PermohonanObserver::class);
        PermohonanFile::observe(PermohonanFileObserver::class);
        PermohonanPenilaian::observe(PermohonanPenilaianObserver::class);
        PermohonanApprove::observe(PermohonanApproveObserver::class);

        // Register authorization policies
        Gate::policy(Permohonan::class, PermohonanPolicy::class);
        Gate::policy(PermohonanFile::class, PermohonanFilePolicy::class);
    }
}
