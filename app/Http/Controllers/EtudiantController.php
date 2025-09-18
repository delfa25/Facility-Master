<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $etudiant->load('personne');
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
        $request->validate([
            'INE' => [
                'required','string','max:13',
                Rule::unique('etudiant', 'INE')->ignore($etudiant->id),
            ],
            'statut' => ['required', Rule::in(['INACTIF','ACTIF','SUSPENDU','DIPLOME'])],
            'date_inscription' => ['nullable','date'],
        ]);

        $etudiant->update([
            'INE' => $request->INE,
            'statut' => $request->statut,
            'date_inscription' => $request->date_inscription,
        ]);

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
