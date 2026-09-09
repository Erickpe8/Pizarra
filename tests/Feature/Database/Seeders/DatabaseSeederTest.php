<?php

use App\Models\User;

it('creates the demo user and ninety nine additional users', function () {
    $this->seed();

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
    $this->assertDatabaseCount('users', 100);
});

it('does not duplicate users when seeded again', function () {
    $this->seed();

    $this->seed();

    $this->assertDatabaseCount('users', 100);
    expect(User::query()->where('email', 'test@example.com')->count())->toBe(1);
});
