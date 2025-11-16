<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Crea una cuenta')" :description="__('Ingresa los datos para crear una cuenta')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Nombre -->
        <flux:input
            wire:model="name"
            :label="__('Nombre')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Nombre completo')"
        />

        <!-- Usuario -->
        <flux:input
            wire:model="usuario"
            :label="__('Usuario')"
            type="text"
            required
            autocomplete="usuario"
            :placeholder="__('Usuario')"
        />

        <!-- Agencia -->
        <flux:select
            wire:model="agencia"
            :label="__('Agencia')"
            required
            :placeholder="__('Agencia')"
        >
        <flux:select.option class="text-zinc-600 font-semibold">ACANCEH</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">CENTRO</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">CONKAL</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">HUNUCMA</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">NORTE</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">ORIENTE</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">PONIENTE</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">PROGRESO</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">SUR</flux:select.option>
        <flux:select.option class="text-zinc-600 font-semibold">UMAN</flux:select.option>
        </flux:select>

        <!-- Cargo -->
        <flux:select
            wire:model="cargo"
            :label="__('Cargo')"
            required
            :placeholder="__('Cargo (Permisos)')"
        >
            <flux:select.option value="supervisor" class="text-zinc-600 font-semibold">Supervisor</flux:select.option>
            <flux:select.option value="oficinista" class="text-zinc-600 font-semibold">Oficinista</flux:select.option>
            <flux:select.option value="secretaria" class="text-zinc-600 font-semibold">Secretaria</flux:select.option>
            <flux:select.option value="jefe_area" class="text-zinc-600 font-semibold">Jefe de area</flux:select.option>
            <flux:select.option value="otro" class="text-zinc-600 font-semibold">otro</flux:select.option>
            <flux:select.option value="admin" class="text-zinc-600 font-semibold">Admin Sistema</flux:select.option>
        </flux:select>

        <!-- Contraseña -->
        <flux:input
            wire:model="password"
            :label="__('Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Contraseña')"
            viewable
        />

        <!-- Confirmar contraseña -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmar contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmar contraseña')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Crear cuenta') }}
            </flux:button>
        </div>
    </form>

    {{-- 
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        <span>{{ __('¿Ya tienes una cuenta?') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('Inicia sesión') }}</flux:link>
    </div>
    --}}
    
</div>
