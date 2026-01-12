<?php

namespace App\Services;

use App\DTOs\FileStorageConfig;
use App\DTOs\PhotoStorageConfig;
use App\Models\Academic;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyServiceCategory;
use App\Models\Catalogs\TechnologyServiceType;
use App\Models\Institution\Department;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\TechnologyService;
use App\Traits\HasOrderableRelations;
use App\Traits\SyncsOneToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TechnologyServiceService
{
	use HasOrderableRelations;
	use SyncsOneToMany;

	public function __construct(private FileService $fileService, private PhotoService $photoService) {}

	public function getFormData(): array
	{
		$user = Auth::user();
		$institutionId = $user->getInstitutionId();
		$departments = Department::select('id', 'name')->where('institution_id', $institutionId)->get();

		return [
			'departments' => $departments,
			'serviceTypes' => TechnologyServiceType::orderBy('name')->get(),
			'serviceCategories' => TechnologyServiceCategory::orderBy('name')->get(),
			'economicSectors' => EconomicSector::getHierarchy(),
			'oecdSectors' => OecdSector::getHierarchy(),
			'academics' => Academic::select(['id', 'first_name', 'last_name', 'second_last_name'])
				->whereHas('department', function ($q) use ($institutionId) {
					$q->where('institution_id', $institutionId);
				})
				->orderBy('first_name')->get()->map(function ($academic) {
					return [
						'id' => $academic->id,
						'name' => $academic->full_name
					];
				}),
			'facilities' => Facility::select(['id', 'name'])
				->whereHas('department', function ($q) use ($institutionId) {
					$q->where('institution_id', $institutionId);
				})
				->orderBy('name')->get(),
			'equipments' => FacilityEquipment::select(['id', 'name'])
				->whereHas('facility.department', function ($q) use ($institutionId) {
					$q->where('institution_id', $institutionId);
				})
				->orderBy('name')->get(),
		];
	}

	protected function getOrderableRelations(): array
	{
		return [
			'department' => ['departments', 'department_id', 'name'],
			'status' => ['technology_service_statuses', 'technology_service_status_id', 'name'],
		];
	}

	public function buildQuery(string|null $search): Builder
	{
		$user = Auth::user();

		$query = TechnologyService::query()->with(
			'technologyServiceStatus',
			'department',
			'assessments.user'
		)
			->when($search, function ($query, $search) {
				$query->where('title', 'LIKE', '%' . $search . '%')
					->orWhere('technical_description', 'LIKE', '%' . $search . '%')
					->orWhere('start_date', 'LIKE', '%' . $search . '%')
					->orWhere('end_date', 'LIKE', '%' . $search . '%')
					->orWhereHas('department', function ($query) use ($search) {
						$query->where('name', 'LIKE', '%' . $search . '%');
					})
					->orWhereHas('technologyServiceStatus', fn($tq) => $tq->where('name', 'LIKE', "%$search%"));
			});

		if ($user->canPermission('technologyServices.viewInstitution')) {
			$query->fromInstitution($user->institution->id);
		} else {
			$query->where('user_id', $user->id);
		}

		return $query;
	}

	public function buildFilters(Builder $query, object $filters)
	{
		$this->applyOrdering($query, $filters->order, $filters->direction);
		return $query->paginate($filters->rows)->withQueryString();
	}

	public function store(array $fields): TechnologyService | null
	{
		return DB::transaction(function () use ($fields) {
			$technologyService = TechnologyService::create($fields);
			$technologyService->oecdSectors()->attach($fields['oecd_sectors'] ?? []);
			$technologyService->economicSectors()->attach($fields['economic_sectors'] ?? []);
			$technologyService->keywords()->createMany($fields['keywords'] ?? []);
			$technologyService->academics()->attach($fields['academics'] ?? []);
			$technologyService->facilities()->attach($fields['facilities'] ?? []);
			$technologyService->equipments()->attach($fields['equipments'] ?? []);
			$this->fileService->storeFiles($technologyService, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/technology_services'));
			$this->photoService->storePhotos($technologyService, $fields['photos'] ?? [], new PhotoStorageConfig(basePath: 'photos/technology_services'));
			return $technologyService;
		});
	}

	public function update(TechnologyService $technologyService, array $fields): TechnologyService | null
	{
		return DB::transaction(function () use ($technologyService, $fields) {
			$technologyService->update($fields);
			$technologyService->oecdSectors()->sync($fields['oecd_sectors'] ?? []);
			$technologyService->economicSectors()->sync($fields['economic_sectors'] ?? []);
			$technologyService->academics()->sync($fields['academics'] ?? []);
			$technologyService->facilities()->sync($fields['facilities'] ?? []);
			$technologyService->equipments()->sync($fields['equipments'] ?? []);
			$this->syncsOneToMany($technologyService->keywords(), $fields['keywords'], ['name']);
			$this->fileService->syncFiles($technologyService, $fields['files'] ?? [], new FileStorageConfig(basePath: 'files/technology_services'));
			$this->photoService->syncPhotos($technologyService, $fields['photos'] ?? [], new PhotoStorageConfig(basePath: 'photos/technology_services'));
			return $technologyService;
		});
	}

	public function delete(TechnologyService $technologyService)
	{
		return DB::transaction(function () use ($technologyService) {
			$this->fileService->deleteFiles($technologyService->files, 'private', true);
			$this->photoService->deletePhotos($technologyService->photos, 'private', true);
			$technologyService->keywords()->delete();
			$technologyService->delete();
		});
	}
}
