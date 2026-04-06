<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isActive()) {
            return redirect()->route('login')->with('error', 'No tiene acceso.');
        }

        if ($role === 'admin') {
            if (!$user->isAdmin()) {
                abort(403, 'Acceso denegado.');
            }
        }

        if ($role === 'guardia') {
            if (!$user->isGuardia() && !$user->isAdmin()) {
                abort(403, 'Acceso denegado.');
            }
        }

        return $next($request);
    }
}
