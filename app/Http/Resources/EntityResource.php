<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalogs\EconomicSectorResource;
use App\Http\Resources\Catalogs\GovernmentSectorResource;
use App\Http\Resources\Catalogs\InstitutionTypeResource;
use App\Http\Resources\Catalogs\LegalEntityTypeResource;
use App\Http\Resources\GovernmentAgency\GovernmentLevelResource;
use App\Http\Resources\Institution\ReniecytResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
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
            'category' => $this->getEntityCategory(),
            'code' => $this->getEntityCode(),
            'description' => $this->description ?? $this->overview,
            'legal_representative' => $this->legal_representative,
            'location' => $this->whenLoaded('location', $this->location?->full_address),
            'legal_entity_type' => new LegalEntityTypeResource($this->whenLoaded('legalEntityType')),
            'economic_sector' => new EconomicSectorResource($this->whenLoaded('economicSector')),
            'institution_type' => new InstitutionTypeResource($this->whenLoaded('institutionType')),
            'logo' => new PhotoResource($this->whenLoaded('logo')),
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'reniecyt' => new ReniecytResource($this->whenLoaded('reniecyt')),
            'government_level' => new GovernmentLevelResource($this->whenLoaded('governmentLevel')),
            'government_sector' => new GovernmentSectorResource($this->whenLoaded('governmentSector')),
        ];
    }
}
