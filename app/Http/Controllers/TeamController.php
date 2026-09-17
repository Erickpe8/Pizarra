<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);

        $team = Team::create([
            'name' => $validated['name'],
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
        if ($this->userAlreadyHasTeam()) {
            return redirect()->route('dashboard');
        }

        $teams = Team::query()->orderBy('name')->get();

        return view('join', compact('teams'));
    }

    public function storeJoin(Request $request): RedirectResponse
    {
        if ($this->userAlreadyHasTeam()) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
        ]);

        $user = Auth::user();
        $team = Team::query()->findOrFail($validated['team_id']);

        $user->teams()->syncWithoutDetaching([$team->id]);

        $this->ensureRolesExist();

        setPermissionsTeamId($team->id);

        $user->assignRole('trabajador');

        $request->session()->put('current_team_id', $team->id);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Te has unido al equipo correctamente. Ahora eres trabajador.');
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
    private function userAlreadyHasTeam(): bool
    {
        return Auth::user()->teams()->exists();
    }

    private function ensureRolesExist(): void
    {
        Role::findOrCreate('lider', 'web');
        Role::findOrCreate('trabajador', 'web');
    }
}