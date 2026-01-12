<?php

namespace App\Http\Controllers\Notice;

use App\Http\Requests\Notice\UpdateNoticeRequest;
use App\Http\Requests\Notice\StoreNoticeRequest;
use App\Http\Resources\Notice\NoticeResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\NewsCategory;
use App\Http\Controllers\Controller;
use App\Models\Notice\NoticeStatus;
use App\Services\NoticeService;
use Illuminate\Http\Request;
use App\Models\Notice\Notice;
use App\Traits\Filterable;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
    use Filterable;

    protected NoticeService $noticeService;
    protected string $routeName;
    protected string $source;
    protected Model $model;

    public function __construct(NoticeService $noticeService)
    {
        $this->routeName = "notices.";
        $this->model     = new Notice();
        $this->noticeService = $noticeService;
        $this->source    = "Core/Admin/Notices/Pages/";

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
    }

    public function index(Request $request)
    {
        $filters = (object) $this->getFiltersBase($request->query());
        $query = Notice::query()->with(['newsCategory', 'noticeStatus', 'photo']);
        $notices = $this->noticeService->buildQuery($filters, true, $query);

        return Inertia::render("{$this->source}Index", [
            'title'           => 'Gestión de Noticias',
            'routeName'       => $this->routeName,
            'notices'        => NoticeResource::collection($notices),
            'filters'         => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'           => 'Crear Noticia',
            'routeName'       => $this->routeName,
            'categories'      => NewsCategory::select('id', 'name')->get(),
            'statuses'        => NoticeStatus::select('id', 'name')->get(),
        ]);
    }

    public function store(StoreNoticeRequest $request)
    {
        try {
            $this->noticeService->createNotice($request->validated());
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Noticia creada exitosamente.');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->with('error', 'Error al crear la noticia');
        }
    }

    public function edit(Notice $notice)
    {
        $notice->load(['newsCategory:id,name', 'noticeStatus:id,name', 'keywords', 'photo']);
        $notice = new NoticeResource($notice);

        return Inertia::render("{$this->source}Edit", [
            'title'           => 'Editar Noticia',
            'routeName'       => $this->routeName,
            'notice'          => $notice,
            'categories'      => NewsCategory::select('id', 'name')->get(),
            'statuses'        => NoticeStatus::select('id', 'name')->get(),
        ]);
    }

    public function update(UpdateNoticeRequest $request, Notice $notice)
    {
        try {
            $this->noticeService->updateNotice($notice, $request->validated());
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Noticia actualizada exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la noticia');
        }
    }

    public function destroy(Notice $notice)
    {
        try {
            $this->noticeService->deleteNotice($notice);
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Noticia eliminada exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la noticia');
        }
    }
}
