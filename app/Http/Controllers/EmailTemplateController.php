<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        //
    }

    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        $validatedData = $request->validated();

        $emailTemplate->update([
            'subject' => $validatedData['subject'],
            'body' => $validatedData['body'],
        ]);

        return redirect()->back()
            ->with('success', 'Plantilla de correo electrónico actualizada correctamente.');
    }
}
