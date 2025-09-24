<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ATTESTATION','DIPLOME','AUTRE']);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('etudiant_id')->constrained('etudiant');
            $table->string('numero', 100);
            $table->date('date_emission');
            $table->string('chemin_fichier', 255)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
