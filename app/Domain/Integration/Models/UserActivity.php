<?php

namespace App\Domain\Integration\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = 'user_activities';
    protected $fillable = ['user_id', 'activity', 'description', 'ip_address', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
