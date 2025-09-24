<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InscriptionController extends Controller
{
    // Listing filtrable des inscriptions (reporting)
    public function index(Request $request)
    {
        $etudiantId = $request->get('etudiant_id');
        $classeId = $request->get('classe_id');
        $anneeId = $request->get('annee_id');
        $q = trim((string) $request->get('q', ''));

        $query = Inscription::with(['etudiant','classe','anneeAcad']);

        if ($etudiantId) {
            $query->where('etudiant_id', $etudiantId);
        }
        if ($classeId) {
            $query->where('classe_id', $classeId);
        }
        if ($anneeId) {
            $query->where('annee_id', $anneeId);
        }
        if ($q !== '') {
            $query->whereHas('etudiant', function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%");
            })->orWhereHas('etudiant.user', function($sub) use ($q) {
                $sub->where('email', 'like', "%{$q}%");
            })->orWhereHas('classe', function($sub) use ($q) {
                $sub->where('libelle', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            })->orWhereHas('anneeAcad', function($sub) use ($q) {
                $sub->where('annee', 'like', "%{$q}%");
            });
        }

        $inscriptions = $query->orderByDesc('date_inscription')->paginate(15)->withQueryString();

        $classes = Classe::orderBy('libelle')->get();
        $annees = AnneeAcad::orderByDesc('annee')->get();

        return view('admin.inscription.index', compact('inscriptions','classes','annees','etudiantId','classeId','anneeId','q'));
    }
    // Afficher le formulaire d'inscription pour un étudiant
    public function create(Request $request)
    {
        $etudiantId = (int) $request->get('etudiant');
        $etudiant = Etudiant::findOrFail($etudiantId);

        if ($etudiant->statut === 'DIPLOME') {
            return redirect()->route('etudiants.show', $etudiant)
                ->with('error', "Impossible d'inscrire un étudiant diplômé.");
        }

        $classes = Classe::orderBy('libelle')->get();
        $annees = AnneeAcad::orderByDesc('annee')->get();

        return view('admin.inscription.create', compact('etudiant','classes','annees'));
    }

    // Enregistrer une inscription
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => ['required','exists:etudiant,id'],
            'classe_id' => ['required','exists:classe,id'],
            'annee_id' => ['required','exists:annee_acad,id'],
            'date_inscription' => ['nullable','date'],
        ]);

        DB::transaction(function () use ($request) {
            $etudiant = Etudiant::lockForUpdate()->findOrFail($request->etudiant_id);

            if ($etudiant->statut === 'DIPLOME') {
                abort(422, "Cet étudiant est diplômé et ne peut pas être inscrit.");
            }

            // Unicité logique: un étudiant ne peut avoir qu'une inscription par année
            $exists = Inscription::where('etudiant_id', $etudiant->id)
                ->where('annee_id', $request->annee_id)
                ->exists();
            if ($exists) {
                abort(422, 'Cet étudiant est déjà inscrit pour cette année académique.');
            }

            Inscription::create([
                'etudiant_id' => $etudiant->id,
                'classe_id' => $request->classe_id,
                'annee_id' => $request->annee_id,
                'date_inscription' => $request->date_inscription ?: now()->toDateString(),
            ]);

            // Mettre à jour le statut de l'étudiant et sa date d'inscription globale
            if ($etudiant->statut !== 'ACTIF') {
                $etudiant->statut = 'ACTIF';
            }
            if (!$etudiant->date_inscription) {
                $etudiant->date_inscription = now()->toDateString();
            }
            $etudiant->save();
        });

        return redirect()->route('etudiants.index')->with('success', "Inscription enregistrée avec succès.");
    }
}
