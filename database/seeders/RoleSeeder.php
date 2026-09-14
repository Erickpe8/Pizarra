<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'lider',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'trabajador',
            'guard_name' => 'web',
        ]);
    }
}