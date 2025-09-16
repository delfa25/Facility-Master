<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classe', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('nom', 100);
            $table->foreignId('filiere_id')->constrained('filiere');
            $table->foreignId('niveau_id')->constrained('niveau');
            $table->foreignId('salle_id')->constrained('salle');
            $table->foreignId('responsable_enseignant_id')->constrained('enseignant');
            $table->foreignId('annee_id')->constrained('annee_acad');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe');
    }
};
