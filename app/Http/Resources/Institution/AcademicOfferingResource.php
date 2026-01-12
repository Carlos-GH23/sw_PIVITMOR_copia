<?php

namespace App\Http\Resources\Institution;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\EntityResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\KeywordResource;
use App\Http\Resources\UserResource;

class AcademicOfferingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'description' => $this->description,
            'objective' => $this->objective,
            'graduate_profile' => $this->graduate_profile,
            'website' => $this->website,
            'semester_cost' => $this->semester_cost,
            'duration_months' => $this->duration_months,
            'revoe' => $this->revoe,
            'fimpes_accreditation_id' => $this->fimpes_accreditation_id,

            'educational_level' => new EducationalLevelResource($this->whenLoaded('educationalLevel')),
            'study_mode' => new StudyModeResource($this->whenLoaded('studyMode')),
            'postgraduate_detail' => new PostgraduateDetailsResource($this->whenLoaded('postgraduateDetail')),

            'copaes_accreditation_program' => new CopaesAccreditationProgramResource($this->whenLoaded('copaesAccreditationProgram')),
            'ciees_accreditation_program' => new CieesAccreditationProgramResource($this->whenLoaded('cieesAccreditationProgram')),
            'fimpes_accreditation' => new FimpesAccreditationResource($this->whenLoaded('fimpesAccreditation')),

            'department' => new DepartmentResource($this->whenLoaded('department')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'user' => new UserResource($this->whenLoaded('user')),
            'entity' => new EntityResource($this->whenLoaded('entity')),

            'created_at' => $this->created_at,
        ];
    }
}
