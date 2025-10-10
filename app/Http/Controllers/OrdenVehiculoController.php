<?php

namespace App\Http\Controllers;

use App\Models\HistorialOrden;
use App\Models\OrdenArchivo;
use App\Models\OrdenVehiculo;
use Illuminate\Http\Request;
use TinyButStrong\clsTinyButStrong;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use clsOpenTBS;
use Illuminate\Support\Facades\Storage;


class OrdenVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Optimizado: solo selecciona los campos necesarios para el index
        $ordenes = OrdenVehiculo::select('id', 'area', 'zona', 'departamento', 'noeconomico', 'status', 'fechafirm', 'created_at', 'updated_at', 'orden_500')
            ->get();
        return view('ordenvehiculos.index', compact('ordenes'));
    }

    // Descarga el escaneo de ENTRADA (Entregado PV) por ID de orden
    public function descargarEscaneoEntrada($id)
    {
        $escaneo = \App\Models\OrdenArchivo::where('orden_vehiculo_id', $id)
            ->where('tipo_archivo', 'entrada')
            ->first();
        if ($escaneo) {
            $path = Storage::disk('public')->path($escaneo->ruta_archivo);
            return response()->download($path);
        }
        return redirect()->back()->with('error', 'El archivo no existe.');
    }

    // Descarga el escaneo de SALIDA (Vehículo funcionamiento) por ID de orden
    public function descargarEscaneoSalida($id)
    {
        $escaneo = \App\Models\OrdenArchivo::where('orden_vehiculo_id', $id)
            ->where('tipo_archivo', 'salida')
            ->first();
        if ($escaneo) {
            $path = Storage::disk('public')->path($escaneo->ruta_archivo);
            return response()->download($path);
        }
        return redirect()->back()->with('error', 'El archivo no existe.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Enviar numero de orden nueva
        $id = OrdenVehiculo::max('id') + 1;
        return view('ordenvehiculos.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'noeconomico' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'placas' => 'required|string|max:255',
            'taller' => 'nullable|string|max:255',
            'kilometraje' => 'nullable|integer',
            'fecharecep' => 'nullable|date',
            'radiocom' => 'nullable|string',
            'llantaref' => 'nullable|string',
            'autoestereo' => 'nullable|string',
            'gatoh' => 'nullable|string',
            'llavecruz' => 'nullable|string',
            'extintor' => 'nullable|string',
            'botiquin' => 'nullable|string',
            'escalera' => 'nullable|string',
            'escalerad' => 'nullable|string',
            'gasolina' => 'nullable|string',
            // Observaciones y fecha firma
            'observacion' => 'required|string',
            'fechafirm' => 'required|date',
            // Firmas y rpe
            'areausuaria' => 'required|string',
            'rpeusuaria' => 'required|string',
            'autoriza' => 'required|string',
            'rpejefedpt' => 'required|string',
            'resppv' => 'required|string',
            'rperesppv' => 'required|string',
            // Orden 500 (usar valores en MAYÚSCULAS)
            'orden_500' => 'nullable|in:SI,NO',
        ]);

        // Validación para opciones de checkbox
        $checkboxes = [
            'vehicle1',
            'vehicle2',
            'vehicle3',
            'vehicle4',
            'vehicle5',
            'vehicle6',
            'vehicle7',
            'vehicle8',
            'vehicle9',
            'vehicle10',
            'vehicle11',
            'vehicle12',
            'vehicle13',
            'vehicle14',
            'vehicle15',
            'vehicle16',
            'vehicle17',
            'vehicle18',
            'vehicle19',
            'vehicle20',
        ];
        //Si no se selecciona ningun checkbox, se guarda como cadena vacia
        foreach ($checkboxes as $checkbox) {
            $validatedData[$checkbox] = $request->input($checkbox, '');
        }

        // Asegurar y normalizar orden_500 a MAYÚSCULAS; por defecto 'NO'
        $validatedData['orden_500'] = strtoupper($request->input('orden_500', 'NO'));

        //Crea el registro en la bd
        $orden = OrdenVehiculo::create($validatedData);
        //Crea el historial de la orden
        HistorialOrden::create(
            [
                'orden_vehiculo_id' => $orden->id,
                'tipo_evento' => 'orden_creado',
                'detalles' => 'Orden creado',
            ]
        );
        // Redirige a la misma página (create) y pasa el ID de la orden en la sesión.
        // Esto es lo que Livewire usará para abrir el modal de exito y descargar.
        //return redirect()->route('ordenvehiculos.generarOrden', ['id' => $orden->id]);
        return redirect()->route('ordenvehiculos.generar', ['id' => $orden->id]);
    }

    public function generarOrden($id)
    {
        $orden = OrdenVehiculo::findOrFail($id);
        // Iniciar la librería TinyButStrong y OpenTBS
        $TBS = new \clsTinyButStrong;
        new clsOpenTBS;
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

        // 4. Cargar la plantilla. Es crucial que esta ruta sea correcta.
        //$templatePath = public_path('plantillas/orden_vehiculo.docx');
        $templatePath = public_path('plantillas/orden_vehiculo.docx');
        //dd($templatePath); // Esta línea detendrá la ejecución y mostrará la ruta
        $TBS->LoadTemplate($templatePath, OPENTBS_ALREADY_UTF8);
        if (!file_exists($templatePath)) {
            // Manejar el error si la plantilla no existe.
            // Esto evita el error "template not loaded" y muestra un mensaje claro.
            return redirect()->route('ordenvehiculos.index')
                ->with('error', 'Error: La plantilla de documento no se encuentra.');
        }
        //Cargar plantilla word
        //$TBS->LoadTemplate(public_path('plantillas/orden_vehiculo.docx'));
        //Se asignan los valores a la plantilla
        $TBS->MergeField('pro.ordenq', $orden->id);
        $TBS->MergeField('pro.noorden', $orden->id);
        $TBS->MergeField('pro.area', strtoupper($orden->area));
        $TBS->MergeField('pro.zona', strtoupper($orden->zona));
        $TBS->MergeField('pro.departamento', strtoupper($orden->departamento));
        $TBS->MergeField('pro.noeconomico', $orden->noeconomico);
        $TBS->MergeField('pro.marca', strtoupper($orden->marca));
        $TBS->MergeField('pro.placas', $orden->placas);
        $TBS->MergeField('pro.taller', strtoupper($orden->taller));
        $TBS->MergeField('pro.kilometraje', $orden->kilometraje);
        $TBS->MergeField('pro.fecharecep', $orden->fecharecep);
        //Si y No de los radio buttons
        $radioOptions = [
            'radiocom',
            'llantaref',
            'autoestereo',
            'gatoh',
            'llavecruz',
            'extintor',
            'botiquin',
            'escalera',
            'escalerad'
        ];
        $contador = 1;
        foreach ($radioOptions as $option) {
            $valorSi = ($orden->$option === 'Si') ? ' X' : '';
            $valorNo = ($orden->$option === 'No') ? ' X' : '';

            $TBS->MergeField('pro.rs' . $contador, 'Si' . $valorSi);
            $TBS->MergeField('pro.rn' . $contador, 'No' . $valorNo);

            $contador++;
        }
        //Cambiar imagen de gasolina dependiendo el valor
        $gasImg = public_path('');
        switch ($orden->gasolina) {
            case '0':
                $gasImg = public_path('plantillas/gasolina/0.png');
                break;
            case '25':
                $gasImg = public_path('plantillas/gasolina/25.png');
                break;
            case '50':
                $gasImg = public_path('plantillas/gasolina/50.png');
                break;
            case '75':
                $gasImg = public_path('plantillas/gasolina/75.png');
                break;
            case '100':
                $gasImg = public_path('plantillas/gasolina/100.png');
                break;
            default:
                $gasImg = '';
                break;
        }

        $TBS->VarRef['x'] = $gasImg;
        //Checkboxes
        for ($i = 1; $i <= 20; $i++) {
            $TBS->MergeField('pro.c' . $i, $orden->{'vehicle' . $i});
        }
        //Observaciones y fecha firma
        $TBS->MergeField('pro.observaciones', strtoupper($orden->observacion));
        $TBS->MergeField('pro.fechafirm', $orden->fechafirm);
        //Firmas y rpe
        $TBS->MergeField('pro.areausuaria', strtoupper($orden->areausuaria));
        $TBS->MergeField('pro.rpeusuaria', $orden->rpeusuaria);
        $TBS->MergeField('pro.jefedpto', strtoupper($orden->autoriza));
        $TBS->MergeField('pro.rpejefedpto', $orden->rpejefedpt);
        $TBS->MergeField('pro.responsablepv', strtoupper($orden->resppv));
        $TBS->MergeField('pro.responsablepvrpe', $orden->rperesppv);

        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
        //$TBS->Plugin(OPENTBS_DEBUG_XML_SHOW);

        // Asigna el nombre del archivo.
        $fileName = 'orden_vehiculo_' . $orden->id . '.docx';
        $docxFilePath = storage_path('app/public/orden_vehiculos/' . $fileName); 
        $TBS->Show(\OPENTBS_FILE, $docxFilePath);
        
        // Redirigir a la generación/descarga del PDF inmediatamente después de crear el DOCX
        //return redirect()->route('ordenvehiculos.pdf', ['id' => $orden->id]);
        return redirect()->route('ordenvehiculos.create')->with('orden_id', $orden->id);
    }

    public function generatePdf($id)
    {
        // 1. Definición de Archivos y Rutas
        $docxInputFile = 'orden_vehiculo_' . $id . '.docx';
        $outputDirectoryName = 'pdf_exports';
        
        // Rutas absolutas
        $docxFilePath = storage_path("app/public/orden_vehiculos/{$docxInputFile}");
        $outputDirectory = storage_path("app/public/{$outputDirectoryName}");

         // 2. Comprobaciones iniciales
         if (!File::exists($docxFilePath)) {
            return response("Error: El archivo DOCX de entrada no se encontró en: {$docxFilePath}", 404);
        }

        if (!File::exists($outputDirectory)) {
            // Crea la carpeta de salida si no existe (0755 es el permiso estándar en Linux)
            File::makeDirectory($outputDirectory, 0755, true);
        }
        

        // 3. Preparar y Ejecutar el Comando
        $sofficePath = env('LIBREOFFICE_PATH'); 
        
        // Los argumentos clave son:
        // --headless: Ejecutar sin interfaz gráfica.
        // --convert-to pdf: Convertir al formato PDF.
        // --outdir: Directorio donde se guardará el PDF.
        $command = "\"{$sofficePath}\" --headless --convert-to pdf \"{$docxFilePath}\" --outdir \"{$outputDirectory}\"";

        // Ejecutar el comando con Laravel Process
        $result = Process::run($command);

        // 4. Procesar el Resultado
        if ($result->successful()) {
            
            // LibreOffice usa el mismo nombre base, solo cambia la extensión.
            $pdfFileName = Str::replaceLast('docx', 'pdf', basename($docxInputFile));
            $pdfFilePath = "{$outputDirectory}/{$pdfFileName}";

            if (File::exists($pdfFilePath)) {
                // Devolver el archivo para descarga y borrar el temporal
                return response()->download($pdfFilePath, $pdfFileName)->deleteFileAfterSend(true);
            }
            
            return response('Error: Conversión exitosa pero el archivo PDF no se encontró.', 500);

        } else {
            // Error en la ejecución del comando (ej. permisos, ruta incorrecta, etc.)
            return response('Error en la conversión de LibreOffice: ' . $result->errorOutput(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OrdenVehiculo $ordenvehiculo)
    {
        $historial = HistorialOrden::where('orden_vehiculo_id', $ordenvehiculo->id)
            ->orderBy('id', 'desc')
            ->get();
        $archivo1 = OrdenArchivo::where('orden_vehiculo_id', $ordenvehiculo->id)
            ->where('tipo_archivo', 'entrada')
            ->select('comentarios')
            ->get();
        $archivo2 = OrdenArchivo::where('orden_vehiculo_id', $ordenvehiculo->id)
            ->where('tipo_archivo', 'salida')
            ->select('comentarios')
            ->get();
        return view('ordenvehiculos.show', compact('historial', 'ordenvehiculo', 'archivo1', 'archivo2'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $orden = OrdenVehiculo::findOrFail($id);
        return view('ordenvehiculos.edit', compact('orden'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'noeconomico' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'placas' => 'required|string|max:255',
            'taller' => 'nullable|string|max:255',
            'kilometraje' => 'nullable|integer',
            'fecharecep' => 'nullable|date',
            'radiocom' => 'nullable|string',
            'llantaref' => 'nullable|string',
            'autoestereo' => 'nullable|string',
            'gatoh' => 'nullable|string',
            'llavecruz' => 'nullable|string',
            'extintor' => 'nullable|string',
            'botiquin' => 'nullable|string',
            'escalera' => 'nullable|string',
            'escalerad' => 'nullable|string',
            'gasolina' => 'nullable|string',
            // Observaciones y fecha firma
            'observacion' => 'required|string',
            'fechafirm' => 'required|date',
            // Firmas y rpe
            'areausuaria' => 'required|string',
            'rpeusuaria' => 'required|string',
            'autoriza' => 'required|string',
            'rpejefedpt' => 'required|string',
            'resppv' => 'required|string',
            'rperesppv' => 'required|string',
            // Orden 500 (usar valores en MAYÚSCULAS)
            'orden_500' => 'nullable|in:SI,NO',
        ]);

        // Validación para opciones de checkbox
        $checkboxes = [
            'vehicle1',
            'vehicle2',
            'vehicle3',
            'vehicle4',
            'vehicle5',
            'vehicle6',
            'vehicle7',
            'vehicle8',
            'vehicle9',
            'vehicle10',
            'vehicle11',
            'vehicle12',
            'vehicle13',
            'vehicle14',
            'vehicle15',
            'vehicle16',
            'vehicle17',
            'vehicle18',
            'vehicle19',
            'vehicle20',
        ];
        //Si no se selecciona ningun checkbox, se guarda como cadena vacia
        foreach ($checkboxes as $checkbox) {
            $validatedData[$checkbox] = $request->input($checkbox, '');
        }
        // Asegurar y normalizar orden_500 a MAYÚSCULAS; por defecto 'NO'
        $validatedData['orden_500'] = strtoupper($request->input('orden_500', 'NO'));

        $ordenVehiculo = OrdenVehiculo::findOrFail($id);
        //Actualiza el registro en la bd
        $ordenVehiculo->update($validatedData);
        //Crea el historial de la orden
        HistorialOrden::create(
            [
                'orden_vehiculo_id' => $ordenVehiculo->id,
                'tipo_evento' => 'orden_actualizado',
                'detalles' => 'Orden actualizado',
            ]
        );
        return redirect()->route('ordenvehiculos.generar', ['id' => $ordenVehiculo->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ordenVehiculo = OrdenVehiculo::findOrFail($id);
        $ordenVehiculo->delete();
        return redirect()->route('ordenvehiculos.index')
            ->with('message', 'Orden de vehículo eliminada con éxito');
    }
}
