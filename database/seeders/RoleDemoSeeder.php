<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Personne;

class RoleDemoSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'superadmin@example.com';
        $password = 'superadmin123';

        // Skip if a user with same email already exists
        $existing = User::where('email', $email)->first();
        if ($existing) {
            return;
        }

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'SUPERADMIN',
            'actif' => true,
            'must_change_password' => true,
        ]);

        // assign spatie role
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('SUPERADMIN');
        }

        // Attach an admin Personne profile for completeness
        Personne::firstOrCreate(['user_id' => $user->id], ['bureau' => 'A101']);
    }
}

// Removed helper since only SUPERADMIN is created here
