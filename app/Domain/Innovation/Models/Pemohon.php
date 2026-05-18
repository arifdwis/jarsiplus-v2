<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemohon extends Model
{
    protected $table = 'pemohon';

    protected $fillable = [
        'id_operator', 'uuid', 'name', 'foto', 'jabatan', 'unit_kerja',
        'nip', 'nik', 'nik_file', 'slug', 'email', 'phone', 'nickname',
        'address', 'kota', 'kota_id', 'gender', 'date_birth',
    ];

    protected $casts = [
        'date_birth' => 'date',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'id_operator');
    }

    public function permohonan(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'id_pemohon_0');
    }
}
