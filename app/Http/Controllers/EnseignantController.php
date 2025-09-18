<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $q = trim($request->get('q', ''));
        $grade = $request->get('grade');
        $specialite = $request->get('specialite');

        $query = Enseignant::with('personne');
        if ($q !== '') {
            $query->whereHas('personne', function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }
        if ($grade !== null && $grade !== '') {
            $query->where('grade', 'like', "%{$grade}%");
        }
        if ($specialite !== null && $specialite !== '') {
            $query->where('specialite', 'like', "%{$specialite}%");
        }

        $enseignants = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        // Quick counts
        $counts = [
            'total' => \App\Models\Enseignant::count(),
            'with_grade' => \App\Models\Enseignant::whereNotNull('grade')->count(),
            'without_grade' => \App\Models\Enseignant::whereNull('grade')->count(),
        ];
        return view('admin.enseignant.index', compact('enseignants','q','grade','specialite','counts'));
    }

    public function show(Enseignant $enseignant)
    {
        $enseignant->load('personne');
        return view('admin.enseignant.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        $enseignant->load('personne');
        return view('admin.enseignant.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'grade' => ['nullable','string','max:50'],
            'specialite' => ['nullable','string','max:100'],
        ]);

        $enseignant->update([
            'grade' => $request->grade,
            'specialite' => $request->specialite,
        ]);

        return redirect()->route('enseignants.show', $enseignant)->with('success', 'Enseignant mis à jour.');
    }

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();
        return redirect()->route('enseignants.index')->with('success', 'Enseignant supprimé.');
    }
}
