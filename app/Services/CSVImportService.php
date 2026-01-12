<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CSVImportService
{

    public function import(UploadedFile $file, string $modelClass): void
    {
        $columnMapping = $modelClass::getCsvColumnMapping();
        $validationRules = $modelClass::getCsvValidationRules();

        if (empty($validationRules)) {
            throw new \Exception('El modelo no reglas de validación CSV definidos.');
        }

        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $dataForBulkInsert = [];
        $errors = [];
        $rowNumber = 1;

        foreach ($records as $record) {
            $rowNumber++;
            $dataToValidate = [];

            foreach ($validationRules as $field => $rule) {
                $dataToValidate[$field] = $record[$field] ?? null;
            }

            $validator = Validator::make($dataToValidate, $validationRules);

            if ($validator->fails()) {
                $errors['Fila ' . $rowNumber] = $validator->errors()->all();
                continue;
            }

            $validatedData = $validator->validated();
            $dataToInsert = [];


            foreach ($columnMapping as $csvColumn => $modelField) {
                if (isset($validatedData[$csvColumn])) {
                    $dataToInsert[$modelField] = $validatedData[$csvColumn];
                }
            }

            $dataForBulkInsert[] = $dataToInsert;
        }
        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
        if (!empty($dataForBulkInsert)) {
            DB::transaction(function () use ($modelClass, $dataForBulkInsert) {
                foreach ($dataForBulkInsert as $row) {
                    if (method_exists($modelClass, 'prepareCsvRowForImport')) {
                        $row = $modelClass::prepareCsvRowForImport($row);
                    }
                    $modelClass::create($row);
                }
            });
        }
    }

    public function downloadTemplate(string $modelClass): string
    {
        $columnMapping = $modelClass::getCsvColumnMapping();

        if (empty($columnMapping)) {
            throw new \Exception('El modelo no tiene un mapa de columnas CSV definidos.');
        }

        $headers = array_keys($columnMapping);

        $handle = fopen('php://memory', 'r+');

        fputcsv($handle, $headers);

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return $csvContent;
    }
}
