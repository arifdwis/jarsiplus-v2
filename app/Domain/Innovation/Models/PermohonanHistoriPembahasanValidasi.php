<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanHistoriPembahasanValidasi extends Model
{
    protected $table = 'permohonan_histori_pembahasan_validasi';
    protected $fillable = ['id_pembahasan', 'validator_id', 'status_validasi', 'catatan'];

    public function pembahasan(): BelongsTo
    {
        return $this->belongsTo(PermohonanHistoriPembahasan::class, 'id_pembahasan');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'validator_id');
    }
}
