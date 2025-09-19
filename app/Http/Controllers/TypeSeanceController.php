<?php

namespace App\Http\Controllers;

use App\Models\TypeSeance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeSeanceController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = TypeSeance::query();
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('libelle', 'like', "%{$q}%");
        }
        $types = $query->orderBy('code')->paginate(15)->withQueryString();
        return view('admin.typeseance.index', compact('types','q'));
    }

    public function create()
    {
        return view('admin.typeseance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('type_seance','code')],
            'libelle'  => ['required','string','max:255'],
        ]);

        $ts = TypeSeance::create($request->only(['code','libelle']));
        return redirect()->route('typeseances.show', $ts)->with('success', 'Type de séance créé.');
    }

    public function show(TypeSeance $typeseance)
    {
        return view('admin.typeseance.show', compact('typeseance'));
    }

    public function edit(TypeSeance $typeseance)
    {
        return view('admin.typeseance.edit', compact('typeseance'));
    }

    public function update(Request $request, TypeSeance $typeseance)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('type_seance','code')->ignore($typeseance->id)],
            'libelle'  => ['required','string','max:255'],
        ]);

        $typeseance->update($request->only(['code','libelle']));
        return redirect()->route('typeseances.show', $typeseance)->with('success', 'Type de séance mis à jour.');
    }

    public function destroy(TypeSeance $typeseance)
    {
        $typeseance->delete();
        return redirect()->route('typeseances.index')->with('success', 'Type de séance supprimé.');
    }
}
