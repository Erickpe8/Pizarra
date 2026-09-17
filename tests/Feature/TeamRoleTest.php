<?php

use App\Models\Team;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

it('leaves newly registered users without a role', function () {
    $response = $this->post('/register', [
        'name' => 'Nuevo Usuario',
        'email' => 'nuevo@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::query()->where('email', 'nuevo@example.com')->firstOrFail();

    expect($user->teams)->toBeEmpty()
        ->and($user->getRoleNames())->toBeEmpty();
});

it('shows the no-role options on the dashboard for users without a team', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('No tienes un rol')
        ->assertSee('Crear equipo')
        ->assertSee('Unirme a un equipo');
});

it('assigns the lider role when a user creates a team', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('teams.store'), [
        'name' => 'Equipo Alpha',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user->refresh();
    $team = Team::query()->where('name', 'Equipo Alpha')->firstOrFail();

    expect($user->teams)->toHaveCount(1)
        ->and(session('current_team_id'))->toBe($team->id);

    setPermissionsTeamId($team->id);

    expect($user->hasRole('lider'))->toBeTrue()
        ->and($user->hasRole('trabajador'))->toBeFalse();
});

it('assigns the trabajador role when a user joins a team', function () {
    $leader = User::factory()->create();
    $worker = User::factory()->create();
    $team = Team::factory()->create(['name' => 'Equipo Beta']);

    $leader->teams()->attach($team->id);
    setPermissionsTeamId($team->id);
    $leader->assignRole('lider');

    $response = $this->actingAs($worker)->post(route('teams.join.store'), [
        'team_id' => $team->id,
    ]);

    $response->assertRedirect(route('dashboard'));

    $worker->refresh();
    setPermissionsTeamId($team->id);

    expect($worker->teams)->toHaveCount(1)
        ->and($worker->hasRole('trabajador'))->toBeTrue()
        ->and($worker->hasRole('lider'))->toBeFalse()
        ->and(session('current_team_id'))->toBe($team->id);
});

it('allows a lider to open the team management page', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $user->teams()->attach($team->id);
    setPermissionsTeamId($team->id);
    $user->assignRole('lider');

    $this->actingAs($user)
        ->withSession(['current_team_id' => $team->id])
        ->get(route('teams.manage'))
        ->assertOk()
        ->assertSee('Gestionar equipo')
        ->assertSee($team->name);
});

it('forbids a trabajador from opening the team management page', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $user->teams()->attach($team->id);
    setPermissionsTeamId($team->id);
    $user->assignRole('trabajador');

    $this->actingAs($user)
        ->withSession(['current_team_id' => $team->id])
        ->get(route('teams.manage'))
        ->assertForbidden();
});

it('seeds only lider and trabajador roles', function () {
    expect(Role::query()->where('guard_name', 'web')->pluck('name')->sort()->values()->all())
        ->toBe(['lider', 'trabajador']);
});

it('allows a lider to create more than one team', function () {
    $user = User::factory()->create();

    $firstTeam = Team::factory()->create([
        'name' => 'Equipo Uno',
    ]);

    $user->teams()->attach($firstTeam->id);

    setPermissionsTeamId($firstTeam->id);
    $user->assignRole('lider');

    $response = $this->actingAs($user)->post(route('teams.store'), [
        'name' => 'Equipo Dos',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user->refresh();

    expect($user->teams)->toHaveCount(2)
        ->and(Team::query()->where('name', 'Equipo Uno')->exists())->toBeTrue()
        ->and(Team::query()->where('name', 'Equipo Dos')->exists())->toBeTrue();
});


it('shows all teams belonging to a lider on the management page', function () {
    $user = User::factory()->create();

    $teamOne = Team::factory()->create([
        'name' => 'Equipo Uno',
    ]);

    $teamTwo = Team::factory()->create([
        'name' => 'Equipo Dos',
    ]);

    $user->teams()->attach([
        $teamOne->id,
        $teamTwo->id,
    ]);

    setPermissionsTeamId($teamOne->id);
    $user->assignRole('lider');

    $this->actingAs($user)
        ->withSession([
            'current_team_id' => $teamOne->id,
        ])
        ->get(route('teams.manage'))
        ->assertOk()
        ->assertSee('Equipo Uno')
        ->assertSee('Equipo Dos');
});
