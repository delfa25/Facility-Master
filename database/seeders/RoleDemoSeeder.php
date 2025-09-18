<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;

class RoleDemoSeeder extends Seeder
{
    public function run(): void
    {
        $datasets = [
            [
                'personne' => [
                    'nom' => 'Admin',
                    'prenom' => 'System',
                    'date_naissance' => now()->subYears(30)->toDateString(),
                    'lieu_naissance' => 'Ouaga',
                    'email' => 'admin@example.com',
                    'phone' => '+22670000000',
                    'role' => 'ADMINISTRATEUR',
                ],
                'user' => [
                    'password' => 'admin123',
                ],
            ],
            [
                'personne' => [
                    'nom' => 'Prof',
                    'prenom' => 'Alpha',
                    'date_naissance' => now()->subYears(35)->toDateString(),
                    'lieu_naissance' => 'Dakar',
                    'email' => 'enseignant@example.com',
                    'phone' => '+221700000002',
                    'role' => 'ENSEIGNANT',
                ],
                'user' => [
                    'password' => 'enseignant123',
                ],
            ],
            [
                'personne' => [
                    'nom' => 'Etudiant',
                    'prenom' => 'Beta',
                    'date_naissance' => now()->subYears(20)->toDateString(),
                    'lieu_naissance' => 'Dakar',
                    'email' => 'etudiant@example.com',
                    'phone' => '+221700000003',
                    'role' => 'ETUDIANT',
                ],
                'user' => [
                    'password' => 'etudiant123',
                ],
            ],
            [
                'personne' => [
                    'nom' => 'Invite',
                    'prenom' => 'Gamma',
                    'date_naissance' => now()->subYears(28)->toDateString(),
                    'lieu_naissance' => 'Dakar',
                    'email' => 'invite@example.com',
                    'phone' => '+221700000004',
                    'role' => 'INVITE',
                ],
                'user' => [
                    'password' => 'invite123',
                ],
            ],
        ];

        foreach ($datasets as $data) {
            // Skip if email already exists
            $existing = Personne::where('email', $data['personne']['email'])->first();
            if ($existing) {
                continue;
            }

            $personne = Personne::create($data['personne']);

            $isAdmin = $personne->role === 'ADMINISTRATEUR';
            $user = User::create([
                'password' => Hash::make($data['user']['password']),
                'personne_id' => $personne->id,
                // Seul l'admin est actif par défaut, les autres restent inactifs
                'actif' => $isAdmin,
                'must_change_password' => true,
            ]);

            // Auto-create role specific records
            switch ($personne->role) {
                case 'ETUDIANT':
                    Etudiant::create([
                        'INE' => generateIne(),
                        'personne_id' => $personne->id,
                        'date_inscription' => null,
                        'statut' => 'INACTIF',
                    ]);
                    break;
                case 'ENSEIGNANT':
                    Enseignant::create([
                        'personne_id' => $personne->id,
                        'grade' => null,
                        'specialite' => null,
                        'statut' => 'INACTIF',
                    ]);
                    break;
                default:
                    // nothing
                    break;
            }
        }
    }
}

// Simple helper to generate a 13-char INE (YY + 11 digits)
function generateIne(): string
{
    $yy = now()->format('y');
    $rand = str_pad((string)random_int(0, 99999999999), 11, '0', STR_PAD_LEFT);
    return $yy . $rand;
}
