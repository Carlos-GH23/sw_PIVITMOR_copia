<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePolicyRequest;
use App\Models\Policy;
use Inertia\Inertia;

class PolicyController extends Controller
{
    public function __construct()
    {
        //admin permissions
        $this->middleware("permission:system.settings.policy.update")->only(['update']);
    }
    
    public function update(UpdatePolicyRequest $request)
    {
        $policy = Policy::first();
        if ($policy === null ){
            $policy = Policy::Create($request->validated());
        }else{
            $policy->update($request->validated());
        }
        

        return redirect()->back()
            ->with('success', "Politicas actualizadas correctamente.");
    }
}
