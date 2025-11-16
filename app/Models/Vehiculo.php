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

    public function supervisioDiaria()
    {
        return $this->hasMany(SupervisionDiaria::class);
    }
    
    public function supervisioSemanal()
    {
        return $this->hasMany(SupervisionSemanal::class);
    }

    public function ultimoKilometraje()
    {
         $ultimaSupervision = $this->supervisioDiaria()
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_fin', 'desc')
            ->first();

        return $ultimaSupervision ? $ultimaSupervision->kilometraje : 0;
    }

    public function tieneSupervisionHoy()
    {
        return $this->supervisioDiaria()
            ->whereDate('fecha', today())
            ->exists();
    }

    public function tieneSupervisionSemanal()
    {
        return $this->supervisioSemanal()
            ->whereDate('created_at', today())
            ->exists();
    }

    /**
 * Scope para filtrar vehículos que tienen supervisión diaria hoy.
 */
public function scopeConSupervisionDiariaHoy($query)
{
    return $query->whereHas('supervisioDiaria', function ($q) {
        $q->whereDate('fecha', today());
    });
}

/**
 * Scope para filtrar vehículos que tienen supervisión semanal esta semana.
 * NOTA: Corregí tu lógica para que busque en la semana actual, no solo hoy.
 */
public function scopeConSupervisionSemanalEstaSemana($query)
{
    return $query->whereHas('supervisioSemanal', function ($q) {
        // whereBetween busca desde el inicio de la semana (Lunes) hasta el final (Domingo)
        $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    });
}

    /**
     * Obtiene el ÚLTIMO registro de supervisión diaria (el KM más actual).
     * Esta es una relación hasOne para eficiencia (Eager Loading).
     */
    public function latestSupervision()
    {
        // Usa la llave foránea 'vehiculo_id' que ya existe en tu tabla.
        // Ordena por fecha y luego por hora para asegurar que sea el último.
        return $this->hasOne(SupervisionDiaria::class)->latest('fecha')->latest('hora_fin');
    }

    /**
     * Obtiene la ÚLTIMA orden de mantenimiento/servicio (el KM base).
     * Esta es una relación hasOne para eficiencia (Eager Loading).
     */
    public function latestMantenimiento()
    {
        // Vincula 'vehiculos.no_economico' con 'orden_vehiculos.noeconomico'.
        // Ordena por 'kilometraje' DESC para obtener la orden con el KM más alto.
        return $this->hasOne(OrdenVehiculo::class, 'noeconomico', 'no_economico')
                    ->where('observacion', 'like', '%mantenimiento%')
                    ->latest('kilometraje');
    }

    /*public function getEstadoMantenimientoAttribute()
    {
        // --- REGLAS ---
        $intervalo = 10000;       // Mantenimiento cada 10,000 km
        $ventanaRoja = 1000;      // 1,000 km o menos = ROJO
        $ventanaAmarilla = 2000;  // 2,000 km o menos = AMARILLO
        $margenServicio = 500;    // KM de margen para considerar un servicio "recién hecho"
        // --- Fin de las reglas ---

        $kmActual = $this->latestSupervision->kilometraje ?? 0;
        $kmUltimoMantenimiento = $this->latestMantenimiento->kilometraje ?? 0;

        if ($kmActual === 0) {
            return 'gris'; // Sin datos
        }

        // 1. REVISIÓN DE SERVICIO RECIENTE
        // Si el KM actual y el del último servicio son casi iguales, está VERDE.
        if (abs($kmActual - $kmUltimoMantenimiento) <= $margenServicio) {
            return 'verde'; // ¡Servicio recién hecho!
        }

        // 2. REVISIÓN DE VENCIMIENTO
        // Si han pasado más de 10,000 km desde el último servicio y si ya ha tenido un servicio.
        if ($kmUltimoMantenimiento > 0) {
            $kmDesdeUltimoServicio = $kmActual - $kmUltimoMantenimiento;
        if ($kmDesdeUltimoServicio > $intervalo) {
            return 'rojo_pasado'; // ¡Está vencido!
        }
        }
        

        // 3. LÓGICA DEL SEMÁFORO (Si no está vencido y no está recién hecho)
        // Calculamos cuál es el próximo mantenimiento en el horizonte.
        // Ej: ceil(158,500 / 10,000) * 10,000 = 160,000
        $proximoMantenimiento = ceil($kmActual / $intervalo) * $intervalo;
        
        // Si el KM actual es 0, proximoMantenimiento será 0. Lo ajustamos al primer intervalo.
        if ($proximoMantenimiento == 0) $proximoMantenimiento = $intervalo;

        $kmFaltantes = $proximoMantenimiento - $kmActual;

        if ($kmFaltantes <= $ventanaRoja) {
            return 'rojo'; // Menos de 1,000 km faltantes
        }
        if ($kmFaltantes <= $ventanaAmarilla) {
            return 'amarillo'; // Menos de 2,000 km faltantes
        }
        
        // Si faltan más de 2,000 km
        return 'verde';
    } */
    public function getEstadoMantenimientoAttribute()
{
    $intervalo = 10000;
    $ventanaRoja = 1000;
    $ventanaAmarilla = 2000;
    $margenServicio = 500;

    $supervision = $this->latestSupervision;
    $mantenimiento = $this->latestMantenimiento;

    if (!$supervision || $supervision->kilometraje === null) {
        return 'gris';
    }

    $kmActual = $supervision->kilometraje;
    $kmUltimoMantenimiento = $mantenimiento?->kilometraje ?? 0;

    // 1. Servicio reciente
    if ($mantenimiento && abs($kmActual - $kmUltimoMantenimiento) <= $margenServicio) {
        return 'verde';
    }

    // 2. Vencido (solo si HAY mantenimiento)
    if ($mantenimiento && ($kmActual - $kmUltimoMantenimiento) > $intervalo) {
        return 'rojo_pasado';
    }

    // 3. Próximo mantenimiento: basado en el ÚLTIMO servicio
    if ($mantenimiento) {
        $proximoMantenimiento = $kmUltimoMantenimiento + $intervalo;
    } else {
        $proximoMantenimiento = ceil($kmActual / $intervalo) * $intervalo;
        if ($proximoMantenimiento == 0) $proximoMantenimiento = $intervalo;
    }

    $kmFaltantes = $proximoMantenimiento - $kmActual;

    if ($kmFaltantes <= $ventanaRoja) {
        return 'rojo';
    }
    if ($kmFaltantes <= $ventanaAmarilla) {
        return 'amarillo';
    }

    return 'verde';
}



}
