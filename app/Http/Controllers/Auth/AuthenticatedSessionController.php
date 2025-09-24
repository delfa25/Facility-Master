<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Prioritize Spatie roles, then fallback to column value
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('SUPERADMIN')) {
                return redirect()->route('superadmin.dashboard');
            }
            if ($user->hasRole('ADMINISTRATEUR')) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('ENSEIGNANT')) {
                return redirect()->route('teacher.dashboard');
            }
            if ($user->hasRole('ETUDIANT')) {
                return redirect()->route('student.dashboard');
            }
        }

        // Fallback using users.role column
        switch ($user->role) {
            case 'SUPERADMIN':
                return redirect()->route('superadmin.dashboard');
            case 'ADMINISTRATEUR':
                return redirect()->route('admin.dashboard');
            case 'ENSEIGNANT':
                return redirect()->route('teacher.dashboard');
            case 'ETUDIANT':
                return redirect()->route('student.dashboard');
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
