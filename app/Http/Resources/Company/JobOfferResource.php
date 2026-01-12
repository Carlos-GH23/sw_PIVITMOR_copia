<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AcademicDegreeResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\PhoneNumberResource;
use App\Http\Resources\SocialLinkResource;
use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\Catalogs\JobOfferTypeResource;
use App\Http\Resources\EntityResource;

class JobOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'gender' => $this->gender?->value,
            'travel_requirements' => $this->travel_requirements,
            'job_offer_type_id' => $this->job_offer_type_id,
            'academic_degree_id' => $this->academic_degree_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'job_description' => $this->job_description,
            'responsibilities' => $this->responsibilities,
            'skills_languages' => $this->skills_languages,
            'observations' => $this->observations,
            'comments' => $this->comments,
            'user_id' => $this->user_id,
            'is_active' => (int) $this->is_active,

            'academic_degree' => new AcademicDegreeResource($this->whenLoaded('academicDegree')),
            'job_offer_type' => new JobOfferTypeResource($this->whenLoaded('offerType')),

            'contact' => new ContactResource($this->whenLoaded('contact')),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),

            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'entity' => new EntityResource($this->whenLoaded('entity')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
