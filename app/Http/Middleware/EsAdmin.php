<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdmin
{
    // corre antes del controlador: si el usuario no es admin, la request se corta acá
    public function handle(Request $request, Closure $next): Response
    {
        // si no hay usuario, ?-> devuelve null en vez de romper, y null cuenta como falso
        abort_unless($request->user()?->is_admin, 403, 'Solo los administradores pueden entrar acá.');

        // es admin: la request sigue su camino hacia el controlador
        return $next($request);
    }
}
