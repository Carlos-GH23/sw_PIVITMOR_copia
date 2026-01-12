<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\DTOs\PhotoStorageConfig;
use App\Models\AcademicGroups\ResearchLine;
use App\Services\FileService;
use App\Traits\HasOrderableRelations;
use App\Traits\SyncsOneToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResearchLineService
{
    protected PhotoService $photoService;
    protected PhotoStorageConfig $configPhoto;
    use HasOrderableRelations;
    use SyncsOneToMany;

    public function __construct(private FileService $fileService, PhotoService $photoService)
    {
        $this->photoService = $photoService;
        $this->configPhoto = new PhotoStorageConfig('private', 'institution/researchLines/logos', 'logo', 'logo');
    }


    public function buildQuery(object $filters)
    {
        $user = Auth::user();

        $query = ResearchLine::query()->with('department')
            ->whereHas('department', function ($departmentQuery) use ($user) {
                $departmentQuery->where('institution_id', $user->institution?->id);
            })
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('department', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields): ResearchLine
    {
        return DB::transaction(function () use ($fields) {
            $researchLine = ResearchLine::create($fields);
            $this->photoService->storePhoto($researchLine, $fields['logo'], $this->configPhoto);
            $this->fileService->storeFiles($researchLine, $fields['files'] ?? [], new FileStorageConfig(basePath: 'institution/researchLines/files'));

            $researchLine->keywords()->createMany($fields['keywords'] ?? []);
            $researchLine->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $researchLine->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $researchLine->academics()->sync($fields['academics'] ?? []);
            return $researchLine;
        });
    }

    public function update(ResearchLine $researchLine, array $fields): ResearchLine
    {
        return DB::transaction(function () use ($researchLine, $fields) {
            $researchLine->update($fields);
            $this->photoService->upsertPhoto($researchLine, $fields['logo'], $this->configPhoto);
            $this->fileService->syncFiles($researchLine, $fields['files'] ?? [], new FileStorageConfig(basePath: 'institution/researchLines/files'));
            $this->syncsOneToMany($researchLine->keywords(), $fields['keywords'], ['name']);
            $researchLine->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $researchLine->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $researchLine->academics()->sync($fields['academics'] ?? []);
            return $researchLine;
        });
    }

    public function destroy(ResearchLine $researchLine): void
    {
        DB::transaction(function () use ($researchLine) {
            $researchLine->keywords()->delete();
            $researchLine->economicSectors()->detach();
            $researchLine->oecdSectors()->detach();
            $researchLine->academics()->detach();
            if ($researchLine->logo) {
                $this->photoService->deletePhoto($researchLine->logo, $this->configPhoto->disk);
            }
            $this->fileService->deleteFiles($researchLine->files, 'private');
            $researchLine->delete();
        });
    }

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
        ];
    }
}
