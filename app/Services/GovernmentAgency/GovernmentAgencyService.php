<?php

namespace App\Services\GovernmentAgency;

use App\DTOs\PhotoStorageConfig;
use App\Services\PhotoService;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Services\LocationService;
use App\Services\ContactService;
use App\Traits\SyncsOneToMany;

class GovernmentAgencyService
{
    protected ContactService $contactService;
    protected PhotoService $photoService;
    protected PhotoStorageConfig $configPhoto;
    protected LocationService $locationService;
    use SyncsOneToMany;

    public function __construct(ContactService $contactService, PhotoService $photoService, LocationService $locationService)
    {
        $this->contactService = $contactService;
        $this->photoService = $photoService;
        $this->configPhoto = new PhotoStorageConfig('private', 'governmentAgency/profile/logos', 'logo', 'logo');
        $this->locationService = $locationService;
    }

    public function updateFromRequest(array $data, GovernmentAgency $agency): GovernmentAgency
    {
        $agency->update([
            'name'                      => $data['name'],
            'acronym'                   => $data['acronym'],
            'mission'                   => $data['mission'],
            'vision'                    => $data['vision'],
            'objectives'                => $data['objectives'],
            'government_level_id'       => $data['government_level_id'],
            'government_sector_id'        => $data['government_sector_id'],
        ]);
        $agency->keywords()->delete();
        $agency->keywords()->createMany($data['keywords'] ?? []);
        $this->photoService->upsertPhoto($agency, $data['logo'], $this->configPhoto);
        $this->locationService->upsertLocation($agency, $data['location'] ?? []);
        $this->contactService->upsertContact($agency, $data['contact'] ?? []);
        $this->syncsOneToMany($agency->phoneNumbers(), $data['phones'] ?? [], ['number', 'dial_code', 'type']);
        $this->syncsOneToMany($agency->socialLinks(), $data['social_links'] ?? [], ['url', 'type']);

        return $agency;
    }
}
