<?php

namespace App\Policies;

use App\Domain\DataDukung\Models\PermohonanFile;
use App\Models\User;

class PermohonanFilePolicy
{
    /**
     * Determine if the user can view the file
     */
    public function view(User $user, PermohonanFile $file): bool
    {
        return $user->id === $file->permohonan->pemohon_id || $user->hasRole('administrator');
    }

    /**
     * Determine if the user can update the file
     */
    public function update(User $user, PermohonanFile $file): bool
    {
        return ($user->id === $file->permohonan->pemohon_id && $file->permohonan->status === 'draft') 
            || $user->hasRole('administrator');
    }

    /**
     * Determine if the user can delete the file
     */
    public function delete(User $user, PermohonanFile $file): bool
    {
        return ($user->id === $file->permohonan->pemohon_id && $file->permohonan->status === 'draft') 
            || $user->hasRole('administrator');
    }
}
