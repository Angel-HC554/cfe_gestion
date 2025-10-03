<?php

namespace App\Livewire;

use App\Models\OrdenVehiculo;
use App\Models\Vehiculo;
use Livewire\Component;

class OrdenVehiculosCreate extends Component
{
    //Para datalist No Economico
    public $noeconom;
    //Para llenar los datos del vehiculo
    public $numeco;
    public $placa;
    public $modelo;
    //Recupera orden para editar
    public $ordenEditar = null;
    //obtiene el nivel de gasolina del range para paserselo a gasolina-imagen
    public $nivelGasolina;
    //Controla modal de confirmacion y descarga de orden
    public $showModal = false;
    public $ordenId = 0;

    public function mount()
    {
        // Para obtener todos los numeros economicos sin repetir
        $this->noeconom = Vehiculo::pluck('no_economico')->unique();

        //Para saber que imagen de la gasolina mostrar
        if ($this->ordenEditar) {
            // Si es edición, carga el valor de el elemnto a editar
            $this->nivelGasolina = $this->ordenEditar->gasolina;
        } else {
            // Si es nuevo, arranca con un valor por defecto
            $this->nivelGasolina = 50;
        }

        //Para llenar los inputs si el formulario es para editar
        if ($this->ordenEditar) {
            $this->numeco = $this->ordenEditar->noeconomico;
            $this->placa = $this->ordenEditar->placas;
            $this->modelo = $this->ordenEditar->marca;
        }

        // El método mount() se ejecuta cada vez que el componente se carga.
        // Aquí verificamos si hay un valor 'orden_id' en la sesión.
        if (session()->has('orden_id')) {
            $this->showModal = true;
            $this->ordenId = session('orden_id');
        }
    }

    // Rellenar los demas campos con ayuda de numero economico
    public function updatedNumeco(){
        $placaymodelo = Vehiculo::where('no_economico', $this->numeco)->first();
        if ($placaymodelo) {
            $this->placa = $placaymodelo->placas;
        $this->modelo = $placaymodelo->marca . $placaymodelo->modelo;
        }else {
            $this->placa = '';
            $this->modelo = '';
        }

    }
    //value="{{ isset($ordenEditar) ? $ordenEditar->marca : '' }}"
    //value="{{ isset($ordenEditar) ? $ordenEditar->placas : '' }}"

    public function render()
    {
        return view('livewire.orden-vehiculos-create');
    }
}
