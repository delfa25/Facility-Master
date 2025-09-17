<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Personne;
use App\Models\User;
use Illuminate\Validation\Rule;

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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('personne', 'email')->whereNull('deleted_at'),
            ],
            'phone' => 'required|string|max:30',
            'role' => 'required|in:ADMINISTRATEUR,ENSEIGNANT,ETUDIANT,INVITE',
        ]);

        // Créer d'abord la personne
        $personne = Personne::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'email' => $request->email,
            'phone' => $request->phone,
            // Rôle désormais stocké sur personne
            'role' => $request->role ?? 'INVITE',
        ]);

        // Puis créer l'utilisateur lié à cette personne
        $user = User::create([
            'password' => Hash::make('facilitypass'),
            'personne_id' => $personne->id,
            'actif' => true,
            'must_change_password' => true,
        ]);
        
        try {
            Mail::to($user->personne->email)->send(new WelcomeMail($user));
            $message = 'Inscription réussie ! Un e-mail de bienvenue a été envoyé.';
        } catch (\Throwable $e) {
            \Log::warning('Mail send failed (welcome mail)', [
                'to' => $user->personne->email,
                'error' => $e->getMessage(),
            ]);
            $message = "Inscription réussie, mais l'envoi de l'e-mail a échoué (configuration SMTP).";
        }

        return back()->with('success', $message);
    }

    public function updatePersonneForm($id){

    }

    public function destroy(Personne $personne)
    {
        // Soft delete linked user first (if exists)
        if ($personne->user) {
            $personne->user->delete();
        }

        $personne->delete();
        return back()->with('success', 'Personne supprimée (corbeille).');
    }

    // --- Admin CRUD ---
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $role = $request->get('role');

        $query = Personne::query();

        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        if ($role && in_array($role, ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT','INVITE'], true)) {
            $query->where('role', $role);
        }

        $personnes = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $roles = ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT','INVITE'];

        return view('admin.personne.index', compact('personnes','q','role','roles'));
    }

    public function show(Personne $personne)
    {
        $personne->load('user');
        return view('admin.personne.show', compact('personne'));
    }

    public function edit(Personne $personne)
    {
        $roles = ['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT','INVITE'];
        return view('admin.personne.edit', compact('personne','roles'));
    }

    public function update(Request $request, Personne $personne)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'date_naissance' => 'required|date|before:today',
            'lieu_naissance' => 'required|string|max:100',
            'email' => [
                'required','email','max:255',
                Rule::unique('personne', 'email')->ignore($personne->id)->whereNull('deleted_at'),
            ],
            'phone' => 'required|string|max:30',
            'role' => ['required', Rule::in(['ADMINISTRATEUR','ENSEIGNANT','ETUDIANT','INVITE'])],
        ]);

        $personne->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('personnes.show', $personne)->with('success', 'Personne mise à jour.');
    }
}