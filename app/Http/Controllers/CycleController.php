<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CycleController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $query = Cycle::query();
        if ($q !== '') {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('nom', 'like', "%{$q}%");
        }
        $cycles = $query->orderBy('code')->paginate(15)->withQueryString();
        return view('admin.cycle.index', compact('cycles','q'));
    }

    public function create()
    {
        return view('admin.cycle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('cycle','code')],
            'nom'  => ['required','string','max:255'],
        ]);

        $cycle = Cycle::create($request->only(['code','nom']));
        return redirect()->route('cycles.show', $cycle)->with('success', 'Cycle créé.');
    }

    public function show(Cycle $cycle)
    {
        return view('admin.cycle.show', compact('cycle'));
    }

    public function edit(Cycle $cycle)
    {
        return view('admin.cycle.edit', compact('cycle'));
    }

    public function update(Request $request, Cycle $cycle)
    {
        $request->validate([
            'code' => ['required','string','max:50', Rule::unique('cycle','code')->ignore($cycle->id)],
            'nom'  => ['required','string','max:255'],
        ]);

        $cycle->update($request->only(['code','nom']));
        return redirect()->route('cycles.show', $cycle)->with('success', 'Cycle mis à jour.');
    }

    public function destroy(Cycle $cycle)
    {
        $cycle->delete();
        return redirect()->route('cycles.index')->with('success', 'Cycle supprimé.');
    }
}
