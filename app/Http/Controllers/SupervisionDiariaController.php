<?php

namespace App\Http\Controllers;

use App\Models\SupervisionDiaria;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SupervisionDiariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        //Configuración de fechas
        $mes = $request->input('mes', now()->month);
        $año = $request->input('año', now()->year);
        $fecha = Carbon::create($año, $mes, 1);
        //Array con los numeros de dias
        $diasDelMes = range(1, $fecha->daysInMonth);
        $nombreMes = $fecha->translatedFormat('F Y');
        $hoy = now();

        //Consulta BD
        $queryVehiculos = Vehiculo::query()
            ->select('id','no_economico','agencia')
            ->orderBy('agencia')
            ->orderBy('no_economico');
        //filtros del cliente
        if ($request->filled('agencia')) {
            $queryVehiculos->where('agencia', $request->agencia);
        }
        //EAGER LOADING - Cargamos *solo* las supervisiones diarias que ocurrieron en el mes/año seleccionado.
        $queryVehiculos->with(['supervisioDiaria' => function ($q) use ($fecha){
            $q->whereMonth('fecha', $fecha->month)
            ->whereYear('fecha', $fecha->year)
            ->select('id', 'vehiculo_id', 'fecha');
        }]);

        $vehiculos = $queryVehiculos->get();
        // PROCESAR DATOS (El "Mapa" de Cumplimiento)
        $vehiculosProcesados = $vehiculos->map(function ($vehiculo) use ($diasDelMes, $fecha,$hoy){
            //se crea el mapa de busqueda rapida
            $diasConSupervision = $vehiculo->supervisioDiaria->keyBy(function ($supervision){
                return $supervision->fecha->day;
            });

            $statusPorDia = [];
            $incumplimientos = 0;

            foreach ($diasDelMes as $dia) {
                $fechaActualLoop = $fecha->copy()->day($dia);
                $tieneSupervision = $diasConSupervision->has($dia);

                if ($fechaActualLoop->isFuture()) {
                    $status = 'futuro'; // Días que aún no llegan
                }elseif ($tieneSupervision) {
                    $status = 'cumplido';
                }else {
                    $status = 'no_cumplido';
                    $incumplimientos++;
                }
                $statusPorDia[$dia] = $status;
            }

            $vehiculo->status_dias = $statusPorDia; // El array [1 => 'cumplido', 2 => 'no_cumplido', ...]
            $vehiculo->total_incumplimientos = $incumplimientos;

            return $vehiculo;
        });
        //APLICAR FILTRO "SOLO INCUMPLIDOS"
            if ($request->cumplimiento == 'no_cumple') {
                $vehiculosProcesados = $vehiculosProcesados->filter(function ($vehiculo){
                    return $vehiculo->total_incumplimientos > 0;
                });
            }
        //DATOS PARA LOS FILTROS DE LA VISTA
        $agencias = Vehiculo::select('agencia')->distinct()->orderBy('agencia')->pluck('agencia');
        //ENVIAR TODO A LA VISTA
        return view('supervicion_diaria.index',[
            'vehiculos' => $vehiculosProcesados,
            'diasDelMes' => $diasDelMes,
            'nombreMes' => $nombreMes,
            'agencias' => $agencias,
            'filtrosActuales' => $request->all(),
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 2. Define las reglas de validación en una variable
        $rules = [
            'vehiculo_id' => 'required|integer',
            'no_eco' => 'required|string|max:255',
            'nombre_auxiliar' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'kilometraje' => 'required|integer',
            'gasolina' => 'required|boolean',
            'aceite' => 'required|boolean',
            'liq_fren' => 'required|boolean',
            'anti_con' => 'required|boolean',
            'agua' => 'required|boolean',
            'radiador' => 'required|boolean',
            'llantas' => 'required|boolean',
            'llanta_r' => 'required|boolean',
            'tapon_gas' => 'required|boolean',
            'limp_cab' => 'required|boolean',
            'limp_ext' => 'required|boolean',
            'cinturon' => 'required|boolean',
            'limpia_par' => 'required|boolean',
            'manijas_puer' => 'required|boolean',
            'espejo_int' => 'required|boolean',
            'espejo_lat_i' => 'required|boolean',
            'espejo_lat_d' => 'required|boolean',
            'gato' => 'required|boolean',
            'llave_cruz' => 'required|boolean',
            'extintor' => 'required|boolean',
            'direccionales' => 'required|boolean',
            'luces' => 'required|boolean',
            'intermit' => 'required|boolean',
            'golpes' => 'required|boolean',
            'golpes_coment' => 'nullable|string',
            'escaneo_url' => 'nullable|file|mimes:jpeg,png,jpg,pdf',
        ];

        // 3. Crea el validador manualmente
        $validator = Validator::make($request->all(), $rules);

        // 4. Comprueba si la validación falla
        if ($validator->fails()) {
            
            // Construye un mensaje de error HTML con todos los errores
            $errorMessages = '<ul>';
            foreach ($validator->errors()->all() as $error) {
                $errorMessages .= '<li>' . $error . '</li>';
            }
            $errorMessages .= '</ul>';

            // 5. Muestra la alerta de error
            Swal::fire([
                'position' => 'top-center',
                'icon' => 'error',
                'title' => 'Errores de validación',
                'html' => $errorMessages, // Usa 'html' para renderizar la lista
                'showConfirmButton' => true,
            ]);

            // Redirige de vuelta con los errores y los datos viejos
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 6. Si la validación pasa, obtén los datos validados
        $validatedData = $validator->validated();

        // --- TU CÓDIGO EXISTENTE (SI LA VALIDACIÓN ES EXITOSA) ---

        // Procesar archivo si existe
        if ($request->hasFile('escaneo_url')) {
            $file = $request->file('escaneo_url');
            $filename = 'escaneo_' . $validatedData['no_eco'] . '_' . date('Y-m-d') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('escaneos_supervision_diaria', $filename, 'public');
            $validatedData['escaneo_url'] = '/storage/' . $path;
        }

        SupervisionDiaria::create($validatedData);
        Cache::forget('conteos_mantenimiento');
        
        // Muestra la alerta de éxito
        Swal::fire([
            'position' => "top-center",
            'icon' => "success",
            'title' => "Se envió correctamente.",
            'showConfirmButton' => false,
            'timer' => 1500
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SupervisionDiaria $supervisionDiaria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupervisionDiaria $supervisionDiaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupervisionDiaria $supervisionDiaria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupervisionDiaria $supervisionDiaria)
    {
        //
    }
}
