<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'id',
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
