<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ressource_cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours');
            $table->foreignId('enseignant_id')->nullable()->constrained('enseignant');
            $table->string('titre', 200);
            $table->text('description')->nullable();
            $table->string('fichier', 255)->nullable();
            $table->dateTime('date_publication');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ressource_cours');
    }
};
