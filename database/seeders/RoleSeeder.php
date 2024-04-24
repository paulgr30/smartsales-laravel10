<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Vendedor']);
        $role3 = Role::create(['name' => 'Cajero']);
        $role4 = Role::create(['name' => 'Despachador']);
        $role5 = Role::create(['name' => 'Cliente']);

        Permission::create(['name' => 'categories.bycriteria', 'description' => 'Ver listado de categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.store', 'description' => 'Crear categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.update', 'description' => 'Actualizar categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.toggle.status', 'description' => 'Cambiar estado de categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.destroy', 'description' => 'Eliminar categorias'])->syncRoles([$role1]);
    }
}
