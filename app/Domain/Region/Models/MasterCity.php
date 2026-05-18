<?php

namespace App\Domain\Region\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterCity extends Model
{
    public $timestamps = false;
    protected $table = 'master_cities';
    protected $fillable = ['province_id', 'name'];

    public function province(): BelongsTo
    {
        return $this->belongsTo(MasterProvince::class, 'province_id');
    }

    public function districts(): HasMany
    {
        return $this->hasMany(MasterDistrict::class, 'city_id');
    }
}
