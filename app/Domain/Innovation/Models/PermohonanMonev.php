<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanMonev extends Model
{
    protected $table = 'permohonan_monev';
    protected $fillable = ['id_permohonan', 'tanggal_monev', 'hasil_monev', 'catatan', 'monev_by'];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    public function monevBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'monev_by');
    }
}
