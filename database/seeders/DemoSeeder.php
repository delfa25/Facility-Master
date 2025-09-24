<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Personne;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin
        $super = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'password' => Hash::make('superadmin123'),
                'role' => 'SUPERADMIN',
                'nom' => 'Super',
                'prenom' => 'Admin',
                'actif' => true,
                'must_change_password' => true,
            ]
        );
        if (method_exists($super, 'assignRole')) {
            $super->assignRole('SUPERADMIN');
        }
        Personne::firstOrCreate(['user_id' => $super->id], ['bureau' => 'A000']);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'password' => Hash::make('admin123'),
                'role' => 'ADMINISTRATEUR',
                'nom' => 'Admin',
                'prenom' => 'System',
                'actif' => true,
                'must_change_password' => true,
            ]
        );
        if (method_exists($admin, 'assignRole')) {
            $admin->assignRole('ADMINISTRATEUR');
        }
        Personne::firstOrCreate(['user_id' => $admin->id], ['bureau' => 'A101']);

        // Enseignant
        $ensUser = User::firstOrCreate(
            ['email' => 'enseignant@example.com'],
            [
                'password' => Hash::make('enseignant123'),
                'role' => 'ENSEIGNANT',
                'nom' => 'Prof',
                'prenom' => 'Alpha',
                'actif' => true,
                'must_change_password' => true,
            ]
        );
        if (method_exists($ensUser, 'assignRole')) {
            $ensUser->assignRole('ENSEIGNANT');
        }
        Enseignant::firstOrCreate(['user_id' => $ensUser->id], [
            'grade' => 'MCF',
            'specialite' => 'Maths',
            'statut' => 'ACTIF',
        ]);

        // Étudiant
        $etUser = User::firstOrCreate(
            ['email' => 'etudiant@example.com'],
            [
                'password' => Hash::make('etudiant123'),
                'role' => 'ETUDIANT',
                'nom' => 'Etudiant',
                'prenom' => 'Beta',
                'actif' => true,
                'must_change_password' => true,
            ]
        );
        if (method_exists($etUser, 'assignRole')) {
            $etUser->assignRole('ETUDIANT');
        }
        Etudiant::firstOrCreate(['user_id' => $etUser->id], [
            'INE' => '2500000000001',
            'date_inscription' => now()->toDateString(),
            'statut' => 'ACTIF',
        ]);
    }
}
