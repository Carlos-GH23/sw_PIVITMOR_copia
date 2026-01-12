<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    protected FileService $fileService;
    protected string $storage_path = 'photos';

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Interface/Profile/Edit', [
            'user' => new UserResource(
                Auth::user()->load('photo')
            )
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());
        $user->update($request->validated());
        $this->fileService->storeOrUpdate(
            'photos_user',
            [
                'file' => $request->photo,
                'file_type_id' => 1, // photo user
                'relation' => 'photo'
            ],
            $user
        );
        return Redirect::route('profile.edit')->with('success', 'Perfil actualizado con éxito');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function destroyPhoto()
    {
        $this->fileService->destroy(Auth::user()->photo);

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado con éxito');
    }
}
