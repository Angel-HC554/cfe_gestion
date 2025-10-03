<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenArchivo extends Model
{
    protected $fillable = [
        'orden_vehiculo_id',
        'ruta_archivo',
        'tipo_archivo',
        'comentarios',
    ];

    /**
     * Get the ordenVehiculo that owns the OrdenArchivo
     */
    public function ordenVehiculo()
    {
        return $this->belongsTo(OrdenVehiculo::class, 'orden_vehiculo_id');
    }
}
