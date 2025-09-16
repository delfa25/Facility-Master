<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MustChangePassword
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (bool) Auth::user()->must_change_password) {
            // Autoriser l'accès aux routes de changement de mot de passe et au logout pour éviter les boucles
            if (! $request->routeIs('password.change.*') && ! $request->routeIs('logout')) {
                return redirect()->route('password.change.form');
            }
        }

        return $next($request);
    }
}