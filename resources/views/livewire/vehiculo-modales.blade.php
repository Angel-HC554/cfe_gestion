 <div>
    <flux:button icon="arrow-up-tray" variant="outline" wire:click="abrirModalImp" class="mr-2">Importar</flux:button>
    <flux:button icon="arrow-down-tray" variant="outline" wire:click="abrirModalExp" class="mr-2">Exportar</flux:button>
    <flux:button icon="plus" variant="primary" wire:click="abrirModalNuevo">Nuevo Vehículo</flux:button>

    {{-- modal importar excel de vehiculos --}}
    <flux:modal wire:model.live="showImportarModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Importar vehiculos</flux:heading>
                <flux:text class="mt-2">Sube el archivo excel con el formato correcto para importar los vehiculos.
                </flux:text>
            </div>
            <form wire:submit="importarVehiculos">
                {{-- 1. Mensaje de éxito (usando session flash) --}}
                @if (session()->has('mensajeEscaneado'))
                    <div class="m-2 p-2 text-sm text-green-800 bg-green-100 rounded-lg">
                        {{ session('mensajeEscaneado') }}
                    </div>
                @endif

                {{-- 2. Indicador de "Cargando..." mientras se sube el archivo --}}
                <div wire:loading wire:target="archivoExcel" class="m-2 text-sm text-gray-500">
                    Subiendo archivo...
                </div>

                <div>
                    <input type="file" wire:model="archivoExcel"
                        id="logo-upload"class="block w-full max-w-xs text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-600/10 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                </div>

                {{-- 3. Mensaje de error de validación --}}
                @error('archivoExcel')
                    <p class="m-2 text-sm text-red-600">El archivo debe ser de tipo: xlsx, xls.</p>
                @enderror

                <p class="m-3 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">.xlsx</p>

                <div class="flex">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button class="mr-2" variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" icon="arrow-up-tray" variant="primary">Importar</flux:button>
                </div>
            </form>

        </div>
    </flux:modal>

    {{-- modal exportar excel de vehiculos --}}
    <flux:modal class="md:w-96" wire:model.live="showExportarModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Exportar vehiculos</flux:heading>
                <flux:text class="mt-2">Descarga el archivo excel con los vehiculos.</flux:text>
            </div>
            <form wire:submit="exportarVehiculos">

                <div class="flex">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button class="mr-2" variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" icon="arrow-down-tray" variant="primary">Descargar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- modal nuevo vehiculo --}}
    <flux:modal class="w-[90vw] max-w-[1200px]" wire:model.live="showNuevoModal">
        <div class="space-y-6 max-h-[90vh] overflow-y-auto px-2 md:px-6">
            <div>
                <flux:heading size="lg">Nuevo Vehículo</flux:heading>
                <flux:text class="mt-2">Completa la información para registrar un nuevo vehículo.</flux:text>
            </div>

            <form wire:submit="guardarVehiculos" class="space-y-4 vehiculo-modal">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agencia</label>
                        <select wire:model.defer="agencia" class="mt-1 block w-full rounded-md border-zinc-200 border-2">
                            <option value="DW01">DW01</option>
                            <option value="DW01A">DW01A</option>
                            <option value="DW01B">DW01B</option>
                            <option value="DW01C">DW01C</option>
                            <option value="DW01D">DW01D</option>
                            <option value="DW01E">DW01E</option>
                            <option value="DW01G">DW01G</option>
                            <option value="DW01H">DW01H</option>
                            <option value="DW01J">DW01J</option>
                            <option value="DW01K">DW01K</option>
                            <option value="DW01M">DW01M</option>
                        </select>
                        @error('agencia')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. económico</label>
                        <input type="text" wire:model.defer="no_economico" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('no_economico')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Placas</label>
                        <input type="text" wire:model.defer="placas" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('placas')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de vehículo</label>
                        <input type="text" wire:model.defer="tipo_vehiculo" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('tipo_vehiculo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Marca</label>
                        <input type="text" wire:model.defer="marca" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('marca')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Modelo</label>
                        <input type="text" wire:model.defer="modelo" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('modelo')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Año</label>
                        <input type="number" wire:model.defer="año" class="mt-1 block w-full rounded-md border-zinc-200 border-2" placeholder="2025" />
                        @error('año')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Proceso</label>
                        <input type="text" wire:model.defer="proceso" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('proceso')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alias</label>
                        <input type="text" wire:model.defer="alias" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('alias')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">RPE Crea/Mod</label>
                        <input type="text" wire:model.defer="rpe_creamod" class="mt-1 block w-full rounded-md border-zinc-200 border-2" />
                        @error('rpe_creamod')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select wire:model.defer="estado" class="mt-1 block w-full rounded-md border-zinc-200 border-2">
                            <option value="">Seleccione...</option>
                            <option value="En circulacion">En circulación</option>
                            <option value="En mantenimiento">En mantenimiento</option>
                            <option value="Fuera de circulacion por falla pendiente">Fuera de circulación por falla pendiente</option>
                            <option value="Fuera de circulacion">Fuera de circulación</option>
                        </select>
                        @error('estado')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Propiedad</label>
                        <select wire:model.defer="propiedad" class="mt-1 block w-full rounded-md border-zinc-200 border-2">
                            <option value="">Seleccione...</option>
                            <option value="Arrendado">Arrendado</option>
                            <option value="Propio (CFE)">Propio (CFE)</option>
                        </select>
                        @error('propiedad')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex mt-4">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button class="mr-2" variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Guardar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <style>
        /* Estilos sólo para el formulario del modal de vehículo */
        .vehiculo-modal input[type="text"],
        .vehiculo-modal input[type="number"],
        .vehiculo-modal select {
            height: 2rem; /* ~32px */
            padding: 0.25rem 0.75rem; /* py-1 px-3 */
            font-size: 0.875rem; /* text-sm */
            line-height: 1.25rem; /* leading-5 */
            caret-color: #111827; /* gray-900 para ver el cursor */
        }

        .vehiculo-modal input:focus,
        .vehiculo-modal select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25); /* focus:ring-emerald-500/25 */
            border-color: rgba(16, 185, 129, 0.7);
        }
    </style>

</div>
