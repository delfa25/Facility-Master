<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Personne;
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
            $remember = $request->has('remember');
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Redirection obligatoire si le mot de passe doit être changé
            if ($user->must_change_password) {
                return redirect()->route('password.change.form');
            }

            return redirect()->intended('/dashboard');
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
