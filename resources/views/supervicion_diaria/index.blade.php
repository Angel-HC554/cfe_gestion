<x-layouts.app>
    <div class="flex h-full flex-1 flex-col gap-4 mx-10">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Supervisiónes Diarias</flux:heading>
            <h3 class="font-semibold">Mostrando: {{ strtoupper($nombreMes) }}</h3>
        </div>
    <form method="GET" action="{{ route('supervicion_diaria.index') }}" class="filtros-panel">
    
    <div class="flex flex-row w-auto justify-around border-1 shadow-sm items-center bg-white rounded-md border-t-3 border-t-emerald-700/40 p-3">
        <div class="flex items-center">
        <flux:heading size="lg" class="mr-2">Agencia:</flux:heading>
        <select name="agencia" class="w-64 h-8 border border-gray-300 bg-gray-50 rounded-md p-1 text-gray-500 focus:ring-emerald-600 focus:border-2 focus:border-emerald-600">
        <option value="">Todas las Agencias</option>
        @foreach($agencias as $agencia)
            <option value="{{ $agencia }}" {{ ($filtrosActuales['agencia'] ?? '') == $agencia ? 'selected' : '' }}>
                {{ $agencia }}
            </option>
        @endforeach
    </select>
        </div>
        <div class="flex items-center">
        <flux:heading size="lg" class="mr-2">Cumplimiento:</flux:heading>
    <select name="cumplimiento" class="w-64 h-8 border border-gray-300 bg-gray-50 rounded-md p-1 text-gray-500 focus:ring-emerald-600 focus:border-2 focus:border-emerald-600">
        <option value="todos">Mostrar Todos</option>
        <option value="no_cumple" {{ ($filtrosActuales['cumplimiento'] ?? '') == 'no_cumple' ? 'selected' : '' }}>
            Mostrar Solo Incumplidos
        </option>
    </select>
    </div>
    <flux:button type="submit" class="w-20">Filtrar</flux:button>
    </div>
    
</form>

<div id="loader-tabla" class="flex justify-center items-center" style="min-height: 300px;">
    @include('placeholders.progressbars') 
</div>
    <hr>
<div id="contenido-tabla"style="display:none;" class="tabla-scrollable"> <table class="tabla-matriz">
        <thead>
            <tr>
                <th>Agencia</th>
                <th>Vehículo</th>
                @foreach($diasDelMes as $dia)
                    <th>{{ $dia }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($vehiculos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->agencia }}</td>
                    <td>{{ $vehiculo->no_economico }}</td>
                    
                    @foreach($vehiculo->status_dias as $status)
                        <td>
                            @if($status == 'cumplido')
                                <span class="icono-cumplido"><flux:icon.check-circle/></span> @elseif($status == 'no_cumplido')
                                <span class="icono-no-cumplido"><flux:icon.x-mark/></span> @elseif($status == 'futuro')
                                <span class="icono-futuro">-</span> @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($diasDelMes) + 2 }}">No hay vehículos que coincidan con los filtros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<style>
    .tabla-scrollable { 
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
        max-width: 100%;
        margin: 0 auto;
        -webkit-overflow-scrolling: touch;
    }
    .tabla-matriz {
        border-collapse: collapse;
        width: 100%;
        table-layout: auto;
    }
    .tabla-matriz th, 
    .tabla-matriz td {
        border: 1px solid #ddd; 
        padding: 8px; 
        text-align: center;
        white-space: nowrap;
    }
    .tabla-matriz th {
        background-color: #f4f4f4; 
        position: sticky;
        top: 0;
    }
    .tabla-matriz td:nth-child(2),
    .tabla-matriz th:nth-child(2) {
        position: sticky;
        left: 0;
        background-color: #fff;
        z-index: 1;
    }
    .tabla-matriz th:nth-child(2) {
        z-index: 2;
    }
    .icono-cumplido { color: green; }
    .icono-no-cumplido { color: red; }
    .icono-futuro { color: #ccc; }
</style>
</div> 
    <script>
    // Espera a que la ventana completa (CSS, imágenes, etc.) esté cargada
    window.onload = function() {
        
        // 1. Busca el loader
        const loader = document.getElementById('loader-tabla');
        
        // 2. Busca el contenido (la tabla)
        const contenido = document.getElementById('contenido-tabla');

        // 3. Oculta el loader
        if (loader) {
            loader.style.display = 'none';
        }

        // 4. Muestra el contenido de la tabla (ya estilizado)
        if (contenido) {
            contenido.style.display = 'block'; // 'block' lo hace visible
        }
    };
</script>

</div>
</x-layouts.app>