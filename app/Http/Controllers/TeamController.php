<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
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

        $this->setTeamContext($team->id, $user);

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

        $this->setTeamContext($team->id, $user);

        $user->assignRole('trabajador');

        $request->session()->put('current_team_id', $team->id);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Te has unido al equipo correctamente. Ahora eres trabajador.'
            );
    }

    public function select(Request $request, Team $team): RedirectResponse
    {
        $user = Auth::user();

        // Verificar que el usuario pertenece al equipo.
        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        // Establecer el equipo actual para Spatie.
        $this->setTeamContext($team->id, $user);

        // Guardar el equipo seleccionado en la sesión.
        $request->session()->put('current_team_id', $team->id);

        return redirect()
            ->route('teams.workspace', $team)
            ->with(
                'success',
                "Ahora estás trabajando en el equipo «{$team->name}»."
            );
    }

    public function workspace(Team $team): View
    {
        $user = Auth::user();

        // El usuario debe pertenecer al equipo.
        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        // Establecer el contexto del equipo.
        $this->setTeamContext($team->id, $user);

        // Obtener las tareas de este equipo.
        $tasks = $team->tasks()
            ->with([
                'creator',
                'assignee',
            ])
            ->latest()
            ->get();

        return view('teams.workspace', [
            'team' => $team,
            'tasks' => $tasks,
        ]);
    }

    public function manage(): View
    {
        $user = Auth::user();

        $teams = $user->teams()
            ->with('users')
            ->orderBy('name')
            ->get();

        $leaderTeamIds = [];
        $memberRoles = [];

        foreach ($teams as $team) {

            $this->setTeamContext($team->id, $user);

            if ($user->hasRole('lider')) {
                $leaderTeamIds[] = $team->id;
            }

            foreach ($team->users as $member) {

                $this->setTeamContext($team->id, $member);

                $memberRoles[$team->id][$member->id] =
                    $member->getRoleNames()->first() ?? null;
            }
        }

        $currentTeamId = session('current_team_id');

        if ($currentTeamId && $teams->contains('id', $currentTeamId)) {
            $this->setTeamContext($currentTeamId, $user);
        } elseif ($teams->isNotEmpty()) {
            $this->setTeamContext($teams->first()->id, $user);
        }

        return view('teams.manage', [
            'teams' => $teams,
            'leaderTeamIds' => $leaderTeamIds,
            'memberRoles' => $memberRoles,
        ]);
    }

    public function edit(Team $team): View
    {
        $user = Auth::user();

        $this->setTeamContext($team->id, $user);

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

        $this->setTeamContext($team->id, $user);

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

        $this->setTeamContext($team->id, $user);

        if (!$user->hasRole('lider')) {
            abort(403);
        }

        $team->users()->detach();

        $team->delete();

        if (session('current_team_id') === $team->id) {
            session()->forget('current_team_id');
        }

        return redirect()
            ->route('teams.manage')
            ->with('success', 'Equipo eliminado correctamente.');
    }

    public function removeMember(Team $team, int $user): RedirectResponse
    {
        $leader = Auth::user();

        $this->setTeamContext($team->id, $leader);

        if (!$leader->hasRole('lider')) {
            abort(403);
        }

        if ($leader->id === $user) {
            return back()->withErrors([
                'member' => 'No puedes eliminarte a ti mismo del equipo.',
            ]);
        }

        $member = $team->users()
            ->where('users.id', $user)
            ->first();

        if (!$member) {
            return back()->withErrors([
                'member' => 'El usuario no pertenece a este equipo.',
            ]);
        }

        $team->users()->detach($member->id);

        $this->setTeamContext($team->id, $member);

        $member->syncRoles([]);

        return redirect()
            ->route('teams.manage')
            ->with(
                'success',
                'El integrante fue eliminado del equipo correctamente.'
            );
    }

    public function changeMemberRole(
        Request $request,
        Team $team,
        User $member
    ): RedirectResponse {
        $user = Auth::user();

        $this->setTeamContext($team->id, $user);

        if (!$user->hasRole('lider')) {
            abort(403);
        }

        if ($member->id === $user->id) {
            return redirect()
                ->route('teams.manage')
                ->withErrors([
                    'member' => 'No puedes cambiar tu propio rol.',
                ]);
        }

        $validated = $request->validate([
            'role' => ['required', 'in:lider,trabajador'],
        ]);

        $newRole = $validated['role'];

        $memberInTeam = $team->users()
            ->whereKey($member->id)
            ->first();

        if (!$memberInTeam) {
            return redirect()
                ->route('teams.manage')
                ->withErrors([
                    'member' => 'El usuario seleccionado no pertenece a este equipo.',
                ]);
        }

        $member = $memberInTeam;

        $this->setTeamContext($team->id, $member);

        $currentRole = $member->getRoleNames()->first();

        if ($currentRole === $newRole) {
            return redirect()
                ->route('teams.manage')
                ->with('success', 'El integrante ya tiene ese rol.');
        }

        if (
            $currentRole === 'lider' &&
            $newRole === 'trabajador'
        ) {
            $teamMembers = $team->users()->get();

            $leaderCount = 0;

            foreach ($teamMembers as $teamMember) {

                $this->setTeamContext($team->id, $teamMember);

                if ($teamMember->hasRole('lider')) {
                    $leaderCount++;
                }
            }

            if ($leaderCount <= 1) {
                return redirect()
                    ->route('teams.manage')
                    ->withErrors([
                        'member' =>
                            'No puedes quitar el rol de líder al único líder del equipo.',
                    ]);
            }
        }

        $this->ensureRolesExist();

        $this->setTeamContext($team->id, $member);

        $member->syncRoles([
            $newRole,
        ]);

        $member->unsetRelation('roles');
        $member->unsetRelation('permissions');

        /*
        * Limpiar la caché de permisos.
        */
        app(\Spatie\Permission\PermissionRegistrar::class)
            ->forgetCachedPermissions();

        return redirect()
            ->route('teams.manage')
            ->with(
                'success',
                'El rol del integrante se actualizó correctamente.'
            );
    }
    private function setTeamContext(int|string $teamId, User $user): void
    {
        setPermissionsTeamId($teamId);

        $user->unsetRelation('roles');
        $user->unsetRelation('permissions');
    }

    private function ensureRolesExist(): void
    {
        Role::findOrCreate('lider', 'web');
        Role::findOrCreate('trabajador', 'web');
    }
}