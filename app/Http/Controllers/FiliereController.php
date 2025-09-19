<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FiliereController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Filiere::query();
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('nom', 'like', "%{$q}%");
        }
        $filieres = $query->orderBy('code')->paginate(15)->withQueryString();
        return view('admin.filiere.index', compact('filieres','q'));
    }

    public function create()
    {
        return view('admin.filiere.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('filiere','code')],
            'nom'  => ['required','string','max:255'],
        ]);

        $filiere = Filiere::create($request->only(['code','nom']));
        return redirect()->route('filieres.show', $filiere)->with('success', 'Filière créée.');
    }

    public function show(Filiere $filiere)
    {
        return view('admin.filiere.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        return view('admin.filiere.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('filiere','code')->ignore($filiere->id)],
            'nom'  => ['required','string','max:255'],
        ]);

        $filiere->update($request->only(['code','nom']));
        return redirect()->route('filieres.show', $filiere)->with('success', 'Filière mise à jour.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return redirect()->route('filieres.index')->with('success', 'Filière supprimée.');
    }
}
