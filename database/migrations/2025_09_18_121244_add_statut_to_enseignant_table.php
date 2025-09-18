<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enseignant', function (Blueprint $table) {
            // ENUM INACTIF, SUSPENDU, ACTIF avec défaut INACTIF
            $table->enum('statut', ['INACTIF', 'SUSPENDU', 'ACTIF'])
                  ->default('INACTIF')
                  ->after('specialite');
        });
    }

    public function down(): void
    {
        Schema::table('enseignant', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};