<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAnimalDataEntryAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $animal = $request->route('animal');

        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($user->isDataEntry() && $animal && $animal->independent_team_id === $user->independent_team_id) {
            return $next($request);
        }

        abort(403, __('messages.access_denied'));
    }
}
