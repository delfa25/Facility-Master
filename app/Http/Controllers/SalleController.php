<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalleController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Salle::query();
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('localisation', 'like', "%{$q}%");
        }
        $salles = $query->orderBy('code')->paginate(15)->withQueryString();
        return view('admin.salle.index', compact('salles','q'));
    }

    public function create()
    {
        return view('admin.salle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('salle','code')],
            'capacite' => ['required','integer','min:0'],
            'localisation' => ['nullable','string','max:255'],
        ]);

        $salle = Salle::create($request->only(['code','capacite','localisation']));
        return redirect()->route('salles.show', $salle)->with('success', 'Salle créée.');
    }

    public function show(Salle $salle)
    {
        return view('admin.salle.show', compact('salle'));
    }

    public function edit(Salle $salle)
    {
        return view('admin.salle.edit', compact('salle'));
    }

    public function update(Request $request, Salle $salle)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('salle','code')->ignore($salle->id)],
            'capacite' => ['required','integer','min:0'],
            'localisation' => ['nullable','string','max:255'],
        ]);

        $salle->update($request->only(['code','capacite','localisation']));
        return redirect()->route('salles.show', $salle)->with('success', 'Salle mise à jour.');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();
        return redirect()->route('salles.index')->with('success', 'Salle supprimée.');
    }
}
