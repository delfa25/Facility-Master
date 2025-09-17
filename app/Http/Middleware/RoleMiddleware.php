<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware('role:ADMINISTRATEUR') or multiple roles: 'role:ADMINISTRATEUR,ENSEIGNANT'
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            // If not authenticated, redirect to login (or return 403 JSON for API)
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Non authentifié'], 401);
            }
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // When no role specified, allow pass-through (or you can choose to deny)
        if (empty($roles)) {
            return $next($request);
        }

        // User model exposes accessor getRoleAttribute() reading personne->role
        $userRole = $user->role;

        if ($userRole === null || !in_array($userRole, $roles, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Accès refusé: rôle requis.'], 403);
            }
            // Redirect to dashboard with an error flash message
            return redirect()->route('dashboard')->with('error', 'Accès refusé: rôle requis.');
        }

        return $next($request);
    }
}
