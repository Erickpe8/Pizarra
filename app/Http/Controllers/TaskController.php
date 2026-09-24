<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(Team $team): View
    {
        $user = Auth::user();

        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        setPermissionsTeamId($team->id);

        $user->unsetRelation('roles');
        $user->unsetRelation('permissions');

        if (!$user->hasRole('lider')) {
            abort(403);
        }

        $members = $team->users()
            ->orderBy('name')
            ->get();

        return view('tasks.create', [
            'team' => $team,
            'members' => $members,
        ]);
    }

    public function store(Request $request, Team $team): RedirectResponse
    {
        $user = Auth::user();

        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        setPermissionsTeamId($team->id);

        $user->unsetRelation('roles');
        $user->unsetRelation('permissions');

        if (!$user->hasRole('lider')) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:por hacer,en progreso,terminada',
            ],

            'assigned_to' => [
                'nullable',
                'integer',
            ],

            'assigned_at' => [
                'nullable',
                'date',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'estimated_time' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        if (!empty($validated['assigned_to'])) {

            $memberBelongsToTeam = $team->users()
                ->whereKey($validated['assigned_to'])
                ->exists();

            if (!$memberBelongsToTeam) {
                return back()
                    ->withErrors([
                        'assigned_to' =>
                            'El usuario seleccionado no pertenece a este equipo.',
                    ])
                    ->withInput();
            }
        }

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'team_id' => $team->id,
            'created_by' => $user->id,
            'assigned_to' => $validated['assigned_to'] ?? null,
            'assigned_at' => $validated['assigned_at'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'estimated_time' => $validated['estimated_time'] ?? null,
        ]);

        return redirect()
            ->route('teams.workspace', $team)
            ->with(
                'success',
                'La tarea se creó correctamente.'
            );
    }
    

    public function show(Team $team, Task $task): View
    {
        $user = Auth::user();

        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        if ($task->team_id !== $team->id) {
            abort(404);
        }

        $task->load([
            'creator',
            'assignee',
        ]);

        return view('tasks.show', [
            'team' => $team,
            'task' => $task,
        ]);
    }
    public function edit(Team $team, Task $task): View
    {
        $user = Auth::user();

        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        if ($task->team_id !== $team->id) {
            abort(404);
        }

        setPermissionsTeamId($team->id);

        $user->unsetRelation('roles');
        $user->unsetRelation('permissions');

        if (!$user->hasRole('lider')) {
            abort(403);
        }

        $members = $team->users()
            ->orderBy('name')
            ->get();

        return view('tasks.edit', [
            'team' => $team,
            'task' => $task,
            'members' => $members,
        ]);
    }
    public function update(
        Request $request,
        Team $team,
        Task $task
    ): RedirectResponse {
        $user = Auth::user();

        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        // Verificar que la tarea pertenece al equipo.
        if ($task->team_id !== $team->id) {
            abort(404);
        }

        setPermissionsTeamId($team->id);

        $user->unsetRelation('roles');
        $user->unsetRelation('permissions');

        if (!$user->hasRole('lider')) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:por hacer,en progreso,terminada',
            ],

            'assigned_to' => [
                'nullable',
                'integer',
            ],

            'assigned_at' => [
                'nullable',
                'date',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'estimated_time' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        if (!empty($validated['assigned_to'])) {

            $memberBelongsToTeam = $team->users()
                ->whereKey($validated['assigned_to'])
                ->exists();

            if (!$memberBelongsToTeam) {
                return back()
                    ->withErrors([
                        'assigned_to' =>
                            'El usuario seleccionado no pertenece a este equipo.',
                    ])
                    ->withInput();
            }
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'assigned_to' => $validated['assigned_to'] ?? null,
            'assigned_at' => $validated['assigned_at'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'estimated_time' => $validated['estimated_time'] ?? null,
        ]);

        return redirect()
            ->route('tasks.show', [$team, $task])
            ->with(
                'success',
                'La tarea se actualizó correctamente.'
            );
    }
}