<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Guardar un comentario en una tarea.
     */
    public function store(
        Request $request,
        Team $team,
        Task $task
    ): RedirectResponse {
        $user = Auth::user();

        /*
         * Verificar que el usuario pertenezca al equipo.
         */
        if (!$user->teams()->where('teams.id', $team->id)->exists()) {
            abort(403);
        }

        /*
         * Verificar que la tarea pertenezca al equipo.
         */
        if ($task->team_id !== $team->id) {
            abort(404);
        }

        /*
         * Validar el comentario.
         */
        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        /*
         * Crear el comentario.
         */
        Comment::create([
            'content' => $validated['content'],
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        /*
         * Volver al detalle de la tarea.
         */
        return redirect()
            ->route('tasks.show', [$team, $task])
            ->with(
                'success',
                'El comentario se agregó correctamente.'
            );
    }
}