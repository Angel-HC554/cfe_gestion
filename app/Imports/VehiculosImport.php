<?php

namespace App\Imports;

use App\Models\Vehiculo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class VehiculosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithUpserts
{
    public function __construct()
    {
        // Preservar los encabezados tal cual aparecen (incluido '#')
        HeadingRowFormatter::default('none');
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Vehiculo([
            // ID proviene de la columna '#' del Excel exportado
            'id' => $row['#'] ?? null,
            'agencia' => $row['Agencia'],
            'no_economico' => $row['Número Económico'],
            'placas' => $row['Placas'],
            'tipo_vehiculo' => $row['Tipo Vehículo'],
            'marca' => $row['Marca'],
            'modelo' => $row['Modelo'],
            'año' => $row['Año'],
            'estado' => $row['Estado'],
            'propiedad' => $row['Propiedad'],
            'proceso' => $row['Proceso'],
            'alias' => $row['Alias'],
            'rpe_creamod' => $row['RPE Crea/Modifica'],
        ]);
    }

    /**
     * Define the columns that uniquely identify a Vehiculo record to perform an upsert.
     * Adjust this if your unique business key differs.
     *
     * @return string|array
     */
    public function uniqueBy()
    {
        // Usar el ID del vehículo como clave única (columna '#' en el Excel)
        return 'id';
    }

    /**
     * Define which columns are updated when a duplicate is found.
     * Do not include the conflict keys here.
     *
     * @return array
     */
    public function upsertColumns()
    {
        // Actualizar todos los campos posteriores a 'id'
        return [
            'agencia',
            'no_economico',
            'placas',
            'tipo_vehiculo',
            'marca',
            'modelo',
            'año',
            'estado',
            'propiedad',
            'proceso',
            'alias',
            'rpe_creamod',
        ];
    }

    //Procesa cada mil lineas en lugar de todo
    public function batchSize(): int
    {
        return 1000;
    }
    //Inserta cada mil datos a la vez en caso de que el archivo sea grande
    public function chunkSize(): int
    {
        return 1000;
    }
}
