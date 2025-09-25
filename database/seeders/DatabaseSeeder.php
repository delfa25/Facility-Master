<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles/permissions then demo users and profiles
        $this->call([
            RolesAndPermissionsSeeder::class,
            DemoSeeder::class,
            AcademicYearSeeder::class,
            MasterDataSeeder::class,
        ]);
    }
}
