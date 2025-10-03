<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HistorialOrden extends Model
{
    protected $table = 'historial_ordenes';
    protected $fillable = [
        'orden_vehiculo_id', 'tipo_evento', 'detalles', 'old_value', 'new_value'
    ];

    public function ordenVehiculo()
    {
        return $this->belongsTo(OrdenVehiculo::class,'orden_vehiculo_id');
    }
}
