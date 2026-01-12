<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePrivacityComplianceRequest;
use App\Http\Requests\UpdatePrivacityAcceptanceRequest;
use App\Notifications\PrivacityAdviceDenyNotification;
use App\Http\Resources\PrivacityAcceptanceResource;
use App\Http\Resources\PrivacityComplianceResource;
use Illuminate\Support\Facades\Notification;
use App\Models\PrivacityAdviceAcceptance;
use App\Models\PrivacityCompliance;
use Illuminate\Support\Facades\Auth;
use App\Models\ConsentConfiguration;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PrivacityComplianceController extends Controller
{
    protected string $source;
    protected string $routeName;
    public function __construct()
    {
        $this->source = "Domains/Academic/Policy/Pages/";
        $this->routeName = "policies.";
        
        //academic permissions
        $this->middleware("permission:{$this->routeName}index")->only(['index']);
        $this->middleware("permission:{$this->routeName}accept")->only(['acceptPrivacityAdvice']);
        //admin permissions
        $this->middleware("permission:system.settings.privacityCompliance.update")->only(['update']);
        $this->middleware("permission:system.settings.privacityCompliance.enable")->only(['enable']);
    }

    public function index()
    {
        $privacity = PrivacityCompliance::where('is_active', 1)->first();
        $privacityConfirmation = PrivacityAdviceAcceptance::where('user_id', Auth::id())
            ->first();

        $privacityConfirmation = $privacityConfirmation ? PrivacityAcceptanceResource::make($privacityConfirmation) : [];

        return Inertia::render("{$this->source}Index", [
            'title' => 'Políticas de privacidad',
            'routeName' => $this->routeName,
            'privacity' => PrivacityComplianceResource::make($privacity),
            'privacityConfirmation' => $privacityConfirmation,
        ]);
    }

    public function store(UpdatePrivacityComplianceRequest $request)
    {
        $renovationFrequency = ConsentConfiguration::first()?->frequency_of_acceptance ?? null;

        if ($renovationFrequency === "version_change") {
            PrivacityAdviceAcceptance::query()->delete();
        }

        $privacityCompliance = PrivacityCompliance::where('is_active', 1)->first();

        if ($privacityCompliance === null) {
            $privacityCompliance = PrivacityCompliance::Create($request->validated());
        } else {
            $privacityCompliance->update(['is_active' => 0]);
            $privacityCompliance = PrivacityCompliance::Create($request->validated());
        }

        return redirect()->back()
            ->with('success', "Politicas actualizadas correctamente.");
    }

    public function enable(PrivacityCompliance $privacityCompliance)
    {
        if ($privacityCompliance->is_active === 1) {
            return redirect()->back()
                ->with('error', "Debe haber al menos una política de privacidad activa.");
        } else {
            PrivacityCompliance::where('is_active', 1)->update(['is_active' => 0]);
            $privacityCompliance->update(['is_active' => 1]);
            return redirect()->back()
                ->with('success', "Política de privacidad activada correctamente.");
        }
    }

    public function acceptPrivacityAdvice(UpdatePrivacityAcceptanceRequest $request)
    {
        $userId = Auth::id();

        DB::Transaction(function () use ($request, $userId) {
            $validatedData = $request->validated();
            PrivacityAdviceAcceptance::updateOrCreate(
                [
                    'user_id' => $userId,
                    'privacity_compliance_id' => $validatedData['privacity_compliance_id'],
                ],
                [
                    'is_accepted' => $validatedData['is_accepted'],
                ]
            );
        });

        if ($request->is_accepted) {
            return redirect()->back()
                ->with('success', "Gracias por aceptar las políticas de privacidad.");
        } else {
            Notification::send(Auth::user(), new PrivacityAdviceDenyNotification());
            return redirect()->back()
                ->with('error', "Has rechazado las políticas de privacidad. En breve se le proporcionará más información vía correo electrónico.");
        }
    }
}
