<?php

namespace App\Http\Resources\Institution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CieesAccreditationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'ciees_accreditation_programs' => CieesAccreditationProgramResource::collection($this->whenLoaded('cieesAccreditationPrograms')),
        ];
    }
}