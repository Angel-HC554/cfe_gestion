<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            {{-- widget 1 --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border-2 border-emerald-600/20 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-950/50 dark:to-gray-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 h-full flex flex-col justify-around">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                <flux:icon.user variant="solid" class="text-white" size="md"/>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">¡Bienvenido de nuevo!</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ Auth::user()->cargo }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 bg-emerald-50 dark:bg-gray-800/50 rounded-md p-2">
                            <flux:icon.user variant="mini" class="mr-2 text-emerald-600"/>
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 bg-emerald-50 dark:bg-gray-800/50 rounded-md p-2">
                            <flux:icon.calendar variant="mini" class="mr-2 text-emerald-600"/>
                            <span class="font-medium">{{ date('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- widget 2 --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border-2 border-emerald-600/20 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-950/50 dark:to-gray-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                <flux:icon.chart-bar variant="solid" class="text-white" size="md"/>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Resumen de Órdenes</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Estadísticas generales</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                            <div class="flex items-center">
                                <flux:icon.document-text variant="mini" class="mr-2 text-emerald-600"/>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Total Órdenes:</span>
                            </div>
                            <span class="font-bold text-emerald-600">{{ $totalOrdenes }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                            <div class="flex items-center">
                                <flux:icon.clock variant="mini" class="mr-2 text-orange-500"/>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Pendientes:</span>
                            </div>
                            <span class="font-bold text-orange-500">{{ $ordenesPendientes }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                            <div class="flex items-center">
                                <flux:icon.check-circle variant="mini" class="mr-2 text-green-500"/>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Completadas:</span>
                            </div>
                            <span class="font-bold text-green-500">{{ $ordenesCompletadas }}</span>
                        </div>
                    </div>
            </div>
            
        </div>
       <div class="relative aspect-video overflow-hidden rounded-xl border-2 border-emerald-600/20 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-950/50 dark:to-gray-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                <flux:icon.clipboard-document-check variant="solid" class="text-white" size="md"/>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Supervisiones</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Resumen de supervisiones</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                            <div class="flex items-center">
                                <flux:icon.truck variant="mini" class="mr-2 text-emerald-600"/>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Total Vehículos:</span>
                            </div>
                            <span class="font-bold text-emerald-600">{{ $totalVehiculos }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                            <div class="flex items-center">
                                <flux:icon.check-circle variant="mini" class="mr-2 text-green-500"/>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Con Supervisión Diaria:</span>
                            </div>
                            <span class="font-bold text-green-500">{{ $vehiculosConSupervisionDiaria }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                            <div class="flex items-center">
                                <flux:icon.clock variant="mini" class="mr-2 text-blue-500"/>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Con Supervisión Semanal:</span>
                            </div>
                            <span class="font-bold text-blue-500">{{ $vehiculosConSupervisionSemanal }}</span>
                        </div>
                    </div>
                </div>
        </div>

        {{-- widget 4 --}}
<div class="relative aspect-video overflow-hidden rounded-xl border-2 border-emerald-600/20 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-950/50 dark:to-gray-900 shadow-lg hover:shadow-xl transition-shadow duration-300">
    <div class="p-6 h-full flex flex-col justify-between">
        <div>
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                    <flux:icon.wrench variant="solid" class="text-white" size="md"/> {{-- Cambia a icon.truck si no tienes wrench --}}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Mantenimientos Próximos</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Resumen de estado de vehículos</p>
                </div>
            </div>
        </div>
        <div class="mt-4 space-y-3">
            <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                <div class="flex items-center">
                    <flux:icon.exclamation-triangle variant="mini" class="mr-2 text-yellow-500"/> {{-- Ícono para amarillo --}}
                    <span class="font-medium text-gray-700 dark:text-gray-300">En Amarillo:</span>
                </div>
                <span class="font-bold text-yellow-500">{{ $conteosMantenimiento['amarillo'] }}</span>
            </div>
            <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                <div class="flex items-center">
                    <flux:icon.exclamation-circle variant="mini" class="mr-2 text-red-500"/> {{-- Ícono para rojo --}}
                    <span class="font-medium text-gray-700 dark:text-gray-300">En Rojo:</span>
                </div>
                <span class="font-bold text-red-500">{{ $conteosMantenimiento['rojo'] + $conteosMantenimiento['rojo_pasado'] }}</span> {{-- Suma rojo y vencidos --}}
            </div>
            <div class="flex items-center justify-between text-sm bg-emerald-50 dark:bg-gray-800/50 rounded-md p-3">
                <div class="flex items-center">
                    <flux:icon.truck variant="mini" class="mr-2 text-emerald-600"/>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Total Vehículos:</span>
                </div>
                <span class="font-bold text-emerald-600">{{ $totalVehiculos }}</span>
            </div>
        </div>
    </div>
</div>
    </div>
</x-layouts.app>
