<?php

namespace App\Policies;

use App\Models\Institution\InstitutionCertification;
use App\Models\User;
use App\Models\Institution\Institution;
use Illuminate\Auth\Access\Response;

class InstitutionCertificationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InstitutionCertification $institutionCertification): bool
    {
        return $institutionCertification->institution_id === $user->institution?->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InstitutionCertification $institutionCertification): bool
    {
        return $institutionCertification->institution_id === $user->institution?->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InstitutionCertification $institutionCertification): bool
    {
        return $institutionCertification->institution_id === $user->institution?->id;
    }

    /**
     * Determine whether the user can enable/disable the model.
     */
    public function enable(User $user, InstitutionCertification $institutionCertification): bool
    {
        return $institutionCertification->institution_id === $user->institution?->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InstitutionCertification $institutionCertification): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InstitutionCertification $institutionCertification): bool
    {
        return false;
    }
}
