<x-layouts.app>
    <div class="flex items-center justify-between mb-6 mx-10">
        <flux:heading size="xl" class="flex items-center gap-2">
            Información del vehículo
        </flux:heading>
        <div id="flash-message-container"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
        </div>
        <flux:button variant="primary" icon="chevron-left" href="{{ route('vehiculos.index') }}">Volver</flux:button>
    </div>

    @php
        // Preparar archivos/imágenes de todas las órdenes relacionadas
        $imagenes = collect($ordenes ?? [])->flatMap(function ($ord) {
            return collect($ord->archivos ?? []);
        })->take(6);

    @endphp

    <div class="mx-6 md:mx-10 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tarjeta de información del vehículo -->
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-md">
                <div class="flex items-start gap-4 bg-gradient-to-t from-emerald-600 to-emerald-900 text-white rounded-t-lg -m-5 mb-2 p-4 md:p-5">
                    <div class="h-20 w-36 shrink-0 overflow-hidden rounded-md bg-gray-100 ring-1 ring-white/20">
                        <img src="https://tork.news/__export/1732683379972/sites/tork/img/2024/11/27/image_-2-.png_95105349.png" alt="vehiculo" class="h-full w-full object-contain">
                    </div>
                    <div>
                        <div class="text-xl font-semibold text-white">{{ $vehiculo->marca ?? 'Marca' }} {{ $vehiculo->modelo ?? '' }}</div>
                        <div class="text-sm text-emerald-100">{{ $vehiculo->tipo_vehiculo ?? 'Tipo' }}</div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Año:</span>
                        <span class="text-gray-700">{{ $vehiculo->{"año"} ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Estado:</span>
                        <span class="text-gray-700">{{ $vehiculo->estado ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Propietario:</span>
                        <span class="text-gray-700">{{ $vehiculo->propiedad ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Agencia:</span>
                        <span class="text-gray-700">{{ $vehiculo->agencia ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">No. Económico:</span>
                        <span class="text-gray-700">{{ $vehiculo->no_economico ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Placas:</span>
                        <span class="text-gray-700">{{ $vehiculo->placas ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Alias:</span>
                        <span class="text-gray-700">{{ $vehiculo->alias ?? '—' }}</span>
                    </div>
                    <div class="flex text-sm">
                        <span class="font-semibold text-gray-700 mr-2">Proceso:</span>
                        <span class="text-gray-700">{{ $vehiculo->proceso ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fotos y Revisión -->
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="lg">Fotos</flux:heading>
                    <flux:button variant="ghost" icon="pencil-square" aria-label="editar" />
                </div>

                @if($imagenes->isEmpty())
                    <div class="text-sm text-gray-500">No hay imágenes asociadas a este vehículo.</div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach ($imagenes as $img)
                            @php
                                $url = \Illuminate\Support\Str::startsWith($img->ruta_archivo, ['http://', 'https://'])
                                    ? $img->ruta_archivo
                                    : \Illuminate\Support\Facades\Storage::url($img->ruta_archivo);
                            @endphp
                            <div class="overflow-hidden rounded-lg ring-1 ring-gray-200">
                                <img src="https://http2.mlstatic.com/D_NQ_NP_722484-MLM88244465756_072025-O-ford-ranger-xlt-4x2-23l-ta.webp" class="h-28 w-full object-cover" alt="foto vehiculo">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Historial de Órdenes -->
    <div class="mx-6 md:mx-10 mt-8">
        <div class="rounded-xl border border-gray-200 bg-white shadow-md">
            <div class="px-6 pt-5 pb-3">
                <flux:heading size="lg">Historial de Ordenes</flux:heading>
            </div>
            <div class="p-4">
                <livewire:ordenes-table :noeconomico-exact="$vehiculo->no_economico" :show-search="false" :back-url="route('vehiculos.show', $vehiculo->id)" />
            </div>
        </div>
    </div>

</x-layouts.app>


