<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        foreach ($roles as $role) {
            $normalizedRoles = array_map('trim', explode('|', $role));
            foreach ($normalizedRoles as $r) {
                if ($user->hasRole($r)) {
                    return $next($request);
                }
            }
        }

        abort(403, __('messages.access_denied'));
    }
}
