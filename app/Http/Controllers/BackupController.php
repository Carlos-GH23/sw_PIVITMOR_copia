<?php

namespace App\Http\Controllers;

use App\Http\Requests\Backup\RestoreBackupRequest;
use App\Http\Requests\Backup\ScheduleBackupRequest;
use App\Http\Requests\Backup\StoreBackupRequest;
use App\Http\Resources\Backup\BackupFrequencyResource;
use App\Http\Resources\Backup\BackupLogResource;
use App\Http\Resources\Backup\BackupScheduleResource;
use App\Http\Resources\UserResource;
use App\Models\Backup\BackupFrequency;
use App\Services\BackupService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class BackupController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;

    public function __construct(private BackupService $backupService)
    {
        $this->routeName = "backup.settings.";
        $this->source    = "Core/Settings/Backups/Pages/";

        $this->middleware("permission:backup.settings")->only(['index', 'store', 'restore', 'schedule']);
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        return Inertia::render("{$this->source}Index", [
            'title' => 'Gestión de respaldos',
            'routeName' => $this->routeName,
            'backups' => BackupLogResource::collection($this->backupService->buildQuery($filters)),
            'availableBackups' => BackupLogResource::collection($this->backupService->getAvailableBackups()),
            'latestBackup' => BackupLogResource::make($this->backupService->getLatestBackup()),
            'totalBackups' => $this->backupService->getTotalBackups(),
            'filters' => $filters,
            'nextBackupDate' => $this->backupService->getNextBackupDate(),
            'schedule' => BackupScheduleResource::make($this->backupService->getSchedule()),
            'frequencies' => BackupFrequencyResource::collection(BackupFrequency::all()),
            'user' => new UserResource(Auth::user()),
        ]);
    }

    public function store(StoreBackupRequest $request)
    {
        try {
            $this->backupService->store($request->validated());
            return back()->with('success', 'Respaldo creado exitosamente');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Error al crear el respaldo');
        }
    }

    public function restore(RestoreBackupRequest $request)
    {
        try {
            $this->backupService->restore($request->validated()['backup_id']);
            return back()->with('success', 'Base de datos restaurada exitosamente');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Error al restaurar la base de datos');
        }
    }

    public function schedule(ScheduleBackupRequest $request)
    {
        try {
            $this->backupService->schedule($request->validated());
            return back()->with('success', 'Tarea programada exitosamente');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Error al programar la tarea');
        }
    }
}
