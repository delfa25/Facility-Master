<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiant', function (Blueprint $table) {
            $table->id();
            $table->string('INE', 13)->unique();
            $table->foreignId('personne_id')->constrained('personne');
            $table->date('date_inscription');
            $table->enum('statut', ['INACTIF','ACTIF','SUSPENDU','DIPLOME'])->default('INACTIF');            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};
