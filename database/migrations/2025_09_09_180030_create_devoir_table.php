<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devoir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours');
            $table->foreignId('classe_id')->nullable()->constrained('classe');
            $table->foreignId('groupe_id')->nullable()->constrained('groupe');
            $table->foreignId('enseignant_id')->constrained('enseignant');
            $table->string('titre', 200);
            $table->text('description')->nullable();
            $table->dateTime('date_publication');
            $table->dateTime('date_limite');
            $table->unsignedSmallInteger('points_max');
            $table->string('piece_jointe', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devoir');
    }
};
