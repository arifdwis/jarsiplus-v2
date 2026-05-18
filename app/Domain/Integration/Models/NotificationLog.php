<?php

namespace App\Domain\Integration\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $table = 'notification_logs';
    protected $fillable = ['user_id', 'type', 'title', 'message', 'data', 'read_at'];

    protected $casts = [
        'data' => 'json',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
