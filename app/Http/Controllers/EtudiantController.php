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
        if ($statut && in_array($statut, ['INACTIF','Actif','Suspendu','Diplome'], true)) {
            $query->where('statut', $statut);
        }
        $etudiants = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $statuts = ['INACTIF','Actif','Suspendu','Diplome'];
        // Quick counts
        $counts = [
            'total' => Etudiant::count(),
            'inactif' => Etudiant::where('statut','INACTIF')->count(),
            'actif' => Etudiant::where('statut','Actif')->count(),
            'suspendu' => Etudiant::where('statut','Suspendu')->count(),
            'diplome' => Etudiant::where('statut','Diplome')->count(),
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
        $statuts = ['INACTIF','Actif','Suspendu','Diplome'];
        return view('admin.etudiant.edit', compact('etudiant','statuts'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'INE' => [
                'required','string','max:13',
                Rule::unique('etudiant', 'INE')->ignore($etudiant->id),
            ],
            'statut' => ['required', Rule::in(['INACTIF','Actif','Suspendu','Diplome'])],
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
        // Only set to Actif if currently INACTIF
        if ($etudiant->statut !== 'Actif') {
            $etudiant->statut = 'Actif';
            $etudiant->date_inscription = now();
            $etudiant->save();
        }
        return back()->with('success', "L'étudiant a été inscrit (statut Actif).");
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé.');
    }
}
