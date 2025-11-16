<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vehiculo;
use App\Models\User;
use App\Models\OrdenVehiculo;

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
    public $backUrl = null;
    // --- 2. NUEVAS PROPIEDADES ---
    public $allUsers; // Para el datalist

    // Pares de inputs
    public $areausuaria;
    public $rpeusuaria;
    public $autoriza;
    public $rpejefedpt;
    public $resppv;
    public $rperesppv;

    public function mount()
    {
        // Para obtener todos los numeros economicos sin repetir
        $this->noeconom = Vehiculo::pluck('no_economico')->unique();
        // Cargar todos los usuarios para el datalist
        // Seleccionamos solo los campos necesarios para optimizar
        $this->allUsers = User::select('name', 'usuario')->get();
        
        // Get the back URL from the session if it exists
        // Don't clear it here, we'll clear it only when we use it
        $this->backUrl = session('back_url');

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
            // --- Inicializar los nuevos campos ---
            $this->areausuaria = $this->ordenEditar->areausuaria;
            $this->rpeusuaria = $this->ordenEditar->rpeusuaria;
            $this->autoriza = $this->ordenEditar->autoriza;
            $this->rpejefedpt = $this->ordenEditar->rpejefedpt;
            $this->resppv = $this->ordenEditar->resppv;
            $this->rperesppv = $this->ordenEditar->rperesppv;
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
    // --- 4. NUEVOS UPDATED HOOKS ---

    /**
     * Se ejecuta cuando la propiedad $areausuaria cambia.
     * Busca al usuario por nombre y autocompleta $rpeusuaria.
     */
    public function updatedAreausuaria($name)
    {
        $user = User::where('name', $name)->first();
        if ($user) {
            $this->rpeusuaria = $user->usuario; // 'usuario' es el RPE, según tu descripción
        } else {
            $this->rpeusuaria = ''; // Limpiar si el nombre no coincide
        }
    }

    /**
     * Se ejecuta cuando la propiedad $autoriza cambia.
     */
    public function updatedAutoriza($name)
    {
        $user = User::where('name', $name)->first();
        if ($user) {
            $this->rpejefedpt = $user->usuario;
        } else {
            $this->rpejefedpt = '';
        }
    }

    /**
     * Se ejecuta cuando la propiedad $resppv cambia.
     */
    public function updatedResppv($name)
    {
        $user = User::where('name', $name)->first();
        if ($user) {
            $this->rperesppv = $user->usuario;
        } else {
            $this->rperesppv = '';
        }
    }

    /**
     * Handle the modal close event
     */
    public function closeModal()
    {
        $this->showModal = false;
        
        // If we have a back URL, redirect to it
        if ($this->backUrl) {
            $backUrl = $this->backUrl;
            
            // Clear the back URL from the session
            session()->forget('back_url');
            $this->backUrl = null;
            
            return redirect($backUrl);
        }
        
        // Clear any remaining back URL from the session
        session()->forget('back_url');
        
        // Otherwise, redirect to the ordenvehiculos index
        return redirect()->route('ordenvehiculos.index');
    }

    public function render()
    {
        return view('livewire.orden-vehiculos-create');
    }
}
