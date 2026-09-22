<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();
        if ($user->teams()->exists() && !$user->hasRole('lider')) {
            return redirect()->route('dashboard');
        }

        return view('create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->teams()->exists() && !$user->hasRole('lider')) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->teams()->syncWithoutDetaching([$team->id]);

        $this->ensureRolesExist();

        setPermissionsTeamId($team->id);

        $user->assignRole('lider');

        $request->session()->put('current_team_id', $team->id);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Equipo creado correctamente. Ahora eres líder.');
    }

    public function join(): View|RedirectResponse
    {
    $user = Auth::user();
    if ($user->teams()->exists() && !$user->hasRole('trabajador')) {
        return redirect()->route('dashboard');
    }

    return view('join');
    }

    public function storeJoin(Request $request): RedirectResponse
    {
    $user = Auth::user();

    if ($user->teams()->exists() && !$user->hasRole('trabajador')) {
        return redirect()->route('dashboard');
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'password' => ['required', 'string'],
    ]);

    $team = Team::query()
        ->where('name', $validated['name'])
        ->first();

    if (!$team) {
        return back()
            ->withErrors([
                'name' => 'No existe un equipo con ese nombre.',
            ])
            ->withInput($request->only('name'));
    }

    if (
        !$team->password ||
        !Hash::check($validated['password'], $team->password)
    ) {
        return back()
            ->withErrors([
                'password' => 'La contraseña del equipo es incorrecta.',
            ])
            ->withInput($request->only('name'));
    }

    if ($user->teams()->where('teams.id', $team->id)->exists()) {
        return back()
            ->withErrors([
                'name' => 'Ya perteneces a este equipo.',
            ])
            ->withInput($request->only('name'));
    }

    $user->teams()->syncWithoutDetaching([$team->id]);

    $this->ensureRolesExist();

    setPermissionsTeamId($team->id);

    $user->assignRole('trabajador');

    $request->session()->put('current_team_id', $team->id);

    return redirect()
        ->route('dashboard')
        ->with(
            'success',
            'Te has unido al equipo correctamente. Ahora eres trabajador.'
        );
    }


    public function edit(Team $team): View
    {
    $user = Auth::user();

    setPermissionsTeamId($team->id);

    if (!$user->hasRole('lider')) {
        abort(403);
    }

    return view('teams.edit', [
        'team' => $team,
    ]);
    }


    public function update(Request $request, Team $team): RedirectResponse
    {
    $user = Auth::user();

    setPermissionsTeamId($team->id);

    if (!$user->hasRole('lider')) {
        abort(403);
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    $team->update([
        'name' => $validated['name'],
    ]);

    return redirect()
        ->route('teams.manage')
        ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Team $team): RedirectResponse
    {
    $user = Auth::user();

    setPermissionsTeamId($team->id);

    if (!$user->hasRole('lider')) {
        abort(403);
    }

    $team->users()->detach();

    $team->delete();

    session()->forget('current_team_id');

    return redirect()
        ->route('teams.manage')
        ->with('success', 'Equipo eliminado correctamente.');
    }

    public function myTeams(): View
    {
    $user = Auth::user();

    $teams = $user->teams()
        ->orderBy('name')
        ->get();

    return view('teams.my-teams', [
        'teams' => $teams,
    ]);
    }

    public function manage(): View
    {
    $user = Auth::user();

    $teams = $user->teams()
        ->with('users')
        ->orderBy('name')
        ->get();

    return view('teams.manage', [
        'teams' => $teams,
    ]);
    }

    private function ensureRolesExist(): void
    {
        Role::findOrCreate('lider', 'web');
        Role::findOrCreate('trabajador', 'web');
    }
}