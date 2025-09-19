<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $statut = $request->get('statut');

        $query = Etudiant::with('personne');
        if ($q !== '') {
            $query->whereHas('personne', function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })->orWhere('INE', 'like', "%{$q}%");
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
        $etudiant->load(['personne','inscriptions.classe','inscriptions.anneeAcad']);
        return view('admin.etudiant.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $etudiant->load('personne');
        $statuts = ['INACTIF','ACTIF','SUSPENDU','DIPLOME'];
        return view('admin.etudiant.edit', compact('etudiant','statuts'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        // Validate both Etudiant and linked Personne fields
        $request->validate([
            // Personne
            'nom' => ['required','string','max:100'],
            'prenom' => ['required','string','max:100'],
            'date_naissance' => ['required','date','before:today'],
            'lieu_naissance' => ['required','string','max:100'],
            'email' => [
                'required','email','max:255',
                Rule::unique('personne', 'email')->ignore($etudiant->personne->id ?? null),
            ],
            'phone' => ['required','string','max:30'],
            // Etudiant
            'INE' => [
                'required','string','max:13',
                Rule::unique('etudiant', 'INE')->ignore($etudiant->id),
            ],
            'statut' => ['required', Rule::in(['INACTIF','ACTIF','SUSPENDU','DIPLOME'])],
            'date_inscription' => ['nullable','date'],
        ]);

        DB::transaction(function () use ($request, $etudiant) {
            // Update linked Personne
            if ($etudiant->personne) {
                $etudiant->personne->update([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_naissance' => $request->date_naissance,
                    'lieu_naissance' => $request->lieu_naissance,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
            }

            // Update Etudiant
            $etudiant->update([
                'INE' => $request->INE,
                'statut' => $request->statut,
                'date_inscription' => $request->date_inscription,
            ]);
        });

        return redirect()->route('etudiants.show', $etudiant)->with('success', 'Étudiant et personne mis à jour.');
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
