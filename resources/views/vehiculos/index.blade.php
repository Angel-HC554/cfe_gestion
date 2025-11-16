<x-layouts.app >
    <div class="flex items-center justify-between mb-6 mx-10">
        <flux:heading size="xl">Vehiculos</flux:heading>
        <div id="flash-message-container"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
        </div>
    
        <div class="flex space-x-2">
            <livewire:vehiculo-modales lazy/>
        </div>
    </div>
    <livewire:ver-autos/>
</x-layouts.app>
