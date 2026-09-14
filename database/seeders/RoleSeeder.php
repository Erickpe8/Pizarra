<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'líder',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'trabajador',
            'guard_name' => 'web',
        ]);
    }
}