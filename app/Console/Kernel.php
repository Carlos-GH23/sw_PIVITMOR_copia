<?php

namespace App\Console;

use App\Models\Backup\BackupLog;
use App\Models\Backup\BackupSchedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Commands\command::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('notices:publish')
        ->timezone('America/Mexico_City')
        ->dailyAt('07:00');
        $this->scheduleBackups($schedule);
        $schedule->command('policies:reset')
        ->timezone('America/Mexico_City')
        ->dailyAt('00:00');
        $schedule->command('validity:check')
        ->timezone('America/Mexico_City')
        ->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function scheduleBackups(Schedule $schedule): void
    {
        try {
            $backupSchedule = BackupSchedule::with('backupFrequency')->first();

            if (!$backupSchedule || !$backupSchedule->backup_frequency_id) {
                return;
            }

            $time = substr($backupSchedule->time, 0, 5);
            $filename = 'scheduled_backup_' . Carbon::now()->format('Y-m-d-H-i') . '.zip';
            $task = $schedule->command('backup:scheduled', ['--filename' => $filename]);

            switch ($backupSchedule->backup_frequency_id) {
                case 1:
                    $task->dailyAt($time);
                    break;
                case 2:
                    $task->weeklyOn(1, $time);
                    break;
                case 3:
                    $task->monthlyOn(1, $time);
                    break;
                default:
                    return;
            }

            $task->name('scheduled-backup')->withoutOverlapping()->runInBackground();
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
        }
    }
}
