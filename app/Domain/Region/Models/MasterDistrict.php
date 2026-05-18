<?php

namespace App\Domain\Region\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterDistrict extends Model
{
    public $timestamps = false;
    protected $table = 'master_districts';
    protected $fillable = ['city_id', 'name'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(MasterCity::class, 'city_id');
    }
}
