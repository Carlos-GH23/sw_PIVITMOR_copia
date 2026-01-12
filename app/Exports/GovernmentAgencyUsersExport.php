<?php

namespace App\Exports;

use App\Models\GovernmentAgency\GovernmentAgency;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GovernmentAgencyUsersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return GovernmentAgency::with(['governmentLevel', 'economicSector'])
            ->get()
            ->map(function ($agency) {
                return [
                    'ID' => $agency->id,
                    'Nombre' => $agency->name,
                    'Acrónimo' => $agency->acronym ?? '-',
                    'Nivel de Gobierno' => $agency->governmentLevel->name ?? '-',
                    'Sector Económico' => $agency->economicSector->name ?? '-',
                    'Objetivos' => strip_tags($agency->objectives),
                    'Estatus' => $agency->is_active ? 'Activa' : 'Inactiva',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Acrónimo',
            'Nivel de Gobierno',
            'Sector Económico',
            'Objetivos',
            'Estatus',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '283C2A'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E6F4EA'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:G{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '283C2A'],
                ],
            ],
        ]);
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(38);
        $sheet->getColumnDimension('G')->setWidth(12);
        return [];
    }
}
