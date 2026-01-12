<?php

namespace App\Policies;

use App\Models\Institution\FacilityEquipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Institution\Institution;

class FacilityEquipmentPolicy
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
    public function view(User $user, FacilityEquipment $equipment): bool
    {
        return $equipment->facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
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
    public function update(User $user, FacilityEquipment $equipment): bool
    {
        return $equipment->facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FacilityEquipment $equipment): bool
    {
        return $equipment->department->institution_id === Institution::where('user_id', $user->id)->value('id');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FacilityEquipment $facilityEquipment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FacilityEquipment $facilityEquipment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can enable/disable the model.
     */    
    public function enable(User $user, FacilityEquipment $equipment): bool
    {
        return $equipment->facility->department->institution_id === Institution::where('user_id', $user->id)->value('id');
    }
}
