<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user(); // Usa el usuario autenticado

        if (!$user || $user->role !== 'administrador') {
            return response()->json(['error' => 'Acceso denegado. Solo administradores.'], 403);
        }

        return $next($request);
    }
}
