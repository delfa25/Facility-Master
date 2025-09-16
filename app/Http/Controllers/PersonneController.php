<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne;
use App\Models\User;

class PersonneController extends Controller
{
    public function showPersonneForm(){
        return view('admin.personne.create');
    }

    public function personne(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom'=> 'required|string|max:255',
            'date_naissance' => 'required|date|before:today',
            'lieu_naissance' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:personne,email',
            'phone' => 'required|string|max:30',
        ]);

        // Créer d'abord la personne
        $personne = Personne::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Puis créer l'utilisateur lié à cette personne
        $user = User::create([
            'password' => Hash::make('facilitypass'),
            'role' => 'INVITE',
            'personne_id' => $personne->id,
            'actif' => true,
            'must_change_password' => true,
        ]);


        return back()->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }
}