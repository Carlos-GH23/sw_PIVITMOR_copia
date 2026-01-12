<?php

namespace App\Http\Resources\Institution;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\InstitutionTypeResource;
use App\Http\Resources\Catalogs\KnowledgeAreaResource;
use App\Http\Resources\Catalogs\OecdSectorResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\KeywordResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PhoneNumberResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\SocialLinkResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionResource extends JsonResource
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
            'user_id' => $this->user_id,
            'is_active' => $this->is_active,
            'logo' => new PhotoResource($this->whenLoaded('logo')),
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'reniecyt' => new ReniecytResource($this->whenLoaded('reniecyt')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'knowledge_areas' => KnowledgeAreaResource::collection($this->whenLoaded('knowledgeAreas')),
            'economic_sectors' => EconomicSectorResource::collection($this->whenLoaded('economicSectors')),
            'oecd_sectors' => OecdSectorResource::collection($this->whenLoaded('oecdSectors')),
            'institution_type' => new InstitutionTypeResource($this->whenLoaded('institutionType')),
        ];
    }
}
