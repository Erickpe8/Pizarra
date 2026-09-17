<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPermissionsTeamFromSession
{
    /**
     * Restore the Spatie team context from the session on each request.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return $next($request);
        }

        $teamId = $request->session()->get('current_team_id');

        if ($teamId === null || ! $user->teams()->where('teams.id', $teamId)->exists()) {
            $teamId = $user->teams()->value('teams.id');

            if ($teamId !== null) {
                $request->session()->put('current_team_id', $teamId);
            } else {
                $request->session()->forget('current_team_id');
            }
        }

        if ($teamId !== null) {
            setPermissionsTeamId($teamId);
        }

        return $next($request);
    }
}
