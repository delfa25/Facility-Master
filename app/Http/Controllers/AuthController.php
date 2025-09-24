<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm(){
        if(auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function showLoginForm(){
        if(auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Trouver l'utilisateur par email
        $user = User::findByEmail($request->email);

        if ($user && Hash::check($request->password, $user->password)) {
            // Interdire la connexion si le compte est inactif
            if (!$user->actif) {
                return back()->withErrors([
                    'email' => "Votre compte est inactif. Veuillez contacter l'administrateur.",
                ]);
            }
            $remember = $request->has('remember');
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Redirection obligatoire si le mot de passe doit être changé
            if ($user->must_change_password) {
                return redirect()->route('password.edit');
            }

            // Redirection par rôle
            switch ($user->role) {
                case 'ETUDIANT':
                    return redirect()->intended('/student/dashboard');
                case 'ENSEIGNANT':
                    return redirect()->intended('/teacher/dashboard');
                case 'ADMINISTRATEUR':
                    return redirect()->intended('/admin/dashboard');
                case 'SUPERADMIN':
                    return redirect()->intended('/superadmin/dashboard');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
