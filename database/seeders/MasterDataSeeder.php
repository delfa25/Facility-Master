<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Filiere;
use App\Models\Cycle;
use App\Models\Niveau;
use App\Models\Semestre;
use App\Models\AcademicYear;
use App\Models\Batiment;
use App\Models\Salle;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Batiments
            $batiments = [
                ['code' => 'A', 'nom' => 'Batiment A'],
                ['code' => 'B', 'nom' => 'Batiment B'],
            ];
            foreach ($batiments as $b) {
                if (class_exists(Batiment::class)) {
                    Batiment::updateOrCreate(['code' => $b['code']], ['nom' => $b['nom']]);
                }
            }

            // Salles (A1..A3 in Batiment A, B1..B3 in Batiment B)
            if (class_exists(Salle::class) && class_exists(Batiment::class)) {
                $batByCode = Batiment::query()->pluck('id', 'code'); // ['A' => idA, 'B' => idB]
                // A1..A3
                for ($i = 1; $i <= 3; $i++) {
                    $code = 'A' . $i;
                    Salle::updateOrCreate(
                        ['code' => $code],
                        [
                            'capacite' => 50,
                            'localisation' => 'A',
                            'batiment_id' => $batByCode['A'] ?? null,
                        ]
                    );
                }
                // B1..B3
                for ($i = 1; $i <= 3; $i++) {
                    $code = 'B' . $i;
                    Salle::updateOrCreate(
                        ['code' => $code],
                        [
                            'capacite' => 50,
                            'localisation' => 'B',
                            'batiment_id' => $batByCode['B'] ?? null,
                        ]
                    );
                }
            }
            // Filieres
            $filieres = [
                ['code' => 'ABF', 'nom' => 'Assurance-Banque-Finance'],
                ['code' => 'ADB', 'nom' => 'Assistance de Direction Bilingue'],
                ['code' => 'CCA', 'nom' => 'Comptabilité-Contrôle-Audit'],
                ['code' => 'MIAGE', 'nom' => "Méthodes Informatiques Appliquées à la Gestion des Entreprises"],
                ['code' => 'MID', 'nom' => 'Marketing et Innovation Digitale'],
            ];
            foreach ($filieres as $f) {
                if (class_exists(Filiere::class)) {
                    Filiere::updateOrCreate(['code' => $f['code']], ['nom' => $f['nom']]);
                }
            }

            // Cycles
            $cycles = [
                ['code' => 'LICENCE', 'nom' => 'Licence'],
                ['code' => 'MASTER', 'nom' => 'Master'],
            ];
            foreach ($cycles as $c) {
                if (class_exists(Cycle::class)) {
                    Cycle::updateOrCreate(['code' => $c['code']], ['nom' => $c['nom']]);
                }
            }

            // Niveaux
            $niveaux = [
                ['code' => 'L1', 'libelle' => 'L1', 'ordre' => 1],
                ['code' => 'L2', 'libelle' => 'L2', 'ordre' => 2],
                ['code' => 'L3', 'libelle' => 'L3', 'ordre' => 3],
                ['code' => 'M1', 'libelle' => 'M1', 'ordre' => 4],
                ['code' => 'M2', 'libelle' => 'M2', 'ordre' => 5],
            ];
            foreach ($niveaux as $n) {
                if (class_exists(Niveau::class)) {
                    Niveau::updateOrCreate(
                        ['code' => $n['code']],
                        ['libelle' => $n['libelle'], 'ordre' => $n['ordre']]
                    );
                }
            }

            // Semestres (requires dates). We'll seed 10 semestres with rolling quarters from today.
            if (class_exists(Semestre::class)) {
                $currentYear = class_exists(AcademicYear::class)
                    ? AcademicYear::where('is_current', true)->first()
                    : null;
                $start = now()->startOfYear();
                for ($i = 1; $i <= 10; $i++) {
                    $code = 'S' . $i;
                    $name = 'Semestre ' . $i; // stored as code only in table; name is for display elsewhere
                    $dateDebut = $start->copy()->addMonths(($i - 1) * 3);
                    $dateFin = $dateDebut->copy()->addMonths(3)->subDay();
                    Semestre::updateOrCreate(
                        ['code' => $code],
                        [
                            'annee_id' => $currentYear?->id, // attach to current academic year if available
                            'date_debut' => $dateDebut->toDateString(),
                            'date_fin' => $dateFin->toDateString(),
                        ]
                    );
                }
            }

            // Backfill salle.batiment_id based on 'localisation' text
            if (class_exists(Salle::class) && class_exists(Batiment::class)) {
                // Map by full name
                $mapByName = Batiment::query()->pluck('id', 'nom');
                foreach ($mapByName as $nom => $id) {
                    Salle::where('localisation', $nom)->update(['batiment_id' => $id]);
                }
                // Map by code letter (e.g., 'A' => Batiment A)
                $mapByCode = Batiment::query()->pluck('id', 'code');
                foreach ($mapByCode as $code => $id) {
                    Salle::where('localisation', $code)->update(['batiment_id' => $id]);
                }
            }
        });
    }
}
