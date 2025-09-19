<?php

namespace App\Livewire;

use App\Models\OrdenVehiculo;
use Livewire\Component;
use Livewire\WithPagination;

class OrdenesTable extends Component
{
    use WithPagination;

    // Para filtrar por fechas
    public $fecha_inicio = '';
    public $fecha_fin = '';

    public $porPagina = 5; // Cantidad de resultados por página

    public $ordenIdToDelete;
    public $showDeleteModal = false;

    public function confirmDelete($id)
    {
        $this->ordenIdToDelete = $id;
        $this->showDeleteModal = true;
    }
    public function deleteOrden()
    {
        // Se asegura de que haya un ID válido
        if ($this->ordenIdToDelete) {
            $orden = OrdenVehiculo::find($this->ordenIdToDelete);
            if ($orden) {
                $orden->delete();
                // Limpia el ID y cierra el modal
                $this->ordenIdToDelete = null;
                $this->showDeleteModal = false;
                // Muestra un mensaje de éxito
                $this->dispatch('orden-eliminada', message: 'Orden eliminada con éxito.');

            }
        }
    }

    public function render()
    {
        //consulta a bd para filtrar por fechas
        $consulta = OrdenVehiculo::query();
        if ($this->fecha_inicio) {
            $consulta->where('fechafirm', '>=', $this->fecha_inicio);
        }
        if ($this->fecha_fin) {
            $consulta->where('fechafirm', '<=', $this->fecha_fin);
        }
        // Paginacion de resultados, mostrando 5 por página
        $ordenes = $consulta->paginate($this->porPagina);

        return view('livewire.ordenes-table', ['ordenes' => $ordenes,]);
    }

    // Este método reinicia los filtros a su estado original
    public function resetFilters()
    {
        $this->reset(['fecha_inicio', 'fecha_fin']);
        $this->resetPage(); // Regresa a la primera página después de reiniciar
    }
}
