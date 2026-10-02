<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    /**
     * Permite continuar la petición únicamente si el usuario tiene el rol de administrador.
     * En caso contrario, cierra e invalida la sesión y redirige al acceso con un error.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()?->rola?->rola_izena !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'emaila' => 'Administratzaileek bakarrik dute sartzeko baimena.',
            ]);
        }

        return $next($request);
    }
}
