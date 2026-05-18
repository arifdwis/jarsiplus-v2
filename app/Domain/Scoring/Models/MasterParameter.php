<?php

namespace App\Domain\Scoring\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterParameter extends Model
{
    use SoftDeletes;

    protected $table = 'master_parameter';
    protected $fillable = ['indikator_id', 'uuid', 'label', 'slug', 'deskripsi', 'bobot'];

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(MasterIndikator::class, 'indikator_id');
    }
}
