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
     *
     * @return void
     */
    public function run()
    {
        //Crear Roles
        
        $administrador = Role::create(['name' => 'Administrador']);
        $contador = Role::create(['name' => 'Contador']);
        $supervisor = Role::create(['name' => 'Supervisor']);

        //Crear permisos

        Permission::create(['name' => 'home.users.index'])->syncRoles([$administrador]);
        Permission::create(['name' => 'home.users.create'])->syncRoles([$administrador]);
        Permission::create(['name' => 'home.users.edit'])->syncRoles([$administrador]);
        Permission::create(['name' => 'home.users.destroy'])->syncRoles([$administrador]);

        Permission::create(['name' => 'home.crews.index'])->syncRoles([$administrador]);
        Permission::create(['name' => 'home.crews.edit'])->syncRoles([$administrador]);

        Permission::create(['name' => 'home.accounts.index'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.accounts.create'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.accounts.edit'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.accounts.destroy'])->syncRoles([$contador]);

        Permission::create(['name' => 'informe.index'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.consolidations'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.contracts.index'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.contracts.create'])->syncRoles([$contador]);
        Permission::create(['name' => 'home.dailyReport'])->syncRoles([$supervisor]);

    }
}
