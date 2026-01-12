<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrivacityComplianceResource;
use App\Http\Requests\UpdateMailSettingRequest;
use App\Http\Resources\EmailTemplateResource;
use Illuminate\Support\Facades\Artisan;
use App\Models\ConsentConfiguration;
use App\Models\PrivacityCompliance;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\MailSetting;
use App\Traits\Filterable;
use App\Models\Policy;
use Inertia\Response;
use Inertia\Inertia;



class SystemSettingController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;

    public function __construct()
    {
        $this->routeName = "system.settings.";
        $this->source    = "Core/Settings/System/Pages/";

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        /*$this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);*/
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $query = PrivacityCompliance::query()
            ->when($filters->search, function ($query, $search) {
                $query->where('version', 'LIKE', '%' . $search . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $search . '%');
            });

        $privacityCompliances = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        $mailSetting = MailSetting::first();

        if ($mailSetting) {
            $mailSetting->makeHidden(['password']);
        }

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Ajustes del sistema',
            'routeName' => $this->routeName,
            'filters'   => $filters,
            'policies' => Policy::first() ?? [],
            'consentConfigurations' => ConsentConfiguration::first() ?? [],
            'privacityCompliances' => $privacityCompliances !== null ? PrivacityComplianceResource::collection($privacityCompliances) : [],
            'emailTemplates' => EmailTemplateResource::collection(EmailTemplate::all()),
            'mailSetting' => $mailSetting ?? [],
        ]);
    }

    public function update(UpdateMailSettingRequest $request)
    {
        $validatedData = $request->validated();
        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        }

        $mailSetting = MailSetting::first();
        
        if ($mailSetting) {
            $mailSetting->update($validatedData);
        } else {
            MailSetting::create($validatedData);
        }

        Artisan::call('queue:restart');
        Artisan::call('config:clear');

        return redirect()->back()
            ->with('success', "Configuración de correo actualizada correctamente.");
    }
}
