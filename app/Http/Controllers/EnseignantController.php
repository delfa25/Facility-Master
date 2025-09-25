<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
{
    public function create()
    {
        return view('admin.enseignant.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required','string','max:100'],
            'prenom' => ['required','string','max:100'],
            'date_naissance' => ['required','date','before:today'],
            'lieu_naissance' => ['required','string','max:100'],
            'email' => ['required','email','max:255','unique:users,email'],
            'phone' => ['required','string','max:30'],
            'grade' => ['nullable','string','max:50'],
            'specialite' => ['nullable','string','max:100'],
        ]);

        $enseignant = DB::transaction(function() use ($request) {
            // Create inactive user with role ENSEIGNANT
            $user = User::create([
                'email' => $request->email,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'phone' => $request->phone,
                'password' => Hash::make('facilitypass'),
                'role' => 'ENSEIGNANT',
                'actif' => false,
                'must_change_password' => true,
            ]);

            // Create Enseignant profile (only its specific fields)
            return Enseignant::create([
                'user_id' => $user->id,
                'grade' => $request->grade,
                'specialite' => $request->specialite,
                'statut' => 'INACTIF',
            ]);
        });

        return redirect()->route('enseignants.show', $enseignant)->with('success', 'Enseignant créé. Le compte utilisateur est en attente d\'activation.');
    }
    public function index(\Illuminate\Http\Request $request)
    {
        $q = trim($request->get('q', ''));
        $grade = $request->get('grade');
        $specialite = $request->get('specialite');
        $statut = $request->get('statut');

        $query = Enseignant::query()->with('user')->whereHas('user');
        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('email', 'like', "%{$q}%")
                          ->orWhere('nom', 'like', "%{$q}%")
                          ->orWhere('prenom', 'like', "%{$q}%");
                    });
            });
        }
        if ($grade !== null && $grade !== '') {
            $query->where('grade', 'like', "%{$grade}%");
        }
        if ($specialite !== null && $specialite !== '') {
            $query->where('specialite', 'like', "%{$specialite}%");
        }
        if ($statut !== null && $statut !== '') {
            $query->where('statut', $statut);
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
        return view('admin.enseignant.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        return view('admin.enseignant.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom' => ['nullable','string','max:100'],
            'prenom' => ['nullable','string','max:100'],
            'email' => [
                'nullable','email','max:255',
                Rule::unique('users','email')->ignore($enseignant->user_id),
            ],
            'phone' => ['nullable','string','max:30'],
            'grade' => ['nullable','string','max:50'],
            'specialite' => ['nullable','string','max:100'],
            'statut' => ['required', 'in:INACTIF,SUSPENDU,ACTIF'],
        ]);

        DB::transaction(function() use ($request, $enseignant) {
            // Sync to related user if provided
            if ($enseignant->user) {
                $enseignant->user->update(array_filter([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ], fn($v) => !is_null($v)));
            }

            $enseignant->update([
                'grade' => $request->grade,
                'specialite' => $request->specialite,
                'statut' => $request->statut,
            ]);
        });

        return redirect()->route('enseignants.show', $enseignant)->with('success', 'Enseignant mis à jour.');
    }

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();
        return redirect()->route('enseignants.index')->with('success', 'Enseignant supprimé.');
    }
}
