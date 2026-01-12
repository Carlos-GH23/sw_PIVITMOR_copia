<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notice\Notice;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NoticeNotification;
use Illuminate\Support\Facades\Log;

class PublishScheduledNotices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notices:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled notices whose publication date has arrived';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('notices:publish started');

        $noticesToPublish = Notice::where('notice_status_id', 1)
            ->whereDate('publication_date', '<=', now())
            ->get();

        if ($noticesToPublish->isEmpty()) {
            $this->info('No scheduled notices to publish at this time.');
            return;
        }

        try {
            foreach ($noticesToPublish as $notice) {
                $notice->update(['notice_status_id' => 2]);
                $notice->save();
                if ($notice->email_notification == 1) {
                    $users = User::all();
                    Notification::send($users, new NoticeNotification($notice));
                }
            }
            $this->info('Scheduled notices published successfully.');
        } catch (\Exception $e) {
            $this->error('Error publishing scheduled notices: ' . $e->getMessage());
            Log::error('Error publishing scheduled notices: ' . $e->getMessage());
        }
    }
}
