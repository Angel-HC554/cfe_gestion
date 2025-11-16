<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenVehiculo; // Agrega imports para tus modelos existentes
use App\Models\Vehiculo;
use Illuminate\Support\Facades\Cache; // Para cache

class HomeController extends Controller
{
    public function index()
    {
        // Usa cache para los conteos (60 min = 3600 seg)
        $conteosMantenimiento = Cache::remember('conteos_mantenimiento', 3600, function () {
            $vehiculos = Vehiculo::with(['latestSupervision', 'latestMantenimiento'])->get();
            return [
                'amarillo' => $vehiculos->where('estado_mantenimiento', 'amarillo')->count(),
                'rojo' => $vehiculos->where('estado_mantenimiento', 'rojo')->count(),
                'rojo_pasado' => $vehiculos->where('estado_mantenimiento', 'rojo_pasado')->count(),
                'total' => $vehiculos->count(),
            ];
        });

        // Agrega tus otras consultas existentes
        $totalOrdenes = OrdenVehiculo::count();
        $ordenesPendientes = OrdenVehiculo::where('status', 'PENDIENTE')->count();
        $ordenesCompletadas = OrdenVehiculo::where('status', 'VEHICULO FUNCIONAMIENTO')->count();
        $totalVehiculos = Vehiculo::count();
        $vehiculosConSupervisionDiaria = Vehiculo::conSupervisionDiariaHoy()->count();
        $vehiculosConSupervisionSemanal = Vehiculo::conSupervisionSemanalEstaSemana()->count();

        // Pasa todo a la vista
        return view('dashboard', compact(
            'conteosMantenimiento',
            'totalOrdenes', 'ordenesPendientes', 'ordenesCompletadas',
            'totalVehiculos', 'vehiculosConSupervisionDiaria', 'vehiculosConSupervisionSemanal'
        ));
    }
}
