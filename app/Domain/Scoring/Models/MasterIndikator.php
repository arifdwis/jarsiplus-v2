<?php

namespace App\Domain\Scoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterIndikator extends Model
{
    use SoftDeletes;

    protected $table = 'master_indikator';
    protected $fillable = ['uuid', 'label', 'deskripsi', 'slug', 'informasi_data_dukung'];

    public function parameters(): HasMany
    {
        return $this->hasMany(MasterParameter::class, 'indikator_id');
    }
}
