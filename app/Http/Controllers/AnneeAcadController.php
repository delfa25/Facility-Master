<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnneeAcadController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = AnneeAcad::query();
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%");
        }
        $annees = $query->orderByDesc('date_debut')->paginate(15)->withQueryString();
        return view('admin.annee.index', compact('annees','q'));
    }

    public function create()
    {
        return view('admin.annee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('annee_acad','code')],
            'date_debut' => ['required','date'],
            'date_fin' => ['required','date','after:date_debut'],
        ]);

        $annee = AnneeAcad::create($request->only(['code','date_debut','date_fin']));
        return redirect()->route('annees.show', $annee)->with('success', "Année académique créée.");
    }

    public function show(AnneeAcad $annee)
    {
        return view('admin.annee.show', compact('annee'));
    }

    public function edit(AnneeAcad $annee)
    {
        return view('admin.annee.edit', compact('annee'));
    }

    public function update(Request $request, AnneeAcad $annee)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('annee_acad','code')->ignore($annee->id)],
            'date_debut' => ['required','date'],
            'date_fin' => ['required','date','after:date_debut'],
        ]);

        $annee->update($request->only(['code','date_debut','date_fin']));
        return redirect()->route('annees.show', $annee)->with('success', "Année académique mise à jour.");
    }

    public function destroy(AnneeAcad $annee)
    {
        $annee->delete();
        return redirect()->route('annees.index')->with('success', "Année académique supprimée.");
    }
}
