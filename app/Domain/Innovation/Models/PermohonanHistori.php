<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanHistori extends Model
{
    protected $table = 'permohonan_histori';

    protected $fillable = [
        'id_permohonan', 'id_operator', 'id_file', 'uuid', 'deskripsi', 'file',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'id_operator');
    }
}
