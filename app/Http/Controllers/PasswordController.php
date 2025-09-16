<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = \App\Models\User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->must_change_password = false; // on désactive le flag
        $user->save();

        return redirect('/dashboard')->with('success', 'Mot de passe modifié avec succès.');
    }
}

