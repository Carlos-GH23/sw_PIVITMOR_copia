<?php

namespace App\Http\Resources;

use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\DepartmentResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\AudienceTypeResource;
use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\KeywordResource;
use App\Http\Resources\FileResource;
use App\Traits\DateFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'speaker_bio' => $this->speaker_bio,
            'modality' => $this->modality,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_time' => $this->start_time ? substr($this->start_time, 0, 5) : null,
            'end_time' => $this->end_time ? substr($this->end_time, 0, 5) : null,
            'technical_requirements' => $this->technical_requirements,
            'department_id' => $this->department_id,
            'language_id' => $this->language_id,
            'user_id' => $this->user_id,
            'conference_status_id' => $this->conference_status_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'status' => new ConferenceStatusResource($this->whenLoaded('conferenceStatus')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'language' => new LanguageResource($this->whenLoaded('language')),

            'audience_types' => AudienceTypeResource::collection($this->whenLoaded('audienceTypes')),
            'academics' => AcademicResource::collection($this->whenLoaded('academics')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'entity' => new EntityResource($this->whenLoaded('entity')),
        ];
    }
}
