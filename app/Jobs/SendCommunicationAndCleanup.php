<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Notifications\CommunicationNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Communication;
use Illuminate\Support\Facades\Notification;
use App\Services\FileService;
use App\DTOs\FileStorageConfig;

class SendCommunicationAndCleanup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Communication $communication,
        public Collection $users,
        public string $subject,
        public string $body,
        public string $footer,
        public array $attachmentsData,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(FileService $fileService): void
    {
        try {
            $this->communication = $this->communication->fresh(['files']);

            Notification::sendNow(
                $this->users,
                new CommunicationNotification(
                    $this->subject,
                    $this->body,
                    $this->footer,
                    $this->attachmentsData
                )
            );

            $configFiles = new FileStorageConfig('public', 'email/files', 'files');

            if ($this->communication->files->isNotEmpty()) {
                $fileService->deleteFiles(
                    $this->communication->files,
                    $configFiles->disk,
                    true
                );
            }
            $this->communication->delete();
        } catch (\Exception $e) {
            
        }
    }
}
