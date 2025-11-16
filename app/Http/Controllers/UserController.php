<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use SweetAlert2\Laravel\Swal;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id','name','usuario','agencia','cargo')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permisos = Permission::all()->pluck('name');
        $userRol = $user->getRoleNames()->pluck('name');
        $userPermisos = $user->getDirectPermissions()->pluck('name');
        
        return view('users.edit', compact('user', 'roles', 'permisos', 'userRol', 'userPermisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rol' => 'required|string',
            'agencia' => 'required|string',
            'permissions' => 'nullable|array'
        ]);

        $user->update([
            'name' => $request->name,
            'cargo' => $request->rol,
            'agencia' => $request->agencia,
            // ... otros campos
        ]);

        $user->syncRoles($request->rol);
        $user->syncPermissions($request->permissions ?? []);

        Swal::fire([
            'position' => "top-center",
            'icon' => "success",
            'title' => "Actualizado correctamente.",
            'showConfirmButton' => false,
            'timer' => 1400
        ]);
        return redirect()->route('users.edit', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
