<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin = Role::create(['name' => 'admin']); //todo
       $jefe_area = Role::create(['name' => 'jefe_area']); //todo
       $supervisor = Role::create(['name' => 'supervisor']); //editar y crear
       $oficinista = Role::create(['name' => 'oficinista']); //crear
       $secretaria = Role::create(['name' => 'secretaria']);
       $agente_comercial = Role::create(['name' => 'agente_comercial']);
       $otro = Role::create(['name' => 'otro']);

       // Permisos para Vehículos - CRUD básico
       Permission::create(['name' => 'vehiculos.index'])->syncRoles(['admin','jefe_area','supervisor']) ;
       Permission::create(['name' => 'vehiculos.show'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'vehiculos.create'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'vehiculos.edit'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'vehiculos.delete'])->syncRoles(['admin','jefe_area','supervisor']);

       // Permisos para Vehículos - Funciones especiales
       Permission::create(['name' => 'vehiculos.import'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'vehiculos.export'])->syncRoles(['admin','jefe_area','supervisor']);

       // Permisos para Órdenes - CRUD básico
       Permission::create(['name' => 'ordenes.index'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.create'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.edit'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.delete'])->syncRoles(['admin','jefe_area','supervisor']);

       // Permisos para Órdenes - Funciones especiales
       Permission::create(['name' => 'ordenes.generar'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.pdf'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.descargar_entrada'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.descargar_salida'])->syncRoles(['admin','jefe_area','supervisor']);
       Permission::create(['name' => 'ordenes.historial'])->syncRoles(['admin','jefe_area','supervisor']);


    }
}
