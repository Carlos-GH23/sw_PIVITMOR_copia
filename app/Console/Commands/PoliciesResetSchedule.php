<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ConsentConfiguration;
use App\Models\PrivacityAdviceAcceptance;
use Exception;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class PoliciesResetSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset accepted policies based on the configured frequency';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('policies:reset started');
        $renovationFrequency = ConsentConfiguration::first()?->frequency_of_acceptance ?? "never";

        $cutOffDate = match ($renovationFrequency) {
            'bi_annually' => now()->subMonths(6),
            'annually'    => now()->subYear(),
            default       => null,
        };

        if (!$cutOffDate) {
            return;
        }

        try {
            PrivacityAdviceAcceptance::where('is_accepted', true)
                ->where('created_at', '<', $cutOffDate)
                ->delete();

            $this->info('Policies reset completed successfully.');
        } catch (\Exception $e) {
            $this->error('Error resetting policies: ' . $e->getMessage());
            Log::error('Error resetting policies: ' . $e->getMessage());
        }
    }
}
