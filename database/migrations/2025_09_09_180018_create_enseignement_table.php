<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enseignement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained('enseignant');
            $table->foreignId('cours_id')->constrained('cours');
            $table->foreignId('classe_id')->constrained('classe');
            $table->foreignId('groupe_id')->constrained('groupe');
            $table->unsignedSmallInteger('volume_horaire');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignement');
    }
};
