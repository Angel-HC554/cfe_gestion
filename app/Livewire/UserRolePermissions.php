<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRolePermissions extends Component
{
    public $allRoles;
    public $selectedRole;
    public $allpermisos;
    public $userpermisos;
    public $user;
    public $userAgencia;

    public function mount($user, $roles, $permisos, $userpermisos){
        $this->user = $user;
        $this->allRoles = $roles;
        $this->selectedRole = $user->cargo;
        $this->allpermisos = $permisos;
        $this->userpermisos = $userpermisos;
        $this->userAgencia = $user->agencia;
    }
    public function render()
    {
        $permissionsForRole = collect();

        if ($this->selectedRole) {
            $roleModel = Role::findByName($this->selectedRole);
        }
        if ($roleModel) {
            $permissionsForRole = $roleModel->permissions()->pluck('name');
        }
        return view('livewire.user-role-permissions',
    ['permissionsForRole' => $permissionsForRole,
    'allpermissions' => $this->allpermisos,
    'userpermissions' => $this->userpermisos,
    'user' => $this->user]);    
    }
}
