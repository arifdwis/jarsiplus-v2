<?php

namespace App\Domain\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Laman extends Model
{
    protected $table = 'laman';
    protected $fillable = ['uuid', 'label', 'slug', 'content', 'status', 'id_operator'];

    public function operator()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_operator');
    }
}
