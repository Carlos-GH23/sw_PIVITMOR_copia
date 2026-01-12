<?php

namespace App\Http\Middleware;

use App\Http\Resources\ContactInformationResource;
use App\Http\Resources\PolicyResource;
use App\Http\Resources\UserResource;
use App\Models\ContactInformation;
use App\Models\Policy;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user'  => $request->user()  ? new UserResource($request->user()->load('photo')) : null,
                'roles' => $request->user()  ? $request->user()->getRolesArray() : [],
                'can'   => $request->user()  ? $request->user()->getPermissionArray() : [],
            ],
            'contactInformation' => fn() => ($contactInfo = ContactInformation::with('phoneNumbers')->first())
                ? ContactInformationResource::make($contactInfo)
                : null,
            'policies' => fn() => PolicyResource::make(
                Policy::first() ?? new Policy()
            ),
            'ziggy' => fn() => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => function () use ($request) {
                foreach (['success', 'error', 'danger', 'isBanned'] as $key) {
                    if ($message = $request->session()->get($key)) {
                        return [
                            'style' => $key,
                            'message' => $message,
                        ];
                    }
                }
                return null;
            },
        ];
    }
}
