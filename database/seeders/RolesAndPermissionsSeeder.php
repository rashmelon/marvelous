<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'users',
        ]);

        $collection->each(function ($item, $key) {
            Permission::create(['group' => $item, 'name' => 'view ' . $item]);
            Permission::create(['group' => $item, 'name' => 'view own ' . $item]);
            Permission::create(['group' => $item, 'name' => 'manage ' . $item]);
            Permission::create(['group' => $item, 'name' => 'manage own ' . $item]);
            Permission::create(['group' => $item, 'name' => 'update ' . $item]);
            Permission::create(['group' => $item, 'name' => 'create ' . $item]);
            Permission::create(['group' => $item, 'name' => 'delete ' . $item]);
            Permission::create(['group' => $item, 'name' => 'restore ' . $item]);
            Permission::create(['group' => $item, 'name' => 'forceDelete ' . $item]);
        });

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'author']);

        $user = User::whereEmail('mahmoud@birdsol.com')->first();
        $user->assignRole('super-admin');
    }
}
