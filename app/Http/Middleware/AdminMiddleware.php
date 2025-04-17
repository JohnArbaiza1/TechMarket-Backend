<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Asegurarse de que esté autenticado y tenga rol admin
        $user = $request->user();

        if (!$user || (!$user->hasRole('admin') && !$user->hasRole('editor'))) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
