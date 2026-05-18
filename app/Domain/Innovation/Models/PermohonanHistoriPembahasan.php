<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermohonanHistoriPembahasan extends Model
{
    protected $table = 'permohonan_histori_pembahasan';
    protected $fillable = ['id_permohonan', 'tanggal_pembahasan', 'hasil_pembahasan', 'catatan'];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    public function validasis(): HasMany
    {
        return $this->hasMany(PermohonanHistoriPembahasanValidasi::class, 'id_pembahasan');
    }
}
