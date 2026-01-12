<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use App\Models\Institution\Institution;
use App\Traits\SyncsOneToMany;
use Illuminate\Support\Facades\DB;

class InstitutionProfileService
{
    protected PhotoService $photoService;
    protected ContactService $contactService;
    protected LocationService $locationService;
    use SyncsOneToMany;

    public function __construct(PhotoService $photoService, ContactService $contactService, LocationService $locationService)
    {
        $this->photoService = $photoService;
        $this->contactService = $contactService;
        $this->locationService = $locationService;
    }

    public function update(Institution $institution, array $fields): Institution
    {
        return DB::transaction(function () use ($institution, $fields) {
            $institution->update($fields);
            $this->upsertReniecyt($institution, $fields['reniecyt']);
            $this->locationService->upsertLocation($institution, $fields['location']);
            $this->photoService->upsertPhoto($institution, $fields['logo'], new PhotoStorageConfig('private', 'institution/logos', 'logo', 'logo'));
            $this->contactService->upsertContact($institution, $fields['contact']);
            $this->syncsOneToMany($institution->phoneNumbers(), $fields['phones'] ?? [], ['number', 'dial_code', 'type']);
            $this->syncsOneToMany($institution->socialLinks(), $fields['social_links'] ?? [], ['url', 'type']);
            $institution->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $institution->knowledgeAreas()->sync($fields['knowledge_areas'] ?? []);
            $institution->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $institution->keywords()->delete();
            $institution->keywords()->createMany($fields['keywords'] ?? []);
            return $institution;
        });
    }


    public function upsertReniecyt(Institution $institution, array $reniecytData)
    {
        $hasReniecytData = !empty($reniecytData['register_number']) || !empty($reniecytData['start_date']) || !empty($reniecytData['end_date']);

        if ($hasReniecytData) {
            $institution->reniecyt()->updateOrCreate(
                [
                    'reniecytable_id' => $institution->id,
                    'reniecytable_type' => Institution::class
                ],
                $reniecytData
            );
        } else {
            $institution->reniecyt()->delete();
        }
    }
}
