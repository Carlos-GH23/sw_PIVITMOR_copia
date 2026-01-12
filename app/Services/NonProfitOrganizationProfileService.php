<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use App\Models\NonProfitOrganization;
use App\Traits\SyncsOneToMany;
use Illuminate\Support\Facades\DB;

class NonProfitOrganizationProfileService
{
    protected ContactService $contactService;
    protected LocationService $locationService;
    protected PhotoService $photoService;
    use SyncsOneToMany;

    public function __construct(ContactService $contactService, LocationService $locationService, PhotoService $photoService,)
    {
        $this->contactService = $contactService;
        $this->locationService = $locationService;
        $this->photoService = $photoService;
    }

    public function update(NonProfitOrganization $nonProfitOrganization, array $fields): NonProfitOrganization
    {
        return DB::transaction(function () use ($nonProfitOrganization, $fields) {
            $nonProfitOrganization->update($fields);
            $this->locationService->upsertLocation($nonProfitOrganization, $fields['location']);
            $this->photoService->upsertPhoto($nonProfitOrganization, $fields['logo'], new PhotoStorageConfig('private', 'nonProfitOrganizations/logos', 'logo', 'logo'));
            $this->contactService->upsertContact($nonProfitOrganization, $fields['contact']);

            $this->syncsOneToMany($nonProfitOrganization->keywords(), $fields['keywords'], ['name']);
            $this->syncsOneToMany($nonProfitOrganization->phoneNumbers(), $fields['phones'], ['number', 'dial_code', 'type']);
            $this->syncsOneToMany($nonProfitOrganization->socialLinks(), $fields['social_links'], ['url', 'type']);
            return $nonProfitOrganization;
        });
    }
}
