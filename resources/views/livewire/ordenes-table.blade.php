<div>
    <div>
        Filtrar:
        <input type="date" id=""
            class="border border-gray-300 rounded-md p-0.5 focus:ring-blue-500 focus:border-blue-500"
            wire:model.live="fecha_inicio">
        -
        <input type="date" id=""
            class="border border-gray-300 rounded-md p-0.5 focus:ring-blue-500 focus:border-blue-500"
            wire:model.live="fecha_fin">
        <flux:button wire:click="resetFilters" variant="subtle">Borrar filtros</flux:button>
    </div>
    <div class="flex justify-between items-center my-5">
        <div class="flex items-center gap-2">
            Ver
            <flux:select size="sm" wire:model.live="porPagina">
                <flux:select.option>5</flux:select.option>
                <flux:select.option>10</flux:select.option>
                <flux:select.option>15</flux:select.option>
            </flux:select>
        </div>
        <flux:button variant="primary" href="{{ route('ordenvehiculos.create') }}">CREAR ORDEN</flux:button>

    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-1">
            <thead class="text-xs text-green-950 uppercase bg-accent-content/20 dark:bg-green-900 dark:text-amber-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No. Orden
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Escaneo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Archivos
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ordenes as $orden)
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $orden->id }}
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $orden->fechafirm }}
                        </td>
                        <td class="px-6 py-4">
                            <label>
                                <input type="file"
                                    class="text-sm text-grey-500
            file:mr-5 file:py-2 file:px-6
            file:rounded-full file:border-0
            file:text-sm file:font-medium
            file:bg-blue-50 file:text-blue-700
            hover:file:cursor-pointer hover:file:bg-amber-50
            hover:file:text-amber-700
          " />
                            </label>
                        </td>
                        <td class="px-6 py-4">
                            <flux:button variant="filled" class="bg-blue-100!"
                                href="{{ route('ordenvehiculos.descargar', [$orden->id]) }}">Doc</flux:button>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:button class="mr-1" href="{{ route('ordenvehiculos.edit', $orden) }}">Editar
                            </flux:button>
                            <flux:button variant="subtle" type="submit" icon="trash"
                                wire:click="confirmDelete({{ $orden->id }})" />

                        </td>
                    </tr>
                @empty
                    {{-- Código que se ejecuta si no hay resultados --}}
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <td class="px-6 py-4 text-center" colspan="5">
                            <flux:heading size="lg" class="inline-flex"><flux:icon.exclamation-circle
                                    class="mr-2" />No se
                                encontraron órdenes para la búsqueda.
                            </flux:heading>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <flux:modal wire:model.live="showDeleteModal" name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar esta orden?</flux:heading>
                <flux:text class="mt-2">
                    <p>Esta acción no se puede revertir.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <form wire:submit.prevent="deleteOrden">
                    <flux:button type="submit" variant="danger">Eliminar</flux:button>

                </form>
            </div>
        </div>
    </flux:modal>
    {{-- Enlaces de paginación --}}
    <div class="mt-4">
        {{ $ordenes->links() }}
    </div>
</div>
