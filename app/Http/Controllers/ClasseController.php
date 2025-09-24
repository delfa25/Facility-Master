<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use App\Models\Classe;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClasseController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Classe::with(['filiere','niveau','salle','anneeAcad','responsableEnseignant']);
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('nom', 'like', "%{$q}%")
                  ->orWhereHas('filiere', function($sub) use ($q){ $sub->where('nom','like',"%{$q}%"); })
                  ->orWhereHas('niveau', function($sub) use ($q){ $sub->where('code','like',"%{$q}%"); });
        }
        $classes = $query->orderBy('code')->paginate(15)->withQueryString();
        return view('admin.classe.index', compact('classes','q'));
    }

    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();
        $niveaux = Niveau::ordered()->get();
        $salles  = Salle::orderBy('code')->get();
        $annees  = AnneeAcad::orderByDesc('date_debut')->get();
        $enseignants = Enseignant::orderBy('id','desc')->get();
        return view('admin.classe.create', compact('filieres','niveaux','salles','annees','enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('classe','code')],
            'nom'  => ['required','string','max:255'],
            'filiere_id' => ['required','exists:filiere,id'],
            'niveau_id'  => ['required','exists:niveau,id'],
            'salle_id'   => ['nullable','exists:salle,id'],
            'annee_id'   => ['nullable','exists:annee_acad,id'],
            'responsable_enseignant_id' => ['nullable','exists:enseignant,id'],
        ]);

        $classe = Classe::create($request->only(['code','nom','filiere_id','niveau_id','salle_id','annee_id','responsable_enseignant_id']));
        return redirect()->route('classes.show', $classe)->with('success', 'Classe créée.');
    }

    public function show(Classe $classe)
    {
        $classe->load(['filiere','niveau','salle','anneeAcad','responsableEnseignant']);
        return view('admin.classe.show', compact('classe'));
    }

    public function edit(Classe $classe)
    {
        $classe->load(['filiere','niveau','salle','anneeAcad','responsableEnseignant']);
        $filieres = Filiere::orderBy('nom')->get();
        $niveaux = Niveau::ordered()->get();
        $salles  = Salle::orderBy('code')->get();
        $annees  = AnneeAcad::orderByDesc('date_debut')->get();
        $enseignants = Enseignant::orderBy('id','desc')->get();
        return view('admin.classe.edit', compact('classe','filieres','niveaux','salles','annees','enseignants'));
    }

    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('classe','code')->ignore($classe->id)],
            'nom'  => ['required','string','max:255'],
            'filiere_id' => ['required','exists:filiere,id'],
            'niveau_id'  => ['required','exists:niveau,id'],
            'salle_id'   => ['nullable','exists:salle,id'],
            'annee_id'   => ['nullable','exists:annee_acad,id'],
            'responsable_enseignant_id' => ['nullable','exists:enseignant,id'],
        ]);

        $classe->update($request->only(['code','nom','filiere_id','niveau_id','salle_id','annee_id','responsable_enseignant_id']));
        return redirect()->route('classes.show', $classe)->with('success', 'Classe mise à jour.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée.');
    }
}
