<?php

namespace App\Http\Resources\Institution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CieesAccreditationProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'expiry_date' => $this->expiry_date,
            'level' => $this->level,
            'ciees_accreditation_id' => $this->ciees_accreditation_id,
            'ciees_accreditation' => new CieesAccreditationResource($this->whenLoaded('cieesAccreditation')),
            'created_at' => $this->created_at,
        ];
    }
}
