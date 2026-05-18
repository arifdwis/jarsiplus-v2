<?php

namespace App\Domain\DataDukung\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanFile extends Model
{
    use SoftDeletes;

    protected $table = 'permohonan_file';

    protected $fillable = [
        'id_permohonan', 'inovasi_penilaian_id', 'uuid', 'label',
        'deskripsi', 'status', 'file', 'slug', 'nomor_surat', 'jenis', 'url',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(\App\Domain\Innovation\Models\Permohonan::class, 'id_permohonan');
    }
}
