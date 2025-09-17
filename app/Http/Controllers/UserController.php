<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        // Récupérer les utilisateurs avec leurs relations
        $users = User::with('personne')
                    ->get();

        return view('admin.user.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé (corbeille).');
    }

    public function show(User $user)
    {
        $user->load('personne');
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('personne');
        $roles = ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT','INVITE'];
        return view('admin.user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->load('personne');

        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'date_naissance' => 'required|date|before:today',
            'lieu_naissance' => 'required|string|max:100',
            'email' => [
                'required','email','max:255',
                Rule::unique('personne', 'email')->ignore($user->personne->id ?? null)->whereNull('deleted_at'),
            ],
            'phone' => 'required|string|max:30',
            'role' => ['required', Rule::in(['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT','INVITE'])],
            'actif' => 'nullable|boolean',
            'must_change_password' => 'nullable|boolean',
        ]);

        // Update personne
        if ($user->personne) {
            $user->personne->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);
        }

        // Update user flags
        $user->update([
            'actif' => (bool) $request->boolean('actif'),
            'must_change_password' => (bool) $request->boolean('must_change_password'),
        ]);

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur mis à jour avec succès.');
    }

}
