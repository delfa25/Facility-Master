<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use App\Models\Etudiant;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Admin dashboard
     */
    public function admin(Request $request)
    {
        $counts = [
            'personnes' => Personne::query()->count(),
            'etudiants' => Etudiant::query()->count(),
            'enseignants' => Enseignant::query()->count(),
        ];

        return view('dashboards.admin', compact('counts'));
    }

    /**
     * Superadmin dashboard
     */
    public function superadmin(Request $request)
    {
        $counts = [
            'personnes' => Personne::query()->count(),
            'etudiants' => Etudiant::query()->count(),
            'enseignants' => Enseignant::query()->count(),
        ];

        return view('dashboards.superadmin', compact('counts'));
    }
}
