<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasOrderableRelations;

class AcademicOfferingService
{
    use HasOrderableRelations;
    public function __construct(protected FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function buildQuery($filters)
    {
        $query = AcademicOffering::query()->with([
            'educationalLevel',
            'department',
            'copaesAccreditationProgram',
            'cieesAccreditationProgram',
            'postgraduateDetail',
            'keywords',
            'files',
            'oecdSectors',
            'economicSectors',
        ])
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('department', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('educationalLevel', 'name', 'LIKE', '%' . $search . '%');
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            })
            ->where('user_id', Auth::id());

        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query = $query->paginate($filters->rows)->withQueryString();
    }

    public function createAcademicOffering(array $fields): AcademicOffering | null
    {
        return DB::transaction(function () use ($fields) {
            $offering = AcademicOffering::create($fields);

            $this->syncAccreditations($offering, $fields);
            $offering->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
            $offering->economicSectors()->attach($fields['economic_sectors'] ?? []);
            $offering->keywords()->createMany($fields['keywords'] ?? []);
            $this->fileService->syncFiles($offering, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/academicOffering'));

            return $offering;
        });
    }

    public function updateAcademicOffering(AcademicOffering $offering, array $data): AcademicOffering
    {
        return DB::transaction(function () use ($offering, $data) {
            $offering->update($data);
            $this->syncAccreditations($offering, $data);
            $offering->oecdSectors()->sync($data['oecd_sectors'] ?? []);
            $offering->economicSectors()->sync($data['economic_sectors'] ?? []);
            $offering->keywords()->delete();
            $offering->keywords()->createMany($data['keywords'] ?? []);
            $this->fileService->syncFiles($offering, $data['files'] ?? [], new FileStorageConfig(basePath: 'files/academicOffering'));

            return $offering;
        });
    }

    private function syncAccreditations(AcademicOffering $offering, array $fields): void
    {
        if ($fields['has_copaes_accreditation']) {
            $offering->copaesAccreditationProgram()->updateOrCreate(
                ['academic_offering_id' => $offering->id],
                [
                    'expiry_date' => $fields['copaes_expiry_date'],
                    'copaes_accreditation_id' => $fields['copaes_accreditation_id']
                ]
            );
        } else {
            $offering->copaesAccreditationProgram()->delete();
        }

        if ($fields['has_ciees_accreditation']) {
            $offering->cieesAccreditationProgram()->updateOrCreate(
                ['academic_offering_id' => $offering->id],
                [
                    'expiry_date' => $fields['ciees_expiry_date'],
                    'level' => $fields['ciees_level'],
                    'ciees_accreditation_id' => $fields['ciees_accreditation_id']
                ]
            );
        } else {
            $offering->cieesAccreditationProgram()->delete();
        }

        if ($fields['has_snp']) {
            $offering->postgraduateDetail()->updateOrCreate(
                ['academic_offering_id' => $offering->id],
                [
                    'start_date' => $fields['snp_start_date'] ?? null,
                    'end_date' => $fields['snp_end_date'] ?? null,
                ]
            );
        } else {
            $offering->postgraduateDetail()->delete();
        }
    }

    public function destroy(AcademicOffering $offering): void
    {
        DB::transaction(function () use ($offering) {
            $this->fileService->deleteFiles($offering->files, 'private', true);
            $offering->keywords()->delete();
            $offering->copaesAccreditationProgram()->delete();
            $offering->cieesAccreditationProgram()->delete();
            $offering->postgraduateDetail()->delete();
            $offering->delete();
        });
    }

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
            'educational_level' => ['educational_levels', 'educational_level_id', 'name'],
        ];
    }
}
