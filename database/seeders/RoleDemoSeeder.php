<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Personne;

class RoleDemoSeeder extends Seeder
{
    public function run(): void
    {
        $datasets = [
            [
                'role' => 'ADMINISTRATEUR',
                'email' => 'admin@example.com',
                'password' => 'admin123',
            ],
            [
                'role' => 'ENSEIGNANT',
                'email' => 'enseignant@example.com',
                'password' => 'enseignant123',
                'enseignant' => [
                    'nom' => 'Prof',
                    'prenom' => 'Alpha',
                    'date_naissance' => now()->subYears(35)->toDateString(),
                    'lieu_naissance' => 'Dakar',
                    'phone' => '+221700000002',
                    'grade' => null,
                    'specialite' => null,
                    'statut' => 'INACTIF',
                ],
            ],
            [
                'role' => 'ETUDIANT',
                'email' => 'etudiant@example.com',
                'password' => 'etudiant123',
                'etudiant' => [
                    'INE' => null, // will be generated
                    'nom' => 'Etudiant',
                    'prenom' => 'Beta',
                    'date_naissance' => now()->subYears(20)->toDateString(),
                    'lieu_naissance' => 'Dakar',
                    'phone' => '+221700000003',
                    'date_inscription' => null,
                    'statut' => 'INACTIF',
                ],
            ],
            [
                'role' => 'INVITE',
                'email' => 'invite@example.com',
                'password' => 'invite123',
            ],
        ];

        foreach ($datasets as $data) {
            // Skip if a user with same email already exists
            $existing = User::where('email', $data['email'])->first();
            if ($existing) {
                continue;
            }

            $isAdmin = ($data['role'] === 'ADMINISTRATEUR');
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'actif' => $isAdmin,
                'must_change_password' => true,
            ]);

            // assign spatie role
            if (method_exists($user, 'assignRole')) {
                $user->assignRole($data['role']);
            }

            // Auto-create role specific records
            switch ($data['role']) {
                case 'ETUDIANT':
                    $et = $data['etudiant'] ?? [];
                    Etudiant::create([
                        'INE' => $et['INE'] ?: generateIne(),
                        'user_id' => $user->id,
                        'date_inscription' => $et['date_inscription'] ?? null,
                        'statut' => $et['statut'] ?? 'INACTIF',
                    ]);
                    break;
                case 'ENSEIGNANT':
                    $ens = $data['enseignant'] ?? [];
                    Enseignant::create([
                        'user_id' => $user->id,
                        'grade' => $ens['grade'] ?? null,
                        'specialite' => $ens['specialite'] ?? null,
                        'statut' => $ens['statut'] ?? 'INACTIF',
                    ]);
                    break;
                default:
                    // admins: attach personne profile for completeness
                    if ($data['role'] === 'ADMINISTRATEUR') {
                        Personne::firstOrCreate(['user_id' => $user->id], ['bureau' => 'A101']);
                    }
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
