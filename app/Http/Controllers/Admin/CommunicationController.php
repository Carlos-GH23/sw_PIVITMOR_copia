<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunicationRequest;
use App\Notifications\CommunicationNotification;
use App\Jobs\SendCommunicationAndCleanup;
use App\Services\FileService;
use App\DTOs\FileStorageConfig;
use App\Models\Communication;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CommunicationController extends Controller
{
    protected string $routeName;
    protected Model $model;
    protected string $source;
    protected FileService $fileService;
    protected FileStorageConfig $configFiles;

    public function __construct(FileService $fileService)
    {
        $this->routeName = "communication.";
        $this->model = new Communication();
        $this->source = "Core/Admin/Communication/Pages/";
        $this->fileService = $fileService;
        $this->configFiles = new FileStorageConfig('public', 'email/files', 'files');

        $this->middleware("permission:{$this->routeName}index")->only(['index']);
    }

    public function index()
    {
        $roles = Role::get();
        $all = (object) [
            'id' => 0,
            'name' => 'Todos',
        ];
        $roles->prepend($all);

        $statuses = [
            1 => 'Habilitados',
            0 => 'Deshabilitados',
            2 => 'Todos'
        ];
        $statuses = collect($statuses)->map(function ($label, $value) {
            return [
                'id' => $value,
                'name' => $label,
            ];
        })->values()->all();

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Gestión de correos',
            'routeName' => $this->routeName,
            'roles'     => $roles,
            'statuses'  => $statuses,
        ]);
    }

    public function email(CommunicationRequest $request)
    {
        $validatedData = $request->validated();
        $status = $validatedData['status'];
        $users = [];
        

        if ($validatedData['recipients'] === 0 || $validatedData['recipients'] === "0") {
            $users = User::whereHas('roles', function ($query) use ($status) {
                $query->whereNot('id', 1);

                if ($status !== 2 && $status !== "2") {
                    $query->where('is_active', $status);
                }
            })->get();
        } else {
            $roleId = $validatedData['recipients'];

            $users = User::whereHas('roles', function ($query) use ($roleId, $status) {
                $query->where('id', $roleId);

                if ($status !== 2 && $status !== "2") {
                    $query->where('is_active', $status);
                }
            })->get();
        }
        
        if ($users->isEmpty() || $users->count() === 0) {
            return redirect()->back()
                ->with('error', 'No se encontraron usuarios para los destinatarios seleccionados.');
        }

        DB::Transaction(function () use ($validatedData, $users) {
            $attachmentsData = [];

            $communication = $this->model->create($validatedData);

            foreach ($validatedData['files'] ?? [] as $file) {
                if (isset($file['file']) && $file['file'] instanceof UploadedFile) {
                    $fileModel = $this->fileService->storeFile($communication, $file, $this->configFiles);

                    if ($fileModel instanceof File) {

                        $extension = pathinfo($fileModel->filename, PATHINFO_EXTENSION);
                        $friendlyFilename = $fileModel->title . '.' . $extension;
                        $attachmentsData[] = [
                            'path'  => $fileModel->path,
                            'title' => $friendlyFilename,
                            'mime'  => $fileModel->mime_type,
                        ];
                    }
                }
            }


            $subject = $validatedData['subject'];
            $body = $validatedData['body'];
            $footer = $validatedData['footer'];

            SendCommunicationAndCleanup::dispatch(
                $communication,
                $users,
                $subject,
                $body,
                $footer,
                $attachmentsData
            );
        });

        return redirect()->back()->with('success', 'Comunicado enviado exitosamente');
    }
}
