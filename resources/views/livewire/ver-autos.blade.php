<div>
    <div class="flex flex-row  mx-70 justify-between border-1 shadow-sm items-center bg-white rounded-md border-t-3 border-t-emerald-700/40 p-3">
        <flux:input icon="magnifying-glass" placeholder="Buscar por no. económico" class="w-72 sm:w-96" wire:model.live="search" />
        <div class="flex flex-col text-gray-700 font-medium">
            Estado
            <select type="date" id=""
                class="w-64 h-8 border border-gray-300 bg-gray-50 rounded-md p-1 text-gray-500 focus:ring-emerald-600 focus:border-emerald-600"
                wire:model.live="estado"> 
                <option value="">Todos</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado }}">{{ $estado }} </option>
                @endforeach
            </select>
        </div>
        <flux:button wire:click="resetFilters" variant="filled" >Borrar filtros</flux:button>
    </div>
    {{-- Mensaje flash post-importación --}}
    @if (session('mensajeEscaneado'))
        <div id="flash-import"
            class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-green-800 transition-opacity">
            {{ session('mensajeEscaneado') }}
        </div>
        <script>
            (function() {
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

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 auto-rows-fr gap-8 px-10 mt-10">

        @forelse ($vehiculos as $vehiculo)
            <a href="{{ route('vehiculos.show', $vehiculo->id) }}"
                class="flex flex-col h-full bg-white rounded-xl shadow-md border border-zinc-300 shadow-zinc-300 hover:shadow-gray-600 cursor-pointer transition-all duration-150 hover:translate-y-2">
                <div class="w-full h-48 overflow-hidden">
                    <img src="https://http2.mlstatic.com/D_NQ_NP_785948-MLM92803177440_092025-O-chevrolet-silverado-54-2500-cab-reg-ls-4x4-at.webp"
                        alt="vehiculo cfe" class="w-full h-full object-cover rounded-t-xl">
                </div>

                <div class="flex-1 p-4 bg-gradient-to-t from-emerald-600 to-emerald-900 rounded-b-xl text-white">
                    <div class="flex justify-between">
                        <h2 class="font-bold text-lg text-white">{{ $vehiculo->marca }}. {{ $vehiculo->modelo }}</h2>
                        <p class="text-sm">Año: {{ $vehiculo->año }}</p>
                    </div>
                    <p class=" text-md font-semibold text-white">No económico: {{ $vehiculo->no_economico }}</p>
                    <p class="text-sm text-white">{{ $vehiculo->estado }}</p>
                    <div class="text-sm flex justify-between text-white">
                        <p>Tipo: {{ $vehiculo->tipo_vehiculo }}</p>
                        <p>{{ $vehiculo->placas }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-4 px-10">
                <div class="rounded-md border border-zinc-200 bg-white p-6 text-zinc-600">No hay vehículos para mostrar.
                </div>
            </div>
        @endforelse
    </div>
    <div class="m-10 font-semibold">
        {{ $vehiculos->links() }}
    </div>
</div>

