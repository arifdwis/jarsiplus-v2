<?php

namespace App\Domain\Scoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanPenilaian extends Model
{
    protected $table = 'permohonan_penilaian';

    protected $fillable = [
        'uuid', 'inovasi_id', 'indikator_id', 'parameter_id',
        'label_indikator', 'label_parameter', 'bobot', 'status',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Innovation\Models\Permohonan::class, 'inovasi_id');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(MasterIndikator::class, 'indikator_id');
    }

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(MasterParameter::class, 'parameter_id');
    }
}
