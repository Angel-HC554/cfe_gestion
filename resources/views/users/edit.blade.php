<x-layouts.app>
    <div class="flex items-center justify-between mb-6 mx-10">
        <flux:heading size="xl" class="flex items-center gap-2">
            Editar usuario
        </flux:heading>
        <div id="flash-message-container"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
        </div>
        <flux:button variant="primary" icon="chevron-left" href="{{ route('users.index') }}">Volver</flux:button>
    </div>

    {{-- formulario para editar usuario --}}
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="mx-10 bg-white p-6 rounded-lg shadow-sm">
        @csrf
        @method('PUT')

       

        <livewire:user-role-permissions :roles="$roles" :user="$user" :permisos="$permisos" :userpermisos="$userPermisos" />


        <div class="mt-6 flex justify-center">
            <flux:button variant="primary" class="w-" type="submit">Actualizar datos del usuario</flux:button>
        </div>
    </form>
</x-layouts.app>
