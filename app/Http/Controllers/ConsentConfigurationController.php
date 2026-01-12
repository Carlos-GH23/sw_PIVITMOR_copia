<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateConsentConfigurationRequest;
use App\Models\ConsentConfiguration;

class ConsentConfigurationController extends Controller
{
    public function __construct()
    {
        //admin permissions
        $this->middleware("permission:system.settings.consentConfiguration.update")->only(['update']);
    }
    public function update(UpdateConsentConfigurationRequest $request)
    {
        $consentConfiguration = ConsentConfiguration::first();

        if ($consentConfiguration === null ){
            $consentConfiguration = ConsentConfiguration::Create($request->validated());
        }else{
            $consentConfiguration->update($request->validated());
        }

        return redirect()->back()
            ->with('success', "Politicas actualizadas correctamente.");
    }
}
