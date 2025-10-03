<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex items-center justify-between mb-6">
            <flux:heading size="xl">Vehiculos</flux:heading>
            <div id="flash-message-container"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
        </div>

            <div class="flex space-x-2">
                <livewire:vehiculo-modales />
            </div>
        </div>

        {{-- Mensaje flash post-importación --}}
        @if (session('mensajeEscaneado'))
            <div id="flash-import" class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800 transition-opacity">
                {{ session('mensajeEscaneado') }}
            </div>
            <script>
                (function () {
                    const el = document.getElementById('flash-import');
                    if (!el) return;
                    setTimeout(() => {
                        el.style.transition = 'opacity 0.5s';
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 500);
                    }, 2500);
                })();
            </script>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-1">
                <thead class="text-xs text-green-950 uppercase bg-accent-content/20 dark:bg-green-900 dark:text-amber-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No. Económico</th>
                        <th scope="col" class="px-6 py-3">Placas</th>
                        <th scope="col" class="px-6 py-3">Agencia</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Marca</th>
                        <th scope="col" class="px-6 py-3">Modelo</th>
                        <th scope="col" class="px-6 py-3">Año</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Propiedad</th>
                        <th scope="col" class="px-6 py-3">Proceso</th>
                        <th scope="col" class="px-6 py-3">Alias</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehiculos as $vehiculo)
                        <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->no_economico }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->placas }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->agencia }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->tipo_vehiculo }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->marca }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->modelo }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->{'año'} }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->estado }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->propiedad }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->proceso }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $vehiculo->alias }}</td>
                        </tr>
                    @empty
                        <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                            <td class="px-6 py-4 text-center" colspan="11">
                                <flux:heading size="lg" class="inline-flex"><flux:icon.exclamation-circle class="mr-2" />No se encontraron vehículos.</flux:heading>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        @if (method_exists($vehiculos, 'links'))
            <div class="mt-4">
                {{ $vehiculos->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
