<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inscription', function (Blueprint $table) {
            // Ajout d'un index unique sur (etudiant_id, annee_id)
            $table->unique(['etudiant_id', 'annee_id'], 'inscription_etudiant_annee_unique');

            // Index utiles (non uniques)
            $table->index('classe_id', 'inscription_classe_idx');
            $table->index('annee_id', 'inscription_annee_idx');
        });
    }

    public function down(): void
    {
        Schema::table('inscription', function (Blueprint $table) {
            $table->dropUnique('inscription_etudiant_annee_unique');
            $table->dropIndex('inscription_classe_idx');
            $table->dropIndex('inscription_annee_idx');
        });
    }
};
