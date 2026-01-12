<?php

namespace App\Http\Resources\Academic;

use App\Http\Resources\CountryResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\Catalogs\KnowledgeAreaResource;
use App\Http\Resources\AcademicDegreeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicBackgroundResource extends JsonResource
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
            'academic_title' => $this->academic_title,
            'institution_name' => $this->institution_name,
            'academic_degree_id' => $this->academic_degree_id,
            'knowledge_area_id' => $this->knowledge_area_id,
            'country_id' => $this->country_id,
            'degree_obtained_at' => $this->degree_obtained_at,
            'certificate_number' => $this->certificate_number,
            'academic_degree' => new AcademicDegreeResource($this->whenLoaded('academicDegree')),
            'knowledge_area' => new KnowledgeAreaResource($this->whenLoaded('knowledgeArea')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}