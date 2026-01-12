<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Notice\NoticeResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use App\Models\Notice\Notice;
use App\Models\Notice\NoticeStatus;
use Illuminate\Http\Request;
use App\Traits\Filterable;
use Inertia\Inertia;


class HomeNoticeController extends Controller
{
    use Filterable;
    protected NoticeService $noticeService;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct(NoticeService $noticeService)
    {
        $this->routeName = "welcome.notices";
        $this->model     = new Notice();
        $this->noticeService = $noticeService;
        $this->source    = "Interface/Welcome/Pages/";
    }

    public function index(Request $request)
    {
        $filters = (object) $this->getFiltersBase($request->query());

        $query = Notice::query()->with(['newsCategory', 'noticeStatus', 'photo'])
        ->whereHas('noticeStatus', function ($q) {
            $q->where('id', 2);
        });
        $query = $this->noticeService->buildQuery($filters, false, $query);
        

        $notices = $query->orderBy('publication_date', 'desc')
            ->paginate(6)
            ->withQueryString();

        return Inertia::render("{$this->source}News", [
            'title'           => 'Noticias',
            'routeName'       => $this->routeName,
            'notices'        => NoticeResource::collection($notices),
            'filters'         => $filters,
        ]);
    }

    public function show($slug = null, $id)
    {
        $notice = $this->model->findOrFail($id);

        $noticeStatus = NoticeStatus::find($notice->notice_status_id);

        if ($noticeStatus->id !== 2) {
            return redirect()->route('welcome.notices');
        }
        if ($notice->slug !== $slug) {
            return redirect()->route('welcome.notices.details', [
                'slug' => $notice->slug,
                'id' => $notice->id
            ], 301);
        }
        $moreNews= Notice::where('id', '!=', $notice->id)
            ->latest()->limit(6)
            ->get();

        $moreNews->load(['newsCategory:id,name', 'noticeStatus:id,name,color', 'photo', 'keywords']);
        
        $notice->load(['newsCategory:id,name', 'noticeStatus:id,name,color', 'photo', 'keywords']);

        return Inertia::render("{$this->source}NewsDetails", [
            'title'           => 'Noticias',
            'routeName'       => $this->routeName,
            'notice'        => new NoticeResource($notice),
            'moreNews'      => NoticeResource::collection($moreNews),
        ]);
    }
}
