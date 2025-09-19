<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemestreController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Semestre::with('anneeAcad');
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhereHas('anneeAcad', function($sub) use ($q) {
                      $sub->where('code', 'like', "%{$q}%");
                  });
        }
        $semestres = $query->orderByDesc('date_debut')->paginate(15)->withQueryString();
        return view('admin.semestre.index', compact('semestres','q'));
    }

    public function create()
    {
        $annees = AnneeAcad::orderByDesc('date_debut')->get();
        return view('admin.semestre.create', compact('annees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('semestre','code')],
            'annee_id' => ['required','exists:annee_acad,id'],
            'date_debut' => ['required','date'],
            'date_fin' => ['required','date','after:date_debut'],
        ]);

        $semestre = Semestre::create($request->only(['code','annee_id','date_debut','date_fin']));
        return redirect()->route('semestres.show', $semestre)->with('success', 'Semestre créé.');
    }

    public function show(Semestre $semestre)
    {
        $semestre->load('anneeAcad');
        return view('admin.semestre.show', compact('semestre'));
    }

    public function edit(Semestre $semestre)
    {
        $annees = AnneeAcad::orderByDesc('date_debut')->get();
        return view('admin.semestre.edit', compact('semestre','annees'));
    }

    public function update(Request $request, Semestre $semestre)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('semestre','code')->ignore($semestre->id)],
            'annee_id' => ['required','exists:annee_acad,id'],
            'date_debut' => ['required','date'],
            'date_fin' => ['required','date','after:date_debut'],
        ]);

        $semestre->update($request->only(['code','annee_id','date_debut','date_fin']));
        return redirect()->route('semestres.show', $semestre)->with('success', 'Semestre mis à jour.');
    }

    public function destroy(Semestre $semestre)
    {
        $semestre->delete();
        return redirect()->route('semestres.index')->with('success', 'Semestre supprimé.');
    }
}
