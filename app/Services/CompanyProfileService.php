<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\DTOs\PhotoStorageConfig;
use App\Models\Company\Company;
use App\Traits\SyncsOneToMany;
use Illuminate\Support\Facades\DB;

class CompanyProfileService
{
    protected FileService $fileService;
    protected PhotoService $photoService;
    protected ContactService $contactService;
    protected PhotoStorageConfig $configPhoto;
    protected FileStorageConfig $configFiles;
    protected LocationService $locationService;
    use SyncsOneToMany;

    public function __construct(PhotoService $photoService, FileService $fileService, ContactService $contactService, LocationService $locationService)
    {
        $this->photoService = $photoService;
        $this->fileService = $fileService;
        $this->contactService = $contactService;
        $this->locationService = $locationService;
        $this->configPhoto = new PhotoStorageConfig('private', 'company/logos', 'logo', 'profile');
        $this->configFiles = new FileStorageConfig(basePath: 'company/technologyCompany/files');
    }

    public function update(Company $company, array $fields): Company
    {
        return DB::transaction(function () use ($company, $fields) {
            $company->update($fields);
            $this->contactService->upsertContact($company, $fields['contact']);
            $this->locationService->upsertLocation($company, $fields['location']);
            $this->photoService->upsertPhoto($company, $fields['logo'], $this->configPhoto);

            $this->syncsOneToMany($company->phoneNumbers(), $fields['phones'] ?? [], ['number', 'dial_code', 'type']);
            $this->syncsOneToMany($company->socialLinks(), $fields['social_links'] ?? [], ['url', 'type']);
            $this->syncsOneToMany($company->keywords(), $fields['keywords'], ['name']);
            $this->upsertReniecyt($company, $fields['reniecyt']);

            if (!empty($fields['technology']['has_company'])) {
                $technologyCompany = $company->technologyCompany()->updateOrCreate([], $fields['technology']);
                $technologyCompany->economicSectors()->sync($fields['economic_sectors'] ?? []);
                $technologyCompany->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
                if ($technologyCompany->files) {
                    $this->fileService->syncFiles($technologyCompany, $fields['files'] ?? [], $this->configFiles);
                } else {
                    $this->fileService->storeFiles($technologyCompany, $fields['files'] ?? [], $this->configFiles);
                }
            } else {
                $company->technologyCompany()->delete();
            }
            return $company;
        });
    }

    public function upsertReniecyt(Company $company, array $reniecytData)
    {
        $hasReniecytData = !empty($reniecytData['register_number']) || !empty($reniecytData['start_date']) || !empty($reniecytData['end_date']);

        if ($hasReniecytData) {
            $company->reniecyt()->updateOrCreate(
                [
                    'reniecytable_id' => $company->id,
                    'reniecytable_type' => Company::class
                ],
                $reniecytData
            );
        } else {
            $company->reniecyt()->delete();
        }
    }
}
