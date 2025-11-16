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
        <flux:dropdown>
                <flux:navbar.item icon="bell">
                    <div wire:poll.9400ms>
            @if($numNotificaciones > 0)
            <flux:badge color="red">{{$numNotificaciones}}</flux:badge>
            @endif
        </div> </flux:navbar.item>
        <flux:navmenu>
                    @if($numNotificaciones > 0)
                        <flux:navmenu.item icon="exclamation-circle" href="{{ route('ordenvehiculos.index') }}">Orden 500 pendiente</flux:navmenu.item>
                        @else
                        <flux:navmenu.item icon="check" href="#" class="hover:text-green-700!">No hay pendientes</flux:navmenu.item>
                        @endif
                    </flux:navmenu>
            </flux:dropdown> 
        HTML;
    }
}
