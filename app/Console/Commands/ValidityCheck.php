<?php

namespace App\Console\Commands;

use App\Models\Capability;
use App\Models\Requirement;
use App\Models\TechnologyService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ValidityCheck extends Command
{

    protected $signature = 'validity:check';

    protected $description = 'Check validity of records and update their status to closed';

    const STATUS_ACTIVE = 3;
    const STATUS_CLOSED = 6;

    public function handle()
    {
        $this->info('validity:check started');
        $this->newLine();

        $definitions = [
            ['model' => Capability::class,        'column' => 'capability_status_id'],
            ['model' => TechnologyService::class, 'column' => 'technology_service_status_id'],
            ['model' => Requirement::class,       'column' => 'requirement_status_id'],
        ];

        foreach ($definitions as $definition) {
            $modelClass = $definition['model'];
            $column = $definition['column'];

            try {
                $affectedRecords = $modelClass::where([['end_date', '<', now()], [$column, '=', self::STATUS_ACTIVE]])
                    ->update([$column => self::STATUS_CLOSED]);

                if ($affectedRecords > 0) {
                    $msg = "Closed {$affectedRecords} expired records in {$modelClass}.";
                    $this->info($msg);
                    Log::info("validity:check -> {$msg}");
                } else {
                    $this->comment("No expired records found in {$modelClass}");
                }
            } catch (\Exception $e) {
                $errorMsg = "Error processing {$modelClass}: " . $e->getMessage();
                Log::error("validity:check -> {$errorMsg}");
                $this->error('validity:check failed: ' . $errorMsg);
            }
        }

        $this->newLine();
        $this->info('validity:check completed successfully');
    }
}
