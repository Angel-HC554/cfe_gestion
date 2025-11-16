<x-layouts.app :title="__('Verificación Vehicular')">
    <div class="min-h-screen bg-gray-50">
        <!-- Bloque 1: Encabezado de Información (Cero Interacción) -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-md mx-auto p-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border">
                    <div class="text-center space-y-2">
                        <h1 class="text-lg font-semibold text-gray-900">Verificación Vehicular</h1>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Conductor:</span> Juan Pérez García</p>
                            <p><span class="font-medium">Vehículo:</span> Toyota Hilux 2023 - ABC123</p>
                            <p><span class="font-medium">Fecha:</span> {{ date('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <flux:input type="time" placeholder="Search orders" />

</x-layouts.app>