<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ue', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('libelle', 150);
            $table->foreignId('filiere_id')->constrained('filiere');
            $table->foreignId('niveau_id')->constrained('niveau');
            $table->unsignedTinyInteger('credits');
            $table->foreignId('semestre_id')->constrained('semestre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ue');
    }
};
