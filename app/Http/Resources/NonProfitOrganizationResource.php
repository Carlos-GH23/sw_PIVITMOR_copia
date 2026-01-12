<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\LegalEntityTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NonProfitOrganizationResource extends JsonResource
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
            'mission' => $this->mission,
            'main_projects' => $this->main_projects,
            'cluni' => $this->cluni,
            'rfc' => $this->rfc,
            'legal_representative' => $this->legal_representative,

            'economic_sector_id' => $this->economic_sector_id,
            'legal_entity_type_id' => $this->legal_entity_type_id,
            'market_reach_id' => $this->market_reach_id,
            'user_id' => $this->user_id,
            'is_active' => $this->is_active,

            'contact' => new ContactResource($this->whenLoaded('contact')),
            'economic_sector' => new EconomicSectorResource($this->whenLoaded('economicSector')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'legal_entity_type' => new LegalEntityTypeResource($this->whenLoaded('legalEntityType')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'logo' => new PhotoResource($this->whenLoaded('logo')),
            'market_reach' => $this->whenLoaded('marketReach'),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
