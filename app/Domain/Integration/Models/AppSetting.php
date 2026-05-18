<?php

namespace App\Domain\Integration\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_settings';
    protected $fillable = ['key', 'value', 'type', 'group', 'label', 'description', 'is_public', 'updated_by'];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
