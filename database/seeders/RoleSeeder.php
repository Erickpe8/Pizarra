<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::findOrCreate('lider', 'web');
        Role::findOrCreate('trabajador', 'web');

        Role::query()
            ->where('guard_name', 'web')
            ->whereNotIn('name', ['lider', 'trabajador'])
            ->delete();
    }
}
