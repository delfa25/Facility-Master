<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use App\Models\Batiment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalleController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Salle::with('batiment');
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('localisation', 'like', "%{$q}%");
        }
        $salles = $query->orderBy('code')->paginate(15)->withQueryString();
        return view('admin.salle.index', compact('salles','q'));
    }

    public function create()
    {
        $batiments = Batiment::orderBy('code')->get();
        return view('admin.salle.create', compact('batiments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('salle','code')],
            'capacite' => ['required','integer','min:0'],
            'localisation' => ['nullable','string','max:255'],
            'batiment_id' => ['nullable','exists:batiment,id'],
        ]);

        $data = $request->only(['code','capacite','localisation','batiment_id']);
        if (!empty($data['batiment_id'])) {
            $bat = Batiment::find($data['batiment_id']);
            if ($bat) {
                $data['localisation'] = $bat->code; // derive from selected batiment
            }
        }
        $salle = Salle::create($data);
        return redirect()->route('salles.show', $salle)->with('success', 'Salle créée.');
    }

    public function show(Salle $salle)
    {
        $salle->load('batiment');
        return view('admin.salle.show', compact('salle'));
    }

    public function edit(Salle $salle)
    {
        $batiments = Batiment::orderBy('code')->get();
        return view('admin.salle.edit', compact('salle','batiments'));
    }

    public function update(Request $request, Salle $salle)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('salle','code')->ignore($salle->id)],
            'capacite' => ['required','integer','min:0'],
            'localisation' => ['nullable','string','max:255'],
            'batiment_id' => ['nullable','exists:batiment,id'],
        ]);

        $data = $request->only(['code','capacite','localisation','batiment_id']);
        if (!empty($data['batiment_id'])) {
            $bat = Batiment::find($data['batiment_id']);
            if ($bat) {
                $data['localisation'] = $bat->code; // derive from selected batiment
            }
        }
        $salle->update($data);
        return redirect()->route('salles.show', $salle)->with('success', 'Salle mise à jour.');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();
        return redirect()->route('salles.index')->with('success', 'Salle supprimée.');
    }
}
