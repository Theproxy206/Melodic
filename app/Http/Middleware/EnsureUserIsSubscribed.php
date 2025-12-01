<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario NO está suscrito y NO es admin/artista/label
        // (Asumimos que artistas y labels tienen acceso gratis o diferente lógica,
        // si no, quita esa parte del if)
        $user = auth()->user();

        if ($user && !$user->is_suscribed && $user->role === 'user') {
            // Lo redirigimos a la página de planes
            return redirect()->route('subscription.index');
        }

        return $next($request);
    }
}
