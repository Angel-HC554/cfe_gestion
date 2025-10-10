<div>
    <div class="flex flex-row justify-between border-1 shadow-sm items-center bg-white rounded-md border-t-3 border-t-emerald-700/40 p-3">
        <div class="flex flex-col text-gray-700 font-medium">
            Desde
            <input type="date" id=""
                class="w-64 h-8 border border-gray-300 bg-gray-50 rounded-md p-2 text-gray-500 focus:ring-emerald-600 focus:border-emerald-600"
                wire:model.live="fecha_inicio">
        </div>
        <div class="flex flex-col text-gray-700 font-medium">
            Hasta
            <input type="date" id=""
                class="w-64 h-8 border border-gray-300 bg-gray-50 rounded-md p-2 text-gray-500 focus:ring-emerald-600 focus:border-emerald-600"
                wire:model.live="fecha_fin">
        </div>
        <div class="flex flex-col text-gray-700 font-medium">
            Estado
            <select type="date" id=""
                class="w-64 h-8 border border-gray-300 bg-gray-50 rounded-md p-1 text-gray-500 focus:ring-emerald-600 focus:border-emerald-600"
                wire:model.live="estado"> 
                <option value="">Todos</option>
                <option value="PENDIENTE">PENDIENTE</option>
                <option value="ENTREGADO PV">ENTREGADO PV</option>
                <option value="VEHICULO TALLER">VEHICULO TALLER</option>
                <option value="VEHICULO FUNCIONAMIENTO">VEHICULO FUNCIONAMIENTO</option>
            </select>
        </div>
        <flux:button wire:click="resetFilters" variant="filled" >Borrar filtros</flux:button>
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
        @if ($showSearch)
            <div class="flex items-center gap-2">
                <flux:input class="w-64" size="sm" icon:leading="magnifying-glass" placeholder="No. económico..."
                    wire:model.live="search" />
            </div>
        @endif
    </div>
    <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-1">
            <thead class="text-xs text-green-950 uppercase bg-accent-content/20 dark:bg-green-900 dark:text-amber-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No. Orden
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No. Economico
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Agencia
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Archivos
                    </th>
                    <th scope="col" class="px-6 py-3">
                        500
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ordenes as $orden)
                    <tr class="bg-white border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ $backUrl ? route('ordenvehiculos.show', $orden->id) . '?back=' . urlencode($backUrl) : route('ordenvehiculos.show', $orden->id) }}" class="underline ml-3 px-4">
                                {{ $orden->id }}
                            </a>
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $orden->noeconomico }}
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $orden->area }}
                        </th>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $orden->fechafirm }}
                        </td>

                        <td class="px-6 py-4">

                            <flux:dropdown>
                                <flux:button icon:trailing="document-text" class="bg-blue-100! hover:bg-blue-200!"/>
                                    <flux:menu>
                                    <flux:menu.item icon="document" href="{{ route('ordenvehiculos.pdf', [$orden->id]) }}">Documento generado</flux:menu.item>
                                    <flux:menu.item icon="document-arrow-up" wire:click="descargarEscaneo1({{ $orden->id }})">Entregado a PV</flux:menu.item>
                                    <flux:menu.item icon="document-check" wire:click="descargarEscaneo2({{ $orden->id }})">Concluido</flux:menu.item>
                                    </flux:menu>
                            </flux:dropdown>

                        </td>
                        <td class="px-6 py-4 flex justify-start">
                            @if ($orden->orden_500 == 'NO')
                                NO
                            @else
                                <a wire:click="openModal500({{ $orden->id }})"
                                    class="text-green-800 font-semibold underline p-1 cursor-pointer">{{ $orden->orden_500 }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <flux:button
                                class=" text-xs! {{ match ($orden->status) {
                                    'PENDIENTE' => ' text-red-800! bg-red-100!',
                                    'ENTREGADO PV' => ' text-blue-800! bg-blue-100!',
                                    'VEHICULO TALLER' => ' text-orange-800! bg-orange-100!',
                                    'VEHICULO FUNCIONAMIENTO' => ' text-green-800! bg-green-100!',
                                    default => 'text-gray-800!',
                                } }}"
                                variant="filled" wire:click="openEditModal({{ $orden->id }})">{{ $orden->status }}
                            </flux:button>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:button.group>
                                <flux:button icon="eye" wire:click="openMoreModal({{ $orden->id }})" class="text-emerald-800!"/>
                                <flux:button icon="pencil-square" href="{{ route('ordenvehiculos.edit', $orden) }}" class="text-emerald-800!"></flux:button>
                            </flux:button.group>

                            <flux:button variant="subtle" type="submit" icon="trash"
                                wire:click="confirmDelete({{ $orden->id }})" class="text-emerald-900/60!"/>

                        </td>
                    </tr>
                @empty
                    {{-- Código que se ejecuta si no hay resultados --}}
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <td class="px-6 py-4 text-center" colspan="5">
                            <flux:heading size="lg" class="inline-flex"><flux:icon.exclamation-circle
                                    class="mr-2" />No se
                                encontraron órdenes.
                            </flux:heading>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    {{-- Modales --}}
    <flux:modal wire:model.live="showModal500" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Ingresar codigo orden 500</flux:heading>
            </div>
            <flux:input icon:trailing="hashtag" placeholder="Ingresa el codigo" wire:model="codigoOrden500" />
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <form wire:submit.prevent="agregarOrden500">
                    <flux:button type="submit" variant="primary">Guardar</flux:button>

                </form>
            </div>
        </div>
    </flux:modal>

    <flux:modal wire:model.live="showMoreModal" class="md:w-96" variant="flyout">
        <div class="space-y-6">
            <div>
                <div class="flex items-center mb-5">
                    <flux:heading size="xl" class="mr-2"> Datos de la orden</flux:heading>
                    <flux:icon.document-text variant="solid" color="green"/>
                </div>
                <flux:separator />
                <flux:heading class="mt-2" size="lg">Comentarios:</flux:heading>
                <div class="bg-amber-100 border-l-4 border-amber-300 p-2 rounded-md mt-2 flex items-center justify-center">
                    <flux:text class="mt-2">
                        <p>{{ $comentarios }}</p>
                    </flux:text>
                </div>
            </div>
            <flux:separator />
            <form wire:submit="guardarEscaneo">
                <flux:heading class="m-2" size="lg">Escaneos:</flux:heading>
                {{-- 1. Mensaje de éxito (usando session flash) --}}
                @if (session()->has('mensajeEscaneado'))
                    <div class="m-2 p-2 text-sm text-green-800 bg-green-100 rounded-lg">
                        {{ session('mensajeEscaneado') }}
                    </div>
                @endif

                {{-- 2. Indicador de "Cargando..." mientras se sube el archivo --}}
                <div wire:loading wire:target="archivoEscaneado" class="m-2 text-sm text-gray-500">
                    Subiendo archivo...
                </div>

                <div>
                    <input type="file" wire:model="archivoEscaneado"
                        id="logo-upload"class="block w-full max-w-xs text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-600/10 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                </div>

                {{-- 3. Mensaje de error de validación --}}
                @error('archivoEscaneado')
                    <p class="m-2 text-sm text-red-600">El archivo escaneado debe ser un archivo de tipo: pdf.</p>
                @enderror

                <p class="m-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">El formato debe ser PDF
                </p>

                {{-- Comentarios para el escaneo --}}
                <div class="m-2">
                    <flux:heading size="lg">Comentarios del escaneo:</flux:heading>
                    <textarea rows="3" wire:model="comentariosEscaneo"
                        class="mt-1 p-2 block w-full rounded-md border border-gray-400 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"></textarea>
                </div>

                <flux:button size="sm" class="ml-2 mt-2 hover:bg-zinc-100!" icon="arrow-up"
                    type="submit">Subir</flux:button>
            </form>
            <flux:separator />
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="primary">OK</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal wire:model.live="showStatusModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="xl">Actualizar estado</flux:heading>
                <flux:text class="mt-2">
                    <p>El estado actual es: {{ $actualStatus }}</p>
                </flux:text>
            </div>
            <select wire:model="newStatus"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Selecciona...</option>
                <option value="PENDIENTE">PENDIENTE</option>
                <option value="ENTREGADO PV">ENTREGADO PV</option>
                <option value="VEHICULO TALLER">VEHICULO TALLER</option>
                <option value="VEHICULO FUNCIONAMIENTO">VEHICULO FUNCIONAMIENTO</option>
            </select>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <form wire:submit.prevent="UpdateEstadoOrden">
                    <flux:button type="submit" variant="primary">Guardar</flux:button>

                </form>
            </div>
        </div>
    </flux:modal>
    <flux:modal wire:model.live="showDeleteModal" class="min-w-[22rem]">
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
