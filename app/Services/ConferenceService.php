<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\Models\Conference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ConferenceService
{
    protected $conference;

    public function __construct(Conference $conference, private FileService $fileService)
    {
        $this->conference = $conference;
    }

    public function buildQuery(object $filters)
    {
        $user = Auth::user();

        $query = Conference::query()->with(['department', 'academics', 'conferenceStatus'])
            ->when($filters->search, function ($query, $search) {
                $query->where('title', 'LIKE', "%$search%")
                    ->orWhere('modality', 'LIKE', "%$search%")
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('conferenceStatus', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%$search%");
                    });
            });


        if ($user->canPermission('conferences.viewInstitution')) {
            $query->fromInstitution($user->institution?->id);
        } else {
            $query->where('user_id', $user->id);
        }

        return $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields): Conference | null
    {
        return DB::transaction(function () use ($fields) {
            $fields['conference_status_id'] = $fields['conference_status_id'] ?? 1;
            
            $conference = Conference::create($fields);
            $conference->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
            $conference->economicSectors()->attach($fields['economic_sectors'] ?? []);
            $conference->audienceTypes()->attach($fields['audience_types'] ?? []);
            $conference->keywords()->createMany($fields['keywords'] ?? []);
            $conference->academics()->attach($fields['academics'] ?? []);
            $this->fileService->storeFiles($conference, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/conferences'));
            return $conference;
        });
    }

    public function update(Conference $conference, array $fields): Conference | null
    {
        return DB::transaction(function () use ($conference, $fields) {
            $conference->update($fields);
            $conference->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $conference->economicSectors()->sync($fields['economic_sectors'] ?? []);
            $conference->audienceTypes()->sync($fields['audience_types'] ?? []);
            $conference->keywords()->delete();
            $conference->keywords()->createMany($fields['keywords'] ?? []);
            $conference->academics()->sync($fields['academics'] ?? []);
            $this->fileService->syncFiles($conference, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/conferences'));
            return $conference;
        });
    }

    public function delete(Conference $conference)
    {
        return DB::transaction(function () use ($conference) {
            $this->fileService->deleteFiles($conference->files, 'private', true);
            $conference->keywords()->delete();
            $conference->delete();
        });
    }
}