<?php

namespace App\Http\Controllers;

use App\Models\SupervisionSemanal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SweetAlert2\Laravel\Swal;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use App\Models\Vehiculo;


class SupervisionSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // === CONFIGURACIÓN DE FECHAS ===
    $mes = $request->input('mes', now()->month);
    $año = $request->input('año', now()->year);

    $fechaInicioMes = Carbon::create($año, $mes, 1)->startOfDay();
    $fechaFinMes = $fechaInicioMes->copy()->endOfMonth();

    // === CONSTRUCCIÓN DE SEMANAS LABORALES (LUNES A SÁBADO) ===
    $inicioSemana = $fechaInicioMes->copy()->startOfWeek(Carbon::MONDAY);
    $semanasDelMes = [];

    while ($inicioSemana <= $fechaFinMes) {
        $finSemana = $inicioSemana->copy()->addDays(5)->endOfDay(); // Lunes a sábado

        // Si el fin de semana se pasa del mes, se recorta
        if ($finSemana->month != $mes) {
            $finSemana = $fechaFinMes;
        }

        $semanasDelMes[] = [
            'inicio' => $inicioSemana->copy(),
            'fin' => $finSemana->copy(),
        ];

        // Avanzar al siguiente lunes
        $inicioSemana->addWeek();
    }

    $totalSemanas = count($semanasDelMes);
    $nombreMes = $fechaInicioMes->translatedFormat('F Y');
    $hoy = now();

    // VAMOS A OBTENER EL RANGO COMPLETO DE FECHAS DE LAS SEMANAS
    // Esto nos dará algo como '2025-10-27 00:00:00'
    $fechaInicioConsulta = $semanasDelMes[0]['inicio']; 
    
    // Esto nos dará algo como '2025-11-29 23:59:59' (gracias al endOfDay() que pusimos)
    $fechaFinConsulta = $semanasDelMes[count($semanasDelMes) - 1]['fin'];


    $totalSemanas = count($semanasDelMes);
    // ... (El resto de variables se quedan igual) ...

    // === CONSULTA A BD ===
    $queryVehiculos = Vehiculo::query()
        ->select('id', 'no_economico', 'agencia')
        ->orderBy('agencia')
        ->orderBy('no_economico');

    if ($request->filled('agencia')) {
        $queryVehiculos->where('agencia', $request->agencia);
    }

    // EAGER LOADING - Supervisiones del mes
    $queryVehiculos->with(['supervisioSemanal' => function ($q) use ($fechaInicioConsulta, $fechaFinConsulta) {
        $q->whereBetween('created_at', [$fechaInicioConsulta, $fechaFinConsulta])
          ->select('id', 'vehiculo_id', 'created_at');
    }]);

    $vehiculos = $queryVehiculos->get();

    // === PROCESAR DATOS ===
    $vehiculosProcesados = $vehiculos->map(function ($vehiculo) use ($semanasDelMes, $hoy) {
        $statusPorSemana = [];
        $incumplimientos = 0;

        foreach ($semanasDelMes as $index => $semana) {
            // Verifica si hay una supervisión dentro del rango (lunes-sábado)
            $tieneSupervision = $vehiculo->supervisioSemanal->contains(function ($sup) use ($semana) {
                return $sup->created_at->between($semana['inicio'], $semana['fin']);
            });

            if ($tieneSupervision) {
                $status = 'cumplido';
            } elseif ($semana['fin']->isFuture()) {
                $status = 'futuro';
            } else {
                $status = 'no_cumplido';
                $incumplimientos++;
            }

            $statusPorSemana[$index + 1] = $status;
        }

        $vehiculo->status_semanas = $statusPorSemana;
        $vehiculo->total_incumplimientos = $incumplimientos;

        return $vehiculo;
    });

    // === FILTRO DE CUMPLIMIENTO ===
    if ($request->cumplimiento == 'no_cumple') {
        $vehiculosProcesados = $vehiculosProcesados->filter(function ($vehiculo) {
            return $vehiculo->total_incumplimientos > 0;
        });
    }

    // === FILTROS PARA VISTA ===
    $agencias = Vehiculo::select('agencia')->distinct()->orderBy('agencia')->pluck('agencia');

    // === RETORNO A LA VISTA ===
    return view('supervicion_semanal.index', [
        'vehiculos' => $vehiculosProcesados,
        'semanasDelMes' => $semanasDelMes,
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
       // Define las reglas de validación
        $rules = [
            'vehiculo_id' => 'required|integer',
            'no_eco' => 'required|string|max:255',
            'foto_del' => 'required|image|mimes:jpeg,png,jpg,gif',
            'foto_tra' => 'required|image|mimes:jpeg,png,jpg,gif',
            'foto_lado_izq' => 'required|image|mimes:jpeg,png,jpg,gif',
            'foto_lado_der' => 'required|image|mimes:jpeg,png,jpg,gif',
            'foto_poliza' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'foto_tar_circ' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'foto_kit' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'foto_atent' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'resumen_est' => 'nullable|string',
        ];

        // 2. Crea el validador manualmente
        $validator = Validator::make($request->all(), $rules);

        // 3. Comprueba si la validación falla
        if ($validator->fails()) {
            
            // Construye un mensaje de error HTML con todos los errores
            $errorMessages = '<ul>';
            foreach ($validator->errors()->all() as $error) {
                $errorMessages .= '<li>' . $error . '</li>';
            }
            $errorMessages .= '</ul>';

            // 4. Muestra la alerta de error
            Swal::fire([
                'position' => 'top-center',
                'icon' => 'error',
                'title' => 'Errores de validación',
                'html' => $errorMessages, // Usa 'html' para renderizar la lista
                'showConfirmButton' => true,
            ]);

            // Redirige de vuelta con los errores y los datos viejos (opcional pero recomendado)
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 5. Si la validación pasa, obtén los datos validados
        $validatedData = $validator->validated();
        // --- TU CÓDIGO EXISTENTE (SI LA VALIDACIÓN ES EXITOSA) ---
        
        // Procesar y guardar archivos
        $validatedData['foto_del'] = $this->storeImage($request->file('foto_del'), $request->no_eco,'del');
        $validatedData['foto_tra'] = $this->storeImage($request->file('foto_tra'), $request->no_eco,'tra');
        $validatedData['foto_lado_izq'] = $this->storeImage($request->file('foto_lado_izq'), $request->no_eco,'izq');
        $validatedData['foto_lado_der'] = $this->storeImage($request->file('foto_lado_der'), $request->no_eco,'der');

        if ($request->hasFile('foto_poliza')) {
            $validatedData['foto_poliza'] = $this->storeImage($request->file('foto_poliza'), $request->no_eco,'poliza');
        }
        if ($request->hasFile('foto_tar_circ')) {
            $validatedData['foto_tar_circ'] = $this->storeImage($request->file('foto_tar_circ'), $request->no_eco,'tar_circ');
        }
        if ($request->hasFile('foto_kit')) {
            $validatedData['foto_kit'] = $this->storeImage($request->file('foto_kit'), $request->no_eco,'kit');
        }
        if ($request->hasFile('foto_atent')) {
            $validatedData['foto_atent'] = $this->storeImage($request->file('foto_atent'), $request->no_eco,'atent');
        }

        $validatedData['user_id'] = auth()->user()->id;

        
        SupervisionSemanal::create($validatedData);

        return response()->json([
        'success' => true,
        'message' => 'Se envió correctamente.'
    ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(SupervisionSemanal $supervisionSemanal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupervisionSemanal $supervisionSemanal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupervisionSemanal $supervisionSemanal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupervisionSemanal $supervisionSemanal)
    {
        //
    }

    /**
     * Guarda una imagen en el directorio especificado y retorna la ruta.
     */
    private function storeImage($file, $no_eco, $descripcion)
    {
        if ($file) {
            // Crear directorio si no existe
            $path = public_path('fotos_supervision_semanal/' . $no_eco . '/' . date('Y-m-d'));

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Generar nombre único para el archivo
            $filename = $descripcion . '.' . $file->getClientOriginalExtension();

            //Comprimir y redimensionar la imagen
            Image::read($file)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio(); // Redimensiona el ancho a 1200px manteniendo la proporción
                $constraint->upsize(); // Evita que imágenes pequeñas se hagan más grandes
            })
            ->save($path . '/' . $filename, 80); // Guarda con 80% de calidad

            // Retornar la ruta relativa para guardar en BD
            return 'fotos_supervision_semanal/' . $no_eco . '/' . date('Y-m-d') . '/' . $filename;
        }

        return null;
    }
}
