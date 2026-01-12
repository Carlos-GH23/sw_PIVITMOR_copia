<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CSVRequest;
use App\Services\CSVImportService;
use Exception;
use Illuminate\Validation\ValidationException;

class CsvController extends Controller
{
    protected CSVImportService $csvImportService;

    public function __construct(CSVImportService $csvImportService)
    {
        $this->csvImportService = $csvImportService;
    }

    public function uploadCSV(CSVRequest $request)
    {
        set_time_limit(300);
        $request->validated();

        try {
            $this->csvImportService->import($request->csv, 'App\Models\\' . $request->model_class);
            return redirect()->back()->with('success', 'Información importada exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(['csv' => 'Error de validación al importar el archivo CSV']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['csv' => 'Error al procesar el archivo CSV']);
        }
    }

    public function downloadTemplate(Request $request)
    {
        $request->validate([
            'model_class' => 'required|string'
        ]);

        try {
            $filename = 'plantilla_' . strtolower(class_basename($request->model_class)) . '.csv';

            return response($this->csvImportService->downloadTemplate('App\Models\\' . $request->model_class))
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['csv' => 'Error al descargar la plantilla: ' . $e->getMessage()]);
        }
    }
}
