<?php

namespace App\Policies;

use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Institution\Institution;


class AcademicOfferingPolicy
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
    public function view(User $user, AcademicOffering $academicOffering): bool
    {
        return $user->id === $academicOffering->user_id;
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
    public function update(User $user, AcademicOffering $academicOffering): bool
    {
        return $user->id === $academicOffering->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AcademicOffering $academicOffering): bool
    {
        return $user->id === $academicOffering->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AcademicOffering $academicOffering): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AcademicOffering $academicOffering): bool
    {
        return false;
    }
}
