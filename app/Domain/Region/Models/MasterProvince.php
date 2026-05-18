<?php

namespace App\Domain\Region\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterProvince extends Model
{
    public $timestamps = false;
    protected $table = 'master_provinces';
    protected $fillable = ['country_id', 'name'];

    public function cities(): HasMany
    {
        return $this->hasMany(MasterCity::class, 'province_id');
    }
}
