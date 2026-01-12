<?php

namespace App\Services;

use App\Models\Backup\BackupLog;
use App\Models\Backup\BackupSchedule;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupService
{
    public function buildQuery(object $filters)
    {
        $query = BackupLog::query()->with(['user', 'backupAction', 'backupStatus'])
            ->when($filters->search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                    ->orWhereHas('backupAction', fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                    ->orWhereHas('backupStatus', fn($q) => $q->where('name', 'LIKE', "%{$search}%"));
            })->orderBy('created_at', 'desc');

        return $query->paginate($filters->rows)->withQueryString();
    }

    public function getAvailableBackups(): Collection
    {
        return BackupLog::query()->where('backup_status_id', 1)->orderBy('created_at', 'desc')->get();
    }

    public function getLatestBackup(): ?BackupLog
    {
        return $this->getAvailableBackups()->first();
    }

    public function getTotalBackups(): int
    {
        return $this->getAvailableBackups()->count();
    }

    public function getSchedule(): ?BackupSchedule
    {
        return BackupSchedule::with('backupFrequency', 'user')->first();
    }

    public function getNextBackupDate(): string
    {
        $schedule = $this->getSchedule();
        if (!$schedule) {
            return 'No configurado';
        }
        $nextBackup = $schedule->next_backup_date;
        return $nextBackup ? $nextBackup->format('d-m-Y H:i') : 'No configurado';
    }

    public function store(array $fields): BackupLog
    {
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $fields['name']);
        $customFileName = $safeName . '_' . now()->format('Y-m-d-H-i') . '.zip';

        $disk = config('backup.backup.destination.disks')[0] ?? 'local';
        $backupName = config('backup.backup.name');
        $backupPath = $backupName . '/' . $customFileName;

        $backupLog = BackupLog::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'path' => $backupPath,
            'user_id' => Auth::id(),
            'backup_action_id' => 1,
            'backup_status_id' => 1,
        ]);

        try {
            $this->configureBackupEncryption($fields['is_encrypted'] ?? false);
            Artisan::call('backup:run', ['--only-db' => true, '--disable-notifications' => true, '--filename' => $customFileName]);

            if (!Storage::disk($disk)->exists($backupPath)) {
                throw new Exception("El archivo de backup no fue creado correctamente en la ruta esperada.");
            }
            return $backupLog;
        } catch (Exception $exception) {
            $backupLog->update(['path' => null, 'backup_status_id' => 2]);
            throw $exception;
        }
    }

    public function restore(int $backupId): void
    {
        $backup = BackupLog::find($backupId);

        if (!$backup || $backup->backup_status_id !== 1 || !$backup->path) {
            throw new Exception("El registro de backup no es válido o no está completo.");
        }

        $restoreLog = BackupLog::create([
            'name' => 'Restauración: ' . $backup->name,
            'description' => 'Restauración desde el backup: ' . $backup->name . ' (ID: ' . $backup->id . ')',
            'path' => $backup->path,
            'user_id' => Auth::id(),
            'backup_action_id' => 2,
            'backup_status_id' => 1,
        ]);

        try {
            $disk = config('backup.backup.destination.disks')[0] ?? 'local';

            $exitCode = Artisan::call('backup:restore', [
                '--disk' => $disk,
                '--backup' => $backup->path,
                '--connection' => config('database.default'),
                '--no-interaction' => true,
                '--password' => env('APP_KEY'),
            ]);

            if ($exitCode !== 0) {
                throw new Exception("El comando de restauración falló con código: {$exitCode}");
            }
        } catch (Exception $exception) {
            $restoreLog->update(['backup_status_id' => 2]);
            throw $exception;
        }
    }

    public function schedule(array $fields): BackupSchedule
    {
        return DB::transaction(function () use ($fields) {
            $fields['user_id'] = Auth::id();
            return BackupSchedule::updateOrCreate(['id' => 1], $fields);
        });
    }

    private function configureBackupEncryption(bool $isEncrypted): void
    {
        if ($isEncrypted) {
            Config::set('backup.backup.password', env('APP_KEY'));
            Config::set('backup.backup.encryption', 'default');
        } else {
            Config::set('backup.backup.password', null);
            Config::set('backup.backup.encryption', false);
        }
    }
}
