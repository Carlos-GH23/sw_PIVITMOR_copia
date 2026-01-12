<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationRegistrationResource extends JsonResource
{
    use DateFormat;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'organization_type' => $this->organization_type,
            'organization_sector' => $this->organization_sector,
            'state_id' => $this->state_id,
            'municipality_id' => $this->municipality_id,
            'organization_registration_status_id' => $this->organization_registration_status_id,
            'rejection_reason' => $this->rejection_reason,

            'state' => new StateResource($this->whenLoaded('state')),
            'municipality' => new MunicipalityResource($this->whenLoaded('municipality')),
            'status' => new OrganizationRegistrationStatusResource($this->whenLoaded('organizationRegistrationStatus')),

            'created_at' => $this->textFormatDate($this->created_at),
        ];
    }
}
