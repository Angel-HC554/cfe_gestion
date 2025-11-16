<?php

namespace App\Livewire;

use App\Imports\VehiculosImport;
use App\Exports\VehiculosExport;
use App\Models\Vehiculo;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;
use Livewire\WithFileUploads;

class VehiculoModales extends Component
{
    use WithFileUploads;
    public $showExportarModal = false;
    public $showImportarModal = false;
    public $showNuevoModal = false;
    public $archivoExcel; //archivo se sube para exportar

    // Campos de formulario para crear un vehículo
    public $agencia;
    public $no_economico;
    public $placas;
    public $tipo_vehiculo;
    public $marca;
    public $modelo;
    public $año;
    public $estado;
    public $propiedad;
    public $proceso;
    public $alias;
    public $rpe_creamod;

    public function abrirModalImp(){
        $this->showImportarModal = true;
    }

    public function abrirModalExp(){
        $this->showExportarModal = true;
    }

    public function abrirModalNuevo(){
        $this->resetValidation();
        $this->reset('agencia','no_economico','placas','tipo_vehiculo','marca','modelo','año','estado','propiedad','proceso','alias','rpe_creamod');
        $this->showNuevoModal = true;
    }

    //Importar vehiculos a bd
    public function importarVehiculos(){
        $this->validate([
            'archivoExcel' => 'required|mimes:xlsx,xls',
        ]);
         Excel::import(new VehiculosImport,$this->archivoExcel);
        session()->flash('mensajeEscaneado', '¡Vehículos importados correctamente!');
        // Recargar la página actual (o ve a la ruta que quieras)
        return $this->redirect(route('vehiculos.index'), navigate: true);
    }

    //Exportar vehiculos a excel
    public function exportarVehiculos()
    {
        $this->showExportarModal = false; 
        return Excel::download(new VehiculosExport, 'vehiculos.xlsx');
    }

    // Guardar nuevo vehículo
    public function guardarVehiculos()
    {
        $validated = $this->validate([
            'agencia' => 'required|string|max:255',
            'no_economico' => 'required|string|max:255',
            'placas' => 'required|string|max:255',
            'tipo_vehiculo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'año' => 'required|digits:4',
            'estado' => 'required|in:En circulacion,En mantenimiento,Fuera de circulacion por falla pendiente,Fuera de circulacion',
            'propiedad' => 'required|in:Arrendado,Propio (CFE)',
            'proceso' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255',
            'rpe_creamod' => 'required|string|max:255',
        ]);

        Vehiculo::create($validated);

        $this->showNuevoModal = false;
        $this->reset('agencia','no_economico','placas','tipo_vehiculo','marca','modelo','año','estado','propiedad','proceso','alias','rpe_creamod');
        session()->flash('mensajeEscaneado', '¡Vehículo creado correctamente!');
        return $this->redirect(route('vehiculos.index'), navigate: true);
    }

    // Si el modal se cierra, resetea los datos
    public function updatedShowImportarModal($value)
    {
        if (!$value) {
            $this->reset('archivoExcel','showImportarModal');
            session()->forget('mensajeEscaneado');
            $this->resetValidation('archivoExcel');
        }
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <flux:button icon="arrow-up-tray" variant="outline" class="mr-2">Importar</flux:button>
            <flux:button icon="arrow-down-tray" variant="outline" class="mr-2">Exportar</flux:button>
            <flux:button icon="plus" variant="primary">Nuevo Vehículo</flux:button>
        </div>
        HTML;
    }
 
    public function render()
    {
        return view('livewire.vehiculo-modales');
    }
}
