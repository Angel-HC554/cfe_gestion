<?php

namespace App\Livewire;

use App\Models\OrdenArchivo;
use App\Models\OrdenVehiculo;
use App\Models\HistorialOrden;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class OrdenesTable extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Para filtrar por fechas
    public $fecha_inicio = '';
    public $fecha_fin = '';

    public $porPagina = 5; // Cantidad de resultados por página
    // Buscador por No. Económico
    public $search = '';
    //filtrar por estado
    public $estado = '';

    // Filtro exacto por No. Económico cuando el componente
    // se usa embebido para un vehículo específico
    public $noeconomicoExact = null;

    // Mostrar/ocultar el input de búsqueda desde el padre
    public $showSearch = true;

    // URL de retorno opcional para construir enlaces con back
    public $backUrl = null;

    //Propiedad para los modales
    public $selectedOrdenId;
    //Modal eliminar
    public $showDeleteModal = false;
    //Modal actualizar estado orden
    public $showStatusModal = false;
    public $newStatus;
    public $actualStatus;
    //Modal Ver mas datos
    public $showMoreModal = false;
    public $comentarios;
    //Subir escaneos
    public $archivoEscaneado;
    public $mensajeEscaneado;
    public $comentariosEscaneo;
    //Modal orden500
    public $showModal500 = false;
    public $codigoOrden500;

    //Actualizar estado orden
    public function openEditModal($id)
    {
        $this->selectedOrdenId = $id;
        $this->showStatusModal = true;
        $this->actualStatus = OrdenVehiculo::find($this->selectedOrdenId)->status;
    }
    public function UpdateEstadoOrden()
    {
        // Se asegura de que haya un ID válido
        if ($this->selectedOrdenId) {
            $orden = OrdenVehiculo::find($this->selectedOrdenId);
            $actualStatus = $orden->status;
            if ($orden) {
                $orden->update([
                    'status' => $this->newStatus
                ]);
                //Crea el historial de la orden
                HistorialOrden::create(
                    [
                        'orden_vehiculo_id' => $orden->id,
                        'tipo_evento' => 'estado_cambiado',
                        'detalles' => 'Estado actualizado',
                        'old_value' => $actualStatus,
                        'new_value' => $this->newStatus,
                    ]
                );
                $this->reset(['selectedOrdenId', 'newStatus', 'showStatusModal', 'actualStatus']);
                // Muestra un mensaje de éxito
                $this->dispatch('orden-eliminada', message: 'Estado actualizado con éxito.');
            }
        }
    }
    //Eliminar orden
    public function confirmDelete($id)
    {
        $this->selectedOrdenId = $id;
        $this->showDeleteModal = true;
    }
    public function deleteOrden()
    {
        // Se asegura de que haya un ID válido
        if ($this->selectedOrdenId) {
            $orden = OrdenVehiculo::find($this->selectedOrdenId);
            if ($orden) {
                $orden->delete();
                // Limpia el ID y cierra el modal
                $this->reset(['showDeleteModal', 'selectedOrdenId']);
                // Muestra un mensaje de éxito
                $this->dispatch('orden-eliminada', message: 'Orden eliminada con éxito.');

            }
        }
    }

    //Abrir el modal de Ver mas datos
    public function openMoreModal($id){
        $this->selectedOrdenId = $id;
        $this->showMoreModal = true;
        $this->comentarios = OrdenVehiculo::find($id)->observacion;

    }

    //Subir archivo escaneado
    public function guardarEscaneo(){
        //validar que el archivo sea un PDF y no sea muy pesado (ej. 10MB)
        $this->validate(
            [
                'archivoEscaneado' => 'required|file|mimes:pdf|max:10240'
            ]);
        //Asegura que haya una orden seleccionada
        if ($this->selectedOrdenId) {
            $escaneosExistentes = OrdenArchivo::where('orden_vehiculo_id',$this->selectedOrdenId)->count();
            $tipoArchivo = ($escaneosExistentes == 0) ? 'entrada' : 'salida';
            if ($tipoArchivo == 'entrada') {
                OrdenVehiculo::find($this->selectedOrdenId)->update(['status' => 'ENTREGADO PV']);
                HistorialOrden::create(
                    [
                        'orden_vehiculo_id' => $this->selectedOrdenId,
                        'tipo_evento' => 'estado_cambiado',
                        'detalles' => 'Estado actualizado',
                        'old_value' => 'PENDIENTE',
                        'new_value' => 'ENTREGADO PV',
                    ]
                );
            } elseif ($tipoArchivo == 'salida') {
                OrdenVehiculo::find($this->selectedOrdenId)->update(['status' => 'VEHICULO FUNCIONAMIENTO']);
                HistorialOrden::create(
                    [
                        'orden_vehiculo_id' => $this->selectedOrdenId,
                        'tipo_evento' => 'estado_cambiado',
                        'detalles' => 'Estado actualizado',
                        'old_value' => 'ENTREGADO PV',
                        'new_value' => 'VEHICULO FUNCIONAMIENTO',
                    ]
                );
            }
            $status = OrdenVehiculo::find($this->selectedOrdenId)->status;
            //Obtenemos la extensión original del archivo (ej: "pdf")
            $extension = $this->archivoEscaneado->getClientOriginalExtension();
            // Creamos nuestro nombre de archivo personalizado.
            // Ejemplo: $nombreArchivo = 'orden-' . $this->selectedOrdenId . '-escaneo-' . time() . '.' . $extension;
            $nombreArchivo = 'orden' . $this->selectedOrdenId . '_escaneo_'. $tipoArchivo . '.' . $extension;
            //guarda el archivo en storage/app/public/escaneos y devuelve la ruta
            $rutaArchivo = $this->archivoEscaneado->storeAs('escaneos', $nombreArchivo,'public');
            //crea el registro en la bd
            OrdenArchivo::create([
                'orden_vehiculo_id' => $this->selectedOrdenId,
                'ruta_archivo' => $rutaArchivo,
                'tipo_archivo' => $tipoArchivo,
                'comentarios' => $this->comentariosEscaneo,
            ]);
            //Crea el historial de la orden
            HistorialOrden::create(
                [
                    'orden_vehiculo_id' => $this->selectedOrdenId,
                    'tipo_evento' => 'archivo_subido',
                    'detalles' => 'ESCANEO SUBIDO: ' . $status,
                    'old_value' => null,
                    'new_value' => $nombreArchivo,
                ]
            );
             // Muestra un mensaje de éxito
            session()->flash('mensajeEscaneado', 'Escaneo subido con éxito!');

            // Resetea el input del archivo para que se limpie
            $this->reset('archivoEscaneado');

        }

    }

    //Abrir el modal de orden 500
    public function openModal500($id){
        $this->selectedOrdenId = $id;
        $this->showModal500 = true;
    }
    public function agregarOrden500(){
        if ($this->selectedOrdenId) {
            //validar que el codigo sea un numero
            $this->validate([
                'codigoOrden500' => 'required|numeric'
            ]);
            $orden = OrdenVehiculo::find($this->selectedOrdenId);
            $orden->update([
                'orden_500' => $this->codigoOrden500
            ]);
            //Crear historial de orden
            HistorialOrden::create(
                [
                    'orden_vehiculo_id' => $this->selectedOrdenId,
                    'tipo_evento' => 'orden_500',
                    'detalles' => 'Numero: ' . $this->codigoOrden500,
                ]
            );
            $this->reset('codigoOrden500','showModal500');
            $this->dispatch('orden-eliminada', message: 'Codigo 500 agregado con éxito.');
        }
    }

    public function updatedShowModal500($value)
    {
        if (!$value) {
            $this->reset(['selectedOrdenId', 'showModal500', 'codigoOrden500']);
            session()->forget('orden-eliminada');//por si quedo algun mensaje
        }
    }

    public function updatedShowMoreModal($value)
    {
        // Si el nuevo valor es 'false' (es decir, el modal se cerró),
        // reseteamos las propiedades relacionadas
        if (!$value) {
            $this->reset(['selectedOrdenId', 'showMoreModal', 'comentarios','archivoEscaneado','comentariosEscaneo']);
            session()->forget('mensajeEscaneado');//por si quedo algun mensaje
            $this->resetValidation('archivoEscaneado');
        }
    }

    public function updatedShowStatusModal($value)
    {
        // Si el nuevo valor es 'false' (es decir, el modal se cerró),
        // reseteamos las propiedades relacionadas
        if (!$value) {
            $this->reset(['selectedOrdenId', 'newStatus', 'actualStatus']);
            session()->forget('orden-eliminada');//por si quedo algun mensaje
        }
    }

    public function updatedShowDeleteModal($value)
    {
        // Si el modal de borrar se cierra, reseteamos el ID
        if (!$value) {
            $this->reset('selectedOrdenId');
        }
    }
    
    // Reiniciar la paginación cuando cambie el término de búsqueda
    public function updatedSearch()
    {
        $this->resetPage();
    }
    

    public function descargarEscaneo1($id)
    {
        $escaneo = OrdenArchivo::where('orden_vehiculo_id', $id)->where('tipo_archivo', 'entrada')->first();
        if ($escaneo) {
            $path = Storage::disk('public')->path($escaneo->ruta_archivo);
            return response()->download($path);
        }
    }

    public function descargarEscaneo2($id)
    {
        $escaneo = OrdenArchivo::where('orden_vehiculo_id', $id)->where('tipo_archivo', 'salida')->first();
        if ($escaneo) {
            $path = Storage::disk('public')->path($escaneo->ruta_archivo);
            return response()->download($path);
        }
    }

    public function placeholder()
    {
        return view('placeholders.progressbars2');
    }
    public function render()
    {
        //consulta a bd para filtrar por fechas
        $consulta = OrdenVehiculo::query()
            ->select('id', 'area', 'zona', 'departamento', 'noeconomico', 'status', 'fechafirm', 'created_at', 'updated_at', 'orden_500');
        
        // Filtro base por No. Económico exacto (si viene desde el padre)
        if (!empty($this->noeconomicoExact)) {
            $consulta->where('noeconomico', $this->noeconomicoExact);
        }
        if ($this->fecha_inicio) {
            $consulta->where('fechafirm', '>=', $this->fecha_inicio);
        }
        if ($this->fecha_fin) {
            $consulta->where('fechafirm', '<=', $this->fecha_fin);
        }
        // Filtro por No. Económico
        if ($this->search) {
            $consulta->where('noeconomico', 'like', '%' . $this->search . '%');
        }
        // Filtro por estado
        if ($this->estado) {
            $consulta->where('status', $this->estado);
        }
        // Paginacion de resultados, mostrando 5 por página
        $ordenes = $consulta->paginate($this->porPagina);

        return view('livewire.ordenes-table', ['ordenes' => $ordenes,]);
    }

    // Este método reinicia los filtros a su estado original
    public function resetFilters()
    {
        $this->reset(['fecha_inicio', 'fecha_fin', 'search']);
        $this->resetPage(); // Regresa a la primera página después de reiniciar
    }
}
