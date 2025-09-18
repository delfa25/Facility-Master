<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Personne;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;
use Illuminate\Validation\Rule;

class PersonneController extends Controller
{
    public function showPersonneForm(){
        return view('admin.personne.create');
    }

// Helpers
private static function generateIne(): string
{
    // Générer un code 13 chars: YY + rand(11 chiffres)
    $yy = now()->format('y');
    $rand = str_pad((string)random_int(0, 99999999999), 11, '0', STR_PAD_LEFT);
    return $yy . $rand;
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
                Rule::unique('personne', 'email'),
            ],
            'phone' => 'required|string|max:30',
            'role' => 'required|in:ADMINISTRATEUR,ENSEIGNANT,ETUDIANT,INVITE',
        ]);

        $message = null;

        DB::transaction(function () use ($request, &$message) {
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

            // Créer l'utilisateur lié (inactif par défaut, pas d'e-mail maintenant)
            $user = User::create([
                'password' => Hash::make('facilitypass'),
                'personne_id' => $personne->id,
                'actif' => false,
                'must_change_password' => true,
            ]);

            // Création spécifique au rôle
            switch ($personne->role) {
                case 'ETUDIANT':
                    // Générer un INE unique de 13 caractères (simple exemple)
                    $ine = self::generateIne();
                    // Créer Etudiant avec statut INACTIF et date_inscription NULL (selon nouvelle migration)
                    Etudiant::create([
                        'INE' => $ine,
                        'personne_id' => $personne->id,
                        'date_inscription' => null,
                        'statut' => 'INACTIF',
                    ]);
                    break;
                case 'ENSEIGNANT':
                    // Champs minimaux uniquement
                    Enseignant::create([
                        'personne_id' => $personne->id,
                        'grade' => null,
                        'specialite' => null,
                        'statut' => 'INACTIF',
                    ]);
                    break;
                default:
                    // Aucun enregistrement spécifique
                    break;
            }

            $message = "Inscription réussie. Le compte est en attente d'activation par un administrateur.";
        });

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
                Rule::unique('personne', 'email')->ignore($personne->id),
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