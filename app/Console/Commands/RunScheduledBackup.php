<?php

namespace App\Console\Commands;

use App\Models\Backup\BackupLog;
use App\Models\Backup\BackupSchedule;
use App\Notifications\BackupFailureNotification;
use App\Notifications\BackupSuccessNotification;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RunScheduledBackup extends Command
{
    protected $signature = 'backup:scheduled {--filename=}';
    protected $description = 'Execute scheduled backup using Spatie and register start/finish.';

    public function handle()
    {
        $filename = $this->option('filename') ?: 'scheduled_backup_' . now()->format('Y-m-d-H-i') . '.zip';
        $backupSchedule = BackupSchedule::with('user')->first();
        $userId = $backupSchedule->user_id;
        $userToNotify = $backupSchedule->user;

        $backupLog = BackupLog::create([
            'name' => 'Scheduled Backup',
            'description' => 'Scheduled backup executed according to schedule',
            'path' => config('backup.backup.name') . '/' . $filename,
            'user_id' => $userId,
            'backup_action_id' => 3,
            'backup_status_id' => 1,
        ]);

        try {
            $arguments = ['--only-db' => true, '--disable-notifications' => true, '--filename' => $filename];
            $exitCode = Artisan::call('backup:run', $arguments);

            if ($exitCode !== 0) {
                throw new Exception("Spatie command failed with code: {$exitCode}");
            }

            if ($backupSchedule->email_notification) {
                $userToNotify->notify(new BackupSuccessNotification($filename, $backupLog));
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            $backupLog->update(['description' => 'Scheduled backup failed', 'path' => null, 'backup_status_id' => 2,]);

            if ($backupSchedule->email_notification) {
                $userToNotify->notify(new BackupFailureNotification($filename, $exception->getMessage()));
            }
            return 1;
        }
        return 0;
    }
}
