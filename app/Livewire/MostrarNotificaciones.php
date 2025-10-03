<?php

namespace App\Livewire;

use App\Models\OrdenVehiculo;
use Livewire\Component;

class MostrarNotificaciones extends Component
{
    public $numNotificaciones;

    public function render()
    {
        $this->numNotificaciones = OrdenVehiculo::where('orden_500', 'SI')->count();
        return <<<'HTML'
        <div wire:poll.8400ms>
            @if($numNotificaciones > 0)
            <flux:badge color="red">{{$numNotificaciones}}</flux:badge>
            @endif
        </div>
        HTML;
    }
}
