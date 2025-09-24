<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Personne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // Récupérer les utilisateurs avec leurs relations
        $users = User::with(['etudiant','enseignant','personne'])->paginate(15);

        $roles = ['ETUDIANT','ENSEIGNANT','ADMINISTRATEUR'];
        return view('admin.user.index', compact('users','roles'));
    }

    public function create()
    {
        $roles = ['ETUDIANT','ENSEIGNANT','ADMINISTRATEUR'];
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', Rule::in(['ETUDIANT','ENSEIGNANT','ADMINISTRATEUR'])],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:6'],
            'nom' => ['required','string','max:100'],
            'prenom' => ['required','string','max:100'],
            'phone' => ['nullable','string','max:30'],
            'date_naissance' => ['nullable','date','before:today'],
            'lieu_naissance' => ['nullable','string','max:100'],
            'adresse' => ['nullable','string','max:255'],
            // spécifiques
            'INE' => ['nullable','string','max:13','unique:etudiant,INE'],
            'date_inscription' => ['nullable','date'],
            'statut_etudiant' => ['nullable', Rule::in(['INACTIF','ACTIF','SUSPENDU','DIPLOME'])],
            'grade' => ['nullable','string','max:50'],
            'specialite' => ['nullable','string','max:100'],
            'statut_enseignant' => ['nullable', Rule::in(['INACTIF','SUSPENDU','ACTIF'])],
            'bureau' => ['nullable','string','max:100'],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'phone' => $request->phone,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'adresse' => $request->adresse,
            'actif' => true,
            'must_change_password' => true,
        ]);

        if (method_exists($user, 'syncRoles')) {
            $user->syncRoles([$request->role]);
        }

        switch ($request->role) {
            case 'ETUDIANT':
                Etudiant::create([
                    'user_id' => $user->id,
                    'INE' => $request->INE,
                    'date_inscription' => $request->date_inscription,
                    'statut' => $request->statut_etudiant ?: 'INACTIF',
                ]);
                break;
            case 'ENSEIGNANT':
                Enseignant::create([
                    'user_id' => $user->id,
                    'grade' => $request->grade,
                    'specialite' => $request->specialite,
                    'statut' => $request->statut_enseignant ?: 'INACTIF',
                ]);
                break;
            case 'ADMINISTRATEUR':
                Personne::create([
                    'user_id' => $user->id,
                    'bureau' => $request->bureau,
                ]);
                break;
        }

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur créé avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé (corbeille).');
    }

    public function show(User $user)
    {
        $user->load(['etudiant','enseignant']);
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load(['etudiant','enseignant','personne']);
        $roles = ['ETUDIANT','ENSEIGNANT','ADMINISTRATEUR'];
        return view('admin.user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', Rule::in(['ETUDIANT','ENSEIGNANT','ADMINISTRATEUR'])],
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','min:6'],
            'nom' => ['required','string','max:100'],
            'prenom' => ['required','string','max:100'],
            'phone' => ['nullable','string','max:30'],
            'date_naissance' => ['nullable','date','before:today'],
            'lieu_naissance' => ['nullable','string','max:100'],
            'adresse' => ['nullable','string','max:255'],
            // spécifiques
            'INE' => ['nullable','string','max:13', Rule::unique('etudiant','INE')->ignore(optional($user->etudiant)->id)],
            'date_inscription' => ['nullable','date'],
            'statut_etudiant' => ['nullable', Rule::in(['INACTIF','ACTIF','SUSPENDU','DIPLOME'])],
            'grade' => ['nullable','string','max:50'],
            'specialite' => ['nullable','string','max:100'],
            'statut_enseignant' => ['nullable', Rule::in(['INACTIF','SUSPENDU','ACTIF'])],
            'bureau' => ['nullable','string','max:100'],
        ]);

        $user->fill([
            'email' => $request->email,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'phone' => $request->phone,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'adresse' => $request->adresse,
            'role' => $request->role,
            'actif' => (bool) $request->boolean('actif', $user->actif),
            'must_change_password' => (bool) $request->boolean('must_change_password', $user->must_change_password),
        ]);
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->must_change_password = true;
        }
        $user->save();

        if (method_exists($user, 'syncRoles')) {
            $user->syncRoles([$request->role]);
        }

        switch ($request->role) {
            case 'ETUDIANT':
                $et = $user->etudiant ?: new Etudiant(['user_id' => $user->id]);
                $et->fill([
                    'INE' => $request->INE,
                    'date_inscription' => $request->date_inscription,
                    'statut' => $request->statut_etudiant ?: $et->statut,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_naissance' => $request->date_naissance,
                    'lieu_naissance' => $request->lieu_naissance,
                    'phone' => $request->phone,
                ]);
                $et->user_id = $user->id;
                $et->save();
                break;
            case 'ENSEIGNANT':
                $ens = $user->enseignant ?: new Enseignant(['user_id' => $user->id]);
                $ens->fill([
                    'grade' => $request->grade,
                    'specialite' => $request->specialite,
                    'statut' => $request->statut_enseignant ?: $ens->statut,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_naissance' => $request->date_naissance,
                    'lieu_naissance' => $request->lieu_naissance,
                    'phone' => $request->phone,
                ]);
                $ens->user_id = $user->id;
                $ens->save();
                break;
            case 'ADMINISTRATEUR':
                $pers = $user->personne ?: new Personne(['user_id' => $user->id]);
                $pers->fill(['bureau' => $request->bureau]);
                $pers->user_id = $user->id;
                $pers->save();
                break;
        }

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function activate(User $user)
    {
        if ($user->actif) {
            return back()->with('success', 'Le compte est déjà actif.');
        }

        $user->actif = true;
        $user->save();

        $msg = 'Compte activé.';

        return back()->with('success', $msg);
    }

}
