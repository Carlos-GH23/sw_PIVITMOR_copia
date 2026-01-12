<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationRegistration extends Model
{
    protected $fillable = [
        'name',
        'email',
        'organization_type',
        'organization_sector',
        'state_id',
        'municipality_id',
        'organization_registration_status_id',
        'rejection_reason',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    public function organizationRegistrationStatus(): BelongsTo
    {
        return $this->belongsTo(OrganizationRegistrationStatus::class, 'organization_registration_status_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrganizationRegistrationStatus::class, 'organization_registration_status_id');
    }
}
