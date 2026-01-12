<?php

namespace App\Http\Resources\Institution;

use App\Http\Resources\Academic\AcademicBackgroundResource;
use App\Http\Resources\Academic\AcademicCertificationResource;
use App\Http\Resources\AcademicBodyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Catalogs\KnowledgeAreaResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\EntityResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Http\Resources\KnowledgeLineResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PhoneNumberResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\ResearchLineResource;
use App\Http\Resources\SocialLinkResource;

class AcademicResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => "{$this->first_name} {$this->last_name} {$this->second_last_name}",
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'second_last_name' => $this->second_last_name,
            'gender' => $this->gender,
            'biography' => $this->biography,
            'academic_degree_id' => $this->academic_degree_id,
            'department_id' => $this->department_id,
            'is_active' => (int) $this->is_active,
            'location' => new LocationResource($this->whenLoaded('location')),
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'sni_membership' => new SystemMembershipResource($this->whenLoaded('sniMembership')),
            'desirable_profile' => new DesirableProfileResource($this->whenLoaded('desirableProfile')),
            'academic_position' => new AcademicPositionResource($this->whenLoaded('academicPosition')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'knowledge_areas' => KnowledgeAreaResource::collection($this->whenLoaded('knowledgeAreas')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'academic_degree' => new AcademicDegreeResource($this->whenLoaded('academicDegree')),
            'photo' => new PhotoResource($this->whenLoaded('photo')),
            'research_lines' => ResearchLineResource::collection($this->whenLoaded('researchLines')),
            'academic_bodies' => AcademicBodyResource::collection($this->whenLoaded('academicBodies')),
            'knowledge_lines' => KnowledgeLineResource::collection($this->whenLoaded('knowledgeLines')),
            'academic_backgrounds' => AcademicBackgroundResource::collection($this->whenLoaded('academicBackgrounds')),
            'academic_certifications' => AcademicCertificationResource::collection($this->whenLoaded('academicCertifications')),

            'active_technology_services_count' => $this->active_technology_services_count ?? 0,
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
