<?php

namespace App\Http\Controllers;

use App\Models\ContactInformation;
use App\Http\Requests\UpdateContactInformationRequest;
use App\Http\Resources\ContactInformationResource;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class ContactInformationController extends Controller
{
    use Filterable;

    private string $routeName;
    private string $source;
    private Model $model;

    public function __construct(ContactInformation $contactInformation)
    {
        $this->source = 'Core/Admin/Contents/ContactInforrmation/Pages/';
        $this->model = $contactInformation;
        $this->routeName = 'contactInformation.';
        $this->middleware("permission:contactInformation")->only(['edit', 'update']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $contactInformation = ContactInformation::with('phoneNumbers')->first();
        return Inertia::render("{$this->source}Edit", [
            'contactInformation' => $contactInformation ? new ContactInformationResource($contactInformation) : null,
            'title' => 'Editar información de contacto',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactInformationRequest $request)
    {
        $contactInformation = ContactInformation::first();
        if (!$contactInformation) {
            $contactInformation = ContactInformation::create($request->only([
                'email',
                'address',
                'latitude',
                'longitude',
                'opening_time',
                'closing_time',
            ]));
        } else {
            $contactInformation->update($request->only([
                'email',
                'address',
                'latitude',
                'longitude',
                'opening_time',
                'closing_time',
            ]));
        }

        $phones = $request->input('phones', []);
        $existingIds = $contactInformation->phoneNumbers()->pluck('id')->toArray();
        $sentIds = collect($phones)->pluck('id')->filter()->toArray();

        $toDelete = array_diff($existingIds, $sentIds);
        if (!empty($toDelete)) {
            $contactInformation->phoneNumbers()->whereIn('id', $toDelete)->delete();
        }

        foreach ($phones as $phone) {
            if (isset($phone['id']) && in_array($phone['id'], $existingIds)) {
                $contactInformation->phoneNumbers()->where('id', $phone['id'])->update([
                    'number' => $phone['number'],
                    'dial_code' => $phone['dial_code'],
                    'type' => $phone['type'],
                ]);
            } else {
                $contactInformation->phoneNumbers()->create([
                    'number' => $phone['number'],
                    'dial_code' => $phone['dial_code'],
                    'type' => $phone['type'],
                ]);
            }
        }

        return redirect()
            ->route($this->routeName . 'edit')
            ->with('success', 'Información de contacto actualizada correctamente.');
    }
}
