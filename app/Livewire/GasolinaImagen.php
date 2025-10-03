<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class GasolinaImagen extends Component
{
    #[Reactive] // Hace que se actualice cuando cambie en el padre
    public $nivelGasolina;

    public function render()
    {
        return view('livewire.gasolina-imagen');
    }
}
