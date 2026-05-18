<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Urusan extends Model
{
    protected $table = 'urusan';
    protected $fillable = ['kategori_id', 'uuid', 'label', 'slug', 'deskripsi'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(UrusanKategori::class, 'kategori_id');
    }
}
