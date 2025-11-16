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

    <div class="mx-6 md:mx-10 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tarjeta de información del vehículo -->
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-md">
                <div
                    class="flex items-start gap-4 bg-gradient-to-t from-emerald-600 to-emerald-900 text-white rounded-t-lg -m-5 mb-2 p-4 md:p-5">
                    <div class="h-20 w-36 shrink-0 overflow-hidden rounded-md bg-gray-100 ring-1 ring-white/20">
                        <img src="https://media.ed.edmunds-media.com/chevrolet/silverado-1500/2026/oem/2026_chevrolet_silverado-1500_crew-cab-pickup_high-country_fq_oem_2_1600.jpg"
                            alt="vehiculo" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <div class="text-xl font-semibold text-white">{{ $vehiculo->marca ?? 'Marca' }}
                            {{ $vehiculo->modelo ?? '' }}</div>
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

        <!-- KM y fotos -->
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-gray-200 bg-white shadow-md tab-group-1">

                <!-- Navegación de pestañas -->
                <div class="border-b border-gray-200 px-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button id="tab-estado-1"
                            class="tab-button-1 border-emerald-500 text-emerald-600 hover:border-emerald-700 hover:text-emerald-700 whitespace-nowrap border-b-2 py-2 px-2 text-sm font-semibold"
                            aria-current="page">
                            Estado KM
                        </button>
                        <button id="tab-fotos-1"
                            class="tab-button-1 border-transparent text-gray-500 hover:border-emerald-700 hover:text-emerald-700 whitespace-nowrap border-b-2 py-2 px-2 text-sm font-semibold">
                            Fotos
                        </button>
                    </nav>
                </div>

                <!-- Contenido de pestañas -->
                <div class="p-6">
                    <!-- Estado KM -->
                    <div id="content-estado-1" class="tab-content-1">
                        @php
                            $estatus = $vehiculo->estado_mantenimiento;
                            $colores = [
                                'verde' => 'bg-green-500',
                                'amarillo' => 'bg-yellow-500',
                                'rojo' => 'bg-red-500',
                                'rojo_pasado' => 'bg-red-700 animate-pulse',
                                'gris' => 'bg-gray-400',
                            ];
                            $texto = [
                                'verde' => 'Vehiculo al día',
                                'amarillo' => 'Mantenimiento próximo',
                                'rojo' => 'Mantenimiento Urgente',
                                'rojo_pasado' => 'MANTENIMIENTO VENCIDO',
                                'gris' => 'Sin datos de KM',
                            ];
                        @endphp

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <!-- Kilometraje Section -->
                            <div class="flex-1">
                                @php
                                    $kmActual = $vehiculo->ultimoKilometraje();
                                    $kmUltimo = $vehiculo->latestMantenimiento?->kilometraje;
                                    $proximo = $kmUltimo 
                                        ? ($kmUltimo + 10000) 
                                        : (($kmActual !== null ? ceil($kmActual / 10000) * 10000 : 0) ?: 10000);
                                @endphp
                                <h2 class="text-sm font-medium text-gray-700 mb-1">Kilometraje actual</h2>
                                <p class="text-2xl font-bold text-gray-800">
                                    @if ($kmActual !== 0)
                                        {{ number_format($kmActual) }}
                                        <span class="text-sm font-normal text-gray-600">km</span>
                                    @else
                                        <span class="text-gray-500">Sin registro</span>
                                    @endif
                                </p>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-sm font-medium text-gray-400 mb-1">Ultimo servicio</h2>
                                <p class="text-2xl font-bold text-gray-500">
                                    @if ($kmUltimo !== null)
                                        {{ number_format($kmUltimo) }}
                                        <span class="text-sm font-normal text-gray-600">km</span>
                                    @else
                                        <span class="text-gray-500">Sin registro</span>
                                    @endif
                                </p>
                            </div>
                            <div class="flex-1 text-right sm:text-left">
                                <h2 class="text-sm font-medium text-gray-400 mb-1">Próximo servicio</h2>
                                <p class="text-xl font-semibold text-indigo-600">
                                    @if($kmActual !== 0)
                                        {{ number_format($proximo) }} km
                                        <span class="block text-xs text-gray-500 mt-1">
                                        Faltan: {{ number_format(max(0, $proximo - $kmActual)) }} km
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </p>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex-shrink-0">
                                <div
                                    class="inline-flex items-center px-4 py-4 rounded-full text-sm font-semibold {{ $colores[$estatus] ?? 'bg-gray-400' }} text-white shadow-sm">
                                    {{ $texto[$estatus] ?? 'Indefinido' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fotos -->
                    <div id="content-fotos-1" class="tab-content-1 hidden">
                        {{-- <div class="flex items-center justify-between mb-4">
                            <flux:heading size="lg">Fotos</flux:heading>
                            <flux:button variant="ghost" icon="pencil-square" aria-label="editar" />
                        </div> --}}
                        

                        @php
                            $photos = [];
                            if ($fotos && $fotos->foto_del) {
                                $nombreFoto = 'Foto delantera del auto ';
                                $photos[] = ['foto' => $fotos->foto_del, 'nombre' => $nombreFoto];
                            }
                            if ($fotos && $fotos->foto_tra) {
                                $nombreFoto = 'Foto trasera del auto ';
                                $photos[] = ['foto' => $fotos->foto_tra, 'nombre' => $nombreFoto];
                            }
                            if ($fotos && $fotos->foto_lado_der) {
                                $nombreFoto = 'Foto lado derecho del auto ';
                                $photos[] = ['foto' => $fotos->foto_lado_der, 'nombre' => $nombreFoto];
                            }
                            if ($fotos && $fotos->foto_lado_izq) {
                                $nombreFoto = 'Foto lado izquierdo del auto ';
                                $photos[] = ['foto' => $fotos->foto_lado_izq, 'nombre' => $nombreFoto];
                            }
                        @endphp

                        @if (count($photos) > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach ($photos as $photo)
                                    <a class="overflow-hidden rounded-lg ring-1 ring-gray-200" href="{{ asset($photo['foto']) }}" data-fancybox="gallery" data-caption="{{ $photo['nombre'] }}">
                                        <img src="{{ asset($photo['foto']) }}" class="h-28 w-full object-cover hover:cursor-pointer"
                                            alt="foto vehiculo">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-sm text-gray-500">No hay imágenes asociadas a este vehículo.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de pestañas -->
    <div class="mx-6 md:mx-10 mt-8">
        <div class="rounded-xl border border-gray-200 bg-white shadow-md tab-group-2">

            <!-- Navegación de pestañas -->
            <div class="border-b border-gray-200 px-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button id="tab-historial-2"
                        class="tab-button-2 border-emerald-500 text-gray-500 hover:border-emerald-700 hover:text-emerald-700 whitespace-nowrap border-b-2 py-2 px-2 text-sm font-semibold"
                        aria-current="page">
                        Historial de Órdenes
                    </button>
                    <button id="tab-supervision-2"
                        class="tab-button-2 border-transparent text-gray-500 hover:border-emerald-700 hover:text-emerald-700 whitespace-nowrap border-b-2 py-2 px-2 text-sm font-semibold">
                        Supervisión Semanal
                    </button>
                    <button id="tab-diaria-2"
                        class="tab-button-2 border-transparent text-gray-500 hover:border-emerald-700 hover:text-emerald-700 whitespace-nowrap border-b-2 py-2 px-2 text-sm font-semibold">
                        Supervisión Diaria
                    </button>
                </nav>
            </div>

            <!-- Contenido de pestañas -->
            <div class="p-6">
                <!-- Historial de Órdenes -->
                <div id="content-historial-2" class="tab-content-2">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium leading-6" style="color: #016f2b;">
                            Todas las órdenes del vehículo
                        </h3>
                        <form action="{{ route('ordenvehiculos.create') }}" method="GET" class="inline">
                            @csrf
                            <input type="hidden" name="back_url" value="{{ url()->current() }}">
                            <flux:button type="submit" variant="primary">CREAR ORDEN</flux:button>
                        </form>
                    </div>
                    <livewire:ordenes-table :noeconomico-exact="$vehiculo->no_economico" :show-search="false" :back-url="route('vehiculos.show', $vehiculo->id)" lazy />
                </div>

                <!-- Supervisión Semanal -->
                <div id="content-supervision-2" class="tab-content-2 hidden">
                    <div class="tab-content-wrapper">
                        @if ($supervision_existe)
                            <div class="bg-emerald-50 border border-emerald-600 text-emerald-900 px-4 py-3 rounded relative"
                                role="alert">
                                <div class="flex items-center">
                                    <flux:icon.check />
                                    <span class="block sm:inline ml-2">La supervisión ya fue realizada esta
                                        semana.</span>
                                </div>
                            </div>
                        @else
                            <x-super_sem_form :no_economico="$vehiculo->no_economico" :vehiculo_id="$vehiculo->id" />
                        @endif
                    </div>
                </div>

                <!-- Supervisión Diaria -->
                <div id="content-diaria-2" class="tab-content-2 hidden">
                    <x-super_diaria_form :no_economico="$vehiculo->no_economico" :vehiculo_id="$vehiculo->id" />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para mostrar el contenido de una pestaña en un grupo específico
            function showTab(groupNumber, tabId) {
                // Ocultar todos los contenidos del grupo específico
                document.querySelectorAll(`.tab-content-${groupNumber}`).forEach(content => {
                    content.classList.add('hidden');
                });

                // Remover clases activas de todos los botones del grupo específico
                document.querySelectorAll(`.tab-button-${groupNumber}`).forEach(button => {
                    button.classList.remove('border-emerald-500', 'text-emerald-600', 'font-semibold',
                        'hover:border-emerald-700');
                    button.classList.add('border-transparent', 'text-gray-500', 'font-normal',
                        'hover:border-gray-300');
                    button.setAttribute('aria-current', 'false');
                });

                // Mostrar el contenido seleccionado
                const selectedContent = document.getElementById(`content-${tabId}-${groupNumber}`);
                if (selectedContent) {
                    selectedContent.classList.remove('hidden');
                }

                // Activar el botón seleccionado
                const selectedButton = document.getElementById(`tab-${tabId}-${groupNumber}`);
                if (selectedButton) {
                    selectedButton.classList.remove('border-transparent', 'text-gray-500', 'font-normal',
                        'hover:border-gray-300');
                    selectedButton.classList.add('border-emerald-500', 'text-emerald-600', 'font-semibold',
                        'hover:border-emerald-700');
                    selectedButton.setAttribute('aria-current', 'page');
                }
            }

            // Grupo 1: Estado KM / Fotos
            document.querySelectorAll('.tab-button-1').forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.id.replace('tab-', '').replace('-1', '');
                    showTab(1, tabId);
                });
            });

            // Grupo 2: Historial / Supervisiones
            document.querySelectorAll('.tab-button-2').forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.id.replace('tab-', '').replace('-2', '');
                    showTab(2, tabId);
                });
            });

            // Mostrar las pestañas por defecto
            showTab(1, 'estado'); // Mostrar estado KM por defecto en el grupo 1
            showTab(2, 'historial'); // Mostrar historial por defecto en el grupo 2
        });
    </script>

    <style>
        /* Asegurar aislamiento de contenido de pestañas */
        .tab-content-wrapper {
            position: relative;
            z-index: 1;
        }

        /* Prevenir interferencia específica que pueda afectar las pestañas */
        .tab-content {
            contain: layout style;
        }
    </style>

</x-layouts.app>
