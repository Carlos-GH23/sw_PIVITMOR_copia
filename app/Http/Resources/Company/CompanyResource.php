<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\ContactResource;
use App\Http\Resources\Institution\ReniecytResource;
use App\Http\Resources\KeywordResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PhoneNumberResource;
use App\Http\Resources\PhotoResource;
use App\Http\Resources\SocialLinkResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'legal_name' => $this->legal_name,
            'rfc' => $this->rfc,
            'year' => $this->year,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'overview' => $this->overview,
            'is_active' => (int) $this->is_active,
            'logo' => new PhotoResource($this->whenLoaded('logo')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'keywords' => KeywordResource::collection($this->whenLoaded('keywords')),
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'phone_numbers' => PhoneNumberResource::collection($this->whenLoaded('phoneNumbers')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('socialLinks')),
            'reniecyt' => new ReniecytResource($this->whenLoaded('reniecyt')),
            'technology' => new TechnologyCompanyResource($this->whenLoaded('technologyCompany')),
        ];
    }
}
