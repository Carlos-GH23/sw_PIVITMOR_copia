<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use App\Models\Academic;
use App\Traits\SyncsOneToMany;
use Illuminate\Support\Facades\DB;

class AcademicProfileService
{
    protected PhotoService $photoService;
    protected ContactService $contactService;
    protected PhotoStorageConfig $configPhoto;
    protected LocationService $locationService;
    use SyncsOneToMany;

    public function __construct(PhotoService $photoService, ContactService $contactService, LocationService $locationService)
    {
        $this->photoService = $photoService;
        $this->contactService = $contactService;
        $this->locationService = $locationService;
        $this->configPhoto = new PhotoStorageConfig('private', 'academics/photos', 'photo', 'profile');
    }

    public function update(Academic $academic, array $fields): Academic
    {
        return DB::transaction(function () use ($academic, $fields) {
            $academic->update($fields);

            $this->upsertSniMembership($academic, $fields['sni'] ?? []);
            $this->upsertDesirableProfile($academic, $fields['profile'] ?? []);

            $this->locationService->upsertLocation($academic, $fields['location']);
            $this->photoService->upsertPhoto($academic, $fields['photo'], $this->configPhoto);
            $this->contactService->upsertContact($academic, $fields['contact']);

            $this->syncsOneToMany($academic->knowledgeLines(), $fields['knowledge_lines'], ['name']);
            $this->syncsOneToMany($academic->phoneNumbers(), $fields['phones'] ?? [], ['number', 'dial_code', 'type']);
            $this->syncsOneToMany($academic->socialLinks(), $fields['social_links'] ?? [], ['url', 'type']);

            $academic->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $academic->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            return $academic;
        });
    }

    private function upsertSniMembership(Academic $academic, array $sniData): void
    {
        $hasSniData = !empty($sniData['start_date']) && !empty($sniData['end_date']);
        if ($hasSniData) {
            $academic->sniMembership()->updateOrCreate([], $sniData);
        } else {
            $academic->sniMembership()->delete();
        }
    }

    private function upsertDesirableProfile(Academic $academic, array $profileData): void
    {
        if (!empty($profileData['has_profile'])) {
            $academic->desirableProfile()->updateOrCreate([], $profileData);
        } else {
            $academic->desirableProfile()->delete();
        }
    }
}
