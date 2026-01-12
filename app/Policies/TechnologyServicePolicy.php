<?php

namespace App\Policies;

use App\Models\TechnologyService;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TechnologyServicePolicy
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
    public function view(User $user, TechnologyService $technologyService): bool
    {
        return $technologyService->user_id === $user->id || $technologyService->institution_id === $user->getInstitutionId();
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
    public function update(User $user, TechnologyService $technologyService): bool
    {
        return $user->id === $technologyService->user_id && ($technologyService->technology_service_status_id === 1 || $technologyService->technology_service_status_id === 4);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TechnologyService $technologyService): bool
    {
        return $user->id === $technologyService->user_id && $technologyService->technology_service_status_id !== 2;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TechnologyService $technologyService): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TechnologyService $technologyService): bool
    {
        return false;
    }

    public function evaluation(User $user, TechnologyService $technologyService): bool
    {
        return $technologyService->technology_service_status_id === 2 && $technologyService->institution_id === $user->institution?->id;
    }

    public function enable(User $user, TechnologyService $technologyService): bool
    {
        return $user->id === $technologyService->user_id || $technologyService->institution_id === $user->institution?->id;
    }

    public function validity(User $user, TechnologyService $technologyService): bool
    {
        return $technologyService->user_id === $user->id && $technologyService->technology_service_status_id === 6;
    }
}
