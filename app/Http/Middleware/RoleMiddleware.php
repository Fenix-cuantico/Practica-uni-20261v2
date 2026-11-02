<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if ($user && $user->role === 'student') {
            if (!$request->is('mis-cursos')) {
                return redirect('/mis-cursos')->with('error', 'Acceso denegado a esta área.');
            }
        }

        if ($user && !empty($roles) && !in_array($user->role, $roles)) {
            abort(403, 'Acceso Denegado');
        }

        return $next($request);
    }
}
