<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NiveauController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Niveau::query();
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('libelle', 'like', "%{$q}%");
        }
        $niveaux = $query->orderBy('ordre')->paginate(15)->withQueryString();
        return view('admin.niveau.index', compact('niveaux','q'));
    }

    public function create()
    {
        return view('admin.niveau.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('niveau','code')],
            'libelle'  => ['required','string','max:255'],
            'ordre' => ['nullable','integer','min:0'],
        ]);

        $niveau = Niveau::create([
            'code' => $request->code,
            'libelle' => $request->libelle,
            'ordre' => $request->ordre ?? 0,
        ]);
        return redirect()->route('niveaux.show', $niveau)->with('success', 'Niveau créé.');
    }

    public function show(Niveau $niveau)
    {
        return view('admin.niveau.show', compact('niveau'));
    }

    public function edit(Niveau $niveau)
    {
        return view('admin.niveau.edit', compact('niveau'));
    }

    public function update(Request $request, Niveau $niveau)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('niveau','code')->ignore($niveau->id)],
            'libelle'  => ['required','string','max:255'],
            'ordre' => ['nullable','integer','min:0'],
        ]);

        $niveau->update([
            'code' => $request->code,
            'libelle' => $request->libelle,
            'ordre' => $request->ordre ?? 0,
        ]);
        return redirect()->route('niveaux.show', $niveau)->with('success', 'Niveau mis à jour.');
    }

    public function destroy(Niveau $niveau)
    {
        $niveau->delete();
        return redirect()->route('niveaux.index')->with('success', 'Niveau supprimé.');
    }
}
