<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PemohonCorporate extends Model
{
    protected $table = 'pemohon_corporate';
    protected $fillable = ['uuid', 'nama_perusahaan', 'email', 'telepon', 'alamat', 'kota_id', 'provinsi_id'];

    public function permohonan(): HasMany
    {
        return $this->hasMany(Permohonan::class, 'pemohon_corporate_id');
    }
}
