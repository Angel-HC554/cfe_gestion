<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;
use SweetAlert2\Laravel\Traits\WithSweetAlert;
use Spatie\Permission\Models\Role;

class Register extends Component
{
    use WithSweetAlert;
    public string $name = '';

    public string $usuario = '';

    public string $agencia = '';

    public string $cargo = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'usuario' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'agencia' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'usuario' => $this->usuario,
            'agencia' => $this->agencia,
            'cargo' => $this->cargo,
            'password' => Hash::make($this->password),
        ]);

        // Asignar el rol al usuario
        $user->assignRole($this->cargo);
        
        // Obtener el rol y sus permisos
        $role = Role::findByName($this->cargo);
        
        // Sincronizar los permisos del rol con el usuario
        $user->syncPermissions($role->permissions);

        // Emitir evento para cerrar el modal desde Alpine.js
        $this->dispatch('user-created');

        // Emitir evento global para refrescar la lista de usuarios
        $this->dispatch('refresh-users-list');

        $this->swalFire([
            'title' => 'Usuario creado exitosamente',
            'text' => 'El usuario se ha creado correctamente',
            'icon' => 'success',
            'showConfirmButton' => false,
            'timer' => 1500
        ]);
    }
}
