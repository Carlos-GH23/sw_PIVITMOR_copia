<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use App\Models\Academic;
use App\Models\Capability;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\User;
use App\Notifications\AcademicCredentialsNotification;
use App\Traits\HasOrderableRelations;
use App\Traits\SyncsOneToMany;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AcademicService
{
    protected PhotoService $photoService;
    protected ContactService $contactService;
    protected PhotoStorageConfig $configPhoto;
    use SyncsOneToMany;
    use HasOrderableRelations;

    public function __construct(PhotoService $photoService, ContactService $contactService)
    {
        $this->photoService = $photoService;
        $this->contactService = $contactService;
        $this->configPhoto = new PhotoStorageConfig('private', 'academics/photos', 'photo', 'profile');
    }

    public function buildQuery($filters)
    {
        $user = Auth::user();

        $query = Academic::query()->with(['department', 'academicPosition', 'contact'])
            ->whereHas('department', function ($departmentQuery) use ($user) {
                $departmentQuery->where('institution_id', $user->institution?->id);
            })
            ->when($filters->search, function ($query, $search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('second_last_name', 'LIKE', "%{$search}%")
                    ->orWhereHas('department', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('academicPosition', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $this->applyOrdering($query, $filters->order, $filters->direction);
        return $query->paginate($filters->rows)->withQueryString();
    }

    public function store(array $fields): Academic
    {
        return DB::transaction(function () use ($fields) {
            $user = $this->createUser($fields);
            $fields['user_id'] = $user->id;
            $academic = Academic::create($fields);
            $academic->knowledgeLines()->createMany($fields['knowledge_lines'] ?? []);

            $this->upsertSniMembership($academic, $fields['sni'] ?? []);
            $this->upsertDesirableProfile($academic, $fields['profile'] ?? []);
            $this->photoService->storePhoto($academic, $fields['photo'], $this->configPhoto);
            $this->contactService->storeContact($academic, $fields['contact']);

            $academic->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
            $academic->economicSectors()->attach($fields['economic_sectors'] ?? []);

            return $academic;
        });
    }

    public function update(Academic $academic, array $fields): Academic
    {
        return DB::transaction(function () use ($academic, $fields) {
            $academic->update($fields);

            $this->upsertSniMembership($academic, $fields['sni'] ?? []);
            $this->upsertDesirableProfile($academic, $fields['profile'] ?? []);
            $this->syncsOneToMany($academic->knowledgeLines(), $fields['knowledge_lines'], ['name']);
            $this->photoService->upsertPhoto($academic, $fields['photo'], $this->configPhoto);
            $this->contactService->upsertContact($academic, $fields['contact']);

            $academic->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
            $academic->economicSectors()->sync($fields['economic_sectors'] ?? []);

            return $academic;
        });
    }

    public function destroy(Academic $academic): void
    {
        DB::transaction(function () use ($academic) {
            $user = $academic->user;
            $academic->contact()->delete();
            $academic->knowledgeLines()->delete();
            $academic->sniMembership()->delete();
            $academic->desirableProfile()->delete();
            $academic->oecdSectors()->detach();
            $academic->economicSectors()->detach();

            if ($academic->photo) {
                $this->photoService->deletePhoto($academic->photo, $this->configPhoto->disk);
            }

            $academic->delete();

            if ($user) {
                $user->delete();
            }
        });
    }

    public function enable(Academic $academic): void
    {
        DB::transaction(function () use ($academic) {
            $newStatus = !$academic->is_active;
            $academic->update(['is_active' => $newStatus]);

            if ($academic->user) {
                $academic->user->update(['is_active' => $newStatus]);
            }

            if ($academic->user_id) {
                $models = [TechnologyService::class, Capability::class, Requirement::class];
                foreach ($models as $model) {
                    $model::where('user_id', $academic->user_id)->update(['is_active' => $newStatus]);
                }
            }
            $academic->conferences()->update(['conference_status_id' => 3]);
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

    protected function getOrderableRelations(): array
    {
        return [
            'department' => ['departments', 'department_id', 'name'],
            'academic_position' => ['academic_positions', 'academic_position_id', 'name'],
        ];
    }

    private function createUser(array $fields): User
    {
        $password = Str::random(12);
        $user = User::create([
            'name' => $fields['first_name'] . ' ' . $fields['last_name'],
            'email' => $fields['contact']['email'] ?? $fields['email'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole(3);

        try {
            $user->notify(new AcademicCredentialsNotification($password));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
        }
        return $user;
    }

    public function createUserFromCsv(array $fields): ?int
    {
        if (!isset($fields['email'])) {
            return null;
        }

        $user = $this->createUser($fields);
        return $user->id;
    }
}
