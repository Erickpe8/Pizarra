<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    // Mostrar formulario para crear equipo
    public function create()
    {
        return view('create');
    }

    // Crear equipo
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $team = Team::create([
            'name' => $request->name,
        ]);

        $user = Auth::user();

        $user->teams()->attach($team->id);

        setPermissionsTeamId($team->id);

        $user->assignRole('líder');

        return redirect()
            ->route('dashboard')
            ->with('success', 'Equipo creado correctamente.');
    }

    // Mostrar equipos disponibles
    public function join()
    {
        $teams = Team::all();

        return view('   join', compact('teams'));
    }

    // Unirse a un equipo
    public function storeJoin(Request $request)
    {
        $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
        ]);

        $user = Auth::user();

        $team = Team::findOrFail($request->team_id);

        $user->teams()->syncWithoutDetaching([
            $team->id
        ]);

        setPermissionsTeamId($team->id);

        $user->assignRole('trabajador');

        return redirect()
            ->route('dashboard')
            ->with('success', 'Te has unido al equipo correctamente.');
    }
}