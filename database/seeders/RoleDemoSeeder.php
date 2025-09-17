<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Personne;
use App\Models\User;

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
            // Skip if email already exists (unique on personne considering soft deletes)
            $existing = Personne::withTrashed()->where('email', $data['personne']['email'])->first();
            if ($existing) {
                continue;
            }

            $personne = Personne::create($data['personne']);

            User::create([
                'password' => Hash::make($data['user']['password']),
                'personne_id' => $personne->id,
                'actif' => true,
                'must_change_password' => false,
            ]);
        }
    }
}
