<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Etudiant: make date_inscription nullable and extend enum with INACTIF as default
        if (Schema::hasTable('etudiant')) {
            // Make date_inscription nullable
            DB::statement("ALTER TABLE etudiant MODIFY date_inscription DATE NULL");
            // Extend enum for statut
            DB::statement("ALTER TABLE etudiant MODIFY statut ENUM('INACTIF','Actif','Suspendu','Diplome') NOT NULL DEFAULT 'INACTIF'");
        }

        // Enseignant: make grade and specialite nullable
        if (Schema::hasTable('enseignant')) {
            DB::statement("ALTER TABLE enseignant MODIFY grade VARCHAR(50) NULL");
            DB::statement("ALTER TABLE enseignant MODIFY specialite VARCHAR(100) NULL");
        }
    }

    public function down(): void
    {
        // Revert enseignant columns to NOT NULL
        if (Schema::hasTable('enseignant')) {
            DB::statement("ALTER TABLE enseignant MODIFY grade VARCHAR(50) NOT NULL");
            DB::statement("ALTER TABLE enseignant MODIFY specialite VARCHAR(100) NOT NULL");
        }

        // Revert etudiant statut enum and date_inscription not null
        if (Schema::hasTable('etudiant')) {
            DB::statement("ALTER TABLE etudiant MODIFY statut ENUM('Actif','Suspendu','Diplome') NOT NULL");
            DB::statement("ALTER TABLE etudiant MODIFY date_inscription DATE NOT NULL");
        }
    }
};
