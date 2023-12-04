<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $roles = ['administrator'];

        $permissions = (Permission::all())->pluck('name');

        foreach ($roles as $role) {

            /**
             * @var $newRole Role
             */
            $newRole = Role::create([
                'guard_name' => 'admin',
                'name' => $role
            ]);

            $newRole->syncPermissions($permissions);
        }
    }
}
