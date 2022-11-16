<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::findByName('admin')->givePermissionTo(Permission::all());
        $permissions[] = Permission::findByName('CRU');
        Role::findByName('user')->givePermissionTo($permissions);
    }
}
