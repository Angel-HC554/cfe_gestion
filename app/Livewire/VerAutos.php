<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehiculo;

class VerAutos extends Component
{

    use WithPagination;
    public $estados;
    public $search = '';
    public $estado = '';
    protected $paginationTheme = 'tailwind';


    public function mount()
    {
        $this->estados = Vehiculo::pluck('estado')->unique();
    }
    // Reiniciar la paginación cuando cambie el término de búsqueda
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Reiniciar la paginación cuando cambie el estado
    public function updatedEstado()
    {
        $this->resetPage();
    }

    // Este método reinicia los filtros a su estado original
    public function resetFilters()
    {
        $this->reset(['search', 'estado']);
        $this->resetPage();
    }
    
    public function render()
    {
        $consulta = Vehiculo::query()
            ->select('id', 'marca', 'modelo', 'año', 'no_economico', 'estado', 'tipo_vehiculo', 'placas');
        
        if ($this->search) {
            $consulta->where('no_economico', 'like', '%' . $this->search . '%');
        }
        if ($this->estado) {
            $consulta->where('estado', $this->estado);
        }
        $vehiculos = $consulta->paginate(16);
        return view('livewire.ver-autos', compact('vehiculos'));
    }
}
