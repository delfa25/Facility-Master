<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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

        // Note: Removed Admin, Enseignant et Étudiant demo users to keep only SUPERADMIN
    }
}
