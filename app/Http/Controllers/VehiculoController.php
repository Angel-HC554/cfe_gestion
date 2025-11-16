<?php

namespace App\Http\Controllers;

use App\Imports\VehiculosImport;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use App\Models\OrdenVehiculo;
use App\Models\SupervisionSemanal;
use Maatwebsite\Excel\Facades\Excel;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        return view('vehiculos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiculo $vehiculo)
    {
        $vehiculo->load(['latestSupervision', 'latestMantenimiento']);
        $numero_eco = $vehiculo->no_economico;
        $ordenes = OrdenVehiculo::with('archivos', 'historial')->where('noeconomico', $numero_eco)->get();
        $fotos = SupervisionSemanal::select('foto_del', 'foto_tra', 'foto_lado_der', 'foto_lado_izq')
            ->where('no_eco', $numero_eco)
            ->orderBy('created_at', 'desc')
            ->first();
        $supervision_existe = SupervisionSemanal::where('no_eco', $numero_eco)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->exists();

        return view('vehiculos.show', compact('vehiculo', 'ordenes', 'supervision_existe', 'fotos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        //
    }
}
