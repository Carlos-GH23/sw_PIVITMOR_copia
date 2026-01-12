<?php

namespace App\Policies;

use App\Models\AcademicGroups\AcademicBody;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AcademicBodyPolicy
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
    public function view(User $user, AcademicBody $academicBody): bool
    {
        return $user->institution->id === $academicBody->department->institution_id;
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
    public function update(User $user, AcademicBody $academicBody): bool
    {
        return $user->institution->id === $academicBody->department->institution_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AcademicBody $academicBody): bool
    {
        return $user->institution->id === $academicBody->department->institution_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AcademicBody $academicBody): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AcademicBody $academicBody): bool
    {
        return false;
    }

    /**
     * Determine whether the user can enable the model.
     */
    public function enable(User $user, AcademicBody $academicBody): bool
    {
        return $user->institution->id === $academicBody->department->institution_id;
    }
}
