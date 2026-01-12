<?php

namespace App\Http\Resources\GovernmentAgency;

use App\Http\Resources\Catalogs\GovernmentSectorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\KeywordResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\SocialLinkResource;
use App\Http\Resources\PhoneNumberResource;
use App\Http\Resources\GovernmentAgency\GovernmentLevelResource;

class GovernmentAgencyResource extends JsonResource
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
            'acronym' => $this->acronym,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'objectives' => $this->objectives,
            'government_level_id' => $this->government_level_id,
            'government_sector_id' => $this->government_sector_id,
            'is_active' => $this->is_active,
            'location' => new LocationResource($this->whenLoaded('location')),
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'logo' => new PhotoResource($this->whenLoaded('logo')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'government_level' => new GovernmentLevelResource($this->whenLoaded('governmentLevel')),
            'government_sector' => new GovernmentSectorResource($this->whenLoaded('governmentSector')),
        ];
    }
}
