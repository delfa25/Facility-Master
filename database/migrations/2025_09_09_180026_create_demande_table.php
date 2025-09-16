<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demande', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiant');
            $table->enum('type_demande', ['ATTESTATION','DIPLOME']);
            $table->enum('statut', ['EN_ATTENTE','APPROUVEE','REJETEE'])->default('EN_ATTENTE');
            $table->foreignId('cycle_id')->constrained('cycle');
            $table->date('date_demande');
            $table->dateTime('date_traitement')->nullable();
            $table->string('commentaire', 255)->nullable();
            $table->foreignId('document_id')->constrained('document');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande');
    }
};
