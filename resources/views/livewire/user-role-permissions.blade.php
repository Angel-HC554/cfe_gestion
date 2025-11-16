<div>
    {{-- Datos del usuario (nombre, etc.) --}}
    <div class="grid grid-cols-2 gap-4">
        <flux:input label="Nombre:" name="name" value="{{ $user->name }}" />
        <flux:select label="Agencia:" name="agencia" wire:model="userAgencia">
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

    </div>
    <div class="grid grid-cols-3 gap-4 mt-4">
        {{-- SECCIÓN 1: ROL --}}
        <div class="col-span-1">
            <flux:radio.group label="Rol:" wire:model.live="selectedRole">
                @foreach ($allRoles as $role)
                    <flux:radio label="{{ $role->name }}" value="{{ $role->name }}" />
                @endforeach
            </flux:radio.group>
            <input type="hidden" name="rol" value="{{ $selectedRole }}">
        </div>

        {{-- SECCIÓN 2: PERMISOS DIRECTOS --}}
        <div>
            <h3 class="font-bold">Permisos </h3>
            <p class="text-sm text-gray-600">
                Permisos extra que este usuario tendrá, además de los de su cargo.
            </p>

            <div class="mt-2 space-y-2">
                @foreach ($allpermissions as $permiso)
                    @php
                        $isRolePermission = $permissionsForRole->contains($permiso);
                        $isDirectPermission = $userpermissions->contains($permiso) && $user->cargo == $selectedRole;
                    @endphp

                    <div class="flex items-center">
                        <input type="checkbox" id="perm-{{ $loop->index }}" name="permissions[]"
                            value="{{ $permiso }}" {{ $isRolePermission ? 'checked disabled' : '' }}
                            {{ $isDirectPermission ? 'checked' : '' }}
                            class="h-4 w-4 text-primary-600 accent-accent border-gray-300 rounded ">
                        <label for="perm-{{ $loop->index }}"
                            class="ml-2 text-sm text-gray-700 {{ $isRolePermission ? 'opacity-50' : '' }}">
                            {{ $permiso }}
                        </label>
                        @if ($isRolePermission)
                            <input type="hidden" name="permissions[]" value="{{ $permiso }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
