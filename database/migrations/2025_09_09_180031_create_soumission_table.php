<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soumission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devoir_id')->constrained('devoir')->cascadeOnDelete();
            $table->foreignId('etudiant_id')->constrained('etudiant');
            $table->dateTime('date_soumission');
            $table->string('fichier', 255)->nullable();
            $table->text('commentaire')->nullable();
            $table->enum('statut', ['RENDUE','EN_RETARD','ANNULEE'])->default('RENDUE');
            $table->decimal('note', 5, 2)->nullable();
            $table->text('remarque_correction')->nullable();
            $table->foreignId('corrige_par')->nullable()->constrained('enseignant');
            $table->dateTime('date_correction')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soumission');
    }
};
