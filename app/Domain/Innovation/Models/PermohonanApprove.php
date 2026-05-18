<?php

namespace App\Domain\Innovation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanApprove extends Model
{
    protected $table = 'permohonan_approve';
    protected $fillable = ['id_permohonan', 'status_approve', 'catatan', 'approved_by', 'approved_at'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}
