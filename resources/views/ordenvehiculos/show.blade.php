<x-layouts.app :title="__('Dashboard')">
    <div class="flex justify-between items-center mx-10">
        <flux:heading class="flex items-center justify-center gap-2 mt-2" size="xl">
            <flux:icon.arrow-path-rounded-square class="size-7" />
            Historial de la orden: {{ $ordenvehiculo->id }}
        </flux:heading>
        <flux:button variant="primary" icon="chevron-left" href="{{ url()->previous() }}">Volver
        </flux:button>
    </div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <flux:heading class="flex items-center justify-center gap-2 mt-2" size="xl">
            Seguimiento
        </flux:heading>

        @php
            $badgeClasses = [
                'orden_creado' => 'bg-green-100 text-green-700',
                'orden_actualizado' => 'bg-blue-100 text-blue-700',
                'estado_cambiado' => 'bg-amber-100 text-amber-700',
                'archivo_subido' => 'bg-purple-100 text-purple-700',
            ];
            $titleMap = [
                'archivo_subido' => 'Se subió un archivo',
                'estado_cambiado' => 'Se cambió el estado',
                'orden_creado' => 'Se creó la orden',
                'orden_actualizado' => 'Se actualizó la orden',
                'orden_500' => 'Se agregó el número de orden 500',
            ];
        @endphp

        <div class="relative mt-6 space-y-4 pl-6 before:content-[''] before:absolute before:left-3 before:top-0 before:bottom-0 before:w-px before:bg-emerald-200">
            @forelse ($historial as $evento)
                @php
                    $cls = $badgeClasses[$evento->tipo_evento] ?? 'bg-gray-100 text-gray-700';
                    $titulo = $titleMap[$evento->tipo_evento] ?? Str::of($evento->tipo_evento)->replace('_', ' ')->title();
                @endphp

                <div class="relative ml-1 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <span class="absolute -left-3 top-5 h-2.5 w-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <span class="text-md font-semibold text-gray-800">{{ $titulo }}@if($evento->tipo_evento === 'file_upload' && !empty($evento->detalles)): {{ $evento->detalles }} @endif</span>
                                <span class="text-[11px] px-2 py-0.5 rounded-full font-medium {{ $cls }}">{{ Str::of($evento->tipo_evento)->replace('_', ' ')->title() }}</span>
                            </div>
                            <span class="text-sm text-gray-600">{{ optional($evento->created_at)->format('d/m/Y H:i') }}</span>
                        </div>
                        <span class="text-[11px] text-gray-400">ID #{{ $evento->id }}</span>
                    </div>

                    @if ($evento->tipo_evento === 'estado_cambiado')
                        <div class="mt-3 rounded-md bg-gray-50 p-2 text-sm text-gray-600 flex content-center">
                            <div class="content-center inline-flex">
                                @if (!is_null($evento->old_value))
                                    <span class="font-semibold"> {{ $evento->old_value }} </span>
                                @endif
                                @if (!is_null($evento->new_value))
                                    <span class="font-semibold flex"> <flux:icon.arrow-long-right class="mx-2" /> {{ $evento->new_value }} </span>
                                @endif
                            </div>
                        </div>
                    @else
                        @if (!empty($evento->detalles) && $evento->tipo_evento !== 'archivo_subido')
                            <div class="mt-2 text-md text-gray-700">{{ $evento->detalles }} </div>
                        @endif
                    @endif

                    @if ($evento->tipo_evento === 'archivo_subido')
                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="text-gray-600">{{ $evento->detalles }}</div>
                                @if(!empty($evento->new_value))
                                    @php
                                        $rutaDescarga = null;
                                        if ($evento->detalles == 'ESCANEO SUBIDO: ENTREGADO PV') {
                                            $rutaDescarga = route('ordenvehiculos.escaneo.entrada', $ordenvehiculo->id);
                                        } elseif ($evento->detalles == 'ESCANEO SUBIDO: VEHICULO FUNCIONAMIENTO') {
                                            $rutaDescarga = route('ordenvehiculos.escaneo.salida', $ordenvehiculo->id);
                                        }
                                    @endphp
                                    @if($rutaDescarga)
                                        <a href="{{ $rutaDescarga }}" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 underline decoration-emerald-300">
                                            <flux:icon.paper-clip class="size-4" />
                                            {{ $evento->new_value }}
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-gray-700">
                                            <flux:icon.paper-clip class="size-4" />
                                            {{ $evento->new_value }}
                                        </span>
                                    @endif
                                @endif
                            </div>
                            @if(!empty($evento->detalles))
                                <div>
                                    <div class="text-gray-600">Comentario:</div>
                                    <div>
                                        @if ($evento->detalles == 'ESCANEO SUBIDO: ENTREGADO PV')
                                            @foreach ($archivo1 as $escaneo1)
                                            @if ($escaneo1->comentarios != null)
                                            {{ $escaneo1->comentarios }}
                                            @else
                                                No hay comentarios.
                                            @endif
                                            @endforeach
                                        @elseif ($evento->detalles == 'ESCANEO SUBIDO: VEHICULO FUNCIONAMIENTO')
                                            @foreach ($archivo2 as $escaneo2)
                                            @if ($escaneo2->comentarios != null)
                                            {{ $escaneo2->comentarios }}
                                            @else
                                                No hay comentarios.
                                            @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">Sin eventos registrados para esta orden.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>

