<x-layouts.app :title="__('Dashboard')">
        <div class="flex justify-between items-center mx-10">
        <flux:heading size="xl">Crear orden de servicio y reparacion</flux:heading>
        <div class="flex">
            <flux:icon.document-text class="mr-2" />
            <flux:heading size="lg">Orden No: {{ $id }}</flux:heading>
        </div>
        <flux:button variant="primary" color="emerald" icon="chevron-left" href="{{ route('ordenvehiculos.index') }}">Volver
        </flux:button>
    </div>
    <livewire:orden-vehiculos-create/>

</x-layouts.app>
