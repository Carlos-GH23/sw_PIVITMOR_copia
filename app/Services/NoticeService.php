<?php

namespace App\Services;

use App\DTOs\PhotoStorageConfig;
use Illuminate\Support\Facades\DB;
use App\Services\PhotoService;
use App\Models\Notice\Notice;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Illuminate\Support\Facades\Notification;
use App\Traits\HasOrderableRelations;


class NoticeService
{
    use HasOrderableRelations;

    protected PhotoStorageConfig $configPhotos;
    protected PhotoService $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
        $this->configPhotos = new PhotoStorageConfig('public', 'notices/photos', 'photo', 'banner');
    }

    public function buildQuery(object $filters, bool $isAdmin = false, $query)
    {
        $query->when($filters->search, function ($query, $search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('publication_date', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('noticeStatus', 'name', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('newsCategory', 'name', 'LIKE', '%' . $search . '%');
        });

        if ($isAdmin) {
            $this->applyOrdering($query, $filters->order, $filters->direction);
            return $query->paginate($filters->rows)->withQueryString();
        }

        return $query;
    }

    public function createNotice(array $data): Notice | null
    {
        return DB::Transaction(function () use ($data) {
            $notice = Notice::create($data);
            $notice->keywords()->createMany($data['keywords'] ?? []);
            $this->photoService->upsertPhoto($notice, $data['photo'], $this->configPhotos);

            if ($data['email_notification'] == 1 && $notice->notice_status_id == 2) {
                $users = User::all();
                Notification::send($users, new NoticeNotification($notice));
            }
        });
    }

    public function updateNotice(Notice $notice, array $data): Notice | null
    {
        return DB::Transaction(function () use ($notice, $data) {
            $notice->update($data);
            $notice->keywords()->delete();
            $notice->keywords()->createMany($data['keywords'] ?? []);

            $this->photoService->upsertPhoto($notice, $data['photo'], $this->configPhotos);

            if ($data['email_notification'] == 1 && $notice->notice_status_id == 2) {
                $users = User::all();
                Notification::send($users, new NoticeNotification($notice));
            }
        });
    }

    public function deleteNotice(Notice $notice): void
    {
        DB::Transaction(function () use ($notice) {
            if ($notice->photo) {
                $this->photoService->deletePhoto($notice->photo, 'public', true);
            }
            $notice->keywords()->delete();
            $notice->delete();
        });
    }
    protected function getOrderableRelations(): array
    {
        return [
            'category' => ['news_categories', 'news_category_id', 'name'],
            'status' => ['notice_statuses', 'notice_status_id', 'name'],
        ];
    }
}
