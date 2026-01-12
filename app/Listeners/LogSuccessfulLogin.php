<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $role = $user->roles->first();

        activity('auth')
            ->causedBy($user)
            ->withProperties(['ip' => Request::ip(), 'user_agent' => Request::userAgent(), 'role_id' => $role?->id])
            ->tap(function ($activity) use ($role) {
                $activity->event = 'login';
                $activity->role_name = $role?->name ?? 'Sin Rol';
                $activity->role_id = $role?->id;
                $activity->module_key = 'auth';
            })
            ->log('Inició sesión en el sistema');
    }
}
