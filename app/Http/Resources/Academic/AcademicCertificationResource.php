<?php

namespace App\Http\Resources\Academic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\Academic\CertificationLevelResource;
use App\Http\Resources\Academic\AccreditationEntityResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\Institution\AcademicResource;

class AcademicCertificationResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'certifying_entity' => $this->certifying_entity,
            'issue_date' => $this->issue_date,
            'expiry_date' => $this->expiry_date,
            'is_active' => $this->is_active,
            'validity_duration' => $this->validity_duration,

            'country_id' => $this->country_id,
            'accreditation_entity_id' => $this->accreditation_entity_id,
            'certification_level_id' => $this->certification_level_id,
            'status_id' => $this->status_id,

            'country' => new CountryResource($this->whenLoaded('country')),
            'accreditation_entity' => new AccreditationEntityResource($this->whenLoaded('accreditationEntity')),
            'certification_level' => new CertificationLevelResource($this->whenLoaded('certificationLevel')),
            'status' => new CertificationStatusResource($this->whenLoaded('status')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'academic' => new AcademicResource($this->whenLoaded('academic')),
        ];
    }
}
