<?php

namespace App\Domain\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';
    protected $fillable = ['id_operator', 'uuid', 'label', 'file', 'slug'];

    public function operator()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_operator');
    }
}
