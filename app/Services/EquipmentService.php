<?php

namespace App\Services;
use App\Services\PhotoService;
use App\Services\FileService;
use App\DTOs\PhotoStorageConfig;
use App\DTOs\FileStorageConfig;
use App\Models\Institution\FacilityEquipment;
use Illuminate\Support\Facades\DB;
use App\Models\Institution\Facility;
use Illuminate\Database\Eloquent\Collection;

class EquipmentService
{
    protected PhotoService $photoService;
    protected FileService $fileService;
    protected FileStorageConfig $configFiles;
    protected PhotoStorageConfig $configPhotos;

    public function __construct(PhotoService $photoService, FileService $fileService)
    {
        $this->photoService = $photoService;
        $this->fileService = $fileService;
        $this->configFiles = new FileStorageConfig('private', 'facilities/files', 'files');
        $this->configPhotos = new PhotoStorageConfig('private', 'facilities/photos', 'photos');
    }

    public function store(array $fields): FacilityEquipment | null
    {
        return DB::Transaction(function () use ($fields) {
            $equipment = FacilityEquipment::create($fields);
            $this->photoService->storePhotos($equipment, $fields['photos'] ?? [], $this->configPhotos);
            $this->fileService->storeFiles($equipment, $fields['files'] ?? [], $this->configFiles);
            return $equipment;
        });
    }

    public function update(FacilityEquipment $equipment, array $fields): FacilityEquipment | null
    {
        return DB::Transaction(function () use ($equipment, $fields) {
            $equipment->update($fields);
            $this->photoService->syncPhotos($equipment, $fields['photos'] ?? [], $this->configPhotos);
            $this->fileService->syncFiles($equipment, $fields['files'] ?? [], $this->configFiles);
            return $equipment;
        });
    }

    public function destroy(FacilityEquipment $equipment): bool
    {
        return DB::Transaction(function () use ($equipment) {
            $this->photoService->deletePhotos($equipment->photos, $this->configPhotos->disk, true);
            $this->fileService->deleteFiles($equipment->files, $this->configFiles->disk, true);
            return $equipment->delete();
        });
    }

    public function getFacilitiesByDepartment(int $departmentId): Collection
    {
        return Facility::where('department_id', $departmentId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

}