<?php

namespace App\Livewire;

use App\Models\OrdenVehiculo;
use Livewire\Component;

class OrdenVehiculosCreate extends Component
{
    //Recupera orden para editar
    public $ordenEditar = null;
    //Controla modal de confirmacion y descarga de orden

    public $showModal = false;
    public $ordenId = 0;
    public function mount()
    {
        // El método mount() se ejecuta cada vez que el componente se carga.
        // Aquí verificamos si hay un valor 'orden_id' en la sesión.
        if (session()->has('orden_id')) {
            $this->showModal = true;
            $this->ordenId = session('orden_id');
        }
    }

    public function render()
    {
        return view('livewire.orden-vehiculos-create');
    }
}
