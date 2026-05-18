<?php

namespace App\Policies;

use App\Domain\Innovation\Models\Permohonan;
use App\Models\User;

class PermohonanPolicy
{
    /**
     * Determine if the user can view the permohonan
     */
    public function view(User $user, Permohonan $permohonan): bool
    {
        return $user->id === $permohonan->pemohon_id || $user->hasRole('administrator');
    }

    /**
     * Determine if the user can create permohonan
     */
    public function create(User $user): bool
    {
        return $user->hasRole('pemohon') || $user->hasRole('administrator');
    }

    /**
     * Determine if the user can update the permohonan
     */
    public function update(User $user, Permohonan $permohonan): bool
    {
        return ($user->id === $permohonan->pemohon_id && $permohonan->status === 'draft') 
            || $user->hasRole('administrator');
    }

    /**
     * Determine if the user can delete the permohonan
     */
    public function delete(User $user, Permohonan $permohonan): bool
    {
        return ($user->id === $permohonan->pemohon_id && $permohonan->status === 'draft') 
            || $user->hasRole('administrator');
    }
}
