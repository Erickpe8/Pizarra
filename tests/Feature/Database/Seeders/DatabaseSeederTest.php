<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

it('creates the demo user and ninety nine additional users', function () {
    $this->seed();

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
    $this->assertDatabaseCount('users', 2);
    $this->assertDatabaseHas('roles', ['name' => 'lider', 'guard_name' => 'web']);
    $this->assertDatabaseHas('roles', ['name' => 'trabajador', 'guard_name' => 'web']);
});

it('does not duplicate users when seeded again', function () {
    $this->seed();

    $this->seed();

    $this->assertDatabaseCount('users', 2);
    expect(User::query()->where('email', 'test@example.com')->count())->toBe(1);
});

it('keeps seeding roles even when demo users already exist', function () {
    $this->seed();

    Role::query()->delete();

    $this->seed();

    $this->assertDatabaseHas('roles', ['name' => 'lider']);
    $this->assertDatabaseHas('roles', ['name' => 'trabajador']);
});
