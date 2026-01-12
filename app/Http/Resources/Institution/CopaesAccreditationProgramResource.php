<?php

namespace App\Http\Resources\Institution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CopaesAccreditationProgramResource extends JsonResource
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
            'copaes_accreditation_id' => $this->copaes_accreditation_id,
            'copaes_accreditation' => new CopaesAccreditationResource($this->whenLoaded('copaesAccreditation')),
            'created_at' => $this->created_at,
        ];
    }
}
