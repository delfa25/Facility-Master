<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Support\IdGenerator;

class EtudiantController extends Controller
{
    public function create()
    {
        $statuts = ['INACTIF','ACTIF','SUSPENDU','DIPLOME'];
        return view('admin.etudiant.create', compact('statuts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required','string','max:100'],
            'prenom' => ['required','string','max:100'],
            'date_naissance' => ['required','date','before:today'],
            'lieu_naissance' => ['required','string','max:100'],
            'email' => ['required','email','max:255','unique:users,email'],
            'phone' => ['required','string','max:30'],
            'INE' => ['nullable','string','max:13','unique:etudiant,INE'],
        ]);

        $etudiant = DB::transaction(function() use ($request) {
            // Create inactive user with role ETUDIANT
            $user = User::create([
                'email' => $request->email,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'phone' => $request->phone,
                'password' => Hash::make('facilitypass'),
                'role' => 'ETUDIANT',
                'actif' => false,
                'must_change_password' => true,
            ]);

            // Create student profile (only academic fields)
            $ine = $request->INE ?: (method_exists(IdGenerator::class, 'generateINE') ? IdGenerator::generateINE() : null);
            return Etudiant::create([
                'INE' => $ine,
                'user_id' => $user->id,
                'date_inscription' => null,
                'statut' => 'INACTIF',
            ]);
        });

        return redirect()->route('etudiants.show', $etudiant)->with('success', 'Étudiant créé. Le compte utilisateur est en attente d\'activation.');
    }
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $statut = $request->get('statut');

        $query = Etudiant::query();
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('INE', 'like', "%{$q}%");
            });
        }
        if ($statut && in_array($statut, ['INACTIF','ACTIF','SUSPENDU','DIPLOME'], true)) {
            $query->where('statut', $statut);
        }
        $etudiants = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $statuts = ['INACTIF','ACTIF','SUSPENDU','DIPLOME'];
        // Quick counts
        $counts = [
            'total' => Etudiant::count(),
            'INACTIF' => Etudiant::where('statut','INACTIF')->count(),
            'ACTIF' => Etudiant::where('statut','ACTIF')->count(),
            'SUSPENDU' => Etudiant::where('statut','SUSPENDU')->count(),
            'diplome' => Etudiant::where('statut','DIPLOME')->count(),
        ];
        return view('admin.etudiant.index', compact('etudiants','q','statut','statuts','counts'));
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load(['inscriptions.classe','inscriptions.anneeAcad']);
        return view('admin.etudiant.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $statuts = ['INACTIF','ACTIF','SUSPENDU','DIPLOME'];
        return view('admin.etudiant.edit', compact('etudiant','statuts'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        // Validate Etudiant fields
        $request->validate([
            'nom' => ['required','string','max:100'],
            'prenom' => ['required','string','max:100'],
            'date_naissance' => ['required','date','before:today'],
            'lieu_naissance' => ['required','string','max:100'],
            'email' => [
                'required','email','max:255',
                Rule::unique('etudiant', 'email')->ignore($etudiant->id),
            ],
            'phone' => ['required','string','max:30'],
            'INE' => [
                'required','string','max:13',
                Rule::unique('etudiant', 'INE')->ignore($etudiant->id),
            ],
            'statut' => ['required', Rule::in(['INACTIF','ACTIF','SUSPENDU','DIPLOME'])],
            'date_inscription' => ['nullable','date'],
        ]);

        DB::transaction(function () use ($request, $etudiant) {
            // Update Etudiant
            $etudiant->update([
                'INE' => $request->INE,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'email' => $request->email,
                'phone' => $request->phone,
                'statut' => $request->statut,
                'date_inscription' => $request->date_inscription,
            ]);
        });

        return redirect()->route('etudiants.show', $etudiant)->with('success', 'Étudiant mis à jour.');
    }

    public function inscrire(Etudiant $etudiant)
    {
        // Only set to ACTIF if currently INACTIF
        if ($etudiant->statut !== 'ACTIF') {
            $etudiant->statut = 'ACTIF';
            $etudiant->date_inscription = now();
            $etudiant->save();
        }
        return back()->with('success', "L'étudiant a été inscrit (statut ACTIF).");
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé.');
    }
}
