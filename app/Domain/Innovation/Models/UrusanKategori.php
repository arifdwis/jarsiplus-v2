<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UrusanKategori extends Model
{
    protected $table = 'urusan_kategori';
    protected $fillable = ['uuid', 'label', 'slug', 'deskripsi'];

    public function urusans(): HasMany
    {
        return $this->hasMany(Urusan::class, 'kategori_id');
    }
}
