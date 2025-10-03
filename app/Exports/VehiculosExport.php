<?php

namespace App\Exports;

use App\Models\Vehiculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VehiculosExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Vehiculo::all();
    }

    /**
     * Define los encabezados para mantener el mismo diseño del import
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Agencia',
            'Número Económico',
            'Placas',
            'Tipo Vehículo',
            'Marca',
            'Modelo',
            'Año',
            'Estado',
            'Propiedad',
            'Proceso',
            'Alias',
            'RPE Crea/Modifica',
        ];
    }

    /**
     * Mapea cada registro de Vehiculo al orden de columnas de las cabeceras
     *
     * @param \App\Models\Vehiculo $vehiculo
     * @return array
     */
    public function map($vehiculo): array
    {
        return [
            $vehiculo->id,
            $vehiculo->agencia,
            $vehiculo->no_economico,
            $vehiculo->placas,
            $vehiculo->tipo_vehiculo,
            $vehiculo->marca,
            $vehiculo->modelo,
            // Si la columna en BD es "año", accedemos de forma segura
            $vehiculo->{'año'} ?? null,
            $vehiculo->estado,
            $vehiculo->propiedad,
            $vehiculo->proceso,
            $vehiculo->alias,
            $vehiculo->rpe_creamod,
        ];
    }

    /**
     * Aplica estilos al documento (encabezado en negritas, fondo, centrado y congelación de fila)
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return array
     */
    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet): array
    {
        // Rango del encabezado (12 columnas A..L)
        $headerRange = 'A1:M1';

        // Negritas y alineación del encabezado
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($headerRange)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // Fondo gris claro al encabezado
        $sheet->getStyle($headerRange)
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('F2F2F2');

        // Congelar la primera fila
        $sheet->freezePane('A2');

        return [];
    }
}
